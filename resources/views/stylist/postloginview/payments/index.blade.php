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
                    <h1>Manage your Payments</h1>
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
                    <div class="col-lg-12 row">

                        <div class="col-lg-10">
                            <h1 class="text-lg-left text-center">Payments</h1>
                        </div>

                        <div class="col-lg-2">
                            <a href="{{route('stylist.payment.create')}}" class="text-lg-left text-center"><button class="make-request px-2">Create Invoice</button></a>
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
                                        <th scope="col">Customer</th>
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
    

    {{-- page scripts --}}
    @section('page-scripts')

        @include('scripts.stylist.payment.index_js')

    @endsection

</div>
@include("stylist.postloginview.partials.footer.footerjs")