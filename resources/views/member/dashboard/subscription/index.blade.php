@extends('member.dashboard.layouts.default')

@section('content')

    <style>

      h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, li{
          font-family: 'Silk Serif';
      }
    </style>
    
    <div class="content-wrapper">

      <div class="content-body">

         <!-- <div class="flex-column-reverse flex-md-row mt-lg-3 row"> -->

         <div class=" flex-md-row mt-lg-3 row">
                  <div class="col-8">

                    <h1>Choose Your Right Plan</h1>
                    <h3>Upgrade to Premium & Get more Features!</h3>
                  </div>
                  
                  <div class="col-4 text-right mt-2">
                      <a href="{{ route('member.subscription.billing.index')}}" class="h4  view-billing-history">View Billing History <i class="ft-arrow-up-right"></i></a>
                  </div>


               </div>


         </div>

         <div id="" class="mt-3">

            <div class="row" id="subscription_container">

            </div>

         </div>

       </div>

   </div>

    {{-- Grid's clients --}}
  <div class="modal" id="payment_modal" tabindex="-1" role="dialog" style="top: 5% !important;">

    <div class="modal-dialog" role="document">

      <div class="modal-content pt-1">

          <div class="modal-header">
            <h3 class="modal-title" id="payment_modal_title">Buy Subscription</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body py-2">

            <div class="col-12" id="card_element">
               
              <form id="subscription-buy-form" method="post">
                <div id="card-ui-element">
                  <!-- Elements will create input elements here -->
                </div>
              
                <!-- We'll put the error messages in this element -->
                <div id="card-errors" class="text-danger mt-1" role="alert"></div>
              
                <div class="row justify-content-end mt-3">

                  <button class="submit-request" id="stylegrid_item_frm_btn">Buy</button>

                </div>

              </form>
            </div>

          </div>

      </div>

    </div>

  </div>

   {{-- page scripts --}}

    @section('page-scripts')
    
        <script src="https://js.stripe.com/v3/"></script>

        @include('scripts.member.subscription.index_js')

    @endsection

@stop



