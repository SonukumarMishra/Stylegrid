<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Validator;
use Helper;
use App\Models\Subscription;
use DB;
use Log;

class SubscriptionRepository {
	
	public static function get_subscription_list($request, $auth_user) {

		$result = [
			'list' => [],
			'total' => 0,
			'total_page' => 0,
			'current_page' => 1,
			'cart_items_count' => 0
		];

		try{

			$limit = $request->has('limit') ? $request->limit : config('custom.default_page_limit');
			$page_index = $request->has('page') ? $request->page : 1;
			
			if(isset($auth_user) && !empty($auth_user)){

				$main_query = Subscription::from('sg_subscriptions as sub')
									->select('sub.*', 'user_sub.user_subscription_id', 'user_sub.subscription_id as user_main_subscription_id')
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
									->whereIn('sub.subscription_type', [config('custom.subscription.types.free'), config('custom.subscription.types.paid')])
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


}
