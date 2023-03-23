<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserSubscription;
use App\Helpers\Helper;
use App\Mail\SubscriptionExpireBeforeTwoDaysMail;
use Log;
use DB;
use App\Repositories\CommonRepository as CommonRepo;
use Illuminate\Support\Facades\Mail;

class SubscriptionExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:expiry_notify';

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
    public function handle(){

        try {

            \Log::info("Cron is working fine Subscription-Expiry !". date('Y-m-d H:i:s'));

            $today_date = date('Y-m-d');
            $today_before_day_date = date('Y-m-d', strtotime("-2 days"));

            $before_date_user_subscription_expiry_list = UserSubscription::from('user_subscriptions as us')
                                                                ->select("us.*" , 'users.display_name','users.username')
                                                                ->where('us.is_active',1)
                                                                ->where('us.cancelled_on', null)
                                                                ->whereDate('us.end_date',$today_before_day_date)
                                                                ->leftJoin("users" ,'users.user_id' ,'=' ,'us.user_id')
                                                                ->get(['user_id','association_id','association_type_term'])
                                                                ->toArray();

            $today_date_user_subscription_expiry_list = UserSubscription::from('user_subscriptions as us')
                                                                ->where('us.is_active',1)
                                                                ->where('us.cancelled_on', null)
                                                                ->whereDate('us.end_date',$today_date)
                                                                ->get(['user_id','association_id','association_type_term'])
                                                                ->toArray();


           // Before 2 Days Expiry Users
           if(!empty($before_date_user_subscription_expiry_list) && count($before_date_user_subscription_expiry_list) > 0){

             $notification_obj_before_date = [
                    'type' => config('global.notification_types.subscription_expiry'),
                    'title' =>  trans('pages.notifications.subscription_expire_title'),
                    'description' => trans('pages.notifications.subscription_expire_before_day'),
                    'data' => [
                        'send_association_id' => '',
                        'send_association_type' => config('global.user_type.admin'),

                    ],
                    'users' => $before_date_user_subscription_expiry_list
                ];

                CommonRepo::save_notification($notification_obj_before_date);

                if(!empty($before_date_user_subscription_expiry_list->username)){

                    try{
                        
                        Mail::to($before_date_user_subscription_expiry_list->username)->send(new SubscriptionExpireBeforeTwoDaysMail($before_date_user_subscription_expiry_list->display_name));

                    }catch(\Exception $e){

                        Log::info("error send email - ". $e->getMessage());
                    }
                }
           }

           // Today Expiry Users
           if(!empty($today_date_user_subscription_expiry_list) && count($today_date_user_subscription_expiry_list) > 0){

            $notification_obj_today = [
                   'type' => config('global.notification_types.subscription_expiry'),
                   'title' =>  trans('pages.notifications.subscription_expire_title'),
                   'description' => trans('pages.notifications.subscription_expire'),
                   'data' => [
                       'send_association_id' => '',
                       'send_association_type' => config('global.user_type.admin'),

                   ],
                   'users' => $today_date_user_subscription_expiry_list
               ];

               CommonRepo::save_notification($notification_obj_today);

          }

        } catch (\Exception $e) {
            Log::info('error cron Subscription-Expiry '. print_r($e->getMessage(), true));
        }

    }
}
