<script>
    window.onload = function() {
        'use strict';

        var ViewGridRef = window.ViewGridRef || {};
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
        
        ViewGridRef.styleGridJson = @json($style_grid_dtls);
       
        ViewGridRef.initEvents = function() {


            $('body').on('click', '.grid-item-inner-input-block', function(e) {

                e.preventDefault();

                ViewGridRef.bindGridItemDetailsModal($(this).data('stylegrid-id'), $(this).data('stylegrid-product-id'));

            });

            $('body').on('click', '#cart_action_btn', function(e) {

                e.preventDefault();

                if($(this).data('action') == 'remove'){

                    ViewGridRef.removeCartItem({
                        cart_id :  $(this).data('cart-id'),
                        cart_dtls_id : $(this).data('cart-dtls-id'),
                    });
                   
                }else{
                    ViewGridRef.addToCartItem();
                }

            });

            $('body').on('click', '.grid_cart_action_btn', function(e) {

                e.preventDefault();

                if($(this).data('action') == 'remove'){

                    ViewGridRef.removeCartItem({
                        cart_id :  $(this).data('cart-id'),
                        cart_dtls_id : $(this).data('cart-dtls-id'),
                    });
                
                }else{
                    ViewGridRef.addToCartItem();
                }

            });

        }

        ViewGridRef.bindGridItemDetailsModal = function(stylegrid_id, stylegrid_product_id) {
            
            var formData = new FormData();    
            formData.append( 'stylegrid_id', stylegrid_id );
            formData.append( 'stylegrid_product_id', stylegrid_product_id );

            getResponseInJsonFromURL('{{ route("member.grid.product") }}', formData, (response) => { 
                
                $('#cart_action_btn').prop('disabled', false);

                if(response.status != undefined && response.status == 0){

                    showErrorMessage(response.message);
                    return false;

                }else{
           
                    var item_details = response.data;
 
                    if(item_details != undefined){
 
                        $('#product_name').html(item_details.product_name);
                        $('#product_brand').html(item_details.product_brand);
                        $('#product_type').html(item_details.product_type);
                        $('#product_price').html(item_details.product_price.toFixed(2));
                        $('#product_size').html(item_details.product_size);
                        $('#product_image_preview').attr('src', asset_url+item_details.product_image);
                        $('#cart_item_id').val(stylegrid_product_id);

                        $('#cart_action_btn').data('cart-id', '');
                        $('#cart_action_btn').data('cart-dtls-id', '');

                        if(item_details.is_cart_item == 1){
                            $('#cart_btn_title').text('Remove From Cart');
                            $('#cart_action_btn').data('action', 'remove');
                            $('#cart_action_btn').data('cart-id', item_details.cart_id);
                            $('#cart_action_btn').data('cart-dtls-id', item_details.cart_dtls_id);
                        }else{
                            $('#cart_btn_title').text('Add To Cart');
                            $('#cart_action_btn').data('action', 'add');
                        }

                        $('#grid_item_details_modal').modal('show');

                    }

                }

            }, (error) => { console.log(error) } );
           
        };

        ViewGridRef.addToCartItem = function() {

            showSpinner('#cart_action_btn', 'sm', 'light', 'span');
                
            var items = [
                {   
                    'item_id' : $('#cart_item_id').val(),
                    'item_type' : $('#cart_item_type').val()
                }
            ];

            var formData = new FormData();    
            formData.append( 'module_id', $('#cart_module_id').val() );
            formData.append( 'module_type', $('#cart_module_type').val() );
            formData.append( 'items', JSON.stringify(items) );

            getResponseInJsonFromURL('{{ route("member.cart.add") }}', formData, (response) => { 
            
                hideSpinner('#cart_action_btn', 'sm');

                if(response.status != undefined && response.status == 0){

                    showErrorMessage(response.message);

                }else{

                    manageCartBadgeCount(response.data.cart_items_count);
                    
                    ViewGridRef.bindGridItemDetailsModal($('#grid_id').val(), $('#cart_item_id').val());
                    $('#cart_action_btn').prop('disabled', true);
                    showSuccessMessage(response.message);
                }

            }, (error) => { console.log(error) } );
            
        }

        ViewGridRef.removeCartItem = function(data) {
        
            showSpinner('#cart_action_btn', 'sm', 'light', 'span');

            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            formData.append('cart_id', data.cart_id);
            formData.append('cart_dtls_id', data.cart_dtls_id);
            
            window.getResponseInJsonFromURL('{{ route("member.cart.remove") }}', formData, (response) => {

                hideSpinner('#cart_action_btn', 'sm');

                if (response.status == '1') {

                    showSuccessMessage(response.message);
                    
                    manageCartBadgeCount(response.data.cart_items_count);

                    $('#cart_action_btn').data('cart-id', '');
                    $('#cart_action_btn').data('cart-dtls-id', '');
                    $('#cart_btn_title').text('Add To Cart');
                    $('#cart_action_btn').data('action', 'add');

                } else {
                    showErrorMessage(response.message);
                }


            }, processExceptions, 'POST');
        
        };
        

        ViewGridRef.processExceptions = function(e) {
            showErrorMessage(e);
        };

        ViewGridRef.initEvents();
    };
</script>
