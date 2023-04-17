<?php

namespace App\Http\Controllers\Member;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\StyleGrids;
use App\Models\StyleGridDetails;
use App\Models\StyleGridProductDetails;
use App\Models\StyleGridClients;
use App\Models\Cart;
use App\Repositories\GridRepository as GridRepo;
use App\Repositories\CommonRepository as CommonRepo;
use Validator,Redirect;
use Config;
use Storage;
use Helper;
use PDF;
use DB;

class GridController extends BaseController
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
    		return view('member.dashboard.grids.index');

        }catch(\Exception $e){

            Log::info("index error - ". $e->getMessage());
            return redirect()->back();
        }

	}
    
    public function getStyleGridList(Request $request)
	{
        try{

            $result = GridRepo::get_stylegrid_list($request, $this->auth_user);
          
            $view = '';

            $view = view("member.dashboard.grids.index-list-ui", compact('result'))->render();

            $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 
                                'data' => [
                                    'view' => $view,
                                    'total_page' => $result['total_page']
                                ]  
                            ];

            return response()->json($response_array, 200);

            $response_array = ['status' => 1, 'message' => trans('pages.action_success'), 'data' => $result ];

            return response()->json($response_array, 200);

        }catch(\Exception $e){

            Log::info("index getStyleGridList - ". $e->getMessage());
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}
    

    public function view($grid_id)
	{
        try{

            $style_grid_dtls = GridRepo::get_stylegrid_details($grid_id);
         
            if($style_grid_dtls){

                // Notify stylist if memebr showing first time

                $is_notify_stylist = StyleGridClients::from('sg_grid_clients as client')
                                                        ->where([
                                                            'client.stylegrid_id' => $grid_id,
                                                            'client.member_id' => Session::get("member_id"),
                                                            'client.is_read' => 0
                                                        ])
                                                        ->join('sg_stylegrids as grid', 'grid.stylegrid_id', '=', 'client.stylegrid_id')
                                                        ->leftjoin('sg_member as member', 'member.id', '=', 'client.member_id')
                                                        ->select('grid.stylist_id', 'client.member_id', 'client.stylegrid_id', 'grid.title', 'member.full_name as member_name', 'client.grid_client_id')
                                                        ->first();

                if($is_notify_stylist){

                    $notify_users = [
                        [
                            'association_id' => $is_notify_stylist->stylist_id,
                            'association_type_term' => config('custom.user_type.stylist')
                        ]
                    ];

                    $notification_obj = [
                        'type' => config('custom.notification_types.grid_viewed_by_member'),
                        'title' => trans('pages.notifications.grid_viewed_by_member_title'),
                        'description' => trans('pages.notifications.grid_viewed_by_member_des', ['title' => $is_notify_stylist->title, 'user' => $is_notify_stylist->member_name]),
                        'data' => [
                            'stylegrid_id' => $is_notify_stylist->stylegrid_id,
                        ],
                        'users' => $notify_users
                    ];

                    CommonRepo::save_notification($notification_obj);

                    StyleGridClients::where(['grid_client_id' => $is_notify_stylist->grid_client_id])->update(['is_read' => 1]);

                }

                return view('member.dashboard.grids.view', compact('style_grid_dtls'));

            }else{

                return redirect()->route('member.grid.index')->with(['status' => 0, 'message' => trans('pages.crud.no_data', ['attr' => 'grid'])]);

            }

        }catch(\Exception $e){
            
            Log::info("view error ". print_r($e->getMessage(), true));

            return redirect()->route('member.grid.index')->with(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
        }
	}

    public function getStyleGridProductDetails(Request $request)
	{
        try{

            $user_data = $this->auth_user;

            $cart_id = NULL;

            $user_grid_cart_dtls = Cart::where([
                                            'association_id' => $user_data['auth_id'],
                                            'association_type_term' => $user_data['auth_user'],
                                            'module_id' => $request->stylegrid_id,
                                            'module_type' => config('custom.cart.module_type.stylegrid'),
                                            'is_active' => 1
                                        ])
                                        ->first();

            if($user_grid_cart_dtls){
                
                $cart_id = $user_grid_cart_dtls->cart_id;

            }

            $details = StyleGridProductDetails::from('sg_stylegrid_product_details as product')
                                                ->where([
                                                    'product.stylegrid_id' => $request->stylegrid_id,
                                                    'product.stylegrid_product_id' => $request->stylegrid_product_id
                                                ])
                                                ->leftjoin('sg_cart_details as cart_item', function($join) use($cart_id) {
                                                    $join->on('cart_item.item_id', '=', 'product.stylegrid_product_id')
                                                        ->where([
                                                            'cart_item.item_type' => config('custom.cart.item_type.stylegrid_product'),
                                                            'cart_id' => $cart_id
                                                        ]);
                                                })
                                                ->select('product.*', DB::raw('(CASE WHEN cart_item.cart_dtls_id IS NOT NULL THEN 1 ELSE 0 END) AS is_cart_item'), 'cart_item.cart_id', 'cart_item.cart_dtls_id')
                                                ->first();

            if($details){
                $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 'data' => $details ];
            }else{
                $response_array = [ 'status' => 0, 'message' => trans('pages.crud.no_data', ['attr' => 'grid']) ];
            }

            return response()->json($response_array, 200);

        }catch(\Exception $e){

            Log::info("index getStyleGridProductDetailsUI - ". $e->getMessage());
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];
            return response()->json($response_array, 200);
        }

	}

}
