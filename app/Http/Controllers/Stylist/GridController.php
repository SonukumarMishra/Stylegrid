<?php

namespace App\Http\Controllers\Stylist;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\StyleGrids;
use App\Models\StyleGridDetails;
use App\Models\StyleGridProductDetails;
use Validator,Redirect;
use Config;
use Storage;
use Helper;
//use Dompdf\Dompdf;
//use PDF;

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

    public function index()
	{
        try{

            $stylist_id = Session::get("stylist_id");

            $style_grids = StyleGrids::where([
                                        'stylist_id' => $stylist_id,
                                        'is_active' => 1
                                    ])
                                    ->orderBy('stylegrid_id', 'desc')
                                    ->get();

    		return view('stylist.postloginview.grids.index', compact('style_grids'));

        }catch(\Exception $e){

            Log::info("index error - ". $e->getMessage());
            return redirect()->back();
        }

	}
    
    public function createGridIndex()
	{
		return view('stylist.postloginview.grids.create');
	}
	
    public function saveGridDetails(Request $request)
	{
        try {

            $style_grid_request = json_decode($request->stylegrid_json);

            $stylist_id = Session::get("stylist_id");

            $style_grid = new StyleGrids;
            $style_grid->stylist_id = $stylist_id;
            $style_grid->title = $style_grid_request->main_grid->title;
            $style_grid->total_grids = count($style_grid_request->grids);
            $style_grid->created_by = $stylist_id;
            $style_grid->updated_by = $stylist_id;
            $style_grid->save();

            if($style_grid){

                $stylegrid_id = $style_grid->stylegrid_id;

                if(isset($style_grid_request->main_grid->feature_image) && !empty($style_grid_request->main_grid->feature_image)){

                    try{

                        $feature_image = \Helper::upload_document($style_grid_request->main_grid->feature_image, 'stylist/stylegrids/'.$stylegrid_id, 'FI_'.time());

                        if(!empty($feature_image)){
    
                            $style_grid->feature_image = $feature_image;
                            $style_grid->save();
    
                        }
    
                    }catch(\Exception $e){

                        Log::info("error img upload ". $e->getMessage());

                    }
        
                }

                // Save grids 
                if(count($style_grid_request->grids)){

                    foreach ($style_grid_request->grids as $grid_key => $grid_value) {

                        $style_grid_dtls = new StyleGridDetails;
                        $style_grid_dtls->stylist_id = $stylist_id;
                        $style_grid_dtls->stylegrid_id = $stylegrid_id;
                        $style_grid_dtls->total_grid_products = count($grid_value->items);
                        $style_grid_dtls->created_by = $stylist_id;
                        $style_grid_dtls->updated_by = $stylist_id;
                        $style_grid_dtls->save();

                        if($style_grid_dtls){

                            $stylegrid_dtls_id = $style_grid_dtls->stylegrid_dtls_id;

                            if(isset($grid_value->feature_image) && !empty($grid_value->feature_image)){

                                try{

                                    $grid_feature_image = \Helper::upload_document($grid_value->feature_image, 'stylist/stylegrids/'.$stylegrid_id.'/grids/'.$stylegrid_dtls_id, 'FI_'.time());
                
                                    if(!empty($grid_feature_image)){
                
                                        $style_grid_dtls->feature_image = $grid_feature_image;
                                        $style_grid_dtls->save();
                
                                    }
                
                                }catch(\Exception $e){

                                    Log::info("error img upload ". $e->getMessage());
                                    
                                }
                            }

                            if(count($grid_value->items)){

                                foreach ($grid_value->items as $product_key => $product_value) {
            
                                    $product_dtls = new StyleGridProductDetails;
                                    $product_dtls->stylist_id = $stylist_id;
                                    $product_dtls->stylegrid_id = $stylegrid_id;
                                    $product_dtls->stylegrid_dtls_id = $stylegrid_dtls_id;
                                    $product_dtls->product_name = $product_value->product_name;
                                    $product_dtls->product_brand = $product_value->product_brand;
                                    $product_dtls->product_type = $product_value->product_type;
                                    $product_dtls->product_price = $product_value->product_price;
                                    $product_dtls->product_size = $product_value->product_size;
                                    $product_dtls->created_by = $stylist_id;
                                    $product_dtls->updated_by = $stylist_id;
                                    $product_dtls->save();
            
                                    if($product_dtls){
            
                                        $stylegrid_product_id = $product_dtls->stylegrid_product_id;
            
                                        if(isset($product_value->product_image) && !empty($product_value->product_image)){

                                            try{
            
                                                $product_image = \Helper::upload_document($product_value->product_image, 'stylist/stylegrids/'.$stylegrid_id.'/grids/'.$stylegrid_dtls_id.'/products/'.$stylegrid_product_id, 'PI_'.time());
                            
                                                if(!empty($product_image)){
                            
                                                    $product_dtls->product_image = $product_image;
                                                    $product_dtls->save();
                            
                                                }

                                            }catch(\Exception $e){

                                                Log::info("error img upload ". $e->getMessage());
                                                
                                            }
                        
                                        }
                                    }
            
                                }
            
                            }
                        }

                    }

                }

                $response_array = ['status' => 1, 'message' => trans('pages.crud_messages.added_success', [ 'attr' => 'stylegrid' ]) ];

            }else{

                $response_array = ['status' => 0, 'message' => trans('pages.something_wrong') ];

            }

            return response()->json($response_array, 200);	  
	
        }catch(\Exception $e){
            return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
        }
    }

    public function view($grid_id)
	{
        try{

            $style_grid_dtls = StyleGrids::find($grid_id);

            if($style_grid_dtls){

                $style_grid_dtls->grids = StyleGridDetails::where([
                                                'stylegrid_id' => $style_grid_dtls->stylegrid_id,
                                                'is_active' => 1
                                            ])->get();

                if(count($style_grid_dtls->grids)){
                    
                    foreach ($style_grid_dtls->grids as $key => $value) {

                        $style_grid_dtls->grids[$key]['items'] = StyleGridProductDetails::where([
                                                                    'stylegrid_dtls_id' => $value->stylegrid_dtls_id,
                                                                    'is_active' => 1
                                                                ])->get();


                    }
                }

                return view('stylist.postloginview.grids.view', compact('style_grid_dtls'));

            }else{

                return redirect()->back();
            }

        }catch(\Exception $e){
            return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
        }
	}

    public function exportGridPdf($grid_id)
	{
        try{

            $style_grid_dtls = StyleGrids::find($grid_id);

            if($style_grid_dtls){

                $style_grid_dtls->grids = StyleGridDetails::where([
                                                'stylegrid_id' => $style_grid_dtls->stylegrid_id,
                                                'is_active' => 1
                                            ])->get();

                if(count($style_grid_dtls->grids)){
                    
                    foreach ($style_grid_dtls->grids as $key => $value) {

                        $style_grid_dtls->grids[$key]['items'] = StyleGridProductDetails::where([
                                                                    'stylegrid_dtls_id' => $value->stylegrid_dtls_id,
                                                                    'is_active' => 1
                                                                ])->get();


                    }
                }

                return view('stylist.postloginview.grids.pdf_view', compact('style_grid_dtls'));
                
                $pdf = PDF::loadView('stylist.postloginview.grids.pdf_view', compact('style_grid_dtls'));
                echo "Export PDF";
                return $pdf->download(time().'.pdf');


            }else{

                return response()->json(['status' => 0, 'message' => trans('pages.crud_messages.no_data', [ 'attr' => 'stylegrid' ]) ]);

            }

        }catch(\Exception $e){
            return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
        }
	}
	
}
