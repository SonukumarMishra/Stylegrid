
@if (count($result['list']))

    @foreach ($result['list'] as $g_key => $grid)

    <div class="raise-bg_1 pb-1 col-lg-12 mb-2">
        <div class="">
           <div class=" px-md-1 px-1 py-1">
              
              <h1>Member Noticeboard</h1>
              
           </div>

        </div>
        <div class="mx-md-2" id="board-detail">
              <div class="row mx-md-2 mx-1 my-1 border-bottom">
                 <div class="col-9 row">
                    
                    <div class="form-group col-4">

                 <h5>Product Name:</h5>

                 <label id="product_name">2</label>

              </div>

              <div class="form-group col-4">

                 <h5>Product Brand:</h5>

                 <label id="product_name">2</label>

              </div>

              <div class="form-group col-4">

                 <h5>Product Type:</h5>

                 <label id="product_name">2</label>

              </div>

              <div class="form-group col-4">

                 <h5>Product Price:</h5>

                 <label id="product_name">2</label>

              </div>
              <div class="form-group col-4">

                 <h5>Product Size:</h5>

                 <label id="product_name">2</label>

              </div>

                    
                 </div>
                 <div class="col-2">
                    <img src="http://localhost:8000/member/dashboard/app-assets/images/icons/notice-board.svg" class="img-fluid py-1" alt="">
                 </div>
                 <div class="col-1 d-flex align-items-center">
                    <i class="text-danger fa fa-times fa-3x"></i>
                 </div>
              </div>
              <div class="row mx-md-2 mx-1 my-1 border-bottom">
                 <div class="col-9 row">
                    
                    <div class="form-group col-4">

                 <h5>Product Name:</h5>

                 <label id="product_name">2</label>

              </div>

              <div class="form-group col-4">

                 <h5>Product Brand:</h5>

                 <label id="product_name">2</label>

              </div>

              <div class="form-group col-4">

                 <h5>Product Type:</h5>

                 <label id="product_name">2</label>

              </div>

              <div class="form-group col-4">

                 <h5>Product Price:</h5>

                 <label id="product_name">2</label>

              </div>
              <div class="form-group col-4">

                 <h5>Product Size:</h5>

                 <label id="product_name">2</label>

              </div>

                    
                 </div>
                 <div class="col-2">
                    <img src="http://localhost:8000/member/dashboard/app-assets/images/icons/notice-board.svg" class="img-fluid py-1" alt="">
                 </div>
                 <div class="col-1 d-flex align-items-center">
                    <i class="text-danger fa fa-times fa-3x"></i>
                 </div>
              </div>
              <div class="row mx-md-2 mx-1 my-1 border-bottom">
                 <div class="col-9 row">
                    
                    <div class="form-group col-4">

                 <h5>Product Name:</h5>

                 <label id="product_name">2</label>

              </div>

              <div class="form-group col-4">

                 <h5>Product Brand:</h5>

                 <label id="product_name">2</label>

              </div>

              <div class="form-group col-4">

                 <h5>Product Type:</h5>

                 <label id="product_name">2</label>

              </div>

              <div class="form-group col-4">

                 <h5>Product Price:</h5>

                 <label id="product_name">2</label>

              </div>
              <div class="form-group col-4">

                 <h5>Product Size:</h5>

                 <label id="product_name">2</label>

              </div>

                    
                 </div>
                 <div class="col-2">
                    <img src="http://localhost:8000/member/dashboard/app-assets/images/icons/notice-board.svg" class="img-fluid py-1" alt="">
                 </div>
                 <div class="col-1 d-flex align-items-center">
                    <i class="text-danger fa fa-times fa-3x"></i>
                 </div>
              </div>
              

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

