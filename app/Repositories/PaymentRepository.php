<?php

namespace App\Repositories;
use Illuminate\Http\Request;

use App\Models\Member;
use App\Models\Stylist;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\PaymentTransaction;
use App\Repositories\UserRepository as UserRepo;
use Validator;
use Storage;
use Helper;
use Log;
use Stripe;
use PDF;


class PaymentRepository {

    public static function create_user_stripe_customer($user_data)
    { 
      
        $user_details = false;

        if($user_data['user_type'] == config('custom.user_type.member')){

            $user_details =  Member::find($user_data['user_id']);

        }else if($user_data['user_type'] == config('custom.user_type.stylist')){

            $user_details =  Stylist::find($user_data['user_id']);
            
        }

        if(!$user_details){

            return array('status' => 0, 'message' => trans('pages.crud_messages.no_data', [ 'attr' => 'user']) );
     
        }

        if(empty($user_details->stripe_customer_id)){

            // Create customer 

            try {

                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        
                $customer = $stripe->customers->create([
                    'email' => $user_details->email,
                    'name' => $user_details->full_name,
                    // 'address' => [
                    //     'line1' => $user_location->address_1,
                    //     'postal_code' => $user_location->zipcode,
                    //     'city' => $user_location->city,
                    //     'state' => $user_location->state,
                    //     'country' => !empty($user_location->country_code) ? $user_location->country_code : 'CA'
                    // ],
                    'metadata' => [
                        'user_id' => $user_data['user_id'],
                        'user_type' => $user_data['user_type']
                    ],                                                                                                                                                                                                                                                         
                ]);                                

                $user_details->stripe_customer_id = $customer['id'];
                $user_details->save();

                Log::info("stripe customer res ". print_r($customer, true));

                return ['status' => 1 , 'data' => [ 'customer_id' => $customer['id'] ] ];
            
            }catch (\Exception $e) {
                
                Log::info("response customer ". $e->getMessage());

                return array('status' => 0, 'message' => trans('pages.something_wrong'));

            }

        }else{

            return ['status' => 1 , 'data' => [ 'customer_id' => $user_details->stripe_customer_id ] ];
            
        }

    }
  
