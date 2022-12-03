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
                    <h1>StyleGrid Admin Dashboard</h1>
                    <h3>Manage and explore the StyleGrid database.</h3>
                    <!-- <a href=""><button class="grid-btn">Create Grid</button></a> -->
                </div>

            </div>
            <div id="create-grid-1" class="mt-4">
                <div class="row">
                    <div class="col-lg-4  col-12">
                        <div class="client-grid-img1">
                            <div class="layer-1">
                                <div class=" bottom-text w-100">
                                    <div class="">
                                        <h2 class="pl-1 ">Review stylist applications</h2>
                                    </div>
                                    <div class="row align-items-baseline">
                                        <div class="col-8">
                                            <p class="pl-1">Approve or decline the latest stylist applications.</p>
                                        </div>
                                        <div class="col-4 text-center text-md-right pr-2">
                                            <a href="member-overview.html"><button
                                                    class="go-to-grid-btn mr-1">Browse</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mt-lg-0 mt-2 col-12">
                        <div class="grid-img2">
                            <div class="layer-1">
                                <div class=" bottom-text w-100">
                                    <div class="">
                                        <h2 class="pl-1 ">Stylist overview</h2>
                                    </div>
                                    <div class="row align-items-baseline">
                                        <div class="col-8">
                                            <p class="pl-1">Update the featured product section on the shop page.</p>
                                        </div>
                                        <div class="col-4 text-center text-md-right pr-2">
                                            <a href="stylist-overview.html"><button
                                                    class="go-to-grid-btn mr-1">Browse</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mt-2 mt-lg-0 col-12">
                        <div class="grid-img3">
                            <div class="layer-1">
                                <div class=" bottom-text w-100">
                                    <div class="">
                                        <h2 class="pl-1 ">Member overview</h2>
                                    </div>
                                    <div class="row align-items-baseline">
                                        <div class="col-8">
                                            <p class="pl-1">Check out this weeks drops in fashion and home.</p>
                                        </div>
                                        <div class="col-4 text-center text-md-right pr-2">
                                            <a href="member-overview.html"><button
                                                    class="go-to-grid-btn mr-1">Browse</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mt-2 col-12">
                        <div class="client-grid-img2">
                            <div class="layer-1">
                                <div class=" bottom-text w-100">
                                    <div class="">
                                        <h2 class="pl-1 ">Upload new product</h2>
                                    </div>
                                    <div class="row align-items-baseline">
                                        <div class="col-8">
                                            <p class="pl-1">Update the featured product section on the shop page.</p>
                                        </div>
                                        <div class="col-4 text-center text-md-right pr-2">
                                            <a href="member-overview.html"><button
                                                    class="go-to-grid-btn mr-1">Add Product</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mt-2 col-12">
                        <div class="client-grid-img3">
                            <div class="layer-1">
                                <div class=" bottom-text w-100">
                                    <div class="">
                                        <h2 class="pl-1 ">Order oveview</h2>
                                    </div>
                                    <div class="row align-items-baseline">
                                        <div class="col-8">
                                            <p class="pl-1">View live, pending and previous orders.</p>
                                        </div>
                                        <div class="col-4 text-center text-md-right pr-2">
                                            <a href="member-overview.html"><button
                                                    class="go-to-grid-btn mr-1">Browse</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mt-2 col-12">
                        <div class="client-grid-img4">
                            <div class="layer-1">
                                <div class=" bottom-text w-100">
                                    <div class="">
                                        <h2 class="pl-1 ">Support tickets</h2>
                                    </div>
                                    <div class="row align-items-baseline">
                                        <div class="col-8">
                                            <p class="pl-1">View and resolve support tickets.</p>
                                        </div>
                                        <div class="col-4 text-center text-md-right pr-2">
                                            <a href="member-overview.html"><button
                                                    class="go-to-grid-btn mr-1">View Tickets</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
@stop


