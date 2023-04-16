@include('stylist.postloginview.partials.header.header')

@include('stylist.postloginview.partials.navigate.navigate')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- BEGIN: Content-->

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

<div class="app-content content bg-white">

   <input type="hidden" id="stylegrid_id" name="stylegrid_id" value="{{ $style_grid_dtls->stylegrid_id }}">

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
      
             <div class="col-md-4 quick-link text-right" style="display:block;">

                {{-- <span class="mr-5"><a hrf="">Quick Link</a></span> --}}

                <div class="row justify-content-end my-2">

                  <button class="grid-btn m-0 mr-1" id="send_to_client_btn">Send to Client</button>

                   {{-- <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Chat.svg')}}"

                      alt=""></a>

                   <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/File Invoice.svg')}}"

                      alt=""></a>

                   <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a> --}}

                </div>

             </div>

          </div>

          <!-------------------- fulfil souring request--------->

          <div id="create-grid" class="mt-5">

             <div class="row">

                <div class="col-lg-12">

                   <div class="stylegrid-bg-img mx-lg-4 mx-2 mt-3 px-lg-4 px-2 py-2 height_570" style="background: url({{isset($style_grid_dtls->feature_thumb_img) && !empty($style_grid_dtls->feature_thumb_img) ? asset($style_grid_dtls->feature_thumb_img) : asset($style_grid_dtls->feature_image)}});position:relative;display: flex;align-items: center;">

                        
					<div class="layer"></div>
                       <div class="gridcreated_j" style="background:none;width:100%;">
				

                          <div class="row">

                             <div class="col-lg-12  align-items-center">
                              <h1 style="color:white;font-size: 52px;">{{ $style_grid_dtls->title }}</h1>

                                <h4 style="color:white;">STYLEGRID</h4>

                             </div>

                          </div>

                       </div> 
						<!--div class="gridcreated_j">

                           <h1>STYLEGRID</h1>

                           <div class="row">

                              <div class="col-lg-12 d-flex align-items-center">

                                 <h4>{{ $style_grid_dtls->title }}</h4>

                              </div>

                           </div>

                        </div--> 

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

                            <div class="row add-item d-flex align-items-center">

                                <div class="col-lg-7">

        

                                    <section class="stylegrid-cards p-5">

                                        

                                        @if (count($grid->items))



                                            @foreach ($grid->items as $i_key => $item)



                                                <div class="grid-item-inner-input-block" data-stylegrid-dtls-id="{{ $item->stylegrid_dtls_id }}"  data-stylegrid-product-id="{{ $item->stylegrid_product_id }}">



                                                    <img class="stylegrid-product-img1" src="{{ isset($item->product_thumb_img) && !empty($item->product_thumb_img) ? asset($item->product_thumb_img) : asset($item->product_image)}}" alt=" " />



                                                </div>



                                            @endforeach

                                        

                                        @endif

                                                               

                                    </section>

        

                                </div>

                                <div class="col-lg-5 px-2">

                                    <img src="{{ isset($grid->feature_thumb_img) && !empty($grid->feature_thumb_img) ? asset($grid->feature_thumb_img) : asset($grid->feature_image) }}" class="img-fluid w-100 height_5001 img_preview" alt="">

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

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="background:#1897dcfa !important;">

                         <a class="dropdown-item border-bottom-1" style="font-size:18px !important;" id="export_pdf_btn" href="{{ route('stylist.grid.download.pdf', ['grid_id' => $style_grid_dtls->stylegrid_id]) }}" data-action="{{ route('stylist.grid.download.pdf', ['grid_id' => $style_grid_dtls->stylegrid_id]) }}">Export as PDF</a>

                         <a class="dropdown-item" href="#" style="font-size:18px !important;" id="copy_link_btn" data-copy-content="{{ Request::url() }}">Copy Link</a>

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

                              <label>£ &nbsp;<span id="product_price"></span></label>

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


 {{-- Grid's clients --}}
 <div class="modal" id="grid_clients_modal" tabindex="-1" role="dialog" style="top: 5% !important;">

   <div class="modal-dialog" role="document">

      <div class="modal-content pt-1">

         <div class="modal-header">
            <h3 class="modal-title" id="myModalLabel1">Clients of Grid</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
          </div>

         <div class="modal-body py-2">

            <div class="col-12">
               <ul class="nav nav-tabs justify-content-end" role="tablist">
                  
                  <li class="nav-item">
                     <a class="nav-link active" data-toggle="tab" href="#client-form-tab"
                        aria-controls="service-align-end" role="tab" aria-selected="false">
                        Send To Client
                     </a>
                  </li>

                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#clients-list-tab" role="tab" aria-selected="true">
                        Clients
                     </a>
                  </li>
                  
                  
               </ul>
               <div class="tab-content">

                  <div class="tab-pane active" id="client-form-tab" role="tabpanel">
                     
                     <div class="row">
                     
                        {{-- <div class="col-md-12 mb-1">
                           <div class="form-group">
                             <select class="select2 form-control" id="search_client_input">
                             </select>
                           </div>
                         </div> --}}

                         <div class="col-md-12 mt-1 mb-3" id="search_clients_container">

                           <table class="table w-100 table-responsive" id="grid_clients_tbl">
                              <thead>
                                  <tr>
                                      <th scope="col" class="text-left pl-4">#</th>
                                      <th scope="col">Name</th>
                                  </tr>
                              </thead>
                              <tbody>
                                 
                              </tbody>
                          </table>

                         </div>

                        <div class="row col-12 d-flex justify-content-end">

                           <button class="submit-request" id="send_grid_btn">Send</button>

                        </div>
                        

                     </div>

                  </div>

                  <div class="tab-pane" id="clients-list-tab" role="tabpanel">
                     
                     <div class="text-center add-table-border">

                        <table class="table w-100 table-responsive borderless" id="grid_clients_table">

                            <thead>

                                <tr>

                                    <th scope="col">Client Name</th>

                                    <th scope="col">Send On</th>

                                </tr>

                            </thead>

                            <tbody id="grid_clients_table_body">


                            </tbody>

                        </table>

                    </div>

                  </div>                 
                  
               </div>
            </div>

         </div>

      </div>

   </div>

</div>


@include('stylist.postloginview.partials.footer.footerjs')

@include('scripts.stylist.grid.view_js')

