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
        
        console.log(ViewGridRef.styleGridJson);

        ViewGridRef.initEvents = function() {

            $('body').on('click', '.grid-item-inner-input-block', function(e) {

                e.preventDefault();

                var stylegrid_dtls_id = $(this).data('inner-stylegrid-dtls-id');
                var stylegrid_product_id = $(this).data('stylegrid-product-id');

                ViewGridRef.bindGridItemDetailsModal(stylegrid_dtls_id, stylegrid_product_id);

                $('#grid_item_details_modal').modal('show');

            });

        }

        
        ViewGridRef.bindGridItemDetailsModal = function(stylegrid_dtls_id, stylegrid_product_id) {
            
            var obj_index = ViewGridRef.styleGridJson['grids'].findIndex(x => x.stylestylegrid_dtls_id == stylegrid_dtls_id);

            if(obj_index != -1){

                var obj_item_index = ViewGridRef.styleGridJson['grids'][obj_index]['items'].findIndex(x => x.stylegrid_product_id == stylegrid_product_id);
    
                if(obj_item_index != -1){
       
                    var item_details = ViewGridRef.styleGridJson['grids'][obj_index]['items'][obj_item_index];

                    $('#product_name').html(item_details.product_name);
                    $('#product_brand').html(item_details.product_brand);
                    $('#product_type').html(item_details.product_type);
                    $('#product_size').html(item_details.product_size);
                    $('#product_image_preview').attr('src', item_details.product_image);

                }

            }
        };
                

        ViewGridRef.processExceptions = function(e) {
            showErrorMessage(e);
        };

        ViewGridRef.initEvents();
    };
</script>
