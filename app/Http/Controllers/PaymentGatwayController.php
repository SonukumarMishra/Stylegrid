<?php
// namespace App\Http\Controllers\Api;
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Repositories\PaymentRepository as PaymentRepo;
use Validator,Redirect;
use Config;
use Storage;

class PaymentGatwayController extends BaseController
{
   
	public function stripe_create_payment_intent(Request $request){
      
        $response_array = PaymentRepo::stripe_create_payment_intent($request);

        return response()->json($response_array, 200);
                      
    }
	
}
