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
                <div class="d-flex justify-content-end my-2 mr-lg-2">
                    <a href="" class="mx-1"><img src="member/app-assets/images/icons/Chat.svg" alt=""></a>
                    <!-- <a href="" class="mx-1"><img src="app-assets/images/icons/File Invoice.svg" alt=""></a> -->
                    <a href="" class="mx-lg-1"><img src="member/app-assets/images/icons/Gear.svg" alt=""></a>

                </div>

            </div>
        </div>
        <!--------------------souring hub--------->
        <div id="browse-soursing" class="mt-lg-5 mt-2">
                    <div class="row">
                        <h1 class="col-12">Your Order Summary</h1>
                         </div>
                    <div class="row w-100">
                        <div id="TabContent" class="tab-content my-2 w-100">
                            <div class="tab-pane fade active show" id="Fashion_1" role="tabpanel"
                                aria-labelledby="Fashion-tab">
                                <div class="text-center ml-2 add-table-border">
                                    <table class="table  w-100 table-responsive">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-left pl-4">Order Number</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Value</th>
                                                <th scope="col">Order Placed</th>
                                                <th scope="col">Order Due</th>
                                                <th scope="col">Delivery Location</th>
                                                <th scope="col">Details</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Order 00012
                                                </td>
                                                <td>Live</td>
                                                <td>&pound;12,900</td>
                                                <td>18/09/22</td>
                                                <td>25/09/22</td>
                                                <td>UAE</td>
                                                <td class="green-color">View Invoice</td>
                                                
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Order 00011</td>
                                                <td>Live</td>
                                                <td>&pound;17,900</td>
                                                <td>18/09/22</td>
                                                <td>25/09/22</td>
                                                <td>UAE</td>
                                                <td class="green-color">View Invoice</td>
                                                
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Order 00013</td>
                                                <td>Live</td>
                                                <td>&pound;17,900</td>
                                                <td>18/09/22</td>
                                                <td>25/09/22</td>
                                                <td>UAE</td>
                                                <td class="green-color">View Invoice</td>
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Order 00011</td>
                                                <td>Live</td>
                                                <td>&pound;17,900</td>
                                                <td>18/09/22</td>
                                                <td>25/09/22</td>
                                                <td>UAE</td>
                                                <td class="green-color">View Invoice</td>
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Order 00014</td>
                                                <td>Live</td>
                                                <td>&pound;17,900</td>
                                                <td>18/09/22</td>
                                                <td>25/09/22</td>
                                                <td>UAE</td>
                                                <td class="green-color">View Invoice</td>
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Order 00015</td>
                                                <td>Live</td>
                                                <td>&pound;17,900</td>
                                                <td>18/09/22</td>
                                                <td>25/09/22</td>
                                                <td>UAE</td>
                                                <td class="green-color">View Invoice</td>
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Order 00016</td>
                                                <td>Live</td>
                                                <td>&pound;17,900</td>
                                                <td>18/09/22</td>
                                                <td>25/09/22</td>
                                                <td>UAE</td>
                                                <td class="green-color">View Invoice</td>
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Order 00017</td>
                                                <td>Live</td>
                                                <td>&pound;17,900</td>
                                                <td>18/09/22</td>
                                                <td>25/09/22</td>
                                                <td>UAE</td>
                                                <td class="green-color">View Invoice</td>
                                            </tr>
                                            <tr style="border-bottom: 0px !important;">
                                                <td class="d-flex"><span class="dot"></span>Order 00018</td>
                                                <td>Live</td>
                                                <td>&pound;17,900</td>
                                                <td>18/09/22</td>
                                                <td>25/09/22</td>
                                                <td>UAE</td>
                                                <td class="green-color">View Invoice</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="d-flex px-2">
                                    <div class="show-bg"><img src="app-assets/images/icons/show-more.svg" alt="">
                                    </div>
                                    <span class="show px-1">See more</span>
                                </div> -->
                            </div>
                        </div>
                    </div>

                </div>
        <!--------------------end of souring Hub--------->
    </div>
</div>
@stop\\\\\\\\\\\
