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

                var stylegrid_dtls_id = $(this).data('stylegrid-dtls-id');
                var stylegrid_product_id = $(this).data('stylegrid-product-id');

                ViewGridRef.bindGridItemDetailsModal(stylegrid_dtls_id, stylegrid_product_id);

                $('#grid_item_details_modal').modal('show');

            });

            $('body').on('click', '#copy_link_btn', function(e) {
            
                e.preventDefault();
                copyToClipboard($(this).attr('data-copy-content'));
                // $(this).html("Copied");
            });

            // $('body').on('click', '#export_pdf_btn', function(e) {
                
            //     e.preventDefault();

            //     getResponseInJsonFromURL($(this).data('action'), '', (response) => { 
            //         console.log(response);
                    
            //         if(response.status != undefined && response.status == 0){

            //             showErrorMessage(response.message);
            //         }

            //     }, (error) => { console.log(error) } );

            // });
            
        }

        
        ViewGridRef.bindGridItemDetailsModal = function(stylegrid_dtls_id, stylegrid_product_id) {
            
            var obj_index = ViewGridRef.styleGridJson['grids'].findIndex(x => x.stylegrid_dtls_id == stylegrid_dtls_id);

            if(obj_index != -1){

                var obj_item_index = ViewGridRef.styleGridJson['grids'][obj_index]['items'].findIndex(x => x.stylegrid_product_id == stylegrid_product_id);
    
                if(obj_item_index != -1){
       
                    var item_details = ViewGridRef.styleGridJson['grids'][obj_index]['items'][obj_item_index];

                    $('#product_name').html(item_details.product_name);
                    $('#product_brand').html(item_details.product_brand);
                    $('#product_type').html(item_details.product_type);
                    $('#product_price').html(item_details.product_price.toFixed(2));
                    $('#product_size').html(item_details.product_size);
                    $('#product_image_preview').attr('src', asset_url+item_details.product_image);

                }

            }
        };
                

        ViewGridRef.processExceptions = function(e) {
            showErrorMessage(e);
        };

        ViewGridRef.initEvents();
    };
</script>