    public static function create_stripe_payment_method($user_data, $stripe_customer_id, $payment_method_token){

        $result = self::create_user_stripe_customer($user_data);

        if($result['status'] == 0){

            return array('status' => 0, 'message' => $result['message'] );

        }else{

            $stripe_customer_id = $result['data']['customer_id'];

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

            try{

                $stripe_customer = $stripe->customers->retrieve($stripe_customer_id);

                if($stripe_customer){
    
                    $payment_method = $stripe->paymentMethods->attach(
                        $payment_method_token,
                        ['customer' => $stripe_customer_id]
                    );

                    $stripe->customers->update(
                        $stripe_customer_id,
                        [
                            'invoice_settings' => [
                                'default_payment_method' => $payment_method_token
                            ]
                        ]
                    );
    
                    self::stripe_detech_unused_payment_methods($stripe_customer_id, $payment_method_token);

                    Log::info("payment method payment_card". print_r($payment_method, true));
    
                    return ['status' => 1 , 'message' => trans('pages.action_success'), 'data' => [ 'payment_method_id' =>  $payment_method['id'] ] ];
        
                }else{

                    Log::info("response error stripe customer not found.");

                   return array('status' => 0, 'message' => trans('pages.something_wrong'));

                }

            }catch(\Stripe\Exception\CardException $e) {
                // Since it's a decline, \Stripe\Exception\CardException will be caught
                
                Log::info("response payment method error ". $e->getError()->message);
                return array('status' => 0, 'message' => $e->getError()->message);

            }catch(\Stripe\Exception\ApiErrorException  $e) {
                // Display a very generic error to the user, and maybe send
                
                Log::info("response payment method error ApiErrorException ". $e->getError()->message);
                return array('status' => 0, 'message' => $e->getError()->message);

            }catch (\Stripe\Exception\InvalidRequestException $e) {
                // Invalid parameters were supplied to Stripe's API
                
                Log::info("response payment method error InvalidRequestException ". $e->getError()->message);
                return array('status' => 0, 'message' => $e->getError()->message);

            }catch (\Stripe\Exception\ApiConnectionException  $e) {
                // Invalid parameters were supplied to Stripe's API
                
                Log::info("response payment method error ApiConnectionException  ". $e->getError()->message);
                return array('status' => 0, 'message' => $e->getError()->message);

            }catch (\Exception $e) {
                        
                Log::info("response payment method error ". $e->getMessage());
                return array('status' => 0, 'message' => $e->getError()->message);

            }

        }
    }

    
    public static function create_stripe_subscription($user_data, $subscription_id){

        $response_array = ['status' => 0, 'message' => trans('pages.something_wrong')];

        try {
            
            $subscription_info = Subscription::find($subscription_id);

            if(!$subscription_info){

                return array('status' => 0, 'message' => trans('pages.crud_messages.no_data', [ 'attr' => 'subscription']) );
         
            }

            $user_details = false;

            if($user_data['user_type'] == config('custom.user_type.member')){
    
                $user_details =  Member::find($user_data['user_id']);
    
            }else if($user_data['user_type'] == config('custom.user_type.stylist')){
    
                $user_details =  Stylist::find($user_data['user_id']);
                
            }
    
            if(!$user_details){
    
                return array('status' => 0, 'message' => trans('pages.crud_messages.no_data', [ 'attr' => 'user']) );
         
            }else{

                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        
                try {

                    $last_active_subscription = UserRepo::get_user_subscription($user_data);

                    $last_active_subscription = $last_active_subscription['data'];

                    $billing_date = time();
                    
                    $invoice_date = date('Y-m-d H:i:s');

                    $subscription_end_date = $invoice_date;

                    if(isset($user_details->trial_end_date) && !empty($user_details->trial_end_date) && date('Y-m-d', strtotime($user_details->trial_end_date)) >= date('Y-m-d')){
                       
                        // If user in trial, then billing invoice will be next date of trail end date

                        $invoice_date = date('Y-m-d H:i:s', strtotime($user_details->trial_end_date));
                        
                    }
                    
                    if(isset($last_active_subscription->stripe_subscription_id) && !empty($last_active_subscription->stripe_subscription_id) && $subscription_info->price < $last_active_subscription->price){
                        
                        // If user have trial time, that already included in last active subscription 

                        // When user downgrade plan from upgraded plan, that time new subscription should start after completion of current plan. New subscription should not active immediately
                        $invoice_date = date('Y-m-d H:i:s', strtotime($last_active_subscription->end_date));

                    }

                    if($subscription_info->interval_type == config('custom.subscription.interval.days')){

                        $subscription_end_date = date('Y-m-d H:i:s', strtotime($invoice_date. ' + '.$subscription_info->validity_period.' days'));
                       
                    }else if($subscription_info->interval_type == config('custom.subscription.interval.month')){
    
                        $subscription_end_date = date('Y-m-d H:i:s', strtotime($invoice_date. ' + '.$subscription_info->validity_period.' months'));
                        
                    }else if($subscription_info->interval_type == config('custom.subscription.interval.year')){
    
                        $subscription_end_date = date('Y-m-d H:i:s', strtotime($invoice_date. ' + '.$subscription_info->validity_period.' years'));
                        
                    }

                    Log::info("user invoice_date ". $invoice_date);

                    $billing_date = strtotime($invoice_date);

                    $subscription_result = $stripe->subscriptions->create([
                        'customer' => $user_details['stripe_customer_id'],
                        'items' => [
                                        [
                                            'price' => $subscription_info->stripe_price_id,
                                        ],
                                    ],
                        'billing_cycle_anchor' => $billing_date, // billing date
                        'trial_end' => $billing_date       
                    ]);

                    if(isset($last_active_subscription->stripe_subscription_id) && !empty($last_active_subscription->stripe_subscription_id)){

                        if(isset($last_active_subscription->stripe_subscription_id) && !empty($last_active_subscription->stripe_subscription_id) && $subscription_info->price < $last_active_subscription->price){
                        
                            // When user downgrade plan, that time update current upgraded plan end date and for downgrade plan schedule date to next invoice date and activate that time.

                            try{

                                $subscription_cancel_at = date('Y-m-d', strtotime($last_active_subscription->end_date));

                                $stripe->subscriptions->update(
                                    $last_active_subscription->stripe_subscription_id,
                                    [
                                        'cancel_at' => strtotime($subscription_cancel_at)
                                    ]
                                );     
                            
                            }catch (\Exception $e) {
                            
                                Log::info("error update subscription ". $e->getMessage());
                
                            }
                            
                        }else{

                            // When user buy upgrade plan from downgrade plan  that time cancel active subscription and immadiatly activate latest plan.

                            try{

                                $stripe->subscriptions->cancel(
                                    $last_active_subscription->stripe_subscription_id,
                                    []
                                );     
                            
                                UserSubscription::where([
                                    'user_subscription_id' => $last_active_subscription->user_subscription_id
                                ])->update([
                                    'is_auto_payment' => 0,
                                    'subscription_status' => config('custom.subscription.status.cancelled'),
                                    'cancelled_on' => date('Y-m-d H:i:s')
                                ]);

                                \Helper::update_active_subscription_count($last_active_subscription->subscription_id);

                            }catch (\Exception $e) {
                            
                                Log::info("error upgrade cancel subscription ". $e->getMessage());
                
                            }
                            
                        }
                       
                        
                    }

                    Log::info("stripe last_active_subscription - ". print_r($last_active_subscription, true));

                    $sub_info_status = strtolower($subscription_result->status);

                    if(in_array($subscription_result->status, [ config('custom.stripe.subscription_status.active'), config('custom.stripe.subscription_status.trialing')])){

                        if(isset($last_active_subscription->stripe_subscription_id) && !empty($last_active_subscription->stripe_subscription_id) && $subscription_info->price < $last_active_subscription->price){

                            $sub_info_status = config('custom.subscription.status.pending');

                        }else{

                            $sub_info_status = config('custom.subscription.status.active');

                        }

                    }

                    $is_paid = 0;

                    if(@$subscription_result->status == config('custom.stripe.subscription_status.active')){
                        $is_paid = 1;
                    }

                    $sub_info = [
                        'start_date' => date('Y-m-d H:i:s', $subscription_result->current_period_end),      // subscription response date in timestamp format
                        'end_date' => date('Y-m-d H:i:s', strtotime($subscription_end_date)),
                        'billing_invoice_date' =>  isset($subscription_result->billing_cycle_anchor) && !empty($subscription_result->billing_cycle_anchor) ? date('Y-m-d H:i:s', $subscription_result->billing_cycle_anchor) : '',      // subscription response date in timestamp format
                        'stripe_subscription_id' => $subscription_result->id,
                        'status' => $sub_info_status,
                        'is_paid' => $is_paid
                    ];
                    
                    Log::info("sub info ". print_r($sub_info, true));

                    // Assign subscription to user
                    $user_subscription = UserRepo::assign_subscription_to_user($user_data['user_id'], $user_data['user_type'], config('custom.subscription.types.paid'), $subscription_info->subscription_id, $sub_info);

                    if ($user_subscription['status']) {

                        $user_subscription_id = $user_subscription['data']['user_subscription_id'];

                        \Helper::update_active_subscription_count($subscription_info->subscription_id);

                        $payment_trans_id = '';
                        
                        
                        $payment_trans_data = [
                            'association_id' => $user_data['user_id'],
                            'association_type_term' => $user_data['user_type'],
                            'trans_id' => @$subscription_result->id,
                            'trans_amount' => ((@$subscription_result->plan->amount)/100),
                            'trans_currency' => @$subscription_result->plan->currency,
                            'trans_mode' => @$subscription_result->paymentInstrumentType,
                            'trans_type' => config('custom.payment_transaction.type_debit'),
                            'payment_gatway' => config('custom.payment_gatway.stripe'),
                            'gatway_subscription_id' => @$subscription_result->id,
                            'gatway_subscription_package_id' => @$subscription_result->plan->product,
                            'gatway_subscription_price_id' => @$subscription_result->plan->id,
                            'trans_ref_association_type_term' => config('custom.payment_transaction.trans_type.subscription'),
                            'trans_ref_association_id' => $user_subscription['data']['user_subscription_id'],
                            'trans_status' => @$subscription_result->status,
                            'is_paid' => $is_paid
                        ];

                        // Save payment transaction details
                        $payment_trans_result = self::save_payment_transaction($payment_trans_data);

                        if ($payment_trans_result['status']) {
                            $payment_trans_id = $payment_trans_result['data']['payment_trans_id'];
                        }

                        if (!empty($payment_trans_id)) {

                            // save invoice pdf
                            $new_subscription = UserRepo::get_user_subscription_dtls_by_id($user_subscription_id);

                            $new_subscription = $new_subscription['data'];

                            $pdf_url = '';

                            try {

                                if (app()->environment('production')) {

                                    set_time_limit(300);

                                    $pdf = PDF::loadView('pdf_templates.subscription-invoice-pdf', [ 'data' => $new_subscription, 'user' => $user_details ]);

                                    $default_storage = config('filesystems.default');

                                    $default_storage_driver = config('filesystems.disks.'.$default_storage.'.driver');

                                    $pdf_path = 'uploads/subscription/invoices/In_'.time().'.pdf';

                                    $cloudResponse = Storage::disk($default_storage_driver)->put($pdf_path, $pdf->output());

                                    if($cloudResponse){

                                        $pdf_url = $pdf_path;

                                        // if($default_storage != 'public'){

                                        //     $pdf_url = Storage::url($pdf_path);

                                        // }
                                    }
                                }

                            } catch(\Exception $e) {
                                Log::info("error invoice pdf ". $e->getMessage());
                            }

                            //send email
                            if (!empty($user_details->email)) {

                                try {
                                    $subject = 'Welcome to '.env('APP_NAME');

                                    $page = "email_templates.subscription-invoice";

                                    $emailData = [];

                                    $emailData['data'] = $new_subscription;

                                    $doc_obj = array('attachment_url' => $pdf_url);

                                    $emailData['attachments'][] = (object)$doc_obj;

                                    // send email to admin

                                    \Helper::send_email($user_details->email, $subject, $page, $emailData);

                                } catch(\Exception $e) {
                                    Log::info("error send email - ". $e->getMessage());
                                }
                            }

                            if(isset($pdf_url) && !empty($pdf_url)){

                                $payment_trans_ref = PaymentTransaction::find($payment_trans_id);

                                if ($payment_trans_ref) {
                                    $payment_trans_ref->invoice_pdf = $pdf_url;
                                    $payment_trans_ref->save();
                                }
    
                                UserSubscription::where([
                                    'user_subscription_id' => $user_subscription_id
                                ])
                                ->update([ 
                                    'invoice_pdf' => $pdf_url
                                ]);
                            }

                        }

                        $response_array = array('status' => 1,  'message' => trans('pages.action_success'));
                    }

                }catch(\Stripe\Exception\ApiErrorException  $e) {
                    // Display a very generic error to the user, and maybe send
                    
                    Log::info("error ApiErrorException ". $e->getError()->message);
                    return array('status' => 0, 'message' => trans('pages.unable_to_create_subscription'));
    
                }catch (\Stripe\Exception\InvalidRequestException $e) {
                    // Invalid parameters were supplied to Stripe's API
                    
                    Log::info("error InvalidRequestException ". $e->getError()->message);
                    return array('status' => 0, 'message' => trans('pages.unable_to_create_subscription'));
    
                }catch (\Stripe\Exception\ApiConnectionException  $e) {
                    // Invalid parameters were supplied to Stripe's API
                    
                    Log::info("error ApiConnectionException  ". $e->getError()->message);
                    return array('status' => 0, 'message' => trans('pages.unable_to_create_subscription'));
    
                }catch (\Exception $e) {
                            
                    Log::info("error ". $e->getMessage());
                    return array('status' => 0, 'message' => trans('pages.unable_to_create_subscription'));
    
                }

            }

            return $response_array;

        } catch (\Exception $e) {
           
            Log::info("error create_stripe_subscription last - ". $e->getMessage());

            return $response_array;
        }
	
	}

    
    public static function save_payment_transaction($data=[]){
    
        $response_array = ['status' => 0, 'message' => trans('pages.something_wrong')];

        try {

            if(is_array($data) && count($data)){

                $transaction = new PaymentTransaction;
                $transaction->association_id = @$data['association_id'];
                $transaction->association_type_term = @$data['association_type_term'];
                $transaction->trans_id = @$data['trans_id'];
                $transaction->trans_amount = @$data['trans_amount'];
                $transaction->trans_currency = @$data['trans_currency'];
                $transaction->trans_mode = @$data['trans_mode'];
                $transaction->trans_type = @$data['trans_type'];
                $transaction->is_paid = isset($data['is_paid']) ? $data['is_paid'] : 0;
                $transaction->payment_gatway = @$data['payment_gatway'];
                $transaction->gatway_subscription_id = @$data['gatway_subscription_id'];
                $transaction->gatway_subscription_package_id = @$data['gatway_subscription_package_id'];
                $transaction->gatway_subscription_price_id = @$data['gatway_subscription_price_id'];
                $transaction->trans_ref_association_type_term = @$data['trans_ref_association_type_term'];
                $transaction->trans_ref_association_id = @$data['trans_ref_association_id'];
                $transaction->trans_status = @$data['trans_status'];
                $transaction->trans_error_code = @$data['trans_error_code'];
                $transaction->trans_error_description = @$data['trans_error_description'];
                $transaction->save();

                if($transaction){
                    $response_array = ['status' => 1, 'data' => [ 'payment_trans_id' => $transaction->payment_trans_id ] ];
                }

            }
            return $response_array;

        } catch (\Exception $e) {
           
            Log::info("error save_payment_transaction - ". $e->getMessage());

            return $response_array;
        }
    }

