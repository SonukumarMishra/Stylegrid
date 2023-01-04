<?php

namespace App\Http\Controllers\Member;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Repositories\ChatRepository as ChatRepo;
use Session;
use DB;
use Log;

class ChatController extends BaseController
{
    protected $auth_user;

    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
        
        $this->middleware(function ($request, $next) {
            
            if(!Session::get("Memberloggedin")) {
                return redirect("/member-login");
            }

            $this->auth_user = [
                'auth_id' => Session::get("member_id"),
                'user_id' => Session::get("member_id"),
                'auth_name' => Session::get('member_data')->name,
                'auth_profile' => Session::get('member_data')->profile_image,
                'auth_user' => 'member',
                'user_type' => 'member'
            ];

            return $next($request);
        });
    }

    public function index($chat_room_id='')
    {
        return view('member.dashboard.chat.index', compact('chat_room_id'));
    }

    public function pusherAuth(Request $request)
    {
        $result = ChatRepo::pusherAuth($request, $this->auth_user);
        return $result;
    }
    
    public function getChatContacts(Request $request)
    {
        $result = ChatRepo::getChatContacts($request, $this->auth_user);
        
        $response_array = ['status' => 1, 'message' => trans('pages.action_success'), 'data' => $result ];

        return response()->json($response_array, 200);
    }

    public function saveChatMessage(Request $request){

        $result = ChatRepo::saveChatMessage($request, $this->auth_user);     
        return response()->json($result, 200);

    }

    public function getChatRoomMessage(Request $request){

        $result = ChatRepo::getChatMessages($request, $this->auth_user);     
        return response()->json($result, 200);

    }
            
    public function updateChatMessageReadStatus(Request $request){

        $result = ChatRepo::updateChatMessageReadStatus($request, $this->auth_user);     
        return response()->json($result, 200);

    }

    public function updateOnlineStatus(Request $request)
    {
        $result = ChatRepo::updateOnlineStatus($request);        
        return $result;
    }
    
}
