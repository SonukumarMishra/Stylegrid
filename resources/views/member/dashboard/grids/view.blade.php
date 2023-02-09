@extends('member.dashboard.layouts.default')

@section('content')


   <style>

      .nav.nav-tabs .nav-item .nav-link.active, .nav.nav-pills .nav-item .nav-link.active {
         box-shadow: 0 2px 4px 0 rgb(90 141 238 / 50%);
      }

      .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
         color: #FFFFFF;
         background-color: #00A82F;
         border-color: transparent;
      }
      .nav.nav-tabs {
         margin-bottom: 1rem;
         border-bottom-color: #ededed;
      }
      .nav-tabs {
         border-bottom: 1px solid #7E8FA3;
      }

      .table thead th, .table tbody tr{
         border-bottom: 2px solid #E2E2E2 !important;
      }

   </style>

   <div class="content-wrapper">

      <input type="hidden" id="grid_id" name="grid_id" value="{{ $style_grid_dtls->stylegrid_id }}">
        
      <div class="content-body">

         <!-- Revenue, Hit Rate & Deals -->

         <div class="flex-column-reverse flex-md-row mt-lg-3 row">

            <div class="col-md-8">

               <div class="col-md-8">

                  <h1>Let&apos;s get styling.</h1>

                  <h3>Create a new StyleGrid and send to your clients via PDF or weblink.</h3>

               </div>

            </div>

            <div class="col-md-4 quick-link text-right">

               <span class="mr-5"><a hrf="">Quick Link</a></span>

               <div class="row justify-content-end my-2">

                  <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Chat.svg')}}"

                     alt=""></a>

                  <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/File Invoice.svg')}}"

                     alt=""></a>

                  <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a>

               </div>

            </div>

         </div>

         <!-------------------- fulfil souring request--------->

         <div id="create-grid" class="mt-5">

            <div class="row">

               <div class="col-lg-12">

                  <div class="stylegrid-bg-img mx-lg-4 mx-2 mt-3 px-lg-4 px-2 py-2 height_570" style="background: url({{asset($style_grid_dtls->feature_image)}})">

                       <div class="gridcreated_j">

                          <h1>STYLEGRID</h1>

                          <div class="row">

                             <div class="col-lg-12  align-items-center">

                                <h4>{{ $style_grid_dtls->title }}</h4>

                             </div>

                          </div>

                       </div> 

                  </div>

               </div>

            </div>



           @if (count($style_grid_dtls->grids))



               @foreach ($style_grid_dtls->grids as $g_key => $grid)

                    

                   <div class="row">

                       <div class="col-lg-12">

                       <div class="new-grid-bg mx-lg-4 mx-2 px-lg-3 mx-2 py-2">

                           <div class="row">

                               <div class="col-8">

                                   <h1>STYLEGRID {{ $g_key+1 }}</h1>

                               </div>

                           </div>

                           <div class="row add-item mt-4 mb-4">

                              @php
                                               
                                 list($grid_items1, $grid_items2) = array_chunk($grid->items->ToArray(), ceil(count($grid->items->ToArray()) / 2));
                                    
                              @endphp

                              @if (is_array($grid_items1) && count($grid_items1))
                                                               
                                 <div class="col-lg-5">

                                    <section class="stylegrid-cards row d-flex">

                                       @foreach ($grid_items1 as $i_key => $item)

                                          <div class="grid-item-inner-input-block" data-stylegrid-id="{{ $item['stylegrid_id'] }}" data-stylegrid-dtls-id="{{ $item['stylegrid_dtls_id'] }}"  data-stylegrid-product-id="{{ $item['stylegrid_product_id'] }}">

                                             <img class="stylegrid-product-img" src="{{asset($item['product_image'])}}" alt=" " />

                                       </div>

                                       @endforeach

                                    </section>

                                 </div>
                                 <div class="col-lg-1"></div>

                              @endif

                              @if (is_array($grid_items2) && count($grid_items2))

                                 <div class="col-lg-1"></div>

                                 <div class="col-lg-5">

                                    <section class="stylegrid-cards row d-flex">

                                       @foreach ($grid_items2 as $i_key => $item)

                                          <div class="grid-item-inner-input-block" data-stylegrid-id="{{ $item['stylegrid_id'] }}" data-stylegrid-dtls-id="{{ $item['stylegrid_dtls_id'] }}"  data-stylegrid-product-id="{{ $item['stylegrid_product_id'] }}">

                                             <img class="stylegrid-product-img" src="{{asset($item['product_image'])}}" alt=" " />

                                          </div>

                                       @endforeach

                                    </section>

                                 </div>

                              @endif

                               {{-- <div class="col-lg-5 px-2">

                                   <img src={{asset($grid->feature_image)}} class="img-fluid w-100 height_500 img_preview" alt="">

                               </div> --}}

                           </div>

                       </div>

                       </div>

                   </div>

                @endforeach

           

            @endif

         </div>

      </div>

   </div>

   <div class="modal" id="grid_item_details_modal" tabindex="-1" role="dialog" style="top: 5% !important;">

      <div class="modal-dialog" role="document">

         <div class="modal-content pt-1">

            <div class="mr-2">

               <button type="button" class="close" data-dismiss="modal" aria-label="Close">

               <span aria-hidden="true">&times;</span>

               </button>

            </div>

            <div class="modal-body py-2">

               <h1 class="text-center modal-submit-request">Product Details <span id="modal_stylegrid_item_title"></span></h1>

               <div id="browse-soursing" class="mt-2">

                     <div class="row align-items-center">

                        <div class="col-lg-6 ">

                           <div class="p-1">

                              <img src="" class="item-modal-image-src img_preview" id="product_image_preview" alt="">

                           </div>

                        </div>

                        <div class="col-lg-6">

                           <div class="p-2 lg-border-left">

                              <div class="form-group">

                                 <h5>Product Name:</h5>

                                 <label id="product_name"></label>

                              </div>

                              <div class="form-group">

                                 <h5>Product Brand:</h5>

                                 <label id="product_brand"></label>

                              </div>

                              <div class="form-group">

                                 <h5>Product Type:</h5>

                                 <label id="product_type"></label>

                              </div>

                              <div class="form-group">

                                 <h5>Product Price:</h5>

                                 <label>$<span id="product_price"></span></label>

                              </div>

                              <div class="form-group">

                                 <h5>Product Size:</h5>

                                 <label id="product_size"></label>

                              </div>    

                              <div class="form-group">
                                 <input type="hidden" id="cart_module_id" value="{{ $style_grid_dtls->stylegrid_id }}">
                                 <input type="hidden" id="cart_module_type" value="{{ config('custom.cart.module_type.stylegrid') }}">
                                 <input type="hidden" id="cart_item_id" >
                                 <input type="hidden" id="cart_item_type" value="{{ config('custom.cart.item_type.stylegrid_product') }}">
                                 <button class="submit-request" style="width:210px;" id="cart_action_btn" data-action="add"><span id="cart_icon"><i class="fa-solid fa-cart-shopping"></i></span>&nbsp; <span id="cart_btn_title"> Add To Cart</span></button>

                              </div>                           

                           </div>

                        </div>

                     </div>

               </div>

            </div>

         </div>

      </div>

   </div>

   {{-- page scripts --}}

   @section('page-scripts')

      @include('scripts.member.grid.view_js')

   @endsection



@stop



