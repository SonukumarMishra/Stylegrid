@extends('admin.layouts.default')
@section('content')
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class=" mt-lg-3 ">
                <div class="">
                    <div class="d-flex">
                        <h1>Order #0012: Max Melia</h1>
                        <a href=""><button class="pro-btn mt-1 ml-3">Processing</button></a>
                    </div>
                    <h3>View order overview.</h3>
                    <!-- <a href=""><button class="grid-btn">Create Grid</button></a> -->
                </div>
                <div class="member-detail py-2 px-2 mt-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="order-no">Order #0012</div>
                            <div class="order-detail mt-2">Placed with stylist Francesca Salih on 22/02/23</div>
                        </div>
                        <div class="col-6 text-right"><img src="../Admin/app-assets/images/icons/logo.png"
                                class="order-img img-fluid" alt=""></div>
                    </div>
                    <div class="text-center add-table-border mt-3 mr-lg-3">
                        <table class="table  w-100 table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-left pl-4">PRODUCT NAME</th>
                                    <th scope="col">Colour</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Price</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="d-flex"><span class="dot"></span>Hermes Mini Kelly 20</td>
                                    <td>Black</td>
                                    <td>N/A</td>
                                    <td>Bag</td>
                                    <td>Hermes</td>
                                    <td>UAE</td>
                                    <td>31/05/23</td>
                                    <td>£20,000</td>

                                <tr>
                                    <td class="d-flex"><span class="dot"></span>Zegna Tech T-Shirt</td>
                                    <td>Black</td>
                                    <td>N/A</td>
                                    <td>T-shirt</td>
                                    <td>Zegna</td>
                                    <td>UAE</td>
                                    <td>31/05/23</td>
                                    <td class="">£600</td>
                                </tr>
                                <tr>
                                    <td class="d-flex"><span class="dot"></span>Zegna Tech T-Shirt</td>
                                    <td>Black</td>
                                    <td>N/A</td>
                                    <td>T-shirt</td>
                                    <td>Zegna</td>
                                    <td>UAE</td>
                                    <td>31/05/23</td>
                                    <td class="">£600</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="text-right mt-3 mr-lg-3">
                        <div class="order-fee">Total order fee including stylist commission: £21,400</div>
                        <div class="order-commission mt-1">StyleGrid 3% commission: £642</div>
                    </div>
                    <!-------------pagination---------->
                    <nav aria-label="Page navigation d-flex" id="pagination">
                        <ul class="pagination justify-content-end  mr-lg-3">
                            <h6 class="px-2 pt-1">12 Orders</h6>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <img src="../Admin/app-assets/images/gallery/prev1.png" class="img-fluid"
                                        alt="">
                                    <!-- <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span> -->
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <img src="../Admin/app-assets/images/gallery/prev.png" class="img-fluid" alt="">
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link">of</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <img src="../Admin/app-assets/images/gallery/next.png" alt="">
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <img src="../Admin/app-assets/images/gallery/next.png" alt="">
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!--------------end of pagination--->
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
@stop




