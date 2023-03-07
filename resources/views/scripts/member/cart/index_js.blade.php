<script>
    window.onload = function() {
        'use strict';

        var CartRef = window.CartRef || {};
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

        CartRef.cartCurrentPage = 1;
        CartRef.cartItemsCount = 0;
        CartRef.cartTotalPage = 0;
        CartRef.isActiveAjax = false;

        CartRef.initEvents = function() {

            CartRef.getCartItems();
            
            $('body').on('click', '.remove-item-cart-btn', function(e) {

                e.preventDefault();
                var cart_id = $(this).data('cart-id');
                var cart_dtls_id = $(this).data('cart-dtls-id');
                
                confirmDialogMessage('Remove Item', 'Are you sure to remove?', 'Yes', () => {

                    CartRef.removeCartItem(cart_id, cart_dtls_id);

                });

            });

            $('body').on('click', '#send_items_tochat_btn', function(e) {

                e.preventDefault();
               
                var cart_dtls_ids = [];
                var cart_id = '';

                $(".cart-product-div").each(function (key, val) {

                    cart_dtls_ids.push($(this).data('cart-dtls-id'));
                    cart_id = $(this).data('cart-id');
                });
                
                if(cart_dtls_ids.length > 0){

                    showLoadingDialog();

                    var formData = new FormData();
                    formData.append('cart_dtls_ids', JSON.stringify(cart_dtls_ids));
                    formData.append('cart_id', cart_id);

                    window.getResponseInJsonFromURL('{{ route("member.cart.send_to_messanger") }}', formData, (response) => {

                        hideLoadingDialog();

                        if (response.status == '1') {

                            manageCartBadgeCount(response.data.cart_items_count);

                            CartRef.cartItemsCount = response.data.cart_items_count;
                            CartRef.showHideSendToStylistBtn();
                    
                            window.location.href = '{{ route("member.messanger.index") }}';

                        } else {
                            showErrorMessage(response.message);
                        }


                    }, processExceptions, 'POST');

                }else{
                    showErrorMessage('Unable to process your request.');
                    return false;
                }

            });


            $(window).scroll(function() {
                       
                if ($(document).height() >= $(window).scrollTop() + $(window).height()) {
                   
                    if(CartRef.cartCurrentPage <= CartRef.cartTotalPage && CartRef.isActiveAjax == false){
                        
                        CartRef.isActiveAjax = true;
                        CartRef.cartCurrentPage++;
                        CartRef.getCartItems();
                    }
                }
            });

        }
          
        CartRef.removeCartItem = function(cart_id, cart_dtls_id) {
        
            showLoadingDialog();

            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            formData.append('cart_id', cart_id);
            formData.append('cart_dtls_id', cart_dtls_id);
            
            window.getResponseInJsonFromURL('{{ route("member.cart.remove") }}', formData, (response) => {

                hideLoadingDialog();

                if (response.status == '1') {

                    CartRef.cartCurrentPage = 1;
                    CartRef.getCartItems();
                    
                } else {
                    showErrorMessage(response.message);
                }


            }, processExceptions, 'POST');
        
        };

        CartRef.getCartItems = function(e) {
        
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            formData.append('page', CartRef.cartCurrentPage);
            
            if(CartRef.cartCurrentPage == 1){
                $('#cart_container').html('');
            }

            showSpinner('#cart_container');

            window.getResponseInJsonFromURL('{{ route("member.cart.list") }}', formData, (response) => {

                hideSpinner('#cart_container');
   
                if (response.status == '1') {

                    CartRef.cartTotalPage = response.data.total_page;
                    
                    manageCartBadgeCount(response.data.cart_items_count);

                    CartRef.cartItemsCount = response.data.cart_items_count;
                    CartRef.showHideSendToStylistBtn();

                    $('#cart_container').append(response.data.view);
                    
                } else {
                    showErrorMessage(response.message);
                }
                CartRef.isActiveAjax = false;

            }, processExceptions, 'POST');
           
        };
        
        CartRef.showHideSendToStylistBtn = function(e) {
        
                if(CartRef.cartItemsCount > 0){

                    $('#send_items_tochat_btn').show();

                }else{

                    $('#send_items_tochat_btn').hide();
                    
                }
        }

        CartRef.initEvents();

    };

</script>
