<div class="row">

    <div class="col-lg-12">

        <div class="stylegrid-bg-img mx-lg-4 mx-2 mt-3 px-lg-4 px-2 py-2 height_570"
            style="background: url({{ isset($style_grid_dtls->feature_thumb_img) && !empty($style_grid_dtls->feature_thumb_img) ? asset($style_grid_dtls->feature_thumb_img) : asset($style_grid_dtls->feature_image) }});position:relative;display: flex;align-items: center;">

            <div class="layer"></div>
            <div class="gridcreated_j" style="background:none;width:100%;">



                <div class="row">

                    <div class="col-lg-12  align-items-center">
                        <h1 style="color:white;font-size: 52px;">{{ $style_grid_dtls->title }}</h1>
                        <h4 style="color:white;">STYLEGRID</h4>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@if (count($style_grid_dtls->grids))



    @foreach ($style_grid_dtls->grids as $g_key => $grid)
        <div class="row">

            <div class="col-lg-12">

                <div class="new-grid-bg mx-lg-4 mx-2 px-lg-3 mx-2 py-2">

                    <div class="row">

                        <div class="col-10">

                            <h1>STYLEGRID {{ $g_key + 1 }}</h1>

                        </div>

                        <div class="col-2">

                            <button class="submit-request grid_cart_action_btn" style="width:210px;" data-cart-id="{{ $grid->cart_id }}" data-cart-dtls-ids="{{ json_encode($grid->cart_dtls_ids) }}" data-stylegrid-dtls-id={{ $grid->stylegrid_dtls_id }} data-index="{{ $g_key }}" data-action="{{ $grid->grid_all_items_exists_cart ? 'remove' : 'add' }}">
                                <span id="cart_icon"><i class="fa-solid fa-cart-shopping"></i></span>&nbsp; 
                                <span class="grid_cart_btn_title" data-index="{{ $g_key }}"> {{ $grid->grid_all_items_exists_cart ? 'Remove All From Cart' : 'Add All To Cart' }} </span>
                            </button>


                        </div>

                    </div>

                    <div class="row add-item d-flex align-items-center">

                        <div class="col-lg-7">



                            <section class="stylegrid-cards p-5">



                                @if (count($grid->items))
                                    @foreach ($grid->items as $i_key => $item)
                                        <div class="grid-item-inner-input-block"
                                            data-stylegrid-id="{{ $item->stylegrid_id }}"
                                            data-stylegrid-dtls-id="{{ $item->stylegrid_dtls_id }}"
                                            data-stylegrid-product-id="{{ $item->stylegrid_product_id }}">



                                            <img class="stylegrid-product-img1"
                                                src="{{ isset($item->product_thumb_img) && !empty($item->product_thumb_img) ? asset($item->product_thumb_img) : asset($item->product_image) }}"
                                                alt=" " />



                                        </div>
                                    @endforeach
                                @endif



                            </section>



                        </div>

                        <div class="col-lg-5 px-2">

                            <img src="{{ isset($grid->feature_thumb_img) && !empty($grid->feature_thumb_img) ? asset($grid->feature_thumb_img) : asset($grid->feature_image) }}"
                                class="img-fluid w-100 height_5001 img_preview" alt="">

                        </div>

                    </div>

                </div>

            </div>

        </div>
    @endforeach



@endif
