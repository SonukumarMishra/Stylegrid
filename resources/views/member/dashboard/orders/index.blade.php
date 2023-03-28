@extends('member.dashboard.layouts.default')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
        <!-- Revenue, Hit Rate & Deals -->
        <div class="row mt-lg-3">
            <div class="col-8">
                <h1>View your order history</h1>
                <h3>Browse your current and previous orders made through StyleGrid.</h3>
            </div>
            <div class="col-4 quick-link text-right">
                <span class="mr-md-5"><a hrf="">Quick Link</a></span>
                <div class="d-flex justify-content-end my-2">
                    <a href="" class="mx-lg-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/Chat.svg') }}" alt=""></a>
                    <a href="" class="mx-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/File Invoice.svg') }}" alt=""></a>
                    <a href="" class="mx-lg-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/Gear.svg') }}" alt=""></a>

                </div>

            </div>
        </div>
        <!--------------------souring hub--------->
        <div id="browse-soursing" class="mt-5">
            <div class="row">
                <div class="col-lg-12 row">

                    <div class="col-lg-10">
                        <h1 class="text-lg-left text-center">Your Order Summary</h1>
                    </div>

                </div>
                
            </div>

            <div class="row w-100">

                <div class="col-12 p-0 mt-2">
                    <div class="text-center ml-2 add-table-border">
                        <table class="table w-100 table-responsive" id="payment_list_tbl">
                            <thead>
                                <tr>
                                    <th scope="col">Invoice No</th>
                                    <th scope="col">Stylist</th>
                                    <th scope="col">No of Items</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Paid On</th>
                                    <th scope="col">Created On</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="payment_list_tbl_container">
                               
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    <div class="float-right mt-2" id="payment_list_pagination_container">

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

        @include('scripts.member.payment.index_js')

    @endsection

@stop
