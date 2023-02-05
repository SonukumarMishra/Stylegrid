@extends('admin.layouts.default')
@section('content')
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class=" mt-lg-3 ">
                <div class="message" id="message_box"></div>
                <div class="">
                    <h1>Upload New Featured Products</h1>
                    <h3>Showcase new trending product on members dashboards.</h3>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="search-container-member px-3 py-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <h2 class="upload-text mb-2 ml-2">Upload Fashion Products (up to 15 new ones can be added)</h2>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="clear-all mr-2">Clear all</h6>
                                </div> 
                            </div>
                             <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2 col-md-4 col-6">
                                       
                                            <div class="admin-grid" type="button" class="" data-toggle="modal" data-target="#gridLabel">
                                                <div class="admin-delete px-1">  <img  src='{{ asset('admin-section/assets/images/delete.png')}}' class="img-fluid" ></div>
                                                                             <img src='{{ asset('admin-section/assets/images/adminn1.png')}}' class=" border img-fluid">
                                            </div>
                                     
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                            <div class="admin-grid">
                                                <div class="admin-delete">  <img class="px-1" src='{{ asset('admin-section/assets/images/delete.png')}}' class="img-fluid"></div>
                                            <img src='{{ asset('admin-section/assets/images/adminn2.png')}}' class=" border img-fluid">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                            <div class="admin-grid">
                                                <div class="admin-delete">  <img class="px-1" src='{{ asset('admin-section/assets/images/delete.png')}}' class="img-fluid"></div>
                                            <img src='{{ asset('admin-section/assets/images/adminn3.png')}}' class=" border img-fluid">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                            <div class="admin-grid">
                                                <div class="admin-delete">  <img  src='{{ asset('admin-section/assets/images/delete.png')}}' class="img-fluid"></div>
                                            <img src='{{ asset('admin-section/assets/images/adminn4.png')}}' class=" border img-fluid">
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6 ">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                    <a href="">
                                    <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                              
                             </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="search-container-member px-3 py-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <h2 class="upload-text mb-2 ml-2">Upload Fashion Products (up to 15 new ones can be added)</h2>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="clear-all mr-2">Clear all</h6>
                                </div> 
                            </div>
                             <div class="container-fluid">
                                <div class="row">
                                <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6 ">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                              
                             </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="search-container-member px-3 py-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <h2 class="upload-text mb-2 ml-2">Upload Fashion Products (up to 15 new ones can be added)</h2>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="clear-all mr-2">Clear all</h6>
                                </div> 
                            </div>
                             <div class="container-fluid">
                                <div class="row">
                                <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6 ">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <a href="">
                                        <div class="select-admin-grid py-3 ">
                                              <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                              <div class="text-center mt-1"> <button class="add-item">+</button></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                              
                             </div>
                        </div>
                    </div>
                     
                </div>
                 
                 
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadProductPopup" tabindex="-1" role="dialog" aria-labelledby="cancelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content pt-1">
                <div class="mr-2">
    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="row col-lg-6">
                                    <!--<div class="Neon Neon-theme-dragdropbox mt-lg-5">
                                        <input name="source_image" id="source_image" multiple="multiple"  type="file">
                                        <div class="Neon-input-dragDrop py-5 px-4">
                                            <div class="Neon-input-inner py-4">
                                                <div class="Neon-input-text ">
                                                    <h3>Upload an image of the product here</h3>
                                                </div><a class="Neon-input-choose-btn blue"><img  src="{{ asset('member/dashboard/app-assets/images/icons/plus.png') }}" alt="" id="image_preview"></a>
                                                <div id="image_error" class="error"></div>
                                                <div id="divImageMediaPreview"></div>
                                                <a href="javascript:void(0)" style="display: none;" id="image_preview_remove">Remove</a>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                            <div class="col">
                                <div class="row col-lg-6">
                                    <div>
                                        <div class="form-group my-3 mx-5">
                                            <p>Enter Brand name</p>
                                           <input type="text" name="brand_id" id="brand_name">
                                        </div>
                                        <div class="form-group my-3 mx-5">
                                            <p>Enter Description</p>
                                           <textarea   name="product_description" id="product_description"></textarea>
                                        </div>
                                        <div class="form-group my-3 mx-5">
                                            <p>Enter Size Available</p>
                                            <input type="text" name="product_size" id="product_size">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                          <div class="w-100"></div>
                           
                        </div>
                      </div>                     
                    
                    <div class="row justify-content-center mt-2">
                        <div><a href="javascript:void(0)"><button class="cancel-btn px-3" type="button" id="cancel_membership">Upload Product</button></a></div>
                        <div><a href=""><button class="back-btn ml-2" type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">Go Back</button></a></div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="gridLabel" tabindex="-1" role="dialog" aria-labelledby="gridLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="row">
        <div class="col-md-6">
        <img src='{{ asset('admin-section/assets/images/grid.png')}}' class="  img-fluid">
        </div>
        <div class="col-md-6 text-center">
            <h1 class="modal-h1">Bottega Veneta</h1>
            <span class="span-modal">Cotton-twill jacket</span>
            <p class="modal-p mt-3">Aside from the house's signature intrecciato weave, Bottega Veneta's pieces can also be instantly recognized by the iconic triangle motif. This cotton-twill jacket incorporates the shape into the chest pocket, yoke and sharp collar. Pair yours with the matching pants.</p>
            <span class="span1-modal my-3">All sizes available</span>
            <div class="mt-2">
            <button type="button" class="edit-btn py-1 px-3" >Edit Product</button></div>
            <div class="mt-1">
        <button type="button" class="go-back-btn  py-1 px-4">Go Back</button>
</div>
        </div>
       </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
@include('admin.includes.footer')
<script>
    
    $(function(){
         $('#uploadImage').click(function(){
            $('#uploadProductPopup').modal('show');
         }) 
         
    })
    
</script>
 @stop