    public static function cancel_stripe_subscription($request, $user_data){

        $response_array = ['status' => 0, 'message' => trans('pages.something_wrong')];

        try {
            
            $validator = Validator::make(
                $request->all(),
                [
                    'user_subscription_id' => 'required',    // This is braintree encryted token of card details
                ]
            );

            if ($validator->fails()) {

                $response_array = ['status' => 0, 'message' => implode(',', $validator->messages()->all())];

            } else {

                $user_details = false;

                if($user_data['user_type'] == config('custom.user_type.member')){
        
                    $user_details =  Member::find($user_data['user_id']);
        
                }else if($user_data['user_type'] == config('custom.user_type.stylist')){
        
                    $user_details =  Stylist::find($user_data['user_id']);
                    
                }
        
                if(!$user_details){
        
                    return array('status' => 0, 'message' => trans('pages.crud_messages.no_data', [ 'attr' => 'user']) );
             
                }

                $user_subscription = UserSubscription::find($request->user_subscription_id);

                if($user_subscription){

                    if($user_subscription->subscription_status == config('custom.subscription.status.cancelled')){

                        return response()->json(['status' => 0, 'message' => trans('pages.already_cancelled_subscription') ]);
                    
                    }

                    try {

                        // When canceling subscription that time, update stripe end date to current active subscription's end date. User will be allow to access till end date of month.
                        
                        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
                
                        $subscription_cancel_at = date('Y-m-d', strtotime($user_subscription->end_date));

                        $subscribe_cancel = $stripe->subscriptions->update(
                                $user_subscription->stripe_subscription_id,
                                [
                                    'cancel_at' => strtotime($subscription_cancel_at)
                                ]
                        );     
                                             
        
                        Log::info("stripe cancel subscription ". print_r($subscribe_cancel, true));

                        $user_subscription->is_auto_payment = 0;
                        $user_subscription->cancelled_on = date('Y-m-d H:i:s');
                        $user_subscription->reason_of_cancellation = isset($request->reason_for_cancellation) && !empty($request->reason_for_cancellation) ? $request->reason_for_cancellation : '';
                        $user_subscription->save();

                        \Helper::update_active_subscription_count($user_subscription->subscription_id);

                        // On cancel susbcription time, if user have trial days left then give trail subscription package, otherwise free 

                        // if(isset($user_details->trial_end_date) && !empty($user_details->trial_end_date) && date('Y-m-d', strtotime($user_details->trial_end_date)) >= date('Y-m-d')){
                        
                        //     $sub_info = [
                        //         'start_date' => date('Y-m-d H:i:s'),      // subscription response date in timestamp format
                        //         'end_date' => date('Y-m-d H:i:s', strtotime($user_details->trial_end_date))
                        //     ];

                        //     UserRepo::assign_subscription_to_user($user_data['user_id'], $user_data['user_type'], config('custom.subscription.types.trial'), '', $sub_info);

                        // }else{

                        //     UserRepo::assign_subscription_to_user($user_data['user_id'], $user_data['user_type'], config('custom.subscription.types.free'));

                        // }
                      
                        return array('status' => 1, 'message' => trans('pages.cancel_subscription_success'));

                    }catch (\Exception $e) {
                        
                        Log::info("error cancel subscription ". $e->getMessage());
        
                        return array('status' => 0, 'message' => trans('pages.something_wrong'));
        
                    }


                }else{
             
                    return array('status' => 0, 'message' => trans('pages.crud_messages.no_data', [ 'attr' => 'subscription']) );
             
                }

            }

            return $response_array;

        } catch (\Exception $e) {
           
            Log::info("error save_payment_transaction - ". $e->getMessage());

            return $response_array;
        }
    }

