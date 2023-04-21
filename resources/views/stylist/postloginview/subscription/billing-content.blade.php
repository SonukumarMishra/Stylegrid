<div class="row w-100">

    @php
        
        $subscription_dtls = $result['subscription_dtls'];

    @endphp

    @if (isset($subscription_dtls) && is_object($subscription_dtls) && count(get_object_vars($subscription_dtls)))
        
        <div class="col-lg-6">

            <div class="card sub-card-box">
                <div class="card-header d-flex justify-content-between align-items-center pb-1">
                    <h1 class=""> {{ $subscription_dtls->subscription_type == config('custom.subscription.types.trial') ? 'Free trial ' : '' }} {{ $subscription_dtls->subscription_name }} </h1>
                    <div class="card-title d-flex align-items-center">
                        <h5 class="active-sub-card-price-title">£{{ !empty($subscription_dtls->price) ? $subscription_dtls->price : 0.00 }}</h5>
                        <span class="ml-1 font-weight-light">Per month</span>
                    </div>
                </div>
                @php

                    $remaining_days = \Helper::get_days_from_dates(date('Y-m-d'), date('Y-m-d', strtotime($subscription_dtls->end_date)));

                @endphp
                <div class="card-body pb-1 pt-0 d-flex justify-content-between">
                    <h5 class="text-dark"> {{ $remaining_days > 0 ? $remaining_days.' days remaining' : ''}}</h5>
                    
                    @if ($subscription_dtls->subscription_status == config('custom.subscription.status.active') && isset($subscription_dtls->billing_invoice_date) && !empty($subscription_dtls->billing_invoice_date))

                        <h5 class="text-dark"> Next invoice on {{ date('m/d/Y', strtotime($subscription_dtls->billing_invoice_date)) }}</h5>
                    
                    @elseif ($subscription_dtls->subscription_status == config('custom.subscription.status.cancelled') && isset($subscription_dtls->end_date) && !empty($subscription_dtls->end_date))

                    <h5 class="text-dark"> Expire on {{ date('m/d/Y', strtotime($subscription_dtls->end_date)) }}</h5>
                    
                    @endif
                    
                </div>
                <div class="card-footer d-flex justify-content-between p-1">

                    @if ($subscription_dtls->subscription_type == config('custom.subscription.types.paid') && $subscription_dtls->subscription_status == config('custom.subscription.status.active'))

                        @if ($subscription_dtls->is_auto_payment == 0)
                            
                            <a class="light-outline-btn font-weight-bold text-danger border-danger" href="#" disabled>Cancelled</a>

                        @else 
                        
                            <a class="light-outline-btn font-weight-bold text-danger border-danger cancel-subscription" href="#" data-sub-name="{{ $subscription_dtls->subscription_name }}" data-sub-end-date="{{ date('m/d/Y', strtotime($subscription_dtls->end_date)) }}" data-user-subscription-id="{{ $subscription_dtls->user_subscription_id }}">Cancel Subscription</a>

                        @endif
                        
                    @endif
                    <a class="light-outline-btn font-weight-bold text-primary" href="{{ route('stylist.subscription.index') }}">Upgrade &nbsp;<i class="ft-arrow-up-right"></i></a>
                </div>
            </div>

        </div>
        
    @endif

    
    @php
        
        $payment_method = $result['payment_method_dtls'];

    @endphp
    
    @if (isset($payment_method) && is_object($payment_method) && count(get_object_vars($payment_method)))
     
        <div class="col-lg-6">

            <div class="card sub-card-box">
                <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h1 class="">Payment Method</h1>
                </div>
                <div class="card-body pb-2 pt-1 ml-1 mr-1">
                    <div class="rounded row border border-dark p-1">
                        <div class="col-2 d-flex align-items-center">
                            @php
                                $card_img = '';

                                if(@$payment_method->card->brand == config('custom.card_brand.visa')){
                                    
                                    $card_img = asset('common/images/cards/visa_light.png');

                                }else if(@$payment_method->card->brand == config('custom.card_brand.mastercard')){
                                    
                                    $card_img = asset('common/images/cards/mastercard_light.png');

                                }else if(@$payment_method->card->brand == config('custom.card_brand.amex')){
                                    
                                    $card_img = asset('common/images/cards/amex_light.png');

                                }else if(@$payment_method->card->brand == config('custom.card_brand.discover')){
                                    
                                    $card_img = asset('common/images/cards/discover_light.png');

                                }else if(@$payment_method->card->brand == config('custom.card_brand.jcb')){
                                    
                                    $card_img = asset('common/images/cards/jcb_light.png');

                                }else{
                                    
                                    $card_img = asset('common/images/cards/default_card.png');

                                }

                            @endphp

                            <img src="{{ $card_img }}" alt="" class="active-sub-card-img">
                        </div>
                        <div class="col-10">
                            <h5>
                            <span>{{ ucfirst(@$payment_method->card->brand) }} ending in {{ @$payment_method->card->last4 }}</span>&nbsp;
                            <span class="badge badge-pill badge-dark">Default</span> 
                            </h5>
                            <h6>
                                Expiry {{ @$payment_method->card->exp_month }}/{{ @$payment_method->card->exp_year }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @endif

</div>

<div class="text-lg-left text-center mt-3">

    <h1 class="">Billing History</h1>

</div>

<div class="w-100 p-0 m-0">

    <div class="text-center add-table-border p-2">

        <table class="table  w-100 table-responsive" id="billing_history_tbl">

            <thead>

                <tr>

                    <th>Purchased On</th>

                    <th>Plan</th>

                    <th>Type</th>

                    <th>Amount</th>

                    <th>Start Date</th>

                    <th>End Date</th>

                    <th>Cancelled On</th>
                    
                    <th>Cancellation Reason</th>

                    <th>Status</th>
                    
                    <th>Payment Status</th>

                    <th>Invoice</th>

                </tr>

            </thead>

            <tbody>

                

            </tbody>

        </table>

    </div>

</div>
