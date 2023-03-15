
@if (isset($user_details) && !empty($user_details->trial_start_date) && !empty($user_details->trial_end_date) && date('Y-m-d') >= date('Y-m-d', strtotime($user_details->trial_end_date)))
    
@endif

{{-- <h3 class="text-danger text-center mb-1 col-12">
   Your trial subscription will end on {{ date('m/d/Y', strtotime($user_details->trial_end_date)) }}.
</h3> --}}

@if (count($result['list']))

   <div class="row col-12 justify-content-center">
   
      @foreach ($result['list'] as $key => $val)
         
         <div class="subscription-card col-3">
            
            <div class="card-body">
               <h2 class="text-left text-white mb-3 mt-2">{{ $val->subscription_name }}</h2>
               <h6 class="card-subtitle mb-1 text-white">{{ $val->short_details }}</h6>
               
               <div class="sub-price-container d-flex align-items-center mb-1 justify-content-center">

                  <h5 class="subscription-price-title">£{{ $val->price }}</h5>
                  
                  @if ($val->subscription_type == config('custom.subscription.types.paid'))

                     <span class="subscription-price-subtitle ml-1">Per {{ $val->interval_type }}</span>

                  @endif

               </div>

               <div class="col-12 row p-0 m-0">
                 
                  @if ($val->subscription_type == config('custom.subscription.types.paid') && $val->subscription_id == $val->user_main_subscription_id && $val->subscription_status == config('custom.subscription.status.active'))
                  
                     @if ($val->is_auto_payment == 0)
      
                        <button class="susbcription-buy-btn w-100" disabled>Cancelled</button>
                     
                     @else 

                        <button class="susbcription-buy-btn w-100 cancel-subscription" data-sub-name="{{ $val->subscription_name }}" data-sub-end-date="{{ date('m/d/Y', strtotime($val->subscription_end_date)) }}"  data-user-subscription-id="{{ $val->user_subscription_id }}">Cancel</button>

                     @endif
                  
                  @elseif($val->subscription_type == config('custom.subscription.types.paid') )
                  
                     <button class="susbcription-buy-btn w-100 buy-subscription" data-title="{{ $val->subscription_name }}" data-subscription-id="{{ $val->subscription_id }}" data-interval-type="{{ $val->interval_type }}" data-price="{{ $val->price }}">Buy</button>
                     
                  @elseif($val->subscription_type == config('custom.subscription.types.free'))
                  
                     <button class="susbcription-buy-btn w-100" disabled>
                        @if ($val->subscription_id == $val->user_main_subscription_id)
                           Activate
                        @else 
                           Free       
                        @endif
                     </button>

                  @endif

               </div>

               <div class="susbcription-hr w-100"></div>

               <div class="susbcription-list-dtls">
                  {!! $val->subscription_details !!}
               </div>
             </div>
         </div>
         
      @endforeach

   </div>

@endif
