<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Validator;
use Helper;
use App\Models\StyleGrids;
use App\Models\StyleGridDetails;
use App\Models\StyleGridClients;
use App\Models\StyleGridProductDetails;
use DB;
use Log;

class GridRepository {
	
	public static function get_stylegrid_list($request, $auth_user) {

		$result = [
			'list' => [],
			'total' => 0,
			'total_page' => 0,
			'current_page' => 1
		];

		try{

			$limit = $request->has('limit') ? $request->limit : config('custom.default_page_limit');
			$page_index = $request->has('page') ? $request->page : 1;
			
			if(isset($auth_user) && !empty($auth_user)){

				if($auth_user['auth_user'] == config('custom.user_type.member')){

					$main_query = StyleGrids::from('sg_stylegrids as grid')
											->select('grid.*')
											->join('sg_grid_clients as cl_grid', function($join) use($auth_user) {
												$join->on('cl_grid.stylegrid_id', '=', 'grid.stylegrid_id')
													->where([
														'cl_grid.is_active' => 1,
														'cl_grid.member_id' => $auth_user['auth_id']
													]);
											})
											->where([
												'grid.is_active' => 1
											])
											->groupBy('grid.stylegrid_id')
											->orderBy('cl_grid.grid_client_id', 'desc');
												
					$list = $main_query->paginate($limit, ['*'], 'page', $page_index);

					$result['list'] = $list->getCollection();
					$result['total'] = $list->total();
					$result['total_page'] = $list->lastPage();
					$result['current_page'] = $list->currentPage();

				}else if($auth_user['auth_user'] == config('custom.user_type.stylist')){

					$main_query = StyleGrids::from('sg_stylegrids as grid')
											->select('grid.*')
											->where([
												'grid.is_active' => 1,
												'grid.stylist_id' => $auth_user['auth_id']
											])
											->groupBy('grid.stylegrid_id')
											->orderBy('grid.stylegrid_id', 'desc');
												
					$list = $main_query->paginate($limit, ['*'], 'page', $page_index);

					$result['list'] = $list->getCollection();
					$result['total'] = $list->total();
					$result['total_page'] = $list->lastPage();
					$result['current_page'] = $list->currentPage();
				}
				
				
			}
			
			return $result;

		}catch(\Exception $e) {

            Log::info("error get_stylegrid_list ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function get_stylegrid_details($grid_id) {

		$result = false;

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
                                                                ])
																->get();


                    }
                }

				$result = $style_grid_dtls;

            }

			return $result;

		}catch(\Exception $e) {

            Log::info("error get_stylegrid_details ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function get_stylegrid_product_details($request) {

		$result = false;

		try{
			
			$style_grid_dtls = StyleGrids::find($request->stylegrid_id);
			
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
                                                                ])
																->get();


                    }
                }

				$result = $style_grid_dtls;

            }

			return $result;

		}catch(\Exception $e) {

            Log::info("error get_stylegrid_details ". print_r($e->getMessage(), true));
			return $result;
        }

	}

}
