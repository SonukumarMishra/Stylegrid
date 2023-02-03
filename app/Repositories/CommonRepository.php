<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Validator;
use App\Models\Notifications;
use App\Models\NotificationUsers;
use Helper;
use DB;
use Log;

class CommonRepository {
	
	public static function save_notification($obj)
	{

		try {

			$notification = new Notifications;
			$notification->notification_type = isset($obj['type']) ? $obj['type'] : '';
			$notification->notification_title = isset($obj['title']) ? $obj['title'] : '';
			$notification->notification_description = isset($obj['description']) ? $obj['description'] : '';
			$notification->data = isset($obj['data']) ? json_encode($obj['data']) : '';
			$notification->save();

			$user_association_ids = [];

			if ($notification) {

				if (isset($obj['users']) && is_array($obj['users'])) {

					foreach ($obj['users'] as $key => $value) {

						$notify = new NotificationUsers;
						$notify->notification_id = $notification->notification_id;
						$notify->association_id = $value['association_id'];
						$notify->association_type_term = $value['association_type_term'];
						$notify->save();

					}
				}
			}

		} catch (\Exception $e) {

			Log::info("error save_notification " . print_r($e->getMessage(), true));
		}
	}

	public static function get_all_notifications($request) {

		$result = [
			'list' => [],
			'total' => 0,
			'total_page' => 0
		];

		try{

			NotificationUsers::where('association_type_term', $request->user_type)
								->where('association_id', $request->user_id)
								->where('is_read', '0')
								->update([
									'is_read' => 1
								]);

			$list = Notifications::select('not.notification_id', 'not.notification_type', 'not.notification_title', 'not.notification_description', 'not.data', 'not.icon', 'not.created_at', 'nu.is_read', 'nu.notify_id')
									->from('sg_notifications as not')
									->join('sg_notification_users as nu', function($join) use($request) {
											$join->on('nu.notification_id', '=', 'not.notification_id')
												->where('nu.association_id',  $request->user_id)
												->where('nu.association_type_term', $request->user_type);
									})
									->where('not.is_active', 1)
									->orderBy('not.notification_id', 'desc')
									->paginate(config('custom.default_page_limit'), ['*'], 'page', $request->page);
									
			$result['list'] = $list->getCollection();
			$result['total'] = $list->total();
			$result['total_page'] = $list->lastPage();

			return $result;

		}catch(\Exception $e) {

            Log::info("error get_all_notifications ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function get_unread_notifications(Request $request) {

		$result = [
			'list' => [],
			'total' => 0
		];

		try{

			$list = Notifications::select('not.notification_id', 'not.notification_type', 'not.notification_title', 'not.notification_description', 'not.data', 'not.created_at', 'nu.is_read', 'nu.notify_id')
									->from('sg_notifications as not')
									->leftJoin('sg_notification_users as nu', function($join) use($request) {
											$join->on('nu.notification_id', '=', 'not.notification_id')
												->where('nu.association_id',  $request->user_id)
												->where('nu.association_type_term', $request->user_type);
									})
									->where('not.is_active', 1)
									->where('nu.is_read', 0)
									->orderBy('not.notification_id', 'desc')
									->get();


			$result['list'] = $list;
			$result['total'] = count($list);

			return $result;

		}catch(\Exception $e) {

            Log::info("error get_unread_notifications ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function mark_as_read_notifications(Request $request) {

		try{

			$main_query = Notifications::from('sg_notifications as not')->where('not.is_active', 1)->where('nu.is_read', 0);

			if(isset($request->read_all) && $request->read_all){

				$main_query = 	$main_query->leftJoin('sg_notification_users as nu', function($join) use($request) {
												$join->on('nu.notification_id', '=', 'not.notification_id')
													->where('nu.association_id', $request->user_id)
													->where('nu.association_type_term', $request->user_type);
											})
											->update([
												'nu.is_read' => 1
											]);


			}else{

				if(isset($request->notify_ids) && is_array($request->notify_ids)){

					$main_query = 	$main_query->leftJoin('sg_notification_users as nu', function($join) use($request) {
													$join->on('nu.notification_id', '=', 'not.notification_id')
														 ->whereIn('nu.notify_id', $request->notify_ids);
												})
												->update([
													'nu.is_read' => 1
												]);

				}
			}


			return true;

		}catch(\Exception $e) {

            Log::info("error mark_as_read_notifications ". print_r($e->getMessage(), true));
			return false;
        }

	}
}
