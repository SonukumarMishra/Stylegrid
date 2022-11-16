<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Grid extends Model
{
    public $db;





	function addUpdateData($add_update_data){
		if(count($add_update_data)>0){
			// echo "start";
			$stylist_id=$add_update_data['stylist_id'];
			$grid=$add_update_data['grid'];
			$block=$add_update_data['block'];
			$grid_image=$add_update_data['gridimg_name'];
			$prdimg_name=$add_update_data['prdimg_name'];
			$brand_name=$add_update_data['brand_name'];
			$prd_name=$add_update_data['prd_name'];
			$prd_price=$add_update_data['prd_price'];
			$prd_type=$add_update_data['prd_type'];
			$prd_size=$add_update_data['prd_size'];
			 $getgridResult = DB::table('sg_grid AS sgg')
				 
						->select('*')
						 
						->join('sg_block AS sgb', 'sgb.grid_id', '=', 'sgg.grid_id')
						
						->join('sg_stylist as sgt', 'sgt.id', '=', 'sgg.stylist_id')
						
							 						
						->where('sgg.stylist_id', $stylist_id)		
						->where('sgg.grid_id', $grid)							
						->where('sgb.block_id', $block)						
						
						->get();
						$rows=$getgridResult->count();
						// print_r($getgridResult->count());
			if($rows >0)
			{
				// echo '<pre>';
				// print_r($add_update_data);
				// echo "if"; 
				$affected = DB::table('sg_block')
								->where('grid_id', $add_update_data['grid'])
								->where('block_id', $add_update_data['block'])
							
								->update(
									[
										 
													'block_image' => $add_update_data['prdimg_name'],  												
													'brand_name' => $add_update_data['brand_name'],  												
													'prd_name' => $add_update_data['prd_name'],  												
													'prd_price' => $add_update_data['prd_price'],  												
													'prd_type' => $add_update_data['prd_type'],  												
													'prd_size' => $add_update_data['prd_size'], 
									]);	
				
				}else{
				// echo "else";
				### check same grid exist ######
				
				$getgridRes = DB::table('sg_grid AS sgg')
				 
						->select('*')
						 
						->join('sg_stylist as sgt', 'sgt.id', '=', 'sgg.stylist_id')
						
							 						
						->where('sgg.stylist_id', $stylist_id)		
						->where('sgg.grid_id', $grid)	
						->get();
						// ->toSql();
						// print_r($getgridRes);
						$grid_rows=$getgridRes->count();
				if($grid_rows >0){ echo "update";
				
					
				}else{
					
				### check same grid exist ######
				$insert = DB::table('sg_grid')->insertGetId(
													[  
													'stylist_id' => $stylist_id, 
													'grid_id' =>$grid, 
													'grid_image' => $grid_image,  												
													 
													]
												);
				}
												// print_r($insert);
						 
		// $query= DB::table('sg_grid AS sgg');
			 
		// $query->select( 'sgg.grid_id as grid_id');
		// $query->where([['sgg.id', '=', $insert]]);
		 
		// $sg_grid_res = $query->get()->first();		
		
				// print_r($sg_grid_res->grid_id);								
				##### block insertion###

						$insert = DB::table('sg_block')->insertGetId(
													[  
													
													'grid_id' =>$grid, 
													'block_id' =>$block, 
													'block_image' => $prdimg_name,  												
													'brand_name' => $brand_name,  												
													'prd_name' => $prd_name,  												
													'prd_price' => $prd_price,  												
													'prd_type' => $prd_type,  												
													'prd_size' => $prd_size,  												
													
													]
												);
				##### block insertion###								
			}
						 
			// return $getgridResult;
			
			
			
				// if($add_update_data['id']>0){
					// DB::table($table)
					// ->where(array('id'=>$add_update_data['id']))
					// ->update($add_update_data);
					// $reference_id= $add_update_data['id'];
					// $response=['status'=>1,'reference_id'=>$reference_id,'message'=>'Data successfully updated'];
				// }else{
					// DB::table($table)
					// ->insert($add_update_data);
					// $reference_id= DB::getPdo()->lastInsertId();
					// $response=['status'=>1,'reference_id'=>$reference_id,'message'=>'Data successfully added'];
				// }
			
		}else{
			$response=['status'=>1,'reference_id'=>0,'message'=>'Request data missing'];
		}
		
	
		// return $response;
	}
	
	public function getDatagrid($stylist_id)
	{
		 $getgridResult = DB::table('sg_grid AS sgg')
				 
						->select('*')
						 
						// ->join('sg_block AS sgb', 'sgb.grid_id', '=', 'sgg.grid_id')
						
						->join('sg_stylist as sgt', 'sgt.id', '=', 'sgg.stylist_id')
						
							 						
						->where('sgg.stylist_id', $stylist_id)		
											
						
						->get();
						return $getgridResult;
						// echo '<pre>';
						// print_r($getgridResult);
	}
	public function getDatablock($grid_id)
	{
		 $getblockResult = DB::table('sg_block AS sgb')
				 
						->select('*')
					
						->join('sg_grid as sgg', 'sgg.grid_id', '=', 'sgb.grid_id')
						
							 						
						->where('sgb.grid_id', $grid_id)	
						->get();
						return $getblockResult;
						// echo '<pre>';
						// print_r($getgridResult);
	}
	
		

}