<?php

namespace App\Http\Controllers\Stylist;

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
            
            if(!Session::get("Stylistloggedin")) {
                return redirect("/stylist-login");
            }

            $this->auth_user = [
                'auth_id' => Session::get("stylist_id"),
                'auth_name' => Session::get('stylist_data')->name,
                'user_type' => 'stylist'
            ];

            return $next($request);
        });
    }

    public function index()
    {
        return view('stylist.postloginview.chat.index');
    }

    public function pusherAuth(Request $request)
    {
        $result = ChatRepo::pusherAuth($request, $this->auth_user);
        
        Log::info("result ". print_r($result, true));

        return $result;
    }
    
    public function getContacts(Request $request)
    {

        $auth_user = $this->auth_user;
        
        DB::connection()->enableQueryLog();

        $users = DB::table('sg_chat_room as room')
                            ->select("room.*")
                            ->addselect(DB::raw('(CASE WHEN room.sender_user = "stylist" THEN (select full_name from sg_stylist as tmp_st where tmp_st.id = room.sender_id LIMIT 1)  
                                                WHEN room.sender_user = "member" THEN (select full_name from sg_member as tmp_mb where tmp_mb.id = room.sender_id LIMIT 1)
                                                ELSE "" END) AS sender_name'))
                            ->addselect(DB::raw('(CASE WHEN room.receiver_user = "stylist" THEN (select full_name from sg_stylist as tmp_st where tmp_st.id = room.receiver_id LIMIT 1)  
                                                WHEN room.receiver_user = "member" THEN (select full_name from sg_member as tmp_mb where tmp_mb.id = room.receiver_id LIMIT 1)
                                                ELSE "" END) AS receiver_name'))

                            ->addselect(DB::raw('(CASE WHEN room.sender_user = "stylist" THEN (select profile_image from sg_stylist as tmp_st where tmp_st.id = room.sender_id LIMIT 1)  
                                                WHEN room.sender_user = "member" THEN (select profile_image from sg_member as tmp_mb where tmp_mb.id = room.sender_id LIMIT 1)
                                                ELSE "" END) AS sender_profile'))

                            ->addselect(DB::raw('(CASE WHEN room.receiver_user = "stylist" THEN (select profile_image from sg_stylist as tmp_st where tmp_st.id = room.receiver_id LIMIT 1)  
                                                WHEN room.receiver_user = "member" THEN (select profile_image from sg_member as tmp_mb where tmp_mb.id = room.receiver_id LIMIT 1)
                                                ELSE "" END) AS receiver_profile'))

                            ->addSelect(DB::raw("( SELECT cr1.message FROM chat_room_messages AS cr1 WHERE cr1.chat_room_id = room.chat_room_id ORDER BY cr1.created_at DESC LIMIT 1) as last_message"))
                            ->addSelect(DB::raw("( SELECT cr1.created_at FROM chat_room_messages AS cr1 WHERE cr1.chat_room_id = room.chat_room_id ORDER BY cr1.created_at DESC LIMIT 1) as last_message_on"))
                                            
                            ->where(function ($q) use($auth_user) {
                                $q->where('room.sender_id', $auth_user['auth_id'])
                                ->where('room.sender_user', 'stylist');
                            })
                            ->orwhere(function ($q) use($auth_user) {
                                $q->where('room.receiver_id', $auth_user['auth_id'])
                                ->where('room.receiver_user', 'stylist');
                            })
                            ->where('room.is_active', 1)
                            ->groupBy('room.chat_room_id')
                            ->orderBy('room.created_at')
                            ->get();
                            $queries = DB::getQueryLog();
                            Log::info(print_r($queries, true)); 
         

        $response_array = ['status' => 1, 'message' => trans('pages.action_success'), 'data' => $users ];

        return response()->json($response_array, 200);
    }
}