    public static function stripe_detech_unused_payment_methods($stripe_customer_id, $payment_method_token){

        $response_array = ['status' => 0, 'message' => trans('pages.something_wrong')];

        try { 

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

            $payment_methods = $stripe->customers->allPaymentMethods(
                                                    $stripe_customer_id,
                                                    ['type' => 'card']
                                                );

            if(isset($payment_methods->data) && is_array($payment_methods->data) && count($payment_methods->data)){

                foreach ($payment_methods->data as $key => $value) {
                    
                    if($value->id != $payment_method_token){

                        try { 

                            $stripe->paymentMethods->detach(
                                $value->id,
                                []
                            );

                        }catch (\Exception $e) {
                        
                            Log::info("error detech payment method ". $e->getMessage());
                
                        }
                    }
                }
            }

        }catch (\Exception $e) {
                        
            Log::info("error stripe_detech_unused_payment_methods ". $e->getMessage());
            return array('status' => 0, 'message' => trans('pages.something_wrong'));

        }

    }

    public static function stripe_get_user_default_payment_method($user_data)
    { 
      
        try { 

            $user_details = false;

            if($user_data['user_type'] == config('custom.user_type.member')){

                $user_details =  Member::find($user_data['user_id']);

            }else if($user_data['user_type'] == config('custom.user_type.stylist')){

                $user_details =  Stylist::find($user_data['user_id']);
                
            }

            if(!$user_details){

                return array('status' => 0, 'message' => trans('pages.crud_messages.no_data', [ 'attr' => 'user']) );
        
            }

            $stripe_customer_id = $user_details->stripe_customer_id;

            if(!empty($stripe_customer_id)){

                try {

                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        
                    $stripe_customer = $stripe->customers->retrieve($stripe_customer_id);
    
                    if($stripe_customer){
    
                        $payment_method = $stripe->paymentMethods->retrieve(
                            $stripe_customer->invoice_settings->default_payment_method,
                            []
                          );
    
                    }

                    return ['status' => 1, 'message' => trans('pages.action_success'), 'data' => $payment_method ];

    
                }catch (\Exception $e) {
                                            
                    Log::info("error ". $e->getMessage());
                    return array('status' => 0, 'message' => trans('pages.stripe_payment_method_not_found'), 'error' => $e->getMessage());
    
                }
    
            }else{

                return array('status' => 0, 'message' => trans('pages.stripe_user_not_found'));
    
            }
        
        }catch (\Exception $e) {
                        
            Log::info("error stripe_get_user_default_payment_method ". $e->getMessage());

            return array('status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage());

        }
    }

    public static function stripe_charge_payment($request)
    { 
      
        $result = array('status' => 0, 'message' => trans('pages.something_wrong'));

        try { 

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
    
            $payment_result = $stripe->charges->create([
                                    'amount' => ($request->amount * 100),       // e.g., 100 cents to charge $1.00 or 100 to charge ¥100, a zero-decimal currency
                                    'currency' => 'usd',
                                    'source' => $request->payment_method_token
                                ]);

            Log::info("payment_result ". print_r($payment_result, true));
           
            return ['status' => 1, 'message' => trans('pages.action_success'), 'data' => ['payment_dtls' => $payment_result] ];
        
        }catch (\Exception $e) {
                        
            Log::info("error stripe_charge_payment ". $e->getMessage());

            return array('status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage());

        }
    }

}