@include('stylist.postloginview.partials.header.header')
@include('stylist.postloginview.partials.navigate.navigate')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- BEGIN: Content-->
<style>

</style>
<div class="app-content content bg-white">
    <div class="content-wrapper">
       <div class="content-header row">
       </div>
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
                   <a href="" class="mx-1"><img src="{{asset('stylist/stylist/app-assets/images/icons/Chat.svg')}}"
                      alt=""></a>
                   <a href="" class="mx-1"><img src="{{asset('stylist/stylist/app-assets/images/icons/File Invoice.svg')}}"
                      alt=""></a>
                   <a href="" class="mx-1"><img src="{{asset('stylist/stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a>
                </div>
             </div>
          </div>
          <!-------------------- fulfil souring request--------->
          <div id="create-grid" class="mt-5">
             <div class="row">
                <div class="col-lg-12">
                   <div class="stylegrid-bg-img mx-lg-4 mx-2 mt-3 mb-2 px-lg-4 px-2 py-2 height_400" style="background: url({{asset($style_grid_dtls->feature_image)}})">
                      <h1>STYLEGRID</h1>
                      <div class="row">
                         <div class="col-lg-6 d-flex align-items-center">
                            <h4>{{ $style_grid_dtls->title }}</h4>
                         </div>
                      </div>
                   </div>
                </div>
             </div>

            @if (count($style_grid_dtls->grids))

                @foreach ($style_grid_dtls->grids as $g_key => $grid)
                     
                    <div class="row mt-2">
                        <div class="col-lg-12">
                        <div class="new-grid-bg mx-lg-4 mx-2 px-lg-3 mx-2 py-2">
                            <div class="row">
                                <div class="col-8">
                                    <h1>STYLEGRID {{ $g_key+1 }}</h1>
                                </div>
                            </div>
                            <div class="row add-item d-flex align-items-center">
                                <div class="col-lg-7">
        
                                    <section class="stylegrid-cards">
                                        
                                        @if (count($grid->items))

                                            @foreach ($grid->items as $i_key => $item)

                                                <div class="grid-item-inner-input-block" data-stylegrid-dtls-id="{{ $item->stylegrid_dtls_id }}"  data-stylegrid-product-id="{{ $item->stylegrid_product_id }}">

                                                    <img class="stylegrid-product-img" src="{{asset($item->product_image)}}" alt=" " />

                                                </div>

                                            @endforeach
                                        
                                        @endif
                                                               
                                    </section>
        
                                </div>
                                <div class="col-lg-5 px-2">
                                    <img src={{asset($grid->feature_image)}} class="img-fluid w-100 height_400 img_preview" alt="">
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                 @endforeach
            
             @endif
             
             <div class="row m-3 pt-5 justify-content-end">
                <div>
                   <div class="dropdown">
                      <button class=" dropdown-toggle export-btn px-3 py-1" type="button"
                         id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="false">Export Grid
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                         <a class="dropdown-item border-bottom-1" href="#">Export as PDF</a>
                         <a class="dropdown-item" href="#">Copy Link</a>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>

 <!--------------------end of fulfil souring request--------->
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
                         <div class="Neon Neon-theme-dragdropbox">
                            <div class="Neon-input-dragDrop d-flex align-items-center height_300">
                               <div class="Neon-input-inner">
                                  <a class="Neon-input-choose-btn blue"><img src="" class="item-modal-image-src img_preview" id="product_image_preview" alt=""></a>
                               </div>
                            </div>
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
                                <h5>Product Size:</h5>
                                <label id="product_size"></label>
                            </div>                            
                         </div>
                      </div>
                   </div>
             </div>
          </div>
       </div>
    </div>
 </div>

@include('stylist.postloginview.partials.footer.footerjs')

@include('scripts.stylist.grid.view')
