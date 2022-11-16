<?php

namespace App\Http\Controllers\Stylist;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Grid;
use Validator,Redirect;
use Config;
use Storage;

class GridController extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!Session::get("Stylistloggedin")) {
                return redirect("/stylist-login");
            }
            return $next($request);
        });
    }

    public function createGridIndex()
	{
		return view('stylist.postloginview.grids.create');
	}
	
    public function getGridDataJson()
	{
        try {

		    $stylist_id = 9;

            $grid_model = new Grid();

            $response = $grid_model->getDatagrid($stylist_id); 
           
            foreach($response as $response_val)
            {
                
                $responseblock = $grid_model->getDatablock($response_val->grid_id); 
            
                $mjgrid_block[]= array('grid_data'=>array($response_val),'block_data'=>$responseblock);
                
            }
           
            $response_array = ['status' => 1, 'message' => trans('pages.action_success'), 'data' => $mjgrid_block ];

            return response()->json($response_array, 200);	  
	
        }catch(\Exception $e){
            return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
        }
    }
}
