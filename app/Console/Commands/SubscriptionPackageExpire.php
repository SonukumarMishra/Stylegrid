<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserSubscription;
use App\Helpers\Helper;
use App\Mail\FreetrialExpired;
use App\Mail\SubscriptionExpiryMail;
use App\Models\Subscription;
use Log;
use DB;
use App\Repositories\CommonRepository as CommonRepo;
use App\Repositories\PaymentRepository;
use App\Repositories\UserRepository as UserRepo;
use Illuminate\Support\Facades\Mail;

class SubscriptionPackageExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            \Log::info("Cron is working fine Subscription-Package Expiry Package !". date('Y-m-d H:i:s'));
            
            $today_date = date('Y-m-d');

            $package_expire = UserSubscription::from('user_subscriptions as us')
                                            ->where('us.is_active',1)
                                            // ->where('us.cancelled_on', null)
                                            ->where(function ($query) use($today_date){
                                                $query->whereDate('us.end_date', $today_date)
                                                    ->orWhereDate('us.trial_end_date', $today_date);
                                                })
                                            ->get();

         
            foreach ($package_expire as $key => $value) {
                
                $user_sub = UserSubscription::from('user_subscriptions as user_sub')
                            ->select("user_sub.*" , 'users.display_name','users.username')
                            ->addSelect(DB::raw("(DATE_FORMAT(user_sub.trial_end_date,'%Y-%m-%d')) as trial_for_end_date"))
                            ->where('user_subscription_id', $value->user_subscription_id)
                            ->leftJoin("users" ,'users.user_id' ,'=' ,'user_sub.user_id')
                            ->first();

                $username = env('PAYPAL_Client_ID');
                $password = env('PAYPAL_SECRET_ID');
        
                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Basic '. base64_encode("$username:$password")
                );
                try{
                    // $paypal_subscription_url = config('global.paypal_apis.subscription.details').$request->subscriptionID;
                    $paypal_subscription_url = config('global.paypal_apis.subscription.details').$user_sub->paypal_subscription_id;
    
                    $paypal_subscription = CommonRepo::callCurlAPI( 'GET', $paypal_subscription_url, '', $headers);
                    // log::info(['user_sub' => $user_sub]);
                    log::info("paypal_subscription ==> " .print_r($paypal_subscription , true));

                    if($paypal_subscription){
    
                        $paypal_subscription_dtls =  $paypal_subscription['data'];
    
                        if($paypal_subscription_dtls->status != 'ACTIVE'){
                           
                            $user_sub->is_active = 0;
                            $user_sub->is_auto_payment = 0;
                            // $user_sub->cancelled_on = date('Y-m-d H:i:s');
                            $user_sub->expired_on = date('Y-m-d H:i:s');
                            $user_sub->status_term = config('global.subscription_status.expired');
                            $user_sub->save();

                            $sub_dtls = Subscription::where('subscription_id' , $user_sub->subscription_id)->first();

                            if($sub_dtls){

                                if(!empty($user_sub->trial_end_date)  &&  $user_sub->trial_end_date && $user_sub->trial_for_end_date == $today_date){

                                    try{
                                        $user_dtls = User::where('user_id' , $sub_dtls->user_id)->first();

                                        Mail::to($user_dtls->username)->send(new FreetrialExpired($user_dtls->display_name));
                
                                    }catch(\Exception $e){
                
                                        Log::info("error send email - ". $e->getMessage());
                                    }

                                }


                            }


                            UserRepo::assign_subscription_to_user($user_sub->user_id, $user_sub->association_id, $user_sub->association_type_term, config('global.subscription_type.free'));
                          

                            $client_user = User::where([
                                'user_id' => $user_sub->user_id,
                                'is_active' => 1 ,
                                'association_type_term' => config("global.user_type.client")
                            ])->first();

                            $ref_user_id = $client_user->ref_user_id ; 
                            
                            if($client_user && $ref_user_id && !empty($ref_user_id)){
                                
                                $client_user->ref_user_id = null;
                                $client_user->ref_association_id = null;
                                $client_user->ref_association_type_term = null;
                                $client_user->save(); 


                                $artist_user = User::where([
                                    
                                    'user_id' => $ref_user_id ,
                                    'is_active' => 1 ,
                                    'association_type_term' => config("global.user_type.artist")

                                ])->update([

                                    'ref_user_id' => null ,
                                    'ref_association_id' => null ,
                                    'ref_association_type_term' => null,
                                    'is_profile_verified' => 0
                                ]);

                            }

                            $user_dtls = User::where('user_id' , $sub_dtls->user_id)->first(); 

                            if($user_dtls){

                                $user_dtls->tokens->each(function ($token, $key) {
                                    $token->delete();
                                });

                            }
                           
                        }
    
                     
                    }
                  
                }catch(\Exception $e){
                    log::info(['error' =>$e->getMessage() ,'message' => 'Error while expire.']);
                }
              
              

               
                
                // try{


                //     PaymentRepository::cancel_subscription_paypal([ 'user_subscription_id' => $value->user_subscription_id]);
                
                // } catch(\Exception $e){

                //      Log::info("error send email - ". $e->getMessage());
                // }

                if(!empty($user_sub->username)){

                    try{
                        
                        Mail::to($user_sub->username)->send(new SubscriptionExpiryMail($user_sub->display_name));

                    }catch(\Exception $e){

                        Log::info("error send email - ". $e->getMessage());
                    }
                }

            }


        } catch (\Exception $e) {
            Log::info('error cron Subscription-Expiry Package'. print_r($e->getMessage(), true));
        }
    }
}
