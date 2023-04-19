@include('stylist.postloginview.partials.header.header')
@include('stylist.postloginview.partials.navigate.navigate')
<!-- BEGIN: Content-->
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class="mt-lg-3 row">
                <div class="col-8">
                    <h1>Welcome to your product sourcing hub.</h1>
                    <h3>Submit sourcing requests or fufill sourcing tickets from the live feed.</h3>
                    <div class="mt-lg-3">
                        <a href="{{ url('/stylist-create-source-request') }}"><button class="make-request">Make New Request</button></a>
                    </div>
                </div>
                <div class="col-4 grid-list-view">
                    <div class="d-flex justify-content-end my-2">
                        <div class="mr-2"><button class="grid-view page-view-btn" data-action="grid">Grid View</button></div>
                        <div><button class="list-view page-view-btn" data-action="list">List View</button></div>
                    </div>

                </div>
            </div>

            <!--------------------souring hub--------->
            <div id="browse-soursing" class="mt-5">
                
                <div id="grid-view-container">

                    <div class="text-lg-left text-center mt-3">
                        <h1 class=" pl-1">My Requests</h1>
                        <h2 class="px-2 mt-1 col-lg-5 col-6 text-lg-left text-center"> </h2>
                    </div>

                    <div class="row w-100" id="new-sourcing-page">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="owl-carousel d-flex" id="grid_my_requests_tbl_container">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="owl-carousel row">
                                        <div class=" px-0 mb-3">
                                            <div class="card">
                                                <div>
                                                    <img src="http://127.0.0.1:8000/attachments/source/723675662.jpeg"
                                                        class="img-fluid new-sourcing-active-req-img-border1" alt="">
                                                </div>
                                                <div class="p-1">
                                                    <div class="open-text">Open</div>
                                                    <div class="active-request-product-name ">DAY DATE YELLOW GOLD</div>
                                                    <div class="active-request-product-type">ROLEX</div>
                                                    <a href="#" class=""><button
                                                            class="active-request-product-fulfill mt-1">VIEW
                                                            OFFER</button></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-0 mb-3">
                                            <div class="card">
                                                <div>
                                                    <img src="http://127.0.0.1:8000/attachments/source/723675662.jpeg"
                                                        class="img-fluid new-sourcing-active-req-img-border1" alt="">
                                                </div>
                                                <div class="p-1">
                                                    <div class="open-text">Open</div>
                                                    <div class="active-request-product-name ">EMBROIDERED BOMBER</div>
                                                    <div class="active-request-product-type">MAD HAPPY</div>
                                                    <a href="#" class=""><button
                                                            class="active-request-product-fulfill mt-1">VIEW
                                                            OFFER</button></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-0 mb-3">
                                            <div class="card">
                                                <div>
                                                    <img src="http://127.0.0.1:8000/attachments/source/723675662.jpeg"
                                                        class="img-fluid new-sourcing-active-req-img-border1" alt="">
                                                </div>
                                                <div class="p-1">
                                                    <div class="open-text">Open</div>
                                                    <div class="active-request-product-name ">PRINTED T-SHIRT</div>
                                                    <div class="active-request-product-type">CELINE</div>
                                                    <a href="#" class=""><button
                                                            class="active-request-product-pending mt-1">PENDING</button></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" px-0 mb-3">
                                            <div class="card">
                                                <div>
                                                    <img src="http://127.0.0.1:8000/attachments/source/723675662.jpeg"
                                                        class="img-fluid new-sourcing-active-req-img-border1" alt="">
                                                </div>
                                                <div class="p-1">
                                                    <div class="open-text">Open</div>
                                                    <div class="active-request-product-name ">TAPERED CARGO PANTS</div>
                                                    <div class="active-request-product-type">BRUNELLO CUCINELLI</div>
                                                    <a href="#" class=""><button
                                                            class="active-request-product-pending mt-1">PENDING</button></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-0 mb-3">
                                            <div class="card">
                                                <div>
                                                    <img src="http://127.0.0.1:8000/attachments/source/723675662.jpeg"
                                                        class="img-fluid new-sourcing-active-req-img-border1" alt="">
                                                </div>
                                                <div class="p-1">
                                                    <div class="open-text">Open</div>
                                                    <div class="active-request-product-name ">DAY DATE YELLOW GOLD</div>
                                                    <div class="active-request-product-type">ROLEX</div>
                                                    <a href="#" class=""><button
                                                            class="active-request-product-fulfill mt-1">VIEW
                                                            OFFER</button></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="text-lg-left text-center mt-3">
                        <h1 class=" pl-1">Active Requests</h1>
                        <h2 class="px-2 mt-1 col-lg-5 col-6 text-lg-left text-center"> </h2>
                    </div>

                    <div class="row w-100" id="new-sourcing-page">
                        <div class="container-fluid">
                            <div class="row p-2">
                                <div class="col-md-12">
                                    <!-- <div class="owl-carousel row" id="grid_live_requests_tbl_container"> -->
                                    <div class=" row" id="grid_live_requests_tbl_container">    
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                
                <div id="list-view-container" style="display: none;">

                    <div class="text-lg-left text-center mt-3">
                        <h1 class=" pl-1">My Requests</h1>
                        <h2 class="px-2 mt-1 col-lg-5 col-6 text-lg-left text-center"> </h2>
                    </div>
    
                    <div class="row w-100">
                        <div id="TabContent" class="tab-content my-2 w-100">
                            <div class="tab-pane fade active show" id="Fashion_1" role="tabpanel"
                                aria-labelledby="Fashion-tab">
                                <div class="text-center ml-2 add-table-border">
                                    <table class="table  w-100 table-responsive">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-left pl-4">PRODUCT NAME</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Destination</th>
                                                <th scope="col">Due Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_my_requests_tbl_container">
    
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right mt-2 mr-3" id="my_requests_pagination_container">
    
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row  text-aligns-center justify-content-center justify-content-lg-start">
                                <h1 class="col-lg-4 text-lg-left text-center">Active Requests</h1>
                                
                            </div>
                        </div>
    
                    </div>
                    
                    <div class="row w-100">
                        <div id="TabContent" class="tab-content my-2 w-100">
                            <div class="tab-pane fade active show" id="Fashion_1" role="tabpanel"
                                aria-labelledby="Fashion-tab">
                                <div class="text-center ml-2 add-table-border">
                                    <table class="table  w-100 table-responsive" id="live_requests_tbl">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-left pl-4">PRODUCT NAME</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Destination</th>
                                                <th scope="col">Due Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="list_live_requests_tbl_container">
    
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right mt-2 mr-3" id="live_requests_pagination_container">
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!--------------------end of souring Hub--------->
        </div>
    </div>

    <div class="modal" id="sourcing_invoice_modal" tabindex="-1" role="dialog" style="top: 5% !important;">

        <div class="modal-dialog" role="document">

            <div class="modal-content pt-1">

                <div class="mr-2">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body py-2">

                    <h1 class="text-center modal-submit-request" id="modal_sourcing_invoice_title"></h1>

                    <div id="browse-soursing" class="mt-2">

                        <form action="#" method="POST" id="sourcing_invoice_frm">

                            <input type="hidden" name="sourcing_id">

                            <div class="row align-items-center">

                                <div class="col-lg-12">

                                    <div class="form-group">

                                        <label for="">Enter invoice Amount:</label>

                                        <input type="number" name="invoice_amount" min="0"
                                            class="form-control submit-input" placeholder="Enter invoice amount..."
                                            required>
                                    </div>

                                </div>

                            </div>

                            <div class="row justify-content-center">

                                <button class="submit-request" id="sourcing_invoice_frm_btn">Generate</button>

                                <button class="back-btn ml-2" class="close" data-dismiss="modal"
                                    aria-label="Close">Close</button>

                            </div>

                        </form>

                    </div>


                </div>



            </div>

        </div>

    </div>

    {{-- page scripts --}}
    @section('page-scripts')
        @include('scripts.stylist.sourcing_js')
    @endsection

</div>
@include('stylist.postloginview.partials.footer.footerjs')
