<?php
// namespace App\Http\Controllers\Api;
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Grid;
use Validator,Redirect;
use Config;
use Storage;

class CreateGridController extends BaseController
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
      
        return view('stylist.postloginview.dashboard');
    }
	
	public function loadgridview()
	{
		
		return view('stylist.postloginview.create_grid');
	}
	
	public function add_grid(Request $request)
	{
	if($request->isMethod('post'))
	{
		// echo '</pre>';
	// print_r($request->file());
	// print_r($request->all());
	// die;

	
	          $mj_explode=explode('_',$request->grid_block);
			  // echo '<pre>';
			  // print_r($mj_explode);
			  	// die;
				$grid=$mj_explode[1];
				$block=$mj_explode[3];
	        $prdimg = $request->file('prdimg');
	        $grid_image = $request->file('grid_image');
            $prdimg_name='';
            $gridimg_name='';
            
            
            if(!empty($grid_image)){
                $orgname = rand() . '.' . $grid_image->getClientOriginalExtension();
                $grid_image->move(public_path('stylist/grid_images'), $orgname);
                $gridimg_name=$orgname;
            }
            if(!empty($prdimg)){
                $orgname = rand() . '.' . $prdimg->getClientOriginalExtension();
                $prdimg->move(public_path('stylist/grid_block'), $orgname);
                $prdimg_name=$orgname;
            }else{
				$prdimg_name=$request->previous_img;
			}
            $grid_model=new Grid();
            
            $prdname_row=$request->prdname_row;
            
            $prdname=$request->prdname;
            $brand_name=$request->brand_name;
            $prd_price=$request->prd_price;
            $prd_type=$request->prd_type;
            $prd_size=$request->prd_size;
            $stylist_id =9;
            $add_update_data=array(
              
                'grid'=>$grid,
                'block'=>$block,
                'prdimg_name'=>$prdimg_name,
                'gridimg_name'=>$gridimg_name,
                'prd_name'=>$prdname,
                'brand_name'=>$brand_name,
                'prd_price'=>$prd_price,
                'prd_type'=>$prd_type,
                'prd_size'=>$prd_size,
                'stylist_id'=>$stylist_id,
                
            );
			// echo '<pre>';
			// print_r($add_update_data);
            
            $response=$grid_model->addUpdateData($add_update_data);   
            // if($response['reference_id']>0){
                // $member->addUpdateData(['id'=>$response['reference_id'],'p_slug'=>$add_update_data['p_slug'].'-'.$response['reference_id']],'sg_sourcing');   
            // }
            return true;
        
	}
	}
	
	public function get_grid_data()
	{
		$stylist_id =9;
		 $grid_model=new Grid();
		  $response=$grid_model->getDatagrid($stylist_id); 
		  // echo '<pre>';
		  // print_r($response);
		  // $mjgrid_response=array($response);
		  foreach($response as $response_val)
		  {
			
		  $responseblock=$grid_model->getDatablock($response_val->grid_id); 
		   
			 $mjgrid_block[]=array('grid_data'=>array($response_val),'block_data'=>$responseblock);
			 
		  }
		   // echo '<pre>';
		     // print_r($mjgrid_block);
		  
		  // 
			return json_encode($mjgrid_block);		  
	}
}
