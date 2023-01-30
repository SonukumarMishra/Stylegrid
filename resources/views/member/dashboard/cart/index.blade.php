@extends('member.dashboard.layouts.default')

<style>


</style>
@section('content')

    <div class="content-wrapper">

      <div class="content-body">

         <div class="flex-column-reverse flex-md-row mt-lg-3 row">

               <div class="col-md-8">

                  <div class="col-md-8">

                     <h1>Your Cart</h1>

                     <h3>There are 3 products in your cart</h3>

                  </div>

               </div>


         </div>

         <div id="" class="mt-2">

               <div class="row" id="cart_container">

               </div>
   
         </div>

       </div>

   </div>



   {{-- page scripts --}}

    @section('page-scripts')
    
        @include('scripts.member.cart.index_js')

    @endsection

@stop



