<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Validator;
use Helper;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Repositories\UserRepository as UserRepo;
use App\Repositories\PaymentRepository as PaymentRepo;
use DB;
use Log;

class SubscriptionRepository {
	
	public static function get_subscription_list($request, $auth_user) {

		$result = [
			'list' => [],
			'total' => 0,
			'total_page' => 0,
			'current_page' => 1
		];

		try{

			$limit = $request->has('limit') ? $request->limit : config('custom.default_page_limit');
			$page_index = $request->has('page') ? $request->page : 1;
			
			if(isset($auth_user) && !empty($auth_user)){

				$main_query = Subscription::from('sg_subscriptions as sub')
											->select('sub.*', 'user_sub.user_subscription_id', 'user_sub.subscription_id as user_main_subscription_id', 'user_sub.end_date as subscription_end_date', 'user_sub.is_auto_payment', 'user_sub.is_paid', 'user_sub.subscription_status')
											->leftjoin('sg_user_subscriptions as user_sub', function($join) use($auth_user) {
												$join->on('user_sub.subscription_id', '=', 'sub.subscription_id')
													->where([
														'user_sub.is_active' => 1,
														'user_sub.association_id' => $auth_user['user_id'],
														'user_sub.association_type_term' => $auth_user['user_type'],
														'user_sub.subscription_status' => config('custom.subscription.status.active')
													]);
											})
											->where([
												'sub.is_active' => 1,
												'sub.subscription_user' => $auth_user['user_type'],
											])
											->whereIn('sub.subscription_type', [config('custom.subscription.types.paid')])
											->orderBy('sub.order_no', 'asc');
											
				$list = $main_query->paginate($limit, ['*'], 'page', $page_index);

				$result['list'] = $list->getCollection();
				$result['total'] = $list->total();
				$result['total_page'] = $list->lastPage();
				$result['current_page'] = $list->currentPage();

			}
			
			return $result;

		}catch(\Exception $e) {

            Log::info("error get_subscription_list ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function get_subscription_billing_details($request, $auth_user) {

		$result = [
			'subscription_dtls' => '',
			'payment_method_dtls' => ''
		];

		try{

            $subscription_dtls_result = UserRepo::get_user_subscription($auth_user);

            $result['subscription_dtls'] = $subscription_dtls_result['data'];
			
			$payment_method_result = PaymentRepo::stripe_get_user_default_payment_method($auth_user);
			
			if($payment_method_result['status']){

				$result['payment_method_dtls'] = $payment_method_result['data'];
			
			}	
		
			return $result;

		}catch(\Exception $e) {

            Log::info("error get_subscription_billing_details ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function get_subscription_invoice_history($request, $auth_user) {

		$result = [
			'list' => [],
			'total' => 0,
			'total_page' => 0,
			'current_page' => 1
		];

		try{

			$limit = $request->has('limit') ? $request->limit : config('custom.default_page_limit');
			$page_index = $request->has('page') ? $request->page : 1;
			
			if(isset($auth_user) && !empty($auth_user)){

				$main_query = UserSubscription::from('sg_user_subscriptions as user_sub')
												->select('user_sub.*', 'sub.subscription_name', 'sub.price', 'sub.subscription_type')
												->join('sg_subscriptions as sub', function($join) use($auth_user) {
													$join->on('sub.subscription_id', '=', 'user_sub.subscription_id');
												})
												->where([
													'user_sub.is_active' => 1,
													'user_sub.association_id' => $auth_user['user_id'],
													'user_sub.association_type_term' => $auth_user['user_type']
												])
												->orderBy('user_sub.user_subscription_id', 'desc');
											
				$list = $main_query->paginate($limit, ['*'], 'page', $page_index);

				$result['list'] = $list->getCollection();
				$result['total'] = $list->total();
				$result['total_page'] = $list->lastPage();
				$result['current_page'] = $list->currentPage();

			}
			
			return $result;

		}catch(\Exception $e) {

            Log::info("error get_subscription_invoice_history ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function check_user_already_purchased_cancelled_subscription($request, $user_data) {

		$result = [
			'status' => 0,
			'data' => [
				'subscription_dtls' => '',
				'subscription_purchased' => 0,
				'subscription_cancelled' => 0
			]
		];

		try{

			$subscription = UserSubscription::from('sg_user_subscriptions as us')
												->join('sg_subscriptions as sub','sub.subscription_id','=','us.subscription_id')
												->where([
													'us.subscription_id' => $request->subscription_id,
													'us.association_id' => $user_data['user_id'],
													'us.association_type_term' => $user_data['user_type'],
													'us.is_active' => 1
												])
												->where('us.subscription_status', '!=', config('custom.subscription.status.cancelled'))
												->select('us.*', 'sub.*', 'us.created_at as invoice_date')
												->first();
												
			if($subscription){
				
				if(in_array($subscription->subscription_status, [config('custom.subscription.status.pending')])){

					$result['data']['subscription_purchased'] = 1;

				}else if($subscription->subscription_status == config('custom.subscription.status.active')){

					if($subscription->is_auto_payment == 0){
						$result['data']['subscription_cancelled'] = 1;
					}else{
						$result['data']['subscription_purchased'] = 1;
					}
				}

			}

			$result['status'] = 1;							
            $result['data']['subscription_dtls'] = $subscription;
			

			return $result;

		}catch(\Exception $e) {

            Log::info("error check_user_already_purchased_subscription ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	
    public static function get_user_subscription_dtls_by_id($user_subscription_id){

        $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'data' => []];

        try {

            $subscription = UserSubscription::from('sg_user_subscriptions as us')
                                            ->join('sg_subscriptions as sub','sub.subscription_id','=','us.subscription_id')
                                            ->leftJoin('sg_payment_transactions as pay_tra', function($join) {
                                                $join->on('pay_tra.trans_ref_association_id','=','us.user_subscription_id')
                                                    ->where('pay_tra.trans_ref_association_type_term', config('custom.payment_transaction.trans_type.subscription'));
                                            })
                                            ->where([
                                                'us.user_subscription_id' => $user_subscription_id
                                            ])
                                            ->select('us.*', 'sub.*', 'pay_tra.payment_trans_id', 'pay_tra.trans_status as payment_status', 'us.created_at as invoice_date')
                                            ->first();
                                            
            $response_array = ['status' => 1, 'data' => $subscription ? $subscription : (object)[] ];

            return $response_array;

        } catch (\Exception $e) {
           
            Log::info("error get_user_subscription_dtls_by_id - ". $e->getMessage());

            return $response_array;
        }
    }

}
