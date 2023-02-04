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
                    showErrorMessage(response.error);
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

                    $('#cart_container').append(response.data.view);
                    
                } else {
                    showErrorMessage(response.error);
                }
                CartRef.isActiveAjax = false;

            }, processExceptions, 'POST');
           
        };
        
        CartRef.initEvents();

    };

</script>
