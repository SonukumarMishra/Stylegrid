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
use App\Repositories\GridRepository as GridRepo;
use Validator,Redirect;
use Config;
use Storage;
use Helper;
use PDF;

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

                return view('member.dashboard.grids.view', compact('style_grid_dtls'));

            }else{

                return redirect()->route('member.grid.index')->with(['status' => 0, 'message' => trans('pages.crud.no_data', ['attr' => 'grid'])]);

            }

        }catch(\Exception $e){
            return redirect()->route('member.grid.index')->with(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
        }
	}

}
