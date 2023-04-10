<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\Stylist;
use App\Models\Member;
use App\Models\Sourcing;
use App\Models\SourcingOffer;
use App\Models\SourcingInvoice;
use App\Repositories\CommonRepository as CommonRepo;
use App\Repositories\PaymentRepository as PaymentRepo;
use Carbon\Carbon;
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
							->with('sourcing_invoice')
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

			// DB::connection()->enableQueryLog();

			$list = Sourcing::from('sg_sourcing')
							->select("sg_sourcing.id", "sg_sourcing.member_stylist_id", "sg_sourcing.member_stylist_type", "sg_sourcing.p_image", "sg_sourcing.p_name", "sg_sourcing.p_slug", "sg_sourcing.p_code", "b.name", "sg_sourcing.p_type", "sg_sourcing.p_size", "c.country_name", "sg_sourcing.p_deliver_date", "sg_sourcing.p_status", 'offer.status as stylist_offer_status')
							->addSelect(DB::raw("( SELECT tso.created_at FROM sg_sourcing_offer AS tso WHERE tso.sourcing_id = sg_sourcing.id ORDER BY tso.updated_at DESC LIMIT 1) as offer_updated_on"))
							->join('sg_country AS c', 'c.id', '=', 'sg_sourcing.p_country_deliver')
							->join('sg_brand AS b', 'b.id', '=', 'sg_sourcing.p_brand')
							->leftjoin('sg_sourcing_offer AS offer', function($join) use($request) {
								$join->on('offer.sourcing_id', '=', 'sg_sourcing.id')
									->where([
										'offer.stylist_id' => $request->user_id
									]);
							})
							->withCount([ 
								'sourcing_offers as requested' => function ($query) use($request) {
									$query->select(
										\DB::raw("COUNT(id)")
										)
										->where('stylist_id', $request->user_id);
								}
							])
							->with([ 
								'sourcing_accepted_details' => function ($query) use($request) {
									if($request->user_type == config('custom.user_type.stylist')){
										$query->where('stylist_id', $request->user_id);
									}
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

	public static function getStylistSourcingLiveRequestsWeeklyCount($request) {
		
		$total_count = 0;

		try {

			$my_requests_ids = Sourcing::from('sg_sourcing')
										->where('sg_sourcing.member_stylist_type', '=' , config('custom.sourcing.sourcing_user_type.stylist'))
										->where('sg_sourcing.member_stylist_id', '=', $request->user_id)
										->pluck('id');

			$total_count = Sourcing::from('sg_sourcing')
							->whereNotIn('sg_sourcing.id', $my_requests_ids)
							->whereBetween('sg_sourcing.created_at', 
								[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
							)
							->count("sg_sourcing.id");
							
			return $total_count;
					
		}catch(\Exception $e) {

            Log::info("error getStylistSourcingLiveRequestsWeeklyCount ". print_r($e->getMessage(), true));
	
			return $total_count;

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
							->with([ 
								'sourcing_accepted_details' => function ($query) use($request) {
									// if($request->user_type == config('custom.user_type.stylist')){
									// 	$query->where('stylist_id', $request->user_id);
									// }
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

		try {

			$pusher_ref = new Pusher(
				config('chat.pusher.key'),
				config('chat.pusher.secret'),
				config('chat.pusher.app_id'),
				config('chat.pusher.options'),
			);

			$payload_data = [];
		
			if($action_type == config('custom.sourcing_pusher_action_type.new_request')){

				if(isset($data['sourcing_id']) && !empty($data['sourcing_id'])){
					
					$sourcing_dtls = Sourcing::where('id', $data['sourcing_id'])
											->select('member_stylist_id as association_id','p_name', 'id as sourcing_id')
											->addselect(DB::raw('(CASE 	WHEN member_stylist_type = "'.config("custom.sourcing.sourcing_user_type.member").'" THEN "'.config("custom.user_type.member").'" 
																		WHEN member_stylist_type = "'.config("custom.sourcing.sourcing_user_type.stylist").'" THEN "'.config("custom.user_type.stylist").'" 
																		ELSE "" END) AS association_type_user'))
											->first();
					if($sourcing_dtls){

						$payload_data['association_id'] = $sourcing_dtls->association_id;
						$payload_data['association_type_user'] = $sourcing_dtls->association_type_user;

						try {

							$pusher_ref->trigger('private-chatify', 'sourcing_updates', [
								'action' => config('custom.sourcing_pusher_action_type.new_request'),
								'data' => $payload_data
							]);

						}catch(\Exception $e) {
							Log::info("error pusher sourcing_updates ". print_r($e->getMessage(), true));
						}

						// Notify to all stylists for new request

						$dont_notify_stylist_ids = [];
						
						if($sourcing_dtls->association_type_user == config('custom.user_type.stylist')){

							// If this request created by any stylist user, so send to other all stylists notification, don't send to self stylist who created request
							$dont_notify_stylist_ids[] = $sourcing_dtls->association_id;
							
						}

						$notify_users = Stylist::select('id as association_id',  DB::raw("'".config('custom.user_type.stylist')."' as association_type_term"))
											->whereNotIn('id', $dont_notify_stylist_ids)
											->get()
											->toArray();

						if(count($notify_users)){

							$notification_obj = [
								'type' => config('custom.notification_types.sourcing_new_request'),
								'title' => trans('pages.notifications.sourcing_new_request_title'),
								'description' => trans('pages.notifications.sourcing_new_request_des', ['product_title' => $sourcing_dtls->p_name]),
								'data' => [
									'sourcing_id' => $sourcing_dtls->sourcing_id,
								],
								'users' => $notify_users
							];

							CommonRepo::save_notification($notification_obj);

						}

					}
				}
				
	
			}else if($action_type == config('custom.sourcing_pusher_action_type.offer_received')){
				
				// when stylist send thier price and offer to memeber/stylist notify 

				if(isset($data['sourcing_offer_id']) && !empty($data['sourcing_offer_id'])){
					
					$offer_dtls = SourcingOffer::from('sg_sourcing_offer as offer')
												->join('sg_sourcing AS source', 'source.id', '=', 'offer.sourcing_id')
												->where('offer.id', $data['sourcing_offer_id'])
												->select('source.member_stylist_id', 'source.member_stylist_type', 'source.p_name', 'offer.sourcing_id', 'offer.id as sourcing_offer_id')
												->first();
					
					if($offer_dtls){

						$payload_data['notify_user_id'] = $offer_dtls->member_stylist_id;

						if($offer_dtls->member_stylist_type == config('custom.sourcing.sourcing_user_type.member')){
							$payload_data['notify_user_type'] = config('custom.user_type.member');
						}else{
							$payload_data['notify_user_type'] = config('custom.user_type.stylist');
						}

						try{
						
							$pusher_ref->trigger('private-chatify', 'sourcing_updates', [
													'action' => config('custom.sourcing_pusher_action_type.offer_received'),
													'data' => $payload_data
												]);

						}catch(\Exception $e) {
							Log::info("error pusher sourcing_updates ". print_r($e->getMessage(), true));
						}

						$notify_users = [
							[
								'association_id' => $payload_data['notify_user_id'],
								'association_type_term' => $payload_data['notify_user_type']
							]
						];

						// save notifications 
						if(count($notify_users)){

							$notification_obj = [
								'type' => config('custom.notification_types.sourcing_offer_received'),
								'title' => trans('pages.notifications.sourcing_offer_received_title'),
								'description' => trans('pages.notifications.sourcing_offer_received_des', ['product_title' => $offer_dtls->p_name]),
								'data' => [
									'sourcing_offer_id' => $offer_dtls->sourcing_offer_id,
									'sourcing_id' => $offer_dtls->sourcing_id,
								],
								'users' => $notify_users
							];
		
							CommonRepo::save_notification($notification_obj);
	
						}
					}
				}

			}else if(in_array($action_type, [ config('custom.sourcing_pusher_action_type.offer_accepted'), config('custom.sourcing_pusher_action_type.offer_decline')] )) {
				
				// when any user accept any stylist's offer notify to that offer's stylist user 
				if(isset($data['sourcing_offer_id']) && !empty($data['sourcing_offer_id'])){

					$offer_dtls = SourcingOffer::from('sg_sourcing_offer as offer')
												->join('sg_sourcing AS source', 'source.id', '=', 'offer.sourcing_id')
												->where('offer.id', $data['sourcing_offer_id'])
												->select('offer.*', 'source.p_name')
												->first();
												
					Log::info("offer detls ". print_r($offer_dtls, true));

					if($offer_dtls){

						$payload_data['notify_user_id'] = $offer_dtls->stylist_id;
						$payload_data['notify_user_type'] = config('custom.user_type.stylist');
						
						try{
						
							$pusher_ref->trigger('private-chatify', 'sourcing_updates', [
													'action' => $action_type,
													'data' => $payload_data
												]);
											
						}catch(\Exception $e) {
							Log::info("error pusher sourcing_updates ". print_r($e->getMessage(), true));
						}

						$notify_users = [
							[
								'association_id' => $payload_data['notify_user_id'],
								'association_type_term' => $payload_data['notify_user_type']
							]
						];
						
						$notify_title = $notify_desc = $notify_type = '';

						if($action_type == config('custom.sourcing_pusher_action_type.offer_accepted')){
							
							$notify_type = config('custom.notification_types.sourcing_offer_accepted'); 
							$notify_title = trans('pages.notifications.sourcing_offer_accepted_title');
							$notify_desc = trans('pages.notifications.sourcing_offer_accepted_des', ['product_title' => $offer_dtls->p_name]);
							
						}else if($action_type == config('custom.sourcing_pusher_action_type.offer_decline')){

							$notify_type = config('custom.notification_types.sourcing_offer_decline');
							$notify_title = trans('pages.notifications.sourcing_offer_decline_title');
							$notify_desc = trans('pages.notifications.sourcing_offer_decline_des', ['product_title' => $offer_dtls->p_name]);
						}

						// save notifications 
						if(count($notify_users)){

							$notification_obj = [
								'type' => $notify_type,
								'title' => $notify_title,
								'description' => $notify_desc,
								'data' => [
									'sourcing_offer_id' => $offer_dtls->id,
									'sourcing_id' => $offer_dtls->sourcing_id,
								],
								'users' => $notify_users
							];
		
							Log::info("data obj ". print_r($notification_obj, true));

							CommonRepo::save_notification($notification_obj);
	
						}
					}
				}
			}

		}catch(\Exception $e) {

            Log::info("error triggerPusherEventsForSourcingUpdates ". print_r($e->getMessage(), true));

			$response_array['error'] = $e->getMessage();

			return $response_array;

        }

	}

	public static function getSourcingRequestDetails($slug) {
		
		$result = false;

		try {

			$result = Sourcing::from('sg_sourcing as sourcing')
								->select('sourcing.*')
								->join('sg_brand AS b', 'b.id', '=', 'sourcing.p_brand')
								->where('sourcing.p_slug', $slug)
								->with(['sourcing_accepted_details', 'sourcing_chat_room', 'sourcing_invoice'])
								->first();
					
			return $result;

		}catch(\Exception $e) {

            Log::info("error getSourcingRequestDetails ". print_r($e->getMessage(), true));

			return $result;

        }

	}


	public static function getSourcingRequestDetail($slug) {
		
		$result = false;

		try {

			$result = Sourcing::from('sg_sourcing as sourcing')
								->select(
									[
										"sourcing.id",
										"sourcing.member_stylist_id",
										"sourcing.member_stylist_type",
										"sourcing.p_image",
										"sourcing.p_name",
										"sourcing.p_slug",
										"sourcing.p_code",
										"sourcing.p_brand",
										"sourcing.p_type",
										"sourcing.p_size",
										"sourcing.p_country_deliver",
										"sourcing.p_deliver_date",
										"sourcing.p_status",
										"sourcing.p_created_date",
										"b.name as brand_name",
									]
								)
								->join('sg_brand AS b', 'b.id', '=', 'sourcing.p_brand')
								->where('sourcing.p_slug', $slug)
								->with(['sourcing_accepted_details', 'sourcing_chat_room'])
								->first();
					
			Log::info("data ". print_r($result, true));

			return $result;

		}catch(\Exception $e) {

            Log::info("error getSourcingRequestDetails ". print_r($e->getMessage(), true));

			return $result;

        }

	}

	public static function generateSourcingInvoice($request) {
		
		$result = ['status' => 0, 'message' => trans('pages.something_wrong')];

		try {

			$sourcing_dtls = Sourcing::from('sg_sourcing')
										->where('sg_sourcing.id', '=' , $request->sourcing_id)
										->first();

			if($sourcing_dtls){

				$sourcing_invoice = SourcingInvoice::from('sg_sourcing_invoices as invoice')
													->where([
														'invoice.sourcing_id' => $request->sourcing_id,
														'invoice.is_active' => 1
													])
													->first();

				if(!$sourcing_invoice){
					
					$sourcing_invoice = new SourcingInvoice;
					$sourcing_invoice->sourcing_id = $request->sourcing_id;
					$sourcing_invoice->association_id = $request->association_id;
					$sourcing_invoice->association_type_term = $request->association_type_term;
					$sourcing_invoice->invoice_amount = $request->invoice_amount;
					$sourcing_invoice->invoice_status = config('custom.sourcing.invoice_status.invoice_generated');
					$sourcing_invoice->save();

					if($sourcing_invoice){

						Sourcing::where([
							'id' => $request->sourcing_id
						])->update([
							'p_status' => config('custom.sourcing.status.invoice_generated')
						]);

						$notify_users = [[
							'association_id' => $sourcing_dtls->member_stylist_id,
							'association_type_term' => $sourcing_dtls->member_stylist_type == 1 ? config('custom.user_type.stylist') : config('custom.user_type.member')
						]];

						if(count($notify_users)){

							$notification_obj = [
								'type' => config('custom.notification_types.sourcing_invoice_generated'),
								'title' => trans('pages.notifications.sourcing_invoice_generated_title'),
								'description' => trans('pages.notifications.sourcing_invoice_generated_des', ['product_title' => $sourcing_dtls->p_name]),
								'data' => [
									'sourcing_id' => $sourcing_dtls->id,
								],
								'users' => $notify_users
							];

							CommonRepo::save_notification($notification_obj);

						}

						$result['status'] = 1;
						$result['message'] = trans('pages.sourcing_invoice_generated');
		
					}

				}else{

					$result['message'] = trans('pages.sourcing_invoice_already_generated');

				}

			}else{

				$result['message'] = trans('pages.crud.no_data', ['attr' => 'Sourcing request']);

			}

			return $result;

		}catch(\Exception $e) {

            Log::info("error generateSourcingInvoice ". print_r($e->getMessage(), true));

			return $result;

        }

	}

	public static function paySourcingInvoice($request) {
		
		$response_array = ['status' => 0, 'message' => trans('pages.something_wrong')];

		try {

			$sourcing_dtls = Sourcing::find($request->sourcing_id);
			
			if(!$sourcing_dtls){
				
				$response_array['message'] = trans('pages.crud.no_data', ['attr' => 'Sourcing request']);
				return $response_array;
			}

			$sourcing_invoice = SourcingInvoice::find($request->sourcing_invoice_id);
			
			if(!$sourcing_invoice){
				
				$response_array['message'] = trans('pages.crud.no_data', ['attr' => 'Sourcing invoice']);
				return $response_array;
			}

			$payment_result = PaymentRepo::stripe_charge_payment($request);
            
			if($payment_result['status']){

				$payment_dtls = $payment_result['data']['payment_dtls'];

				$payment_status = $payment_dtls->status;

				$payment_trans_data = [
					'association_id' => @$request->user_id,
					'association_type_term' => @$request->user_type,
					'trans_amount' => @$request->amount,
					'trans_type' => config('custom.payment_transaction.type_debit'),
					'payment_gatway' => config('custom.payment_gatway.stripe'),
					'trans_ref_association_type_term' => config('custom.payment_transaction.trans_type.sourcing'),
					'trans_ref_association_id' => @$sourcing_dtls->id,
					'trans_status' => @$payment_status,
					'is_paid' => @$payment_status == config('custom.stripe.charge_status.succeeded') ? 1 : 0
				];

				if(in_array($payment_status, [ config('custom.stripe.charge_status.succeeded'), config('custom.stripe.charge_status.pending')])){

					$payment_trans_data['trans_id'] = @$payment_dtls->id;
					$payment_trans_data['trans_currency'] = @$payment_dtls->currency;
					$payment_trans_data['trans_mode'] = @$payment_dtls->source->object;
					$payment_trans_data['trans_currency'] = @$payment_dtls->id;
					$payment_trans_data['trans_currency'] = @$payment_dtls->id;

					// Save payment transaction details
					$payment_trans_result = PaymentRepo::save_payment_transaction($payment_trans_data);
					
					$payment_trans_id = '';

					if($payment_trans_result['status']){
						$payment_trans_id = $payment_trans_result['data']['payment_trans_id'];
					}
					
					$sourcing_invoice->invoice_paid_on = date('Y-m-d H:i:s');
					$sourcing_invoice->payment_trans_id = $payment_trans_id;
					$sourcing_invoice->invoice_status = config('custom.sourcing.invoice_status.invoice_paid');
					$sourcing_invoice->save();

					$sourcing_dtls->p_status = config('custom.sourcing.status.invoice_paid');
					$sourcing_dtls->save();

					// Save invoice pdf 

					// send notification to stylist for payment 
					
					$sourcing_user = '';

					if($sourcing_dtls->member_stylist_type == 1){

						$sourcing_user = Stylist::find($sourcing_dtls->member_stylist_id);

					}else{

						$sourcing_user = Member::find($sourcing_dtls->member_stylist_id);
					}

					if(!empty($sourcing_user)){

						$notify_users = [[
							'association_id' => $sourcing_invoice->association_id,
							'association_type_term' => $sourcing_invoice->association_type_term
						]];
	
						if(count($notify_users)){
	
							$notification_obj = [
								'type' => config('custom.notification_types.sourcing_invoice_paid'),
								'title' => trans('pages.notifications.sourcing_invoice_paid_title'),
								'description' => trans('pages.notifications.sourcing_invoice_paid_des', [
									'user' => @$sourcing_user->full_name,
									'amount' => \Helper::format_number(@$request->amount),
									'product_title' => $sourcing_dtls->p_name]),
								'data' => [
									'sourcing_id' => $sourcing_dtls->id,
								],
								'users' => $notify_users
							];
	
							CommonRepo::save_notification($notification_obj);
	
						}

					}
					
					$response_array['status'] = 1;
					$response_array['message'] = trans('pages.sourcing_invoice_payment_success');

				}else if(in_array($payment_status, [ config('custom.stripe.charge_status.failed')])){

					$response_array['message'] = trans('pages.sourcing_invoice_payment_success');

					$payment_trans_data['trans_error_code'] = @$payment_dtls->failure_code;
					$payment_trans_data['trans_error_description'] = @$payment_dtls->failure_message;
					$payment_trans_data['trans_error_reason'] = @$payment_dtls->failure_message;

					PaymentRepo::save_payment_transaction($payment_trans_data);

				}

			}else{

				$response_array['message'] = $payment_result['error'];

			}

			Log::info("all paySourcingInvoice ". print_r($response_array, true));

			return $response_array;

		}catch(\Exception $e) {

            Log::info("error paySourcingInvoice ". print_r($e->getMessage(), true));
			
			$response_array['error'] = $e->getMessage();

			return $response_array;

        }

	}

}
