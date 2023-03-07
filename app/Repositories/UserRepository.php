<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Validator;
use App\Models\Member;
use App\Models\Stylist;
use App\Models\Subscription;
use App\Models\UserSubscription;
use Helper;
use Hash;
use DB;
use Log;

use Setting;

class UserRepository {

	public static function assign_subscription_to_user($association_id, $association_type_term, $subscription_type='', $subscription_id='', $data=[]){

        $response_array = ['status' => 0, 'message' => trans('pages.something_wrong')];

        try {

            $sub_info = false;

            if($subscription_type == config('custom.subscription.types.free')){

                $sub_info = Subscription::from('sg_subscriptions as sub')
                                            ->select('sub.*')
                                            ->where([
                                                'sub.is_active' => 1,
                                                'sub.subscription_user' => $association_type_term,
                                                'sub.subscription_type' => config('custom.subscription.types.free')
                                            ])
                                            ->first();

            }else if($subscription_type == config('custom.subscription.types.trial')){

                $sub_info = Subscription::from('sg_subscriptions as sub')
                                            ->select('sub.*')
                                            ->where([
                                                'sub.is_active' => 1,
                                                'sub.subscription_user' => $association_type_term,
                                                'sub.subscription_type' => config('custom.subscription.types.trial')
                                            ])
                                            ->first();

            }else{

                if(isset($subscription_id) && !empty($subscription_id)){

                    $sub_info = Subscription::find($subscription_id);

                }

            }

            if($sub_info){
                
                $start_date = date('Y-m-d H:i:s');
                $end_date = '';

                if(is_array($data) && count($data)){

                    if(isset($data['start_date']) && !empty($data['start_date']) && isset($data['end_date']) && !empty($data['end_date'])){

                        $start_date = date('Y-m-d H:i:s', strtotime($data['start_date']));
                        $end_date = date('Y-m-d H:i:s', strtotime($data['end_date']));

                    }
                }
                
                if(empty($end_date) && $subscription_type != config('custom.subscription.types.free')) {

                    if($sub_info->interval_type == config('custom.subscription.interval.days')){

                        $end_date = date('Y-m-d H:i:s', strtotime($start_date. ' + '.$sub_info->validity_period.' days'));
                       
                    }else if($sub_info->interval_type == config('custom.subscription.interval.month')){
    
                        $end_date = date('Y-m-d H:i:s', strtotime($start_date. ' + '.$sub_info->validity_period.' months'));
                        
                    }else if($sub_info->interval_type == config('custom.subscription.interval.year')){
    
                        $end_date = date('Y-m-d H:i:s', strtotime($start_date. ' + '.$sub_info->validity_period.' years'));
                        
                    }
                }
                
                Log::info("end date ". $end_date);

                $subscription_status = count($data) && isset($data['status']) ? $data['status']  : config('custom.subscription.status.active');

                $user_sub = new UserSubscription;
                $user_sub->subscription_id = $sub_info->subscription_id;
                $user_sub->association_id = $association_id;
                $user_sub->association_type_term = $association_type_term;
                $user_sub->start_date = isset($start_date) && !empty($start_date) ? date('Y-m-d H:i:s', strtotime($start_date)) : NULL;
                $user_sub->end_date = isset($end_date) && !empty($end_date) ? date('Y-m-d H:i:s', strtotime($end_date)) : NULL;
                $user_sub->stripe_subscription_id = @$data['stripe_subscription_id'];
                $user_sub->subscription_status = $subscription_status;
                $user_sub->save();

                if($user_sub){

                    if($association_type_term == config('custom.user_type.member') && $sub_info->subscription_type == config('custom.subscription.types.trial')){

                        Member::where([
                            'id' => $association_id
                        ])->update([
                            'trial_start_date' => isset($start_date) && !empty($start_date) ? date('Y-m-d H:i:s', strtotime($start_date)) : NULL,
                            'trial_end_date' => isset($end_date) && !empty($end_date) ? date('Y-m-d H:i:s', strtotime($end_date)) : NULL
                        ]);

                    }else if($association_type_term == config('custom.user_type.stylist') && $sub_info->subscription_type == config('custom.subscription.types.trial')){

                        Stylist::where([
                            'id' => $association_id
                        ])->update([
                            'trial_start_date' => isset($start_date) && !empty($start_date) ? date('Y-m-d H:i:s', strtotime($start_date)) : NULL,
                            'trial_end_date' => isset($end_date) && !empty($end_date) ? date('Y-m-d H:i:s', strtotime($end_date)) : NULL
                        ]);

                    }

                    UserSubscription::where([
                        'association_id' => $association_id,
                        'association_type_term' => $association_type_term,
                    ])
                    ->where('user_subscription_id', '!=', $user_sub->user_subscription_id)
                    ->update([ 
                                'is_active' => 0, 
                                'subscription_status' => config('custom.subscription.status.cancelled'),
                                'cancelled_on' => date('Y-m-d H:i:s')
                            ]);

                    $response_array = array('status' => 1,  'message' => trans('pages.action_success'), 'data' => ['user_subscription_id' => $user_sub->user_subscription_id]);

                }
                
            }
           
            return $response_array;

        } catch (\Exception $e) {
           
            Log::info("error assign_subscription_to_user - ". $e->getMessage());

            return $response_array;
        }
	
	}

    public static function get_user_subscription($user_data){

        $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'data' => []];

        try {

            $subscription = UserSubscription::from('sg_user_subscriptions as us')
                                            ->join('sg_subscriptions as sub','sub.subscription_id','=','us.subscription_id')
                                            ->leftJoin('sg_payment_transactions as pay_tra', function($join) {
                                                $join->on('pay_tra.trans_ref_association_id','=','us.user_subscription_id')
                                                    ->where('pay_tra.trans_ref_association_type_term', config('custom.payment_transaction.trans_type.subscription'));
                                            })
                                            ->where([
                                                'us.association_id' => $user_data['user_id'],
                                                'us.association_type_term' => $user_data['user_type'],
                                                'us.is_active' => 1,
                                                'us.subscription_status' => config('custom.subscription.status.active')
                                            ])
                                            ->select('us.*', 'sub.*', 'pay_tra.payment_trans_id', 'pay_tra.trans_status as payment_status', 'us.created_at as invoice_date')
                                            ->first();
                                            
            $response_array = ['status' => 1, 'data' => $subscription ? $subscription : (object)[] ];

            return $response_array;

        } catch (\Exception $e) {
           
            Log::info("error get_user_subscription - ". $e->getMessage());

            return $response_array;
        }
    }

    public static function cancel_user_subscription($request, $association_id, $association_type_term){

        $response_array = ['status' => 0, 'message' => trans('pages.something_wrong')];

        try {

            UserSubscription::where([
                'association_id' => $association_id,
                'association_type_term' => $association_type_term,
                'is_active' => 1
            ])
            ->update([ 
                'subscription_status' => config('custom.subscription.status.cancelled'),
                'cancelled_on' => date('Y-m-d H:i:s'),
                'reason_of_cancellation' => $request->reason_for_cancellation
            ]);

            $response_array = ['status' => 1, 'message' => 'Membership cancelled successfully' ];

            return $response_array;

        } catch (\Exception $e) {
           
            Log::info("error cancel_user_subscription - ". $e->getMessage());

            return $response_array;
        }
	
	}

}