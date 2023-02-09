@if (count($result['list']))

    @foreach ($result['list'] as $g_key => $grid)
        <div class="raise-bg_1 pb-1 col-lg-12 mb-2">
            <div class="">
                <div class=" px-md-1 px-1 py-1">

                    <h1><a href="{{ route('member.grid.view', [ 'grid_id' => $grid->stylegrid_id ]) }}">{{ $grid->title }}</a></h1>

                </div>

            </div>
            <div class="mx-md-2" id="board-detail">

               @if (count($grid->cart_items_details))
                   
                  @foreach ($grid->cart_items_details as $p_key => $p_val)
                     
                     <div class="row mx-md-2 mx-1 my-1 border-bottom">
                        <div class="col-9 row">
   
                           <div class="form-group col-4">
   
                              <h5>Product Name:</h5>
   
                              <label id="product_name">{{ $p_val->product_name }}</label>
   
                           </div>
   
                           <div class="form-group col-4">
   
                              <h5>Product Brand:</h5>
   
                              <label id="product_name">{{ $p_val->product_brand }}</label>
   
                           </div>
   
                           <div class="form-group col-4">
   
                              <h5>Product Type:</h5>
   
                              <label id="product_name">{{ $p_val->product_type }}</label>
   
                           </div>
   
                           <div class="form-group col-4">
   
                              <h5>Product Price:</h5>
   
                              <label id="product_name">{{ $p_val->product_price }}</label>
   
                           </div>
                           <div class="form-group col-4">
   
                              <h5>Product Size:</h5>
   
                              <label id="product_name">{{ $p_val->product_size }}</label>
   
                           </div>
   
   
                        </div>
                        <div class="col-2 d-flex align-items-center">
                           @if (isset($p_val->product_image) && !empty($p_val->product_image))
                              <img src="{{asset($p_val->product_image)}}" class="img-fluid py-1 img_200" alt="">
                           @endif
                        </div>
                        <div class="col-1 d-flex align-items-center">
                           <i class="text-danger fa fa-times fa-3x remove-item-cart-btn" data-cart-dtls-id="{{ $p_val->cart_dtls_id}}" data-cart-id="{{ $p_val->cart_id}}"></i>
                        </div>
                  </div>

                  @endforeach

               @endif

            </div>
        </div>
    @endforeach
@else
    @if (count($result['list']) == 0 && $result['current_page'] == 1)
        <div class="col-12">

            <h3 class="text-center text-muted">

                Your cart is emplty!

            </h3>

        </div>
    @endif

@endif
