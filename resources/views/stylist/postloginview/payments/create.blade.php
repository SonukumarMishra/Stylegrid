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
                    <h1>Create Payment</h1>
                </div>
                <div class="col-4 quick-link text-right">
                    

                </div>
            </div>
            
            <!--------------------souring hub--------->
            <div id="browse-soursing" class="mt-5">
            
                <form action="#" method="post" id="invoice_frm">
                        
                    <div class="row w-100">

                        <div class="col-12 row mt-2">
                        
                            <div class="col-md-10">
                                
                                <div class="form-group">
                                    {{-- <label for="formGroupExampleInput">Select Customer</label> --}}
                                    <select class="form-control" id="customer_id" required>
                                        <option value="">Select Customer</option>
                                        @if (isset($customers) && count($customers))
                                            @foreach ($customers as $item)
                                            <option value="{{ $item->value }}">{{ $item->label }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                            </div>
                                
                            <div class="col-md-2">

                                <button class="make-request px-2" id="select_customer_items_btn">Select Items</button>
                            
                            </div>


                        </div>

                    </div>

                    <div class="row col-12 d-flex justify-content-end">

                        <button class="submit-request" id="invoice_frm_btn">Generate Invoice</button>
    
                    </div>
                
                </form>
            </div>
            <!--------------------end of souring Hub--------->
        </div>
    </div>
    
    <div class="modal" id="customer_items_modal" tabindex="-1" role="dialog" style="top: 5% !important;">

        <div class="modal-dialog" role="document">
    
            <div class="modal-content pt-1">
        
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel1">Select Customer's Items for Invoice</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        
                <div class="modal-body py-2">
        
                    <div class="col-12">
                        
                        <div class="row">
                        
                            <div class="col-md-12 mt-1 mb-3">
    
                                <table class="table w-100 table-responsive" id="temp_customer_items_tbl">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-left pl-4">#</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
    
                            </div>
    
                            <div class="row col-12 d-flex justify-content-end">
    
                                <button class="submit-request" id="send_grid_btn">Save</button>
    
                            </div>
                            
    
                        </div>

                    </div>
        
                </div>
        
            </div>
    
        </div>
    
    </div>

    {{-- page scripts --}}
    @section('page-scripts')

        @include('scripts.stylist.payment.create_js')

    @endsection

</div>
@include("stylist.postloginview.partials.footer.footerjs")