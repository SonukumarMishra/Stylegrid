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
                    <h1>Your Clients</h1>
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
                {{-- <div class="row">
                    <div class="col-lg-12 row">

                        <div class="col-lg-10">
                            <h1 class="text-lg-left text-center">Clients</h1>
                        </div>

                    </div>
                    
                </div> --}}

                <div class="row w-100">

                    <div class="col-12 p-0 mt-2">
                        <div class="text-center ml-2 add-table-border">
                            <table class="table w-100 table-responsive" id="client_list_tbl">
                                <thead>
                                    <tr>
                                        <th scope="col">Client Name</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Payment</th>
                                        <th scope="col">Date Joined</th>
                                    </tr>
                                </thead>
                                <tbody id="client_list_tbl_container">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="float-right mt-2" id="client_list_pagination_container">

                        </div>
                    </div>
                </div>
                
            </div>
            <!--------------------end of souring Hub--------->
        </div>
    </div>
    

    {{-- page scripts --}}
    @section('page-scripts')

        @include('scripts.stylist.client.index_js')

    @endsection

</div>
@include("stylist.postloginview.partials.footer.footerjs")