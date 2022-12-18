<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\Stylist;
use App\Models\Member;
use App\Models\Sourcing;
use App\Models\SourcingOffer;
use Validator;
use Helper;
use DB;
use Log;

class SourcingRepository {

	public $pusher;

	public function __construct()
    {

    }

	public static function getMemberSourcingLiveRequests($request) {
		
		$response_array = [ 'list' => [] ];

		try {

			$page_index = isset($request->page) ? $request->page : 1;

			$list = Sourcing::from('sg_sourcing')
							->select("sg_sourcing.id", "sg_sourcing.member_stylist_id", "sg_sourcing.member_stylist_type", "sg_sourcing.p_image", "sg_sourcing.p_name", "sg_sourcing.p_slug", "sg_sourcing.p_code", "b.name", "sg_sourcing.p_type", "sg_sourcing.p_size", "c.country_name", "sg_sourcing.p_deliver_date", "sg_sourcing.p_status")
							->addSelect(DB::raw("( SELECT tso.created_at FROM sg_sourcing_offer AS tso WHERE tso.sourcing_id = sg_sourcing.id ORDER BY tso.updated_at DESC LIMIT 1) as offer_updated_on"))
							->join('sg_country AS c', 'c.id', '=', 'sg_sourcing.p_country_deliver')
							->join('sg_brand AS b', 'b.id', '=', 'sg_sourcing.p_brand')
							->where([
								'sg_sourcing.member_stylist_type' => config('custom.sourcing.sourcing_user_type.member'),
								'sg_sourcing.member_stylist_id' => $request->user_id
							])
							->where('sg_sourcing.p_deliver_date', '>=' , date('Y-m-d'))
							->withCount([ 
								'sourcing_offers as total_offer' => function ($query) {
									$query->select(\DB::raw("COUNT(id)"));
								},
								'sourcing_offers as pending_offer' => function ($query) {
									$query->where('status', 0)
										->select(\DB::raw("COUNT(id)"));
								},
								'sourcing_offers as accepted_offer' => function ($query) {
									$query->where('status', 1)
										->select(\DB::raw("COUNT(id)"));
								},
								'sourcing_offers as decline_offer' => function ($query) {
									$query->where('status', 2)
										->select(\DB::raw("COUNT(id)"));
								}
								])
							->groupBy("sg_sourcing.id")
							->orderBy('sg_sourcing.p_created_date', 'desc')
							->orderBy("offer_updated_on","DESC")
							->paginate(10, ['*'], 'page', $page_index);
						
			$response_array['list'] = $list;

			return $response_array;

					
		}catch(\Exception $e) {

            Log::info("error getMemberSourcingLiveRequests ". print_r($e->getMessage(), true));

			$response_array['error'] = $e->getMessage();

			return $response_array;

        }

	}

	public static function getStylistSourcingLiveRequests($request) {
		
		$response_array = [ 'list' => [] ];

		try {

			$page_index = isset($request->page) ? $request->page : 1;
			
			$my_requests_ids = Sourcing::from('sg_sourcing')
										->where('sg_sourcing.member_stylist_type', '=' , config('custom.sourcing.sourcing_user_type.stylist'))
										->where('sg_sourcing.member_stylist_id', '=', $request->user_id)
										->pluck('id');

			$list = Sourcing::from('sg_sourcing')
							->select("sg_sourcing.id", "sg_sourcing.member_stylist_id", "sg_sourcing.member_stylist_type", "sg_sourcing.p_image", "sg_sourcing.p_name", "sg_sourcing.p_slug", "sg_sourcing.p_code", "b.name", "sg_sourcing.p_type", "sg_sourcing.p_size", "c.country_name", "sg_sourcing.p_deliver_date", "sg_sourcing.p_status")
							->addSelect(DB::raw("( SELECT tso.created_at FROM sg_sourcing_offer AS tso WHERE tso.sourcing_id = sg_sourcing.id ORDER BY tso.updated_at DESC LIMIT 1) as offer_updated_on"))
							->join('sg_country AS c', 'c.id', '=', 'sg_sourcing.p_country_deliver')
							->join('sg_brand AS b', 'b.id', '=', 'sg_sourcing.p_brand')
							->withCount([ 
								'sourcing_offers as requested' => function ($query) use($request) {
									$query->select(\DB::raw("COUNT(id)"))
											->where('stylist_id', $request->user_id);
								}
							])
							->whereNotIn('sg_sourcing.id', $my_requests_ids)
							->groupBy("sg_sourcing.id")
							->orderBy('sg_sourcing.p_created_date', 'desc')
							->orderBy("offer_updated_on","DESC")
							->paginate(10, ['*'], 'page', $page_index);
						
			$response_array['list'] = $list;

			return $response_array;
					
		}catch(\Exception $e) {

            Log::info("error getStylistSourcingLiveRequests ". print_r($e->getMessage(), true));
			$response_array['error'] = $e->getMessage();
			return $response_array;

        }

	}

