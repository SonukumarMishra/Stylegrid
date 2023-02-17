<?php

namespace App\Http\Controllers\Admin;

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
            
            if(!Session::get("adminLoggedin")) {
                return redirect("/admin");
            }
          
            $this->auth_user = [
                'auth_id' => Session::get("admin_data")->id,
                'user_id' => Session::get("admin_data")->id,
                'auth_name' => Session::get('admin_data')->name,
                'auth_user' => 'admin',
                'user_type' => 'admin'
            ];

            return $next($request);
        });
    }

    public function index($chat_room_id='')
    {
        return view('admin.chat.index', compact('chat_room_id'));
    }
    
    public function getChatContacts(Request $request)
    {
        $result = ChatRepo::getChatContacts($request, $this->auth_user);
     
        $view = '';

        $view = view("admin.chat.contacts-list", compact('result'))->render();

        $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 
                            'data' => [
                                'view' => $view,
                                'total_page' => $result['total_page'],
                                'list' => $result['list']
                            ]  
                        ];

        return response()->json($response_array, 200);
        
    }

    public function getChatRoomMessage(Request $request){

        $result = ChatRepo::getChatMessages($request, $this->auth_user);     
        return response()->json($result, 200);

    }
}
