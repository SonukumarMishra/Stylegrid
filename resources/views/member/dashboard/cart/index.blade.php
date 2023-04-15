@extends('member.dashboard.layouts.default')

@section('content')

    <div class="content-wrapper">

      <div class="content-body">

         <div class="flex-column-reverse flex-md-row mt-lg-3 row">

               <div class="col-md-8">

                  <div class="col-md-8">

                     <h1>Your Cart</h1>

                     <h3 id="cart-index-items-count-title"></h3>

                  </div>
                  
                </div>

               </div>


         </div>

         <div id="" class="mt-2">

               <div class="row" id="cart_container">

               </div>

               <div class="row col-12 d-flex justify-content-end">

                    <button class="submit-request mr-2 send_items_tochat_btn" data-action="request_product" style="display:none;">Request to Buy</button>
                    <button class="submit-request send_items_tochat_btn"  data-action="request_more_details" style="display:none;">Request more details</button>

                </div>
                
   
         </div>

       </div>

   </div>



   {{-- page scripts --}}

    @section('page-scripts')
    
        @include('scripts.member.cart.index_js')

    @endsection

@stop