	public static function getStylistSourcingOwnRequests($request) {
		
		$response_array = [ 'list' => [] ];

		try {

			$page_index = isset($request->page) ? $request->page : 1;

			$list = Sourcing::from('sg_sourcing')
							->select("sg_sourcing.id", "sg_sourcing.member_stylist_id", "sg_sourcing.member_stylist_type", "sg_sourcing.p_image", "sg_sourcing.p_name", "sg_sourcing.p_slug", "sg_sourcing.p_code", "b.name", "sg_sourcing.p_type", "sg_sourcing.p_size", "c.country_name", "sg_sourcing.p_deliver_date", "sg_sourcing.p_status")
							->addSelect(DB::raw("( SELECT tso.created_at FROM sg_sourcing_offer AS tso WHERE tso.sourcing_id = sg_sourcing.id ORDER BY tso.updated_at DESC LIMIT 1) as offer_updated_on"))
							->join('sg_country AS c', 'c.id', '=', 'sg_sourcing.p_country_deliver')
							->join('sg_brand AS b', 'b.id', '=', 'sg_sourcing.p_brand')
							->where([
								'sg_sourcing.member_stylist_type' => config('custom.sourcing.sourcing_user_type.stylist'),
								'sg_sourcing.member_stylist_id' => $request->user_id
							])
							->withCount([ 
								'sourcing_offers as total_offer' => function ($query) {
									$query->select(\DB::raw("COUNT(id)"));
								},
								'sourcing_offers as pending_offer' => function ($query) {
									$query->where('status', 0)
										->select(\DB::raw("COUNT(id)"));
								},
								'sourcing_offers as accepted_offer' => function ($query) {
									$query->where('status', 1)
										->select(\DB::raw("COUNT(id)"));
								},
								'sourcing_offers as decline_offer' => function ($query) {
									$query->where('status', 2)
										->select(\DB::raw("COUNT(id)"));
								}
							])
							->groupBy("sg_sourcing.id")
							->orderBy('sg_sourcing.p_created_date', 'desc')
							->orderBy("offer_updated_on","DESC")
							->paginate(10, ['*'], 'page', $page_index);
						
			$response_array['list'] = $list;

			return $response_array;

					
		}catch(\Exception $e) {

            Log::info("error getMemberSourcingLiveRequests ". print_r($e->getMessage(), true));

			$response_array['error'] = $e->getMessage();

			return $response_array;

        }

	}

	public static function triggerPusherEventsForSourcingUpdates($action_type, $data) {
		
		Log::info(print_r($data, true));

		try {

			$pusher_ref = new Pusher(
				config('chat.pusher.key'),
				config('chat.pusher.secret'),
				config('chat.pusher.app_id'),
				config('chat.pusher.options'),
			);

			$payload_data = [];
		
			if($action_type == config('custom.sourcing_pusher_action_type.offer_send')){
				
				// when stylist send thier price and offer to memeber/stylist notify 

				if(isset($data['sourcing_offer_id']) && !empty($data['sourcing_offer_id'])){
					
					$offer_dtls = SourcingOffer::from('sg_sourcing_offer as offer')
												->join('sg_sourcing AS source', 'source.id', '=', 'offer.sourcing_id')
												->where('offer.id', $data['sourcing_offer_id'])
												->select('source.member_stylist_id', 'source.member_stylist_type')
												->first();
					
					if($offer_dtls){

						$payload_data['notify_user_id'] = $offer_dtls->member_stylist_id;

						if($offer_dtls->member_stylist_type == config('custom.sourcing.sourcing_user_type.member')){
							$payload_data['notify_user_type'] = config('custom.user_type.member');
						}else{
							$payload_data['notify_user_type'] = config('custom.user_type.stylist');
						}

						$pusher_ref->trigger('private-chatify', 'sourcing_updates', [
												'action' => config('custom.sourcing_pusher_action_type.offer_received'),
												'data' => $payload_data
											]);
					}
				}

			}else if($action_type == config('custom.sourcing_pusher_action_type.new_request')){

				if(isset($data['sourcing_id']) && !empty($data['sourcing_id'])){
					
					$sourcing_dtls = Sourcing::where('id', $data['sourcing_id'])
												->select('member_stylist_id as association_id')
												->addselect(DB::raw('(CASE 	WHEN member_stylist_type = "'.config("custom.sourcing.sourcing_user_type.member").'" THEN "'.config("custom.user_type.member").'" 
																			WHEN member_stylist_type = "'.config("custom.sourcing.sourcing_user_type.stylist").'" THEN "'.config("custom.user_type.stylist").'" 
																			ELSE "" END) AS association_type_user'))
												->first();
					if($sourcing_dtls){

						$payload_data['association_id'] = $sourcing_dtls->association_id;
						$payload_data['association_type_user'] = $sourcing_dtls->association_type_user;
		
						Log::info("data ". print_r($payload_data, true));

						$pusher_ref->trigger('private-chatify', 'sourcing_updates', [
												'action' => config('custom.sourcing_pusher_action_type.new_request'),
												'data' => $payload_data
											]);
					}
				}
				
	
			}else if(in_array($action_type, [ config('custom.sourcing_pusher_action_type.offer_accepted'), config('custom.sourcing_pusher_action_type.offer_decline')] )) {
				
				// when any user accept any stylist's offer notify to that offer's stylist user 
				if(isset($data['sourcing_offer_id']) && !empty($data['sourcing_offer_id'])){

					$offer_dtls = SourcingOffer::from('sg_sourcing_offer as offer')
												->where('offer.id', $data['sourcing_offer_id'])
												->first();
					
					if($offer_dtls){

						$payload_data['notify_user_id'] = $offer_dtls->stylist_id;
						$payload_data['notify_user_type'] = config('custom.user_type.stylist');
						
						$pusher_ref->trigger('private-chatify', 'sourcing_updates', [
												'action' => $action_type,
												'data' => $payload_data
											]);
					}
				}
			}

		}catch(\Exception $e) {

            Log::info("error triggerPusherEventsForSourcingUpdates ". print_r($e->getMessage(), true));

			$response_array['error'] = $e->getMessage();

			return $response_array;

        }

	}
}
