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
                        <div class="search-container-member">
                            <h2>Upload Fashion Products (up to 15 new ones can be added)</h2>
                             <div>
                                <a href="javascript:void(0)" id="uploadImage">Add</a>
                             </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="search-container-member">
                            <h2>Upload Home Products (up to 15 new ones can be added)</h2>
                             <div>

                             </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="search-container-member">
                            <h2>Upload Beauty Products (up to 15 new ones can be added)</h2>
                             <div>

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
@include('admin.includes.footer')
<script>
    
    $(function(){
         $('#uploadImage').click(function(){
            $('#uploadProductPopup').modal('show');
         }) 
         
    })
    
</script>
 @stop




