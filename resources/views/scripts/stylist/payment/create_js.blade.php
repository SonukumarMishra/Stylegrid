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

                if($('#customer_id').val() == ''){

                    showErrorMessage('Please select customer');
                    return false;
                }

                PaymentRef.selectedMemberId = $('#customer_id').val();
                $('#customer_items_modal').modal('show');
                PaymentRef.loadCustomerTempItems();

            });

            $('body').on('click', '#invoice_frm_btn', function(e) {

                e.preventDefault();

                if($("#invoice_frm").valid()){

                    var formData = new FormData();            
                    formData.append('association_id', auth_id);
                    formData.append('association_type_term', auth_user_type);
                    formData.append('invoice_amount', $('#sourcing_invoice_frm input[name="invoice_amount"]').val());
                    formData.append('sourcing_id', $('#sourcing_invoice_frm input[name="sourcing_id"]').val());

                    window.getResponseInJsonFromURL('{{ route("stylist.sourcing.generate_invoice") }}', formData, (response) => {
                    
                        if (response.status == '1') {

                            $('#sourcing_invoice_modal').modal('hide');
                            showSuccessMessage(response.message);
                            PaymentRef.getLiveRequests();

                        } else {
                            showErrorMessage(response.message);
                        }
                    }, processExceptions, 'POST');
                    
                }
            });

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
                        // d.member_ids = JSON.stringify(PaymentRef.selectedClientIds)
                    }, 
                    "dataSrc" : function (json) {
                        return json.data;
                    }   
                },
                "columns": [
                        {
                            "data": "value",
                            render: function(e, t, a, s) {
                                return "display" === t && (e = '<div class="checkbox"><input type="checkbox" value="'+e+'" class="dt-checkboxes"><label></label></div>'),
                                e
                            },
                            checkboxes: {
                                selectRow: !0,
                                selectAllRender: '<div class="checkbox"><input type="checkbox" class="dt-checkboxes" checked=""><label></label></div >'
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
