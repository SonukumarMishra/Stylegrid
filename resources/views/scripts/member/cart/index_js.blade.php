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
                
        CartRef.getCartItems = function(e) {
        
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            formData.append('page', CartRef.cartCurrentPage);
            
            showSpinner('#cart_container');

            window.getResponseInJsonFromURL('{{ route("member.cart.list") }}', formData, (response) => {

                hideSpinner('#cart_container');
   
                if (response.status == '1') {

                    CartRef.cartTotalPage = response.data.total_page;
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
