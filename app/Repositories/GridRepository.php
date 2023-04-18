<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Validator;
use Helper;
use App\Models\StyleGrids;
use App\Models\StyleGridDetails;
use App\Models\StyleGridClients;
use App\Models\ProductInvoice;
use App\Models\StyleGridProductDetails;
use App\Models\Cart;
use App\Models\CartDetails;
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

	public static function get_stylegrid_details($grid_id, $user_data=[]) {

		$result = false;

		try{
			
			$style_grid_dtls = StyleGrids::find($grid_id);
			
			if($style_grid_dtls){

				$user_grid_cart_dtls = Cart::where([
												'association_id' => $user_data['auth_id'],
												'association_type_term' => $user_data['auth_user'],
												'module_id' => $grid_id,
												'module_type' => config('custom.cart.module_type.stylegrid'),
												'is_active' => 1
											])
											->first();

				$style_grid_dtls->in_cart_exists = $user_grid_cart_dtls ? 1 : 0;

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

						$style_grid_dtls->grids[$key]['grid_all_items_exists_cart'] = 0;
						$style_grid_dtls->grids[$key]['cart_dtls_ids'] = [];
						$style_grid_dtls->grids[$key]['cart_id'] = '';
						
						if($style_grid_dtls->in_cart_exists){

							$style_grid_dtls->grids[$key]['cart_id'] = $user_grid_cart_dtls->cart_id;
							
							$product_ids = StyleGridProductDetails::where([
																	'stylegrid_dtls_id' => $value->stylegrid_dtls_id,
																	'is_active' => 1
																])
																->get()
																->pluck('stylegrid_product_id')
																->toArray();

							$cart_items_count = CartDetails::where('cart_id', $user_grid_cart_dtls->cart_id)
															->whereIn('item_id', $product_ids)
															->where('item_type', config('custom.cart.item_type.stylegrid_product'))
															->get()
															->pluck('cart_dtls_id')
															->toArray();

							if(count($product_ids) == count($cart_items_count)){

								$style_grid_dtls->grids[$key]['grid_all_items_exists_cart'] = 1;
								$style_grid_dtls->grids[$key]['cart_dtls_ids'] = $cart_items_count;
							
							}

						}

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

            Log::info("error get_stylegrid_product_details ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function getUserProductPaymentsJson($request) {
		
		$response_array = [ 'list' => [] ];

		try {

			$page_index = isset($request->page) ? $request->page : 1;
			
			$list = ProductInvoice::from('sg_product_invoices as invoice')
									->select("invoice.*", 'stylist.full_name as stylist_name', 'member.full_name as member_name')
									->leftjoin('sg_stylist AS stylist', 'stylist.id', '=', 'invoice.stylist_id')
									->leftjoin('sg_member AS member', 'member.id', '=', 'invoice.member_id')
									->orderBy('invoice.product_invoice_id', 'desc');
				
			if(isset($request->stylist_id) && !empty($request->stylist_id)){
				
				$list = $list->where('invoice.stylist_id', $request->stylist_id);

			}
			
			if(isset($request->member_id) && !empty($request->member_id)){

				$list = $list->where('invoice.member_id', $request->member_id);
			
			}
			$list = $list->paginate(10, ['*'], 'page', $page_index);

			$response_array['list'] = $list;

			return $response_array;
					
		}catch(\Exception $e) {

            Log::info("error getUserProductPaymentsJson ". print_r($e->getMessage(), true));
			$response_array['error'] = $e->getMessage();
			return $response_array;

        }

	}
}
