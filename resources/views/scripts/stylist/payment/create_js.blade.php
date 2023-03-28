<script>
    window.onload = function() {
        'use strict';

        var PaymentRef = window.PaymentRef || {};
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
        
        PaymentRef.selectedMemberId = '';
        PaymentRef.myRequestsCurrentPage = 1;
        PaymentRef.selectedInvoiceItemsIds = [];
        PaymentRef.allTempInvoiceItems = [];
        PaymentRef.allInvoiceItems = [];
        PaymentRef.postInvoiceItems = [];
        PaymentRef.totalInvoiceAmount = 0;

        PaymentRef.initEvents = function() {

            $('body').on('click', '.generate-invoice-btn', function (e) {
                e.preventDefault();
                
                $('#modal_sourcing_invoice_title').html($(this).data('title'));
                $('#sourcing_invoice_frm input[name="sourcing_id"]').val($(this).data('sourcing-id'));
                $('#sourcing_invoice_frm input[name="invoice_amount"]').val($(this).data('amount'));
                $('#sourcing_invoice_modal').modal('show');

            });

            $('body').on('click', '#select_customer_items_btn', function(e) {

                e.preventDefault();

                if($('#member_id').val() == ''){

                    showErrorMessage('Please select customer');
                    return false;
                }

                PaymentRef.selectedMemberId = $('#member_id').val();
                $('#customer_items_modal').modal('show');
                PaymentRef.loadCustomerTempItems();

            });

            $('body').on('click', '#select_temp_items_btn', function (e) {
                e.preventDefault();

                var temp_ids = [];
                
                $('.invoice-item-checkbox:checkbox:checked').map(function() {
                    temp_ids.push(this.value);
                    return;
                }).get();

                if(temp_ids.length == 0){
                    showErrorMessage('Please select item.');
                    return false;
                }

                $('.invoice-item-checkbox:checkbox:checked').map(function() {

                    PaymentRef.selectedInvoiceItemsIds.push(this.value);

                    var temp_dtls = getDetailsFromObjectByKey(PaymentRef.allTempInvoiceItems, this.value, 'temp_invoice_item_id');
                    
                    if(temp_dtls != undefined && temp_dtls != ''){

                        PaymentRef.totalInvoiceAmount = parseFloat(PaymentRef.totalInvoiceAmount) + parseFloat(temp_dtls.amount);

                        var selected_index = PaymentRef.allInvoiceItems.findIndex(item => item.stylegrid_id == temp_dtls.stylegrid_id);

                        if(selected_index != -1){

                            PaymentRef.allInvoiceItems[selected_index].items.push(temp_dtls);
                            
                        }else{

                            PaymentRef.allInvoiceItems.push({
                                'stylegrid_id' : temp_dtls.stylegrid_id,
                                'stylegrid_title' : temp_dtls.stylegrid_title,
                                'items' : [ temp_dtls ]
                            });
                        }

                        PaymentRef.postInvoiceItems.push(temp_dtls);

                    }

                }).get();
                
                PaymentRef.renderSelectedInvoiceItems();

                $('#customer_items_modal').modal('hide');

            });

            $('body').on('click', '#invoice_frm_btn', function(e) {

                e.preventDefault();

                if($("#invoice_frm").valid()){

                    if(PaymentRef.selectedInvoiceItemsIds.length > 0){

                        showLoadingDialog();

                        $("#invoice_frm input[name='invoice_amount']").val(parseFloat(PaymentRef.totalInvoiceAmount).toFixed(2));
                        $("#invoice_frm input[name='items']").val(JSON.stringify(PaymentRef.postInvoiceItems));
                        $("#invoice_frm input[name='stylist_id']").val(auth_id);
                        
                        window.getResponseInJsonFromURL('{{ route("stylist.payment.create_product_invoice") }}', new FormData($("#invoice_frm")[0]), (response) => {
                        
                            if (response.status == '1') {
                               
                                showSuccessMessage(response.message);
                                window.location.href = '{{ route("stylist.payment.index") }}';

                            } else {
                                hideLoadingDialog();
                                showErrorMessage(response.message);
                            }
                        }, processExceptions, 'POST');
                        
                    }else{
                        showErrorMessage('Please add item to generate invoice.');
                        return false;
                    }                
                }
            });

            $('body').on('change', '#member_id', function(e) {
            
                PaymentRef.totalInvoiceAmount = 0;
                PaymentRef.selectedInvoiceItemsIds = [];
                PaymentRef.allTempInvoiceItems = [];
                PaymentRef.allInvoiceItems = [];
                PaymentRef.postInvoiceItems = [];
                $('#items-list-container').html('');
                $('#total_invoice').html(parseFloat(PaymentRef.totalInvoiceAmount).toFixed(2));

            });

        }
             
        PaymentRef.renderSelectedInvoiceItems = function() {

            var html = '';
            
            PaymentRef.allInvoiceItems.forEach(function(item, val) {
                
                html += '<div class="raise-bg_1 pb-1 col-lg-12 mb-2">';
                html += '   <div class="">';
                html += '       <div class=" px-md-1 px-1 py-1">';
                html += '           <h1><a class="cart-header" href="#">'+item.stylegrid_title+'</a></h1>';
                html += '       </div>';
                html += '   </div>';
                html += '   <div class="mx-md-2" id="board-detail">';
                if(item.items.length > 0){

                    item.items.forEach(function(item_1, val_1) {

                        html += '<div class="row mx-md-2 mx-1 my-1 border-bottom cart-product-div pt-2">';
                        html += '    <div class="col-9 row">';
    
                        html += '    <div class="form-group col-4">';
    
                        html += '        <h5 class="cart-product-name-header">Product Name</h5>';
    
                        html += '        <label id="product_name">'+item_1.product_name+'</label>';
    
                        html += '    </div>';
    
                        html += '    <div class="form-group col-4">';
    
                        html += '        <h5 class="cart-product-name-header">Product Brand</h5>';

                        html += '        <label id="product_name">'+item_1.product_brand+'</label>';
    
                        html += '    </div>';
    
                        html += '    <div class="form-group col-4">';
    
                        html += '        <h5 class="cart-product-name-header">Product Type</h5>';

                        html += '         <label id="product_name">'+item_1.product_type+'</label>';

                        html += '    </div>';
    
                        html += '    <div class="form-group col-4">';
    
                        html += '        <h5 class="cart-product-name-header">Product Price</h5>';

                        html += '        <label id="product_name">£ '+parseFloat(item_1.amount).toFixed(2)+'</label>';

                        html += '    </div>';
                        html += '    <div class="form-group col-4">';
    
                        html += '        <h5 class="cart-product-name-header">Product Size</h5>';

                        html += '        <label id="product_name">'+item_1.product_size+'</label>';
    
                        html += '    </div>';
    
    
                        html += '    </div>';
                        html += '    <div class="col-2 d-flex align-items-center">';
                        if(item_1.product_image != undefined && item_1.product_image != ''){
                            html += '         <img src="'+asset_url+item_1.product_image+'" class="img-fluid py-1 img_200" alt="">';
                        }
                        html += '    </div>';
                        html += '    <div class="col-1 d-flex align-items-center justify-content-center">';
                        html += '    </div>';
                        html += '</div>';
                        
                    });         
                }
                html += '   </div>';
                html += '</div>';
                    
            });  
            
            $('#items-list-container').html(html);
            $('#total_invoice').html(parseFloat(PaymentRef.totalInvoiceAmount).toFixed(2));
            
        }

        PaymentRef.loadCustomerTempItems = function() {
        
            if ( $.fn.DataTable.isDataTable('#temp_customer_items_tbl') ) {
                $('#temp_customer_items_tbl').DataTable().destroy();
            }

            PaymentRef.gridClientsTbl = $('#temp_customer_items_tbl').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                "ajax": {
                    "type" : "POST",
                    "url" : "{{ route('stylist.payment.member_temp_items') }}",
                    "data": function ( d ) {
                        d._token = $('meta[name="csrf-token"]').attr('content'),
                        d.member_id = PaymentRef.selectedMemberId
                        d.temp_invoice_item_ids = JSON.stringify(PaymentRef.selectedInvoiceItemsIds)
                    }, 
                    "dataSrc" : function (json) {
                        PaymentRef.allTempInvoiceItems = json.data;
                        return json.data;
                    }   
                },
                "columns": [
                        {
                            "data": "value",
                            render: function(e, t, a, s) {
                                return "display" === t && (e = '<div class="checkbox"><input type="checkbox" value="'+a.temp_invoice_item_id+'" class="dt-checkboxes invoice-item-checkbox"><label></label></div>'),
                                e
                            },
                            checkboxes: {
                                selectRow: !0,
                                selectAllRender: '<div class="checkbox"><input type="checkbox" class="dt-checkboxes invoice-item-checkbox" checked=""><label></label></div >'
                            }
                        }, 
                        { "data": "product_name",
                            "render": function ( data, type, row ) {
                                return row.product_name+' - '+row.stylegrid_title;
                            }
                        },
                        { "data": "amount" },
                ],
                columnDefs: [
                    {
                        orderable: !1,
                        targets: [0],
                        width: "10%",
                    }
                ],
                select: "multi",
            });

        }

        PaymentRef.initEvents();
    };

</script>
