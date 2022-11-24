<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Pusher\Pusher;
use Validator;
use Helper;
use DB;
use Log;

class ChatRepository {

	public $pusher;

	public function __construct()
    {
        $this->pusher = new Pusher(
            config('chat.pusher.key'),
            config('chat.pusher.secret'),
            config('chat.pusher.app_id'),
            config('chat.pusher.options'),
        );
    }

	public static function pusherAuth($request, $auth_user) {

		try{

			// Auth data
			$authData = json_encode([
				'user_id' => $auth_user['auth_id'],
				'user_info' => [
					'name' => $auth_user['auth_name']
				]
			]);
	
			return $this->pusher->socket_auth($request->channel_name, $request->socket_id, $authData);
    
		}catch(\Exception $e) {

            Log::info("error pusherAuth ". print_r($e->getMessage(), true));
        }

	}

}
