<?php

namespace App\Http\Controllers\Stylist;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\Stylist;
use App\Repositories\SubscriptionRepository as SubscriptionRepo;
use App\Repositories\PaymentRepository as PaymentRepo;
use App\Repositories\UserRepository as UserRepo;
use Validator,Redirect;
use Config;
use Storage;
use Helper;
use PDF;

class SubscriptionController extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!Session::get("Stylistloggedin")) {
                return redirect("/stylist-login");
            }

            $this->auth_user = [
                'auth_id' => Session::get("stylist_id"),
                'user_id' => Session::get("stylist_id"),
                'auth_name' => Session::get('stylist_data')->name,
                'auth_profile' => Session::get('stylist_data')->profile_image,
                'auth_user' => 'stylist',
                'user_type' => 'stylist'
            ];

            return $next($request);
        });
    }


    public function index()
	{
        try{

    		return view('stylist.postloginview.subscription.index');

        }catch(\Exception $e){

            Log::info("index error - ". $e->getMessage());
            return redirect()->back();
        }

	}

    public function getSubscriptionList(Request $request)
	{
        try{

            $result = SubscriptionRepo::get_subscription_list($request, $this->auth_user);
                      
            $user_details = Stylist::find($this->auth_user['user_id']);

            $view = '';

            $view = view("stylist.postloginview.subscription.index-list-ui", compact('result', 'user_details'))->render();

            $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 
                                'data' => [
                                    'view' => $view,
                                ]  
                            ];

            return response()->json($response_array, 200);

        }catch(\Exception $e){

            Log::info("error getSubscriptionList - ". $e->getMessage());
            
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}
    
    public function buySubscription(Request $request){

        try {

            $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

            $validator = Validator::make(
                $request->all(),
                [
                    'subscription_id' => 'required',
                    'payment_method_id' => 'required',      // This is braintree encryted token of card details
                ]
            );

            if ($validator->fails()) {

                $response_array = ['status' => 0, 'message' => implode(',', $validator->messages()->all())];

            } else {

                $subscription_info = Subscription::find($request->subscription_id);

                if($subscription_info){

                    $user_subscription = UserSubscription::where([
                                                            'association_id' => $this->auth_user['user_id'],
                                                            'association_type_term' => $this->auth_user['user_type'],
                                                            'is_active' => 1,
                                                            'subscription_status' => config('custom.subscription.status.active')
                                                        ])->first();

                    if($user_subscription){
                        
                        if($user_subscription->subscription_id == $request->subscription_id){

                            return response()->json(['status' => 0, 'message' => trans('pages.already_active_subscription_action') ]);
                        
                        }
                    }

                    $auth_user = Stylist::find($this->auth_user['user_id']);

                    if(!$auth_user){

                        return response()->json(['status' => 0, 'message' => trans('pages.crud_messages.no_data', [ 'attr' => 'member']) ]);

                    }

                    $stripe_customer_id = '';

                    if(isset($auth_user->stripe_customer_id) && !empty($auth_user->stripe_customer_id)){
                        
                        $stripe_customer_id = $auth_user->stripe_customer_id;

                    }else{
                       
                        // Create braintree user 
                        $customer_result = PaymentRepo::create_user_stripe_customer($this->auth_user);
                      
                        if($customer_result['status'] == 0){

                            return response()->json(['status' => 0, 'message' => trans('pages.unable_to_create_subscription') ]);

                        }

                        $stripe_customer_id = $customer_result['data']['customer_id'];
                        
                    }

                    if(!empty($stripe_customer_id)){

                        $payment_method_result = PaymentRepo::create_stripe_payment_method($this->auth_user, $stripe_customer_id, $request->payment_method_id);

                        if($payment_method_result['status'] == 0){

                            return response()->json(['status' => 0, 'message' => $payment_method_result['message'] ]);

                        }

                        $payment_method_id = $payment_method_result['data']['payment_method_id'];

                        if(isset($payment_method_id) && !empty($payment_method_id)){

                            $subscription_result = PaymentRepo::create_stripe_subscription($this->auth_user, $subscription_info->subscription_id);
                            
                            if($subscription_result['status']){

                                $active_subscription = UserRepo::get_user_subscription($this->auth_user);
                                
                                $subscription_feature = '';
                                
                                // $subscription_feature = CommonRepo::subscription_plan_feature($request, $this->auth_user['user_id']);

                                $active_subscription = $active_subscription['data'];

                                return response()->json(['status' => 1, 'message' => trans('pages.subscription_success'), 'data' => ['subscription' => $active_subscription ,'subscription_feature' => $subscription_feature] ]);

                            }else{
                                
                                return response()->json(['status' => 0, 'message' => trans('pages.unable_to_create_subscription') ]);

                            }

                        }else{
                            
                            return response()->json(['status' => 0, 'message' => trans('pages.unable_to_create_subscription') ]);

                        }

                    }else{

                        return response()->json(['status' => 0, 'message' => trans('pages.unable_to_create_subscription') ]);

                    }
                    
                }else{

                    return response()->json(['status' => 0, 'message' => trans('pages.crud_messages.no_data', [ 'attr' => 'subscription']) ]);
                }
    
            }

            return response()->json($response_array, 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
        }

    }

    
    public function cancelSubscription(Request $request)
	{
        try{

            $response_array = PaymentRepo::cancel_stripe_subscription($request, $this->auth_user);
          
            return response()->json($response_array, 200);

        }catch(\Exception $e){

            Log::info("error cancelSubscription - ". $e->getMessage());
            
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

    public function subscriptionBillingIndex()
	{
        try{

    		return view('stylist.postloginview.subscription.billing-index');

        }catch(\Exception $e){

            Log::info("subscriptionBillingIndex error - ". $e->getMessage());
            return redirect()->back();
        }

	}

    public function subscriptionBillingDetails(Request $request)
	{
        try{

            $result = SubscriptionRepo::get_subscription_billing_details($request, $this->auth_user);
           
            $view = '';

            $view = view("stylist.postloginview.subscription.billing-content", compact('result'))->render();

            $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 
                                'data' => [
                                    'view' => $view,
                                ]  
                            ];

            return response()->json($response_array, 200);

        }catch(\Exception $e){

            Log::info("error subscriptionBillingDetails - ". $e->getMessage());
            
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

    public function getSubscriptioninvoiceHistory(Request $request)
	{
        try{

            $invoice_history = SubscriptionRepo::get_subscription_invoice_history($request, $this->auth_user);
          
            $response = array(
                "draw" => (int)$request->input('draw'),
                "recordsTotal" => $invoice_history['total'],
                "recordsFiltered" => $invoice_history['total'],
                "data" => $invoice_history['list'],
            );
           
            return response()->json($response, 200);

        }catch(\Exception $e){

            Log::info("error getSubscriptioninvoiceHistory - ". $e->getMessage());
            
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

     
    public function checkAlreadyPurchasedCancelledSubscription(Request $request)
	{
        try{

            $response_array = SubscriptionRepo::check_user_already_purchased_cancelled_subscription($request, $this->auth_user);
          
            return response()->json($response_array, 200);

        }catch(\Exception $e){

            Log::info("error checkAlreadyPurchasedSubscription - ". $e->getMessage());
            
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

}
