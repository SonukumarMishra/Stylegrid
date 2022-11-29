<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\Stylist;
use App\Models\Member;
use App\Models\ChatRoom;
use App\Models\ChatRoomMessage;
use Validator;
use Helper;
use DB;
use Log;

class ChatRepository {

	public $pusher;

	public function __construct()
    {
        // $this->pusher = new Pusher(
        //     config('chat.pusher.key'),
        //     config('chat.pusher.secret'),
        //     config('chat.pusher.app_id'),
        //     config('chat.pusher.options'),
        // );
    }

	public function pusherAuth($request, $auth_user) {

		try{
		Log::info("data ". print_r($auth_user, true));
			// Auth data
			$authData = json_encode([
				'auth_id' => $auth_user['auth_id'],
				'auth_user' => $auth_user['auth_user'],
				'user_info' => $auth_user,
			]);
	
			$pusher_ref = new Pusher(
				config('chat.pusher.key'),
				config('chat.pusher.secret'),
				config('chat.pusher.app_id'),
				config('chat.pusher.options'),
			);

			return $pusher_ref->socket_auth($request->channel_name, $request->socket_id, $authData);
    
		}catch(\Exception $e) {

            Log::info("error pusherAuth ". print_r($e->getMessage(), true));
        }

	}

	public static function getChatContacts($request, $auth_user) {

		$result = [
			'list' => []
		];

		try{
			
			DB::connection()->enableQueryLog();

			$users = DB::table('sg_chat_room as room')
						->select("room.*")
						->addSelect(DB::raw("( SELECT cr1.message FROM sg_chat_room_messages AS cr1 WHERE cr1.chat_room_id = room.chat_room_id ORDER BY cr1.created_at DESC LIMIT 1) as last_message"))
						->addSelect(DB::raw("( SELECT cr1.created_at FROM sg_chat_room_messages AS cr1 WHERE cr1.chat_room_id = room.chat_room_id ORDER BY cr1.created_at DESC LIMIT 1) as last_message_on"))
						->where(function ($q) use($auth_user) {
							$q->where('room.sender_id', $auth_user['auth_id'])
							->where('room.sender_user', $auth_user['user_type']);
						})
						->orwhere(function ($q) use($auth_user) {
							$q->where('room.receiver_id', $auth_user['auth_id'])
							->where('room.receiver_user', $auth_user['user_type']);
						})
						->where('room.is_active', 1)
						->groupBy('room.chat_room_id')
						->orderBy('room.created_at');

			if(isset($request->module) && !empty(isset($request->module))){
				$users = $users->where('module', $request->module);
			}

			$users = $users->get();
			
			if(count($users)){

				foreach ($users as $key => $value) {
					
					$temp_sender_id = $value->sender_id;
					$temp_sender_user = $value->sender_user;
					
					$temp_receiver_id = $value->receiver_id;
					$temp_receiver_user = $value->receiver_user;

					if($auth_user['user_type'] == "stylist"){

						if($temp_sender_user == $auth_user['user_type']){

							$users[$key]->sender_id = $temp_sender_id;
							$users[$key]->receiver_id = $temp_receiver_id;

							$users[$key]->sender_user = $temp_sender_user;
							$users[$key]->receiver_user = $temp_receiver_user;

						}else if($temp_receiver_user == $auth_user['user_type']){
							
							$users[$key]->sender_id = $temp_receiver_id;
							$users[$key]->receiver_id = $temp_sender_id;

							$users[$key]->sender_user = $temp_receiver_user;
							$users[$key]->receiver_user = $temp_sender_user;

						}

					}else if($auth_user['user_type'] == "member"){

						if($temp_sender_user == $auth_user['user_type']){

							$users[$key]->sender_id = $temp_sender_id;
							$users[$key]->receiver_id = $temp_receiver_id;

							$users[$key]->sender_user = $temp_sender_user;
							$users[$key]->receiver_user = $temp_receiver_user;
							

						}else if($temp_receiver_user == $auth_user['user_type']){

							$users[$key]->sender_id = $temp_receiver_id;
							$users[$key]->receiver_id = $temp_sender_id;

							$users[$key]->sender_user = $temp_receiver_user;
							$users[$key]->receiver_user = $temp_sender_user;

						}

					}
					
					$users[$key]->sender_name = "";
					$users[$key]->sender_profile = "";
					$users[$key]->sender_is_online = "";
					$users[$key]->receiver_name = "";
					$users[$key]->receiver_profile = "";
					$users[$key]->receiver_is_online = "";

					$sender_info = $receiver_info = false;

					if($users[$key]->sender_user == 'stylist'){
						
						$sender_info = Stylist::where('id', $users[$key]->sender_id)
											->select('full_name as sender_name', 'profile_image as sender_profile', 'is_online as sender_is_online')
											->first();
						
					}else if($users[$key]->sender_user == 'member'){

						$sender_info = Member::where('id', $users[$key]->sender_id)
											->select('full_name as sender_name', 'profile_image as sender_profile', 'is_online as sender_is_online')
											->first();						
					}

					if($users[$key]->receiver_user == 'stylist'){
						
						$receiver_info = Stylist::where('id', $users[$key]->receiver_id)
											->select('full_name as receiver_name', 'profile_image as receiver_profile', 'is_online as receiver_is_online')
											->first();
						
					}else if($users[$key]->receiver_user == 'member'){

						$receiver_info = Member::where('id', $users[$key]->receiver_id)
											->select('full_name as receiver_name', 'profile_image as receiver_profile', 'is_online as receiver_is_online')
											->first();						
					}

					if($sender_info){

						$users[$key]->sender_name = $sender_info->sender_name;
						$users[$key]->sender_profile = $sender_info->sender_profile;
						$users[$key]->sender_is_online = $sender_info->sender_is_online;

					}

					if($receiver_info){

						$users[$key]->receiver_name = $receiver_info->receiver_name;
						$users[$key]->receiver_profile = $receiver_info->receiver_profile;
						$users[$key]->receiver_is_online = $receiver_info->receiver_is_online;

					}

				}
			}

			// $queries = DB::getQueryLog();
			
			// Log::info(print_r($users, true)); 
			
			$result['list'] = $users;

			return $result;
    
		}catch(\Exception $e) {
            Log::info("error getChatContacts ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function saveChatMessage($request, $auth_user) {

		$response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

		try{

            $validation_rules = [
                'chat_room_id' => 'required',
                'receiver_user' => 'required',
                'receiver_id' => 'required',
            ];

            $validator = Validator::make( $request->all(), $validation_rules );
			
            if($validator->fails()) {

                return ['status' => 0, 'message' => implode(',', $validator->messages()->all()) ];

            }  else {

                $room = DB::table('sg_chat_room')
                            ->where('chat_room_id', $request->chat_room_id)
                            ->where('is_active', 1)
                            ->first();
                if($room){

                    $chat_message = new ChatRoomMessage;

                    if($request->type == 'file'){

                        $doc_title = isset($request->media_name) ? $request->media_name : time();

                        $doc_url = \Helper::upload_document($request->media_source, 'uploads/chat/'.$request->chat_room_id, $doc_title);

                        $chat_message->file_url = $doc_url;
                        $chat_message->file_formate = $request->file_formate;

                    }

                    $chat_message->chat_room_id = $request->chat_room_id;
                    $chat_message->message = $request->message;
                    $chat_message->sender_id = $auth_user['auth_id'];
					$chat_message->sender_user = $auth_user['user_type'];
                    $chat_message->receiver_id = $request->receiver_id;
					$chat_message->receiver_user = $request->receiver_user;
                    $chat_message->type = $request->type;
                    $chat_message->is_active = 1;
                    $chat_message->save();

					if($chat_message){

						$sender_user = $receiver_user = false;

						if($chat_message->sender_user == 'stylist'){
							$sender_user = Stylist::find($chat_message->sender_id);
						}else if($chat_message->sender_user == 'member'){
							$sender_user = Member::find($chat_message->sender_id);
						}
	
						if($chat_message->receiver_user == 'stylist'){
							$receiver_user = Stylist::find($chat_message->receiver_id);
						}else if($chat_message->receiver_user == 'member'){
							$receiver_user = Member::find($chat_message->receiver_id);
						}
	
						$chat_message['sender_name'] = $sender_user ? $sender_user->full_name : '';
						$chat_message['sender_profile'] = $sender_user ? $sender_user->profile_image : '';
						$chat_message['sender_is_online'] = $sender_user ? $sender_user->is_online : 0;
						$chat_message['receiver_name'] = $receiver_user ? $receiver_user->full_name : '';
						$chat_message['receiver_profile'] = $receiver_user ? $receiver_user->profile_image : '';
						$chat_message['receiver_is_online'] = $receiver_user ? $receiver_user->is_online : 0;
						$chat_message['is_my_message'] = ($auth_user['user_type'] == $chat_message->sender_user ? 1 : 0);
						$chat_message['last_message'] = $chat_message->message;
						$chat_message['last_message_on'] = $chat_message->created_at;
						$chat_message['temp_id'] = isset($request->temp_id) ? $request->temp_id : '';
						
						$pusher_ref = new Pusher(
							config('chat.pusher.key'),
							config('chat.pusher.secret'),
							config('chat.pusher.app_id'),
							config('chat.pusher.options'),
						);
			
						$pusher_ref->trigger('private-chatify', 'messaging', [
									'chat_room_id' => $request->chat_room_id,
									'message_obj' => $chat_message
								]);
						
						$response_array = array('status' => 1, 'data' => $chat_message );
	
					}else{
						
						$response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

					}

                } else {

                    $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

                }

            }
	
			return $response_array;
    
		}catch(\Exception $e) {

            Log::info("error saveChatMessage ". print_r($e->getMessage(), true));

			$response_array['error'] = $e->getMessage();

			return $response_array;

        }

	}

	public static function getChatMessages($request, $auth_user) {

		$response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

		try {

            $validation_rules = [
                'chat_room_id' => 'required'
            ];

            $validator = Validator::make( $request->all(), $validation_rules );

            if($validator->fails()) {

                return ['status' => 0, 'message' => implode(',', $validator->messages()->all()) ];

            } else {

                $limit = $request->has('limit') ? $request->limit : 20;
                $page_index = $request->has('page') ? $request->page : 1;

                $main_query = ChatRoomMessage::select('msg.*')
                                            ->from('sg_chat_room_messages as msg')
                                            ->addSelect(DB::raw("(CASE WHEN msg.sender_user = '".$auth_user['user_type']."' THEN 1 ELSE 0 END) as is_my_message"))
											->addselect(DB::raw('(CASE WHEN msg.sender_user = "stylist" THEN (select full_name from sg_stylist as tmp_st where tmp_st.id = msg.sender_id LIMIT 1)  
											WHEN msg.sender_user = "member" THEN (select full_name from sg_member as tmp_mb where tmp_mb.id = msg.sender_id LIMIT 1)
																ELSE "" END) AS sender_name'))
											->addselect(DB::raw('(CASE WHEN msg.receiver_user = "stylist" THEN (select full_name from sg_stylist as tmp_st where tmp_st.id = msg.receiver_id LIMIT 1)  
																WHEN msg.receiver_user = "member" THEN (select full_name from sg_member as tmp_mb where tmp_mb.id = msg.receiver_id LIMIT 1)
																ELSE "" END) AS receiver_name'))
						
											->addselect(DB::raw('(CASE WHEN msg.sender_user = "stylist" THEN (select profile_image from sg_stylist as tmp_st where tmp_st.id = msg.sender_id LIMIT 1)  
																WHEN msg.sender_user = "member" THEN (select profile_image from sg_member as tmp_mb where tmp_mb.id = msg.sender_id LIMIT 1)
																ELSE "" END) AS sender_profile'))
						
											->addselect(DB::raw('(CASE WHEN msg.receiver_user = "stylist" THEN (select profile_image from sg_stylist as tmp_st where tmp_st.id = msg.receiver_id LIMIT 1)  
																WHEN msg.receiver_user = "member" THEN (select profile_image from sg_member as tmp_mb where tmp_mb.id = msg.receiver_id LIMIT 1)
																ELSE "" END) AS receiver_profile'))
											->where('msg.chat_room_id', $request->chat_room_id)
                                            ->orderBy('msg.created_at', 'DESC');

                $list = $main_query->paginate($limit, ['*'], 'page', $page_index);

                $result = [
                    'list' => $list->getCollection(),
                    'total' => $list->total()
                ];

                $response_array = array('status' => 1,  'message' => trans('pages.action_success'), 'data' => $result );

                return $response_array;
            }

        }catch(\Exception $e) {

            Log::info("error getChatMessages ". print_r($e->getMessage(), true));

			$response_array['error'] = $e->getMessage();

			return $response_array;
        }

	}

	
	
}
