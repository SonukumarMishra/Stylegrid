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
			'current_page' => 1
		];

		try{

			$limit = $request->has('limit') ? $request->limit : config('custom.default_page_limit');
			$page_index = $request->has('page') ? $request->page : 1;
			
			if(isset($auth_user) && !empty($auth_user)){

				$main_query = Cart::from('sg_cart as cart')
										->select('grid.*')
										->join('sg_stylegrids as grid', function($join) use($auth_user) {
											$join->on('grid.stylegrid_id', '=', 'grid.stylegrid_id')
												->where([
													'grid.is_active' => 1,
													'grid.member_id' => $auth_user['auth_id']
												]);
										})
										->where([
											'cart.is_active' => 1,
											'cart.association_id' => $auth_user['auth_id'],
											'cart.association_type_term	' => $auth_user['auth_user'],
											'cart.module_type' => config('custom.cart.module_type.stylegrid')
										])
										->groupBy('cart.module_id')
										->orderBy('cart.cart_id', 'desc');
											
				$list = $main_query->paginate($limit, ['*'], 'page', $page_index);

				$result['list'] = $list->getCollection();
				$result['total'] = $list->total();
				$result['total_page'] = $list->lastPage();
				$result['current_page'] = $list->currentPage();

				
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
			
			$cart = new Cart;
			$cart->association_id =  $auth_user['auth_id'];
			$cart->association_type_term =  $auth_user['auth_user'];
			$cart->module_id = $request->module_id;
			$cart->module_type = $request->module_type;
			$cart->item_id = $request->item_id;
			$cart->item_type = $request->item_type;
			$cart->save();

			return $cart;

		}catch(\Exception $e) {

            Log::info("error add_to_cart ". print_r($e->getMessage(), true));
			return $result;
        }

	}

}
