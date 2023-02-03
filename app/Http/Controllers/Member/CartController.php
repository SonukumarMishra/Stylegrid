<?php

namespace App\Http\Controllers\Member;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\StyleGrids;
use App\Repositories\CartRepository as CartRepo;
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

}
