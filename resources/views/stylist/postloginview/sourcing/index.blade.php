@include("stylist.postloginview.partials.header.header")
@include("stylist.postloginview.partials.navigate.navigate")
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
                    </div>
                    <div class="col-4 quick-link text-right">
                        <span class="mr-lg-5"><a hrf="">Quick Link</a></span>
                        <div class="d-flex justify-content-end my-2">
                            <a href="" class="mx-lg-1"><img src="{{asset('stylist/app-assets/images/icons/Chat.svg')}}" alt=""></a>
                            <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/File Invoice.svg')}}" alt=""></a>
                            <a href="" class="mx-lg-1"><img src="{{asset('stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a>

                        </div>

                    </div>
                </div>
            
            <!--------------------souring hub--------->
            <div id="browse-soursing" class="mt-5">
                <div class="row">
                <div class="col-lg-8">
                            <div class="row  text-aligns-center justify-content-center justify-content-lg-start">
                                <h1 class="col-lg-4 text-lg-left text-center">Live Tickets</h1>
                                <h2 class="px-2 mt-1 col-lg-5 col-6 text-lg-left text-center"> </h2>
                                <a href="{{url('/stylist-create-source-request')}}" class=" col-lg-3 col-6 mt-2 text-lg-left text-center"><button class="request-btn px-2">Make Request</button></a>
                            </div>
                        </div>
                    
                    <!-- Pills navs -->
                    <div class="col-lg-4 d-flex justify-content-end mt-lg-0 mt-2">
                        <ul id="myTab_1" role="tablist" class="nav nav-tabs   flex-sm-row text-center  rounded-nav">
                            <li class="nav-item ">
                                <a id="home-tab" data-toggle="tab" href="#home_1" role="tab" aria-controls="home"
                                    aria-selected="true"
                                    class="nav-link border-0 cyan-blue  font-weight-bold">Home</a>
                            </li>
                            <li class="nav-item ">
                                <a id="Fashion-tab" data-toggle="tab" href="#Fashion_1" role="tab"
                                    aria-controls="Fashion" aria-selected="false"
                                    class="nav-link border-0 cyan-blue font-weight-bold active ">Fashion</a>
                            </li>
                            <li class="nav-item ">
                                <a id="Beauty-tab" data-toggle="tab" href="#Beauty_1" role="tab"
                                    aria-controls="Beauty" aria-selected="false"
                                    class="nav-link border-0 cyan-blue font-weight-bold ">Beauty</a>
                            </li>
                            <li class="nav-item ">
                                <a id="Travel-tab" data-toggle="tab" href="#Travel_1" role="tab"
                                    aria-controls="Travel" aria-selected="false"
                                    class="nav-link border-0 cyan-blue font-weight-bold">Travel</a>
                            </li>

                        </ul>
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
                                    <tbody id="live_requests_tbl_container">
                                       
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-right mt-2 mr-3" id="live_requests_pagination_container">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-lg-left text-center mt-3">
                    <h1 class=" pl-1">My Sources</h1>
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
                                    <tbody id="my_requests_tbl_container">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="float-right mt-2 mr-3" id="my_requests_pagination_container">

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
    
                                        <input type="number" name="invoice_amount" min="0" class="form-control submit-input"
    
                                             placeholder="Enter invoice amount..." required>
                                    </div>
    
                                </div>
    
                            </div>
    
                            <div class="row justify-content-center">
    
                                <button class="submit-request" id="sourcing_invoice_frm_btn">Generate</button>
    
                                <button class="back-btn ml-2" class="close" data-dismiss="modal" aria-label="Close">Close</button>
    
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
@include("stylist.postloginview.partials.footer.footerjs")