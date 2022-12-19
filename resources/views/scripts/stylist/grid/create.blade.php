<script>
    window.onload = function() {
        'use strict';

        var CreateGridRef = window.CreateGridRef || {};
        var xhr = null;

        if (window.XMLHttpRequest) {
            xhr = window.XMLHttpRequest;
        } else if (window.ActiveXObject('Microsoft.XMLHTTP')) {
            xhr = window.ActiveXObject('Microsoft.XMLHTTP');
        }

        var send = xhr.prototype.send;

        xhr.prototype.send = function(data) {
            try {
                send.call(this, data);
            } catch (e) {
                showErrorMessage(e);
            }
        };

        CreateGridRef.totalStylegridCount = 1;
        
        CreateGridRef.styleGridJson = {
            'main_grid' : {
                'title' : '',
                'feature_image' : ''
            },
            'grids' : []
        };
        
        CreateGridRef.initEvents = function() {

            CreateGridRef.loadStyleGridUI(CreateGridRef.totalStylegridCount);

            $('body').on('click', '#add_grid_btn', function(e) {
                
                e.preventDefault();
                CreateGridRef.totalStylegridCount++;
                CreateGridRef.loadStyleGridUI(CreateGridRef.totalStylegridCount);

            });

            
            $('body').on('click', '.delete-grid-btn', function(e) {
                e.preventDefault();

                var value = $(this).data('index');
                $('.style-grid-block-row[data-index="'+value+'"]').remove();
                CreateGridRef.deleteStyleGridObj(value);
                CreateGridRef.styleGridNumberPagination();

            });

            
            $('body').on('click', '.delete-grid-item-block-btn', function(e) {

                e.preventDefault();
                var item_index = $(this).data('inner-index');
                var parent_index = $(this).data('parent-index');
                $('.item-block-inner-row[data-inner-index="'+item_index+'"][data-parent-index="'+parent_index+'"]').remove();
                
                CreateGridRef.deleteStyleGridItemObj(parent_index, item_index);

                // rerender grid index title
                $('.style-grid-inner-block-title[data-parent-index="'+parent_index+'"]').each(function(idx, el) {
                    $(this).html('#'+(idx+1));
                });

                CreateGridRef.showHideInnerItemAddBtn(parent_index);

            });

            $('body').on('click', '.grid-item-inner-input-block', function(e) {

                e.preventDefault();

                var inner_index = $(this).data('inner-index');
                var parent_index = $(this).data('parent-index');
                
                $('#stylegrid_item_frm')[0].reset();
                
                $('#stylegrid_item_frm #product_image_preview').attr('src', "{{ asset('stylist/app-assets/images/icons/plus.png')}}");

                $('#modal_stylegrid_item_title').html('('+$('.style-grid-block-title[data-index="'+parent_index+'"]').html()+' - Item '+$('.style-grid-inner-block-title[data-parent-index="'+parent_index+'"][data-inner-index="'+inner_index+'"]').html()+')');
               
                $('#modal_stylegrid_index').val(parent_index);
                $('#modal_stylegrid_item_index').val(inner_index);

                CreateGridRef.bindGridItemDetailsModal(parent_index, inner_index);
                $('#modal_product_img_block').removeClass('border-2 border-danger');
                $('#modal_product_img_error').html('');
                $('#grid_item_details_modal').modal('show');

            });

            $('body').on('click', '.add-item-block-btn', function(e) {

                e.preventDefault();

                var index = $(this).data('index');
                
                var item_block_count = $(".style-grid-item-left-row[data-index='"+index+"'] .item-block-inner-row").length;

                if (item_block_count < 7) {
                
                    var temp_count = (CreateGridRef.getGridInnerBlockMaxItemCount(index)+1);
                    var title_index = (item_block_count+1);
                    
                    var html = "";
                    html+= '                    <div class="item-block-inner-row col-6" data-inner-index="'+temp_count+'"  data-parent-index="'+index+'">';
                    html+= '                        <div class="Neon Neon-theme-dragdropbox">';
                    html+= '                            <div class="Neon-input-dragDrop grid-item-inner-input-block d-flex align-items-center height_200" data-inner-index="'+temp_count+'"  data-parent-index="'+index+'">';
                    html+= '                                <div class="Neon-input-inner">';
                    html+= '                                    <div class="Neon-input-text">';
                    html+= '                                      <h3  class="grid-item-image-title" data-inner-index="'+temp_count+'" data-parent-index="'+index+'">Add an item here</h3>';
                    html+= '                                    </div>';
                    html+= '                                    <a class="Neon-input-choose-btn blue"><img src="{{ asset('stylist/app-assets/images/icons/plus.png')}}" class="grid-item-image-src img_preview" data-inner-index="'+temp_count+'"  data-parent-index="'+index+'"></a>';
                    html+= '                                </div>';
                    html+= '                            </div>';
                    html+= '                        </div>';
                    html+= '                        <img src="{{ asset('stylist/app-assets/images/icons/Empty-Trash.png')}}" class="img-fluid delete-grid-item-block-btn" data-inner-index="'+temp_count+'" data-parent-index="'+index+'" style="position: absolute;top: 0;" alt=""/>';
                    html+= '                        <span class="style-grid-inner-block-title" data-inner-index="'+temp_count+'"  data-parent-index="'+index+'" style="position: absolute;top: 0;right: 25px;">#'+title_index+'</span>';
                    html+= '                    </div>';

                    $('.style-grid-item-left-row[data-index="'+index+'"]').append(html);
                    
                    CreateGridRef.showHideInnerItemAddBtn(index);

                } else {
                    $('.add-item-block-btn[data-index="'+index+'"]').hide();
                }
            

            });

            $('body').on('click', '#stylegrid_item_frm_btn', function(e) {
                
                e.preventDefault();
                
                $('#modal_product_img_block').removeClass('border-2 border-danger');
                $('#modal_product_img_error').html('');

                var is_valid_image = true;
                
                var modal_image_preview_src = $('#stylegrid_item_frm [id="product_image_preview"]').attr('src');

                var base64regex = /^([0-9a-zA-Z+/]{4})*(([0-9a-zA-Z+/]{2}==)|([0-9a-zA-Z+/]{3}=))?$/;

                modal_image_preview_src = modal_image_preview_src.substr(modal_image_preview_src.indexOf(',') + 1);

                if(base64regex.test(modal_image_preview_src) == false){ // is base64 or not

                    // check main grid feature image 
                    is_valid_image = false;

                    $('#modal_product_img_block').addClass('border-2 border-danger');

                }
                
                if($("#stylegrid_item_frm").valid() && is_valid_image)
                {
                    // Save inner block item details to main json 

                    var temp_obj = {
                        'stylegrid_index' :  $('#modal_stylegrid_index').val(),
                        'stylegrid_item_index' : $('#modal_stylegrid_item_index').val(),
                        'product_name' :  $('#stylegrid_item_frm input[name="product_name"]').val(),
                        'product_brand' : $('#stylegrid_item_frm input[name="product_brand"]').val(),
                        'product_type' :  $('#stylegrid_item_frm input[name="product_type"]').val(),
                        'product_price' :  $('#stylegrid_item_frm input[name="product_price"]').val(),
                        'product_size' :  $('#stylegrid_item_frm input[name="product_size"]').val(),
                        'product_image' : $('#stylegrid_item_frm [id="product_image_preview"]').attr('src'),                        
                    };

                    $('.grid-item-image-src[data-parent-index="'+temp_obj.stylegrid_index+'"][data-inner-index="'+temp_obj.stylegrid_item_index+'"]').attr('src', temp_obj.product_image);
                    $('.grid-item-image-title[data-parent-index="'+temp_obj.stylegrid_index+'"][data-inner-index="'+temp_obj.stylegrid_item_index+'"]').html('');
                    

                    CreateGridRef.saveStyleGridItemObj(temp_obj.stylegrid_index, temp_obj.stylegrid_item_index, temp_obj);

                    $('.grid-item-inner-input-block[data-parent-index="'+temp_obj.stylegrid_index+'"][data-inner-index="'+temp_obj.stylegrid_item_index+'"]').removeClass('border-2 border-danger');

                    $('#grid_item_details_modal').modal('hide');

                }
            });

            $('body').on('click', '#stylegrid_main_frm_btn', function(e) {

                e.preventDefault();

                $('.grid-item-inner-input-block').removeClass('border-2 border-danger');
                
                var is_valid_grid = true;

                if(CreateGridRef.styleGridJson.main_grid.feature_image == ""){

                    // check main grid feature image 
                    is_valid_grid = false;

                    $('.style-grid-main-feature-image-block').addClass('border-2 border-danger');

                }

                $.each(CreateGridRef.styleGridJson['grids'], function (key, val) {
                    
                    var grid_index_id = val.stylegrid_index;

                    if(val.feature_image == ""){

                        is_valid_grid = false;

                        $('.style-grid-feature-image-block[data-index="'+grid_index_id+'"]').addClass('border-2 border-danger');

                    }

                    $(".style-grid-item-left-row[data-index='"+grid_index_id+"']").children(".item-block-inner-row").each(function (in_key, in_val) {
                        
                        var parent_index = $(this).data('parent-index');
                        var inner_index = $(this).data('inner-index');

                        var obj_item_index = CreateGridRef.styleGridJson['grids'][key]['items'].findIndex(x => x.stylegrid_item_index == inner_index);
    
                        if(obj_item_index == -1){

                            is_valid_grid = false;

                            $('.grid-item-inner-input-block[data-parent-index="'+parent_index+'"][data-inner-index="'+inner_index+'"]').addClass('border-2 border-danger');
                            
                        }

                    });
                    
                });
                                
                CreateGridRef.styleGridJson['main_grid']['title'] = $('#stylegrid_main_frm input[name="title"]').val();
                
                $('#stylegrid_main_frm input[name="stylegrid_json"]').val(JSON.stringify(CreateGridRef.styleGridJson));

                if($("#stylegrid_main_frm").valid() && is_valid_grid){
                    
                    showLoadingDialog();
                    
                    var form = $("#stylegrid_main_frm");

                    window.getResponseInJsonFromURL(form.attr('action'), getFormInputs(form), (response) => {
                    

                        if(response.status == 1){
                            
                            showSuccessMessage(response.message);
                            window.location.href = '{{ route("stylist.grid.index") }}';

                        }else{
                            
                            hideLoadingDialog();
                            showErrorMessage(response.message);
                        }
                    }, (error) => { hideLoadingDialog(); },  'POST');

                }

            });

            $('#grid_item_details_modal').on('hidden.bs.modal', function() {
                // remove modal form validation error messages
                var $alertas = $('#stylegrid_item_frm');
                $alertas.validate().resetForm();
                $alertas.find('.error').removeClass('error');
            });

            $('body').on('change', "input[name=feature_image], input[name^=item_feature_image]", function(e) {

                var input = this;
                
                let preview_selector = $(this).data('img-preview-selector');
                let parent_index = $(this).data('index');
                
                if(parent_index != undefined){
                    preview_selector = preview_selector+'[data-index="'+parent_index+'"]';
                }

                if(preview_selector != undefined){

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {

                            var img_blob = e.target.result;

                            $(preview_selector).attr('src', img_blob);
                    
                            if(parent_index != undefined){

                                // This is stylegrid feature image
                                var obj_index = CreateGridRef.styleGridJson.grids.findIndex(x => x.stylegrid_index == parent_index);
                                
                                if(obj_index != -1){
                                    CreateGridRef.styleGridJson.grids[obj_index]['feature_image'] = img_blob;
                                    $('.style-grid-feature-image-block[data-index="'+parent_index+'"]').removeClass('border-2 border-danger');
                                    $('.feature-image-title[data-index="'+parent_index+'"]').html('');
                                }

                            }else{
                                // This is first block's feature image  - main block
                                CreateGridRef.styleGridJson['main_grid']['feature_image'] = img_blob;
                                $('.style-grid-main-feature-image-title').html('');
                                $('.style-grid-main-feature-image-block').removeClass('border-2 border-danger');
                            }

                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                    
                }
            });

            $('body').on('change', "#stylegrid_item_frm input[name=product_image]", function(e) {

                // validate file should be max 3 mb            
                var options = {
                    'check_by_size' : true,
                    'max_upload_size' : 3,
                }

                var is_valid_file = fileValidate(this, options);
                
                if(is_valid_file.is_valid == false){
                    $($(this).data('img-preview-selector')).attr('src', "{{ asset('stylist/app-assets/images/icons/plus.png')}}");
                    showErrorMessage(is_valid_file.error);
                    $('#modal_product_img_error').html(is_valid_file.error);
                    return false;

                }else{

                    // var input = this.files[0];

                    // if (input) {
                        
                    //     var reader = new FileReader();
                    //     reader.onload = function (e) {
                    
                    //         var height = this.height;
                    //         var width = this.width;
                    //         if (height > input.data('height') || width > input.data('width')) {
                    //             showErrorMessage("Please check file dimensions.");
                    //             $('#modal_product_img_error').html("Please check file dimensions.");
                    //             return false;

                    //         }else{
                    //             $(input.data('img-preview-selector')).attr('src', e.target.result);
                    //             $('#modal_product_img_block').removeClass('border-2 border-danger');
                    //             $('#modal_product_img_error').html('');
                    //         }
                    //     }
                    //     reader.readAsDataURL(input);
                    // }
                    
                    fileChangePreviewImage(this, $(this).data('img-preview-selector'));
                    $('#modal_product_img_block').removeClass('border-2 border-danger');
                    $('#modal_product_img_error').html('');
                    $('#item-modal-image-title').html('');
                }

            });
        }

        CreateGridRef.loadStyleGridUI = function(index) {
           
            var html = '';

            html+= '<div class="row mt-2 mjrowtrack style-grid-block-row" data-index="'+index+'">';
            html+= '   <div class="col-lg-11">';
            html+= '    <div class="grid-bg mx-4 px-4 py-2 mb-4">';
            html+= '        <div class="row mb-2">';
            html+= '            <div class="col-8">';
            html+= '               <h1 class="style-grid-block-title" data-index="'+index+'">STYLEGRID #'+index+'</h1>';
            html+= '            </div>';
            html+= '            <div class="col-4 text-right "><img src="{{ asset('stylist/app-assets/images/icons/Empty-Trash.png')}}" class="img-fluid delete-grid-btn" data-index="'+index+'" alt=""/></div>';
            html+= '         </div>';
           
            html+= '         <div class="row add-item">';
            html+= '            <div class="col-lg-6 d-flex align-items-center">';
            html+= '               <div class="row">';
            html+= '                  <div class="style-grid-item-left-row d-flex flex-wrap w-100"  data-index="'+index+'">';
            html+= '                    <div class="item-block-inner-row col-6" data-inner-index="1" data-parent-index="'+index+'">';
            html+= '                        <div class="Neon Neon-theme-dragdropbox">';
            html+= '                            <div class="Neon-input-dragDrop grid-item-inner-input-block d-flex align-items-center height_200" data-inner-index="1" data-parent-index="'+index+'">';
            html+= '                                <div class="Neon-input-inner">';
            html+= '                                    <div class="Neon-input-text">';
            html+= '                                      <h3 class="grid-item-image-title" data-inner-index="1" data-parent-index="'+index+'">Add an item here</h3>';
            html+= '                                    </div>';
            html+= '                                    <a class="Neon-input-choose-btn blue"><img src="{{ asset('stylist/app-assets/images/icons/plus.png')}}" class="grid-item-image-src img_preview" data-inner-index="1" data-parent-index="'+index+'"></a>';
            html+= '                                </div>';
            html+= '                            </div>';
            html+= '                        </div>';
            html+= '                        <img src="{{ asset('stylist/app-assets/images/icons/Empty-Trash.png')}}" class="img-fluid delete-grid-item-block-btn" data-inner-index="1" data-parent-index="'+index+'" style="position: absolute;top: 0;" alt=""/>';
            html+= '                        <span class="style-grid-inner-block-title" data-inner-index="1" data-parent-index="'+index+'" style="position: absolute;top: 0;right: 25px;">#1</span>';
            html+= '                    </div>';
            html+= '                  </div>';
            html+= '                  <div class="col-lg-2 text-center add-another-block-div" data-index="'+index+'"><button class="sss px-3 form-border add-item-block-btn"  data-index="'+index+'" ><img src="{{ asset('stylist/app-assets/images/icons/plus.png')}}" alt=""><br>Add another block</button></div>';
            html+= '               </div>';
            html+= '            </div>';
            html+= '            <div class="col-lg-6">';
            html+= '               <div class="Neon Neon-theme-dragdropbox mt-5 mx-lg-4">';
            html+= '                  <input name="item_feature_image['+index+']" class="style-grid-block-input-file"  data-img-preview-selector=".grid-feature-image-src" type="file" data-index="'+index+'">';
            html+= '                  <div class="Neon-input-dragDrop d-flex align-items-center height_300 style-grid-feature-image-block"  data-index="'+index+'">';
            html+= '                     <div class="Neon-input-inner">';
            html+= '                        <div class="Neon-input-text">';
            html+= '                           <h3 class="feature-image-title" data-index="'+index+'">Add your feature image here...</h3>';
            html+= '                        </div>';
            html+= '                     <a class="Neon-input-choose-btn blue"><img class="grid-feature-image-src img_preview" src="{{ asset('stylist/app-assets/images/icons/plus.png')}}" data-index="'+index+'"></a>';
            html+= '                 </div>';
            html+= '               </div>';
            //html+= '               <p>Image size recommendation is 1170px X 570px(Min) </p>';
            html+= '               </div>';
            html+= '            </div>';
            html+= '         </div>';
            html+= '      </div>';
            html+= '   </div>';
            html+= '   <div class="col-lg-1"></div>';
            html+= '</div>';

            $('.style-grids-container').append(html);
            
            CreateGridRef.createStyleGridObj(index);

            CreateGridRef.styleGridNumberPagination();

        };

        CreateGridRef.styleGridNumberPagination = function(e) {
           
            $('.grid-numbering-container').html('');

            var number_html = '';

            var totalStylegridCount = CreateGridRef.getTotalDivLengthBySelector(".style-grid-block-row");
            for (let index = 1; index <= totalStylegridCount; index++) {
              
                number_html += '<div class="blue-bg mt-lg-2 mt-1 mx-lg-0 mx-2">' + index + '</div>';
                
            }
            $('.grid-numbering-container').append(number_html);

            $(".style-grid-block-title").each(function(idx, el) {
                $(this).html('STYLEGRID #'+(idx+1));
            });

            var totalStylegridCount = CreateGridRef.getTotalDivLengthBySelector(".style-grid-block-row");

            if(totalStylegridCount < 11){
                
                if(totalStylegridCount == 10){
                    $('#add_grid_btn').hide();                    
                }else{                
                    $('#add_grid_btn').show();
                }

            }

        };

        CreateGridRef.showHideInnerItemAddBtn = function(parent_index) {
            
            var total_block_count = $(".style-grid-item-left-row[data-index='"+parent_index+"'] .item-block-inner-row").length;

            if (total_block_count == 6) {
                $('.add-item-block-btn[data-index="'+parent_index+'"]').hide();
            }else{
                $('.add-item-block-btn[data-index="'+parent_index+'"]').show();
            }
        };

        CreateGridRef.getTotalDivLengthBySelector = function(selector) {    
            var total = $(selector).length;
            return total;
        };

        CreateGridRef.bindGridItemDetailsModal = function(grid_index, item_index) {
            
            var obj_index = CreateGridRef.styleGridJson['grids'].findIndex(x => x.stylegrid_index == grid_index);

            if(obj_index != -1){

                var obj_item_index = CreateGridRef.styleGridJson['grids'][obj_index]['items'].findIndex(x => x.stylegrid_item_index == item_index);
    
                if(obj_item_index != -1){
       
                    var item_details = CreateGridRef.styleGridJson['grids'][obj_index]['items'][obj_item_index];

                    $('#stylegrid_item_frm input[name="product_name"]').val(item_details.product_name);
                    $('#stylegrid_item_frm input[name="product_brand"]').val(item_details.product_brand);
                    $('#stylegrid_item_frm input[name="product_type"]').val(item_details.product_type);
                    $('#stylegrid_item_frm input[name="product_price"]').val(item_details.product_price);
                    $('#stylegrid_item_frm input[name="product_size"]').val(item_details.product_size);
                    $('#stylegrid_item_frm [id="product_image_preview"]').attr('src', item_details.product_image);

                }

            }
        };
                    

        CreateGridRef.createStyleGridObj = function(grid_index) {
            
            var obj_index = CreateGridRef.styleGridJson.grids.findIndex(x => x.stylegrid_index == grid_index);

            if(obj_index == -1){

                CreateGridRef.styleGridJson.grids.push({
                    'stylegrid_index' : grid_index,
                    'feature_image' : '',
                    'items' : []
                });

            }
            console.log(CreateGridRef.styleGridJson);

        };

        CreateGridRef.saveStyleGridItemObj = function(grid_index, item_index, item_details) {
            
            var obj_index = CreateGridRef.styleGridJson['grids'].findIndex(x => x.stylegrid_index == grid_index);

            if(obj_index != -1){

                var obj_item_index = CreateGridRef.styleGridJson['grids'][obj_index]['items'].findIndex(x => x.stylegrid_item_index == item_index);
    
                if(obj_item_index != -1){

                    CreateGridRef.styleGridJson['grids'][obj_index]['items'].splice(obj_item_index, 1);

                }
                
                CreateGridRef.styleGridJson['grids'][obj_index]['items'].push(item_details);

            }
            console.log('saveStyleGridItemObj ', CreateGridRef.styleGridJson);

        };

        CreateGridRef.deleteStyleGridItemObj = function(grid_index, item_index) {
            
            var obj_index = CreateGridRef.styleGridJson['grids'].findIndex(x => x.stylegrid_index == grid_index);

            if(obj_index != -1){

                var obj_item_index = CreateGridRef.styleGridJson['grids'][obj_index]['items'].findIndex(x => x.stylegrid_item_index == item_index);
    
                if(obj_item_index != -1){

                    CreateGridRef.styleGridJson['grids'][obj_index]['items'].splice(obj_item_index, 1);

                }
        
            }
            console.log('deleteStyleGridItemObj ', CreateGridRef.styleGridJson);

        };
        
        CreateGridRef.deleteStyleGridObj = function(grid_index) {
            
            var obj_index = CreateGridRef.styleGridJson.grids.findIndex(x => x.stylegrid_index == grid_index);

            if(obj_index != -1){

                CreateGridRef.styleGridJson.grids.splice(obj_index, 1);

            }
            console.log(CreateGridRef.styleGridJson);

        };

        CreateGridRef.getGridInnerBlockMaxItemCount = function(grid_index_id) {
            
            var items_index_array = [];

            $(".style-grid-item-left-row[data-index='"+grid_index_id+"']").children(".item-block-inner-row").each(function (key, val) {
                items_index_array.push($(this).data('inner-index'));
            });

            var max_item_count = 0;

            if(items_index_array.length > 0){
                max_item_count = Math.max.apply(Math,items_index_array); 
            }
            return max_item_count;
        };

        CreateGridRef.processExceptions = function(e) {
            showErrorMessage(e);
        };

        CreateGridRef.initEvents();
    };
</script>
