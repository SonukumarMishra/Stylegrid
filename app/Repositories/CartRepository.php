<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Validator;
use Helper;
use App\Models\Cart;
use App\Models\CartDetails;
use DB;
use Log;

class CartRepository {
	
	public static function get_cart_list($request, $auth_user) {

		$result = [
			'list' => [],
			'total' => 0,
			'total_page' => 0,
			'current_page' => 1,
			'cart_items_count' => 0
		];

		try{

			$limit = $request->has('limit') ? $request->limit : config('custom.default_page_limit');
			$page_index = $request->has('page') ? $request->page : 1;
			
			if(isset($auth_user) && !empty($auth_user)){

				$main_query = Cart::from('sg_cart as cart')
									->select('cart.cart_id', 'grid.stylegrid_id', 'grid.title')
									->join('sg_stylegrids as grid', function($join) {
										$join->on('grid.stylegrid_id', '=', 'cart.module_id')
											->where([
												'grid.is_active' => 1
											]);
									})
									->where([
										'cart.is_active' => 1,
										'cart.association_id' => $auth_user['auth_id'],
										'cart.association_type_term' => $auth_user['auth_user'],
										'cart.module_type' => config('custom.cart.module_type.stylegrid')
									])
									->with(
										[
											'cart_items_details'=> function ($query) {
												$query->join('sg_stylegrid_product_details as product', 'product.stylegrid_product_id', '=', 'sg_cart_details.item_id')
													  ->where('product.is_active', 1)
													  ->select('sg_cart_details.*', 'product.product_name', 'product.product_brand', 'product.product_type', 'product.product_price', 'product.product_size', 'product.product_image');
											}
										]
									)
									->groupBy('cart.module_id')
									->orderBy('cart.cart_id', 'desc');
											
				$list = $main_query->paginate($limit, ['*'], 'page', $page_index);

				$result['list'] = $list->getCollection();
				$result['total'] = $list->total();
				$result['total_page'] = $list->lastPage();
				$result['current_page'] = $list->currentPage();
				$result['cart_items_count'] = self::get_user_cart_items_count($auth_user);

			}
			
			return $result;

		}catch(\Exception $e) {

            Log::info("error get_cart_list ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function add_to_cart($request, $auth_user) {

		$result = false;

		try{
			
			$cart = false;

			$cart = Cart::where([
							'association_id' => $auth_user['auth_id'],
							'association_type_term' => $auth_user['auth_user'],
							'module_id' => $request->module_id,
							'module_type' => $request->module_type,
							'is_active' => 1
						])
						->first();
			if(!$cart){

				$cart = new Cart;
				$cart->association_id = $auth_user['auth_id'];
				$cart->association_type_term = $auth_user['auth_user'];
				$cart->module_id = $request->module_id;
				$cart->module_type = $request->module_type;
				$cart->save();

				
			}

			if($cart){

				$items = json_decode($request->items, true);
				$item_ids = json_decode($request->item_ids, true);
				
				if(count($item_ids)){
					// Delete dupliocate records for same id for same user
					CartDetails::where([
						'cart_id' => $cart->cart_id
					])
					->whereIn('item_id', $item_ids)
					->delete();

				}

				if(is_array($items) && count($items)){

					foreach ($items as $key => $value) {
						
						$cart_dtls = new CartDetails;
						$cart_dtls->cart_id = $cart->cart_id;
						$cart_dtls->item_id = $value['item_id'];
						$cart_dtls->item_type = $value['item_type'];
						$cart_dtls->save();
						
					}
				}

			}

			return $cart;

		}catch(\Exception $e) {

            Log::info("error add_to_cart ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function remove_cart_item($request, $auth_user) {

		$result = true;

		try{
			
			$cart_dtls_id = json_decode($request->cart_dtls_id);

			CartDetails::where([
							'cart_id' => $request->cart_id,
							'is_active' => 1
						])
						->whereIn('cart_dtls_id', $cart_dtls_id)
						->delete();

			$existing_cart_items_count = CartDetails::where([
														'cart_id' => $request->cart_id,
														'is_active' => 1
													])
													->count();
			
			if($existing_cart_items_count == 0){

				Cart::where([
					'association_id' => $auth_user['auth_id'],
					'association_type_term' => $auth_user['auth_user'],
					'cart_id' => $request->cart_id,
					'is_active' => 1
				])
				->delete();

			}

			return $result;

		}catch(\Exception $e) {

            Log::info("error remove_cart_item ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function update_user_cart($request, $auth_user) {

		$result = true;

		try{
			
			$user_cart = Cart::where([
								'association_id' => $auth_user['auth_id'],
								'association_type_term' => $auth_user['auth_user'],
								'is_active' => 1
							])->first();

			if($user_cart){

				$existing_cart_items_count = CartDetails::where([
															'cart_id' => $user_cart->cart_id,
															'is_active' => 1
														])
														->count();

				if($existing_cart_items_count == 0){

					Cart::where([
						'association_id' => $auth_user['auth_id'],
						'association_type_term' => $auth_user['auth_user'],
						'is_active' => 1
					])->delete();

				}

			}
			
			return $result;

		}catch(\Exception $e) {

            Log::info("error update_user_cart ". print_r($e->getMessage(), true));
			return $result;
        }

	}

	public static function get_user_cart_items_count($auth_user) {

		$total_items = 0;

		try{

			$cart_items_detils = Cart::from('sg_cart as cart')
										->where([
											'cart.association_id' => $auth_user['auth_id'],
											'cart.association_type_term' => $auth_user['auth_user'],
											'cart.is_active' => 1
										])
										->join('sg_cart_details as item', function($join) {
											$join->on('item.cart_id', '=', 'cart.cart_id')
												->where([
													'item.is_active' => 1
												]);
										})
										->select(DB::raw('COUNT(item.cart_dtls_id) as cart_items_total'))
										->first();
			if($cart_items_detils){
				$total_items = $cart_items_detils->cart_items_total;
			}
			
			return $total_items;

		}catch(\Exception $e) {

            Log::info("error get_user_cart_items_count ". print_r($e->getMessage(), true));
			return $total_items;
        }

	}


}
