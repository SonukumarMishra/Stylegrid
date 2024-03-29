@extends('member.dashboard.layouts.default')

@section('content')


    <style>
        .nav.nav-tabs .nav-item .nav-link.active,
        .nav.nav-pills .nav-item .nav-link.active {
            box-shadow: 0 2px 4px 0 rgb(90 141 238 / 50%);
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            color: #FFFFFF;
            background-color: #00A82F;
            border-color: transparent;
        }

        .nav.nav-tabs {
            margin-bottom: 1rem;
            border-bottom-color: #ededed;
        }

        .nav-tabs {
            border-bottom: 1px solid #7E8FA3;
        }

        .table thead th,
        .table tbody tr {
            border-bottom: 2px solid #E2E2E2 !important;
        }
    </style>

    <div class="content-wrapper">

        <input type="hidden" id="stylegrid_id" name="stylegrid_id" value="{{ $stylegrid_id }}">

        <div class="content-body">

            <!-------------------- fulfil souring request--------->

            <div id="create-grid" class="mt-5">

               
            </div>

        </div>

    </div>

    <div class="modal" id="grid_item_details_modal" tabindex="-1" role="dialog" style="top: 5% !important;">

        <div class="modal-dialog" role="document">

            <div class="modal-content pt-1">

                <div class="mr-2">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body py-2">

                    <h1 class="text-center modal-submit-request">Product Details <span
                            id="modal_stylegrid_item_title"></span></h1>

                    <div id="browse-soursing" class="mt-2">

                        <div class="row align-items-center">

                            <div class="col-lg-6 ">

                                <div class="p-1">

                                    <img src="" class="item-modal-image-src img_preview" id="product_image_preview"
                                        alt="">

                                </div>

                            </div>

                            <div class="col-lg-6">

                                <div class="p-2 lg-border-left">

                                    <div class="form-group">

                                        <h5 class="cart-header-modal">Product Name:</h5>

                                        <label id="product_name"></label>

                                    </div>

                                    <div class="form-group">

                                        <h5 class="cart-header-modal">Product Brand:</h5>

                                        <label id="product_brand"></label>

                                    </div>

                                    <div class="form-group">

                                        <h5 class="cart-header-modal">Product Type:</h5>

                                        <label id="product_type"></label>

                                    </div>

                                    <div class="form-group">

                                        <h5 class="cart-header-modal">Product Price:</h5>

                                        <label>£ &nbsp;<span id="product_price"></span></label>

                                    </div>

                                    <div class="form-group">

                                        <h5 class="cart-header-modal">Product Size:</h5>

                                        <label id="product_size"></label>

                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" id="cart_module_id"
                                            value="{{ $stylegrid_id }}">
                                        <input type="hidden" id="cart_module_type"
                                            value="{{ config('custom.cart.module_type.stylegrid') }}">
                                        <input type="hidden" id="cart_item_id">
                                        <input type="hidden" id="cart_item_type"
                                            value="{{ config('custom.cart.item_type.stylegrid_product') }}">
                                        <button class="submit-request" style="width:210px;" id="cart_action_btn"
                                            data-action="add"><span id="cart_icon"><i
                                                    class="fa-solid fa-cart-shopping"></i></span>&nbsp; <span
                                                id="cart_btn_title"> Add To Cart</span></button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- page scripts --}}

@section('page-scripts')

    @include('scripts.member.grid.view_js')

@endsection



@stop


