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
        ViewGridRef.selectedClientIds = [];
        ViewGridRef.allGridClients = [];

        ViewGridRef.initEvents = function() {

            $('#search_client_input').select2({

                width:"100%",
                dropdownParent: $('#grid_clients_modal'),
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('options.stylist_clients') }}",
                    dataType: 'json',
                    method:"post",
                    delay: 250,
                    data: function (params) {

                        return {
                            search: params.term, // search term
                            stylist_id : auth_id,
                            member_ids : JSON.stringify(ViewGridRef.selectedClientIds),
                            filter:1,
                            page: params.page,
                        };
                    },

                    processResults: function (result) {

                        var retVal = [];

                        for (var i = 0; i < result.data.list.length; i++) {

                            var obj = result.data.list[i];

                            var lineObj = {
                                id: obj.value,
                                text: obj.label,
                                json: obj
                            }
                            retVal.push(lineObj);
                        }
                        return {
                            results: retVal
                        };

                    },

                    cache: true
                },
                placeholder: 'Search here...',
                allowClear: true,
                minimumInputLength: 1,
                // multiple: true,
                language: {
                    inputTooShort: function(args) {
                        return "";
                    }
                }
            });

            $('#search_client_input').on('select2:select', function (e) {

                var json = e.params.data.json;
                ViewGridRef.selectedClientIds.push(json.value);
                
                $(this).val('').trigger('change');

                $('#search_clients_container').append(ViewGridRef.bindClientUI(json));


            });

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

            $('body').on('click', '#send_to_client_btn', function(e) {
            
                e.preventDefault();
                ViewGridRef.getGridClients();
                $('#grid_clients_modal').modal('show');

            });

            $('body').on('click', '.remove-client', function(e) {
            
                e.preventDefault();
                var id = $(this).data('id');
                $('.client-li[data-id="'+id+'"]').remove();
                ViewGridRef.selectedClientIds.splice(ViewGridRef.selectedClientIds.indexOf(id), 1);
            });

            $('body').on('click', '#send_grid_btn', function(e) {
            
                e.preventDefault();
            
                var client_ids = [];
                
                $.each(ViewGridRef.selectedClientIds, function (i1, val1) { 
                     
                    var index_grid = ViewGridRef.allGridClients.indexOf(val1);
                    if(index_grid == -1){
                        client_ids.push(val1);
                    }
                });

                if(client_ids.length == 0){
                    showErrorMessage('Please select client');
                    return false;
                }

                showSpinner('#send_grid_btn', 'sm', 'light');

                var formData = new FormData();    
                formData.append( 'client_ids', JSON.stringify(client_ids) );
                formData.append( 'stylegrid_id', $('#stylegrid_id').val() );

                getResponseInJsonFromURL('{{ route("stylist.grid.sent_to_clients") }}', formData, (response) => { 
                   
                    hideSpinner('#send_grid_btn', 'sm');

                    if(response.status != undefined && response.status == 0){

                        showErrorMessage(response.message);

                    }else{

                        $('#search_clients_container').html('');
                        ViewGridRef.getGridClients();
                        showSuccessMessage(response.message);
                    }

                }, (error) => { console.log(error) } );

            });
            
        }

        ViewGridRef.bindClientUI = function(dtls) {

            var html = '';
            html += '<div class="col-6 client-li mb-1" data-id="'+dtls.value+'">';
            html += '   <div class="d-flex justify-content-between border-primary border_radius_5 p-mini-5">';
            html += '       <h6 class="text-primary mb-0">'+dtls.label+'</h6>';
            html += '       <i class="fa-solid fa-xmark text-danger fa-2x remove-client" data-id="'+dtls.value+'"></i>';
            html += '   </div>';
            html += '</div>';
            return html;
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

        ViewGridRef.getGridClients = function(json) {

            var formData = new FormData();    
            formData.append( 'stylegrid_id', $('#stylegrid_id').val() );

            getResponseInJsonFromURL('{{ route("stylist.grid.clients") }}', formData, (response) => { 
             
                if(response.status != undefined && response.status == 0){

                    showErrorMessage(response.message);

                }else{

                    ViewGridRef.renderGridClientsUI(response.data.list);

                }

            }, (error) => { console.log(error) } );
        
        };
            
        ViewGridRef.renderGridClientsUI = function(json) {

            $('#grid_clients_table_body').html('');

            ViewGridRef.selectedClientIds = [];
            ViewGridRef.allGridClients = [];
            var html = '';

            if(json.length > 0){
                
                $.each(json, function (i, val) { 

                    html += '<tr>';
                    html += '<td>'+val.client_name+'</td>';
                    html += '<td>'+formatDateValue(val.created_at)+'</td>';
                    html += '</tr>';

                    ViewGridRef.selectedClientIds.push(val.member_id);
                    ViewGridRef.allGridClients.push(val.member_id);
                });
               
            }else{
                html += '<tr>';
                html += '   <td colspan="2">No data found!</td>';
                html += '</tr>';
            }
            $('#grid_clients_table_body').html(html);

        };

        ViewGridRef.processExceptions = function(e) {
            showErrorMessage(e);
        };

        ViewGridRef.initEvents();
    };
</script>
