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
                    <h1>Upload New Featured Products</h1>
                    <h3>Showcase new trending product on members dashboards.</h3>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="search-container-member px-3 py-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <div id="common_message_box" class="message"></div>
                                    <h2 class="upload-text mb-2 ml-2">Upload Fashion Products (up to 15 new ones can be added)</h2>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="clear-all mr-2">Clear all</h6>
                                </div> 
                            </div>
                             <div class="container-fluid">
                                <div class="row" id="fashion_product_section">
                                </div>
                             </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="search-container-member px-3 py-3">
                            <div class="row" >
                                <div class="col-md-8">
                                    <h2 class="upload-text mb-2 ml-2">Upload Home Products (up to 15 new ones can be added)</h2>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="clear-all mr-2">Clear all</h6>
                                </div> 
                            </div>
                             <div class="container-fluid">
                                <div class="row" id="home_product_section">                                     
                                </div>
                              
                             </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="search-container-member px-3 py-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <h2 class="upload-text mb-2 ml-2">Upload Beauty Products (up to 15 new ones can be added)</h2>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="clear-all mr-2">Clear all</h6>
                                </div> 
                            </div>
                             <div class="container-fluid">
                                <div class="row" id="beauty_product_section">
                                </div>
                             </div>
                        </div>
                    </div>
                     
                </div>
                 
                 
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewProductPopup" tabindex="-1" role="dialog" aria-labelledby="viewProductPopup" aria-hidden="true">
  <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row" id="viewProductDataSection">
                    </div>
            </div>
        
        </div>
  </div>
</div>
<!--add item Modal -->
<div class="modal fade" id="AddProductPopup" tabindex="-1" role="dialog" aria-labelledby="AddProductPopup" aria-hidden="true">
  <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="mssage_box" class="message"></div>
                <form id="upload-product-form">
                    @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="select-admin-grid py-3 ">
                            <div><h6 class="add-item-here pt-2">Add an item here</h6></div>
                                <div class="Neon Neon-theme-dragdropbox mt-5">
                                    <input name="product_image" id="product-image" class="file-upload" multiple="multiple" type="file">
                                    <div class="Neon-input-dragDrop py-5 px-4 mx-3">
                                        <div class="Neon-input-inner">
                                            <div class="Neon-input-icon"><i class="fa fa-file-image-o"></i></div>
                                            <div class="Neon-input-text"></div>
                                            <a class="Neon-input-choose-btn blue">
                                                <div class="text-center mt-1">
                                                    <button class="add-item" >+</button>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="product_image_error" class="error"></div>
                                <div id="divImageMediaPreview" class="text-center"></div>
                                <div class="text-center">
                                    <a href="javascript:void(0)" style="display: none;" id="image_preview_remove">Remove</a>
                                </div>   
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                                <div class="mb-2">
                                    <h1 class="span-modal">Enter Brand Name</h1>
                                    <input type="text" class="form-control submit-input" aria-describedby="emailHelp"
                                                    placeholder="Enter brand name..." id="brand" name="brand"  maxlength="10" >
                                    <div id="autsuggestion_section"></div>
                                    <div id="brand_error" class="error"></div>
                                </div>
                                <div class="mb-2">
                                    <span class="span-modal">Enter Product Name</span>
                                    <br>
                                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name">
                                    <div id="product_name_error" class="error"></div>
                                </div>
                        <!-- <div class="mt-5">-->
                                <div class="mb-2">
                                    <span class="span-modal">Enter Product Description</span>
                                    <textarea name="product_description" id="product_description" class="form-control" placeholder="Product Description"></textarea>
                                    <!--<a href="" class="mt-3">Click to enter description...</a>-->
                                    <div id="product_description_error" class="error"></div>
                                </div>
                        <!-- </div>-->
                        <!-- <div class="mt-5">-->
                                <div class="mb-2">
                                    <span class="modal-p myb-2">Enter Product Size</span>
                            <!-- </div>-->
                            <!--<span class="span1-modal my-3">All sizes available</span>-->
                                    <input type="text" name="product_size" id="product_size" class="form-control" placeholder="Product Size">
                                    <div id="product_size_error" class="error"></div>
                                </div>
                        <input type="hidden" name="product_type" id="product_type" class="form-control" value="">
                        <div class="mt-2">
                            <button type="button" class="upload-btn py-1 px-3" id="upload_product">Upload Product</button>
                        </div>
                        <div class="mt-1">
                            <button type="button" class="go-back-btn  py-1 px-5"  data-dismiss="modal" aria-label="Close">Go Back</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
