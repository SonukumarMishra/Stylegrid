<?php

namespace App\Http\Controllers\Member;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\StyleGrids;
use App\Models\ChatRoom;
use App\Models\Cart;
use App\Models\CartDetails;
use App\Repositories\CartRepository as CartRepo;
use App\Repositories\ChatRepository as ChatRepo;
use Validator,Redirect;
use Config;
use Storage;
use Helper;
use PDF;

class CartController extends BaseController
{
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

    public function index()
	{
        try{

    		return view('member.dashboard.cart.index');

        }catch(\Exception $e){

            Log::info("index error - ". $e->getMessage());
            return redirect()->back();
        }

	}

    public function addToCart(Request $request)
	{
        try{

            $result = CartRepo::add_to_cart($request, $this->auth_user);
          
            if($result){

                $cart_items_count = CartRepo::get_user_cart_items_count($this->auth_user);

                $result = [
                    'cart_items_count' => $cart_items_count
                ];

                $response_array = ['status' => 1, 'message' => trans('pages.add_to_cart_success'), 'data' => $result ];

            }else{

                $response_array = ['status' => 0, 'message' => trans('pages.something_wrong') ];

            }

            return response()->json($response_array, 200);
          
        }catch(\Exception $e){

            Log::info("error addToCart - ". $e->getMessage());
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

    public function getCartList(Request $request)
	{
        try{

            $result = CartRepo::get_cart_list($request, $this->auth_user);
          
            $view = '';

            $view = view("member.dashboard.cart.index-list-ui", compact('result'))->render();

            $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 
                                'data' => [
                                    'view' => $view,
                                    'total_page' => $result['total_page'],
                                    'cart_items_count' => $result['cart_items_count'],
                                ]  
                            ];

            return response()->json($response_array, 200);

        }catch(\Exception $e){

            Log::info("error getCartList - ". $e->getMessage());
            
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}
    
    public function removeCartItems(Request $request)
	{
        try{

            $result = CartRepo::remove_cart_item($request, $this->auth_user);
          
            if($result){

                $cart_items_count = CartRepo::get_user_cart_items_count($this->auth_user);

                $result = [
                    'cart_items_count' => $cart_items_count
                ];

                $response_array = ['status' => 1, 'message' => trans('pages.remove_cart_item_success'), 'data' => $result ];

            }else{

                $response_array = ['status' => 0, 'message' => trans('pages.something_wrong') ];

            }

            return response()->json($response_array, 200);
          
        }catch(\Exception $e){

            Log::info("error removeCartItems - ". $e->getMessage());
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

    public function sendCartItemsToMessanger(Request $request)
	{
        try{

            $result = false;

            $auth_user = $this->auth_user;

            $cart_items_ids = json_decode($request->cart_dtls_ids, true);
            
            $remove_cart_items_ids = [];

            $items = CartDetails::from('sg_cart_details as item')
                                ->whereIn('item.cart_dtls_id', $cart_items_ids)
                                ->where([
                                            'item.is_active' => 1
                                        ])
                                ->leftjoin('sg_stylegrid_product_details as product', 'product.stylegrid_product_id', '=', 'item.item_id')
                                ->select('product.stylist_id', 'product.product_name', 'product.product_image', 'item.cart_dtls_id')
                                ->get();

            $chat_room = ChatRoom::from('sg_chat_room as room')
                                    ->select("room.*")
                                    ->where(function ($q) use($auth_user) {

                                        $q->where(function ($q1) use($auth_user) {
                                            $q1->where('room.sender_id', $auth_user['auth_id'])
                                                ->where('room.sender_user', $auth_user['user_type']);
                                        })
                                        ->orwhere(function ($q2) use($auth_user) {
                                            $q2->where('room.receiver_id', $auth_user['auth_id'])
                                                ->where('room.receiver_user', $auth_user['user_type']);
                                        });
                                    })
                                    ->where('room.module', config('custom.chat_module.private'))
                                    ->first();
                                 
            if(count($items) && $chat_room){

                $receiver_id = '';

                if($chat_room->sender_user == config('custom.user_type.stylist')){
                 
                    $receiver_id = $chat_room->sender_id;
                
                }else if($chat_room->receiver_user == config('custom.user_type.stylist')){
                
                    $receiver_id = $chat_room->receiver_id;
                
                }

                if(!empty($receiver_id)){

                    foreach ($items as $key => $value) {
                
                        // $product_ext = pathinfo('https://stylist.stylegrid.com/stylist/stylegrids/4/grids/5/products/9/PI_1673934650.jpeg', PATHINFO_EXTENSION);
                        $product_ext = asset($value->product_image);

                        $message_obj = [
                                            'message' => trans('pages.product_chat_default_message', [
                                                'product' => $value && $value->product_name != null ? $value->product_name : '',
                                            ]),
                                            'media_files' => json_encode([
                                                [
                                                    'media_source' => asset($value->product_image), 
                                                    // 'media_source' => 'https://stylist.stylegrid.com/stylist/stylegrids/4/grids/5/products/9/PI_1673934650.jpeg',
                                                    'is_url' => true,
                                                    'media_name' => $value->product_name.'_'.time().'.'.$product_ext,
                                                    'id' => 1,
                                                    'file_formate' => $product_ext
                                                ]
                                            ]),
                                            'type' => 'file',
                                            'receiver_id' => $receiver_id,
                                            'receiver_user' => config('custom.user_type.stylist'),
                                        ];
                        
                        // Create chat contact
                        $send_chat_room = [
                            'chat_room_id' => $chat_room->chat_room_id,
                            'auth_user' => $auth_user,
                            'message_obj' => $message_obj
                        ];
                        
             
                        try{
                            
                            ChatRepo::save_chat_room_details([$send_chat_room]);

                            array_push($remove_cart_items_ids, $value->cart_dtls_id);

                        }catch(\Exception $e){

                            Log::info("error save_chat_room_details - ". $e->getMessage());

                        }
                
                    }

                   
                    // Remove from cart 

                    if(count($remove_cart_items_ids) > 0){

                        CartDetails::whereIn('cart_dtls_id', $remove_cart_items_ids)->delete();

                        CartRepo::update_user_cart($request, $auth_user);

                        $result = true;

                    }
                    
                }

               
            }

            $cart_items_count = CartRepo::get_user_cart_items_count($this->auth_user);

            $response_array = ['status' => 1, 'message' => trans('pages.action_success'), 
                                'data' => [
                                            'result' => $result,
                                            'cart_items_count' => $cart_items_count
                                           ]
                            ];

            return response()->json($response_array, 200);
          
        }catch(\Exception $e){

            Log::info("error sendCartItemsToMessanger - ". $e->getMessage());
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

}
