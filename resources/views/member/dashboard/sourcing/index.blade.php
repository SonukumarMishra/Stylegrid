@extends('member.dashboard.layouts.default')

@section('content')

<!-- BEGIN: Content-->



    <div class="content-wrapper">



        <div class="content-header row">

        </div>

        <div class="content-body">

            <!-- Revenue, Hit Rate & Deals -->

            <div class="mt-lg-3 row">

                <div class="col-8">

                    <h1>Welcome to your product sourcing overview</h1>

                    <h3>Check the status on your existing sourcing requests or submit a new request.</h3>

                    <div class="mt-3">

                        <a href="{{ route('member.create_sourcing_request') }}"><button class="make-request">Make New Request</button></a>

                    </div>

                </div>

                <div class="col-4 quick-link text-right">

                    <span class="mr-lg-5"><a hrf="">Quick Link</a></span>

                  <div class="d-flex justify-content-end my-2 mr-lg-2">

                    <a href="" class="mx-lg-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/Chat.svg') }}" alt=""></a>

                    <a href="" class="mx-lg-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/Gear.svg') }}" alt=""></a>

                </div>



                </div>

            </div>

            <!--------------------souring hub--------->

            <div id="browse-soursing" class="mt-lg-5 mt-2">

                <div class="row">

                    <div class="col-lg-6 text-lg-left text-center">

                          <h1>Live Requests</h1>

                          </div>

                    <!-- Pills navs -->

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

                <!-----------------new table-------------->

                <div class="text-lg-left text-center mt-3">

                    <h1 class=" pl-1">Previous Requests</h1>

                </div>

                <div class="row w-100">

                    <div id="TabContent" class="tab-content my-2 w-100">

                        <div class="tab-pane fade active show" id="Fashion_1" role="tabpanel"

                            aria-labelledby="Fashion-tab">

                            <div class="text-center ml-2 add-table-border">

                                <table class="table  w-100 table-responsive" id="previous_requests_tbl">

                                    <thead>

                                        <tr>

                                            <th scope="col" class="text-left pl-4">PRODUCT NAME</th>

                                            <th scope="col">Size</th>

                                            <th scope="col">Type</th>

                                            <th scope="col">Brand</th>

                                            <th scope="col">Destination</th>

                                            <th scope="col">Due Date</th>

                                            <th scope="col">Status</th>

                                            <th></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!--------------------end of souring Hub--------->

        </div>

    </div>

    <div class="modal" id="sourcing_payment_invoice_modal" tabindex="-1" role="dialog" style="top: 5% !important;">

        <div class="modal-dialog" role="document">
    
            <div class="modal-content pt-1">
    
                <div class="mr-2">
    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    
                        <span aria-hidden="true">&times;</span>
    
                    </button>
    
                </div>
    
                <div class="modal-body py-2">
    
                    <h1 class="text-center modal-submit-request" id="modal_sourcing_payment_invoice_title"></h1>
    
                    <div id="browse-soursing" class="m-2 mt-3">
    
                        <form id="sourcing_payment_invoice_frm" action="#" method="post">

                            <input type="hidden" name="sourcing_id">

                            <div id="card-ui-element">
                              <!-- Elements will create input elements here -->
                            </div>
                          
                            <!-- We'll put the error messages in this element -->
                            <div id="card-errors" class="text-danger mt-1" role="alert"></div>
                          
                            <div class="row justify-content-end mt-3">
            
                              <button class="submit-request" id="sourcing_payment_invoice_frm_btn">Buy</button>
            
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

        @include('scripts.member.sourcing_js')


    @endsection



    @stop