<script>
    
    $(function(){
        showProductList();
        $('#upload_product').click(function(){
            $('.message').html('');
            $('.error').html('');
            $('input, textarea').removeClass('err');
            var status=true;
            var brand=makeTrim($('#brand').val());
            var product_name=makeTrim($('#product_name').val());
            var product_description=makeTrim($('#product_description').val());
            var product_size=makeTrim($('#product_size').val());
            var product_image=makeTrim($('#product-image').val());
            
            if(product_image==''){
                $('#product-image').addClass('err');
                $('#product_image_error').html('Please select product image!');
                status=false;
            }
            if(brand==''){
                $('#brand').addClass('err');
                $('#brand_error').html('Please enter brand name!');
                status=false;
            }
            if(product_name==''){
                $('#product_name').addClass('err');
                $('#product_name_error').html('Please enter product name!');
                status=false;
            }
            if(product_description==''){
                $('#product_description').addClass("err");
                $('#product_description_error').html('Please enter product description!');
                status=false;
            }
            if(product_size==''){
                $('#product_size').addClass('err');
                $('#product_size_error').html('Please enter product size!');
                status=false;
            }
            if(status){
                $.ajax({
                    type: 'POST',
                    url: '/admin-upload-product-ajax',                
                    data: new FormData($("#upload-product-form")[0]),
                    async : false,
                    cache : false,
                    contentType : false,
                    processData : false,
                    success: function(ajaxresponse) {
                        response = JSON.parse(ajaxresponse);
                        if (response['status']) {
                            //$('#sourceConfirmationPopUp').modal('hide');
                            $("#upload-product-form").trigger("reset");
                            setTimeout(function(){
                                $('#AddProductPopup').modal('hide');
                                $('#common_message_box').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>' + response['message'] + '</div>');
                                showProductList();
                            }, 500);
                        } else {
                            //$('#sourceConfirmationPopUp').modal('hide');
                            $('#mssage_box').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>' + response['message'] + '</div>');
                            return false;
                        }
                    }
                });
            }else{
                $('#mssage_box').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Please enter the mandatory fields!</div>');
            }
             
            
         
    })

    $('#brand').keyup(function(){
    $('#autsuggestion_section').html('');
    var brand_search=$(this).val();
    if(brand_search.length>0){
        $.ajax({
            url : '/get-brands-list',
            method : "POST",
            data : {
                'brand_search':brand_search,
                '_token': constants.csrf_token
            },
            success : function (ajaxresponse){
                response = JSON.parse(ajaxresponse);

                if (response['status']) {
                    if(response['data'].length>0){
                        brandList=[];
                        var html='';
                        html +='<ul>';
                        for(i=0;i<response['data'].length;i++){
                            html +='<li class="select_brand" onClick="selectBrand('+response['data'][i]['id']+')" id="'+response['data'][i]['id']+'" title'+response['data'][i]['id']+'="">'+response['data'][i]['name']+'</li>';
                            brandList[response['data'][i]['id']]=response['data'][i]['name']
                        }
                        html +='<ul>';
                        $('#autsuggestion_section').html(html);
                    }
                }
            }
        })
    }
})
        $("#product-image").change(function () {
        if (typeof (FileReader) != "undefined") {
            var dvPreview = $("#divImageMediaPreview");
            dvPreview.html("");    
            $('#product_image_error').html('');        
           // $($(this)[0].files).each(function () {
                var file = $(this)[0].files;//$(this); 
                var ext = $('#product-image').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
                    $('#product_image_error').html('Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.');
                    $("#product-image").val('');
                    return false;
                }else{
                    var image_size = (this.files[0].size);
                    if(image_size>1000000){
                        $('#product_image_error').html('Maximum File Size Limit is 1MB');
                        $("#product-image").val('');
                        return false;
                    }else{
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = $("<img />");
                            img.attr("style", "width: 150px; height:100px; padding: 10px");
                            img.attr("src", e.target.result);
                            dvPreview.append(img);
                        }
                        $('#image_preview_remove').show();
                        reader.readAsDataURL(file[0]);
                    }
                     
                }
           // });
        }
    });

    $('#image_preview_remove').click(function(){
    $("#product-image").val('');
    $('#image_preview_remove').hide();
    $("#divImageMediaPreview").html('');
})

        $('#uploadImage').click(function(){
            $('#uploadProductPopup').modal('show');
        }) 
         
    })
    var brandList=[];
    function selectBrand(brand_id){
        $('#brand').val(brandList[brand_id]);
        $('#autsuggestion_section').html('');
    }

    function showProductList(){
        $.ajax({
            url : '/admin-show-product-list-ajax',
                method : "POST",
                async: false,
                data : {
                    '_token': constants.csrf_token
                },
                success : function (ajaxresponse){
                    response = JSON.parse(ajaxresponse);
                    if (response['status']) {
                        var fashion_html='';
                        for(i=0;i<response['fashion_products'].length;i++){
                                fashion_html +='<div class="col-lg-2 col-md-4 col-6 mb-2 Fashion_product_counter" id="product'+response['fashion_products'][i]['id']+'">';
                                fashion_html +='<div class="admin-grid" type="button" class="" >'; 
                                fashion_html +='<div class="admin-delete px-1"><a href="javascript:void(0)" onClick="removeProduct('+response['fashion_products'][i]['id']+')"><img  src="'+constants.base_url+'/admin-section/assets/images/delete.png" class="img-fluid" ></a></div>';
                                fashion_html +='<a href="javascript:void(0)"  onClick="viewProducts('+response['fashion_products'][i]['id']+')"><img src="'+constants.base_url+'/attachments/products/fashion/'+response['fashion_products'][i]['image']+'" class=" border img-fluid"></a>';
                                fashion_html +='</div>';
                                fashion_html +='</div>';
                            }
                            fashion_html +='<div class="col-lg-2 col-md-4 col-6 mb-2 ">';
                            fashion_html +='<div class="select-admin-grid py-3 " type="button" type_id="Fashion" class="" onClick="AddProduct(this)">';
                            fashion_html +='<div><h6 class="add-item-here pt-2">Add an item here</h6></div>';
                            fashion_html +='<div class="text-center mt-1"> <button class="add-item">+</button></div>';
                            fashion_html +='</div>';
                            fashion_html +='</div>';
                            $('#fashion_product_section').html(fashion_html);
                            var home_html='';
                            for(i=0;i<response['home_products'].length;i++){
                                home_html +='<div class="col-lg-2 col-md-4 col-6 mb-2" id="product'+response['home_products'][i]['id']+'">';
                                home_html +='<div class="admin-grid" type="button" class="" >'; 
                                home_html +='<div class="admin-delete px-1"><a href="javascript:void(0)" onClick="removeProduct('+response['home_products'][i]['id']+')"><img  src="'+constants.base_url+'/admin-section/assets/images/delete.png" class="img-fluid" ></a></div>';
                                home_html +='<a href="javascript:void(0)"  onClick="viewProducts('+response['home_products'][i]['id']+')"><img src="'+constants.base_url+'/attachments/products/home/'+response['home_products'][i]['image']+'" class=" border img-fluid"></a>';
                                home_html +='</div>';
                                home_html +='</div>';
                            }
                            home_html +='<div class="col-lg-2 col-md-4 col-6 mb-2 ">';
                            home_html +='<div class="select-admin-grid py-3 " type="button" type_id="Home" class="" onClick="AddProduct(this)">';
                            home_html +='<div><h6 class="add-item-here pt-2">Add an item here</h6></div>';
                            home_html +='<div class="text-center mt-1"> <button class="add-item">+</button></div>';
                            home_html +='</div>';
                            home_html +='</div>';
                            $('#home_product_section').html(home_html);

                            var beauty_html='';
                            for(i=0;i<response['beauty_products'].length;i++){
                                beauty_html +='<div class="col-lg-2 col-md-4 col-6 mb-2" id="product'+response['beauty_products'][i]['id']+'">';
                                beauty_html +='<div class="admin-grid" type="button" class="">'; 
                                beauty_html +='<div class="admin-delete px-1"><a href="javascript:void(0)" onClick="removeProduct('+response['beauty_products'][i]['id']+')"><img  src="'+constants.base_url+'/admin-section/assets/images/delete.png" class="img-fluid" ></a></div>';
                                beauty_html +='<a href="javascript:void(0)"  onClick="viewProducts('+response['beauty_products'][i]['id']+')"><img src="'+constants.base_url+'/attachments/products/beauty/'+response['beauty_products'][i]['image']+'" class=" border img-fluid"></a>';
                                beauty_html +='</div>';
                                beauty_html +='</div>';
                            }
                            beauty_html +='<div class="col-lg-2 col-md-4 col-6 mb-2 ">';
                            beauty_html +='<div class="select-admin-grid py-3 " type="button" class="" type_id="Beauty" onClick="AddProduct(this)">';
                            beauty_html +='<div><h6 class="add-item-here pt-2">Add an item here</h6></div>';
                            beauty_html +='<div class="text-center mt-1"> <button class="add-item">+</button></div>';
                            beauty_html +='</div>';
                            beauty_html +='</div>';
                            $('#beauty_product_section').html(beauty_html);
                        }else{
                            //$('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
                        }
            }
        })
    }
    function removeProduct(id){
        if(id>0){
            $.ajax({
            url : '/admin-remove-product-ajax',
            method : "POST",
            data : {
                'id':id,
                '_token': constants.csrf_token
            },
            success : function (ajaxresponse){
                response = JSON.parse(ajaxresponse);
                if (response['status']) {
                    $('#product'+id).remove();
                    $('#common_message_box').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response['message']+'</div>');

                }
            }
        })
        }
        

    }
    function AddProduct(type){
        $('.message').html('');
        $('.error').html('');
        $('input, textarea').removeClass('err');
        $('#autsuggestion_section').html('');
        if($(type).attr('type_id')!=''){
            var available_product_count=$('.'+$(type).attr('type_id')+'_product_counter').length;
            if(available_product_count<15){
                $("#product-image").val('');
                $('#image_preview_remove').hide();
                $("#divImageMediaPreview").html('');
                $("#upload-product-form").trigger("reset");
                $('#product_type').val($(type).attr('type_id'));
                $('#AddProductPopup').modal('show');
            }else{
                $('#common_message_box').html('<div class="alert alert-danger">You can not upload more than 15 products.</div>')
            }
        }

    }
    function viewProducts(id){
        $('#viewProductDataSection').html('');
        if(id>0){
            $.ajax({
            url : '/admin-view-product-ajax',
                method : "POST",
                async: false,
                data : {
                    'id':id,
                    '_token': constants.csrf_token
                },
                success : function (ajaxresponse){
                    response = JSON.parse(ajaxresponse);
                    if (response['status']) {
                        $('#viewProductPopup').modal('show');
                        var product_html='';
                        product_html +='<div class="col-md-6">';
                        product_html +='<img src="'+constants.base_url+'/attachments/products/fashion/'+response['product']['image']+'" class="  img-fluid">';
                        product_html +='</div>';
                        product_html +='<div class="col-md-6 text-center">';
                        product_html +='<h1 class="modal-h1">'+response['product']['brand_name']+'</h1>';
                        product_html +='<span class="span-modal">'+response['product']['name']+'</span>';
                        product_html +='<p class="modal-p mt-3">'+response['product']['description']+'</p>';
                        product_html +='<span class="span1-modal my-3">'+response['product']['size']+'</span>';
                        product_html +='<div class="mt-2">';
                        product_html +='<button type="button" class="edit-btn py-1 px-3" >Edit Product</button>';
                        product_html +='</div>';
                        product_html +='<div class="mt-1">';
                        product_html +='<button type="button" class="go-back-btn  py-1 px-5 "  data-dismiss="modal" aria-label="Close">Go Back</button>';
                        product_html +='</div>';
                        product_html +='</div>';
                        $('#viewProductDataSection').html(product_html);
                        }else{
                            //$('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
                        }
            }
        })
        }
    }
</script>
 @stop




