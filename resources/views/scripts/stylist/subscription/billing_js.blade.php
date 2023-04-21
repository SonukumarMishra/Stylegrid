<script>
    window.onload = function() {
        'use strict';

        var BillingRef = window.BillingRef || {};
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

        BillingRef.initEvents = function() {

            BillingRef.getBillingDetailes();

            $('body').on('click', '.cancel-subscription', function(e) {

                e.preventDefault();
                var user_subscription_id = $(this).data('user-subscription-id');

                var msg = 'If you cancel now, you will still have access to '+$(this).data('sub-name')+' until your subscription ends on '+$(this).data('sub-end-date')+'.';
               
                confirmDialogMessage('Cancel Subscription?', msg, 'Cancel Subscription', () => {

                    showLoadingDialog();

                    var formData = new FormData();            
                    formData.append('user_subscription_id', user_subscription_id);
                    
                    window.getResponseInJsonFromURL('{{ route("stylist.subscription.cancel") }}', formData, (response) => {

                        hideLoadingDialog();
                        
                        if (response.status == '1') {

                            BillingRef.getBillingDetailes();


                        } else {
                           
                            showErrorMessage(response.message);
                        }

                    }, processExceptions, 'POST');
                                    

                }, '', 'Not Now');

            });

            $('body').on('click', '.download-invoice',function(e){

                e.preventDefault();

                var url = $(this).data('path');

                downloadFromUrl(url, $(this).data('file-name'));

            });


        }
          
        BillingRef.getBillingDetailes = function(e) {
        
            $('#browse-soursing').html('');

            showSpinner('#browse-soursing', 'lg');

            window.getResponseInJsonFromURL('{{ route("stylist.subscription.billing.content") }}', '', (response) => {

                hideSpinner('#browse-soursing');
   
                if (response.status == '1') {

                    $('#browse-soursing').append(response.data.view);
                    BillingRef.loadInvoiceHistoryTable();
                    
                } else {
                    showErrorMessage(response.message);
                }
             
            }, processExceptions, 'POST');
           
        };
        
        BillingRef.loadInvoiceHistoryTable = function() {
        
            if ( $.fn.DataTable.isDataTable('#billing_history_tbl') ) {
                $('#billing_history_tbl').DataTable().destroy();
            }

            BillingRef.gridClientsTbl = $('#billing_history_tbl').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                "ajax": {
                    "type" : "POST",
                    "url" : "{{ route('stylist.subscription.invoice.history') }}",
                    "data": function ( d ) {
                        d._token = $('meta[name="csrf-token"]').attr('content')
                    }, 
                    "dataSrc" : function (json) {
                        return json.data;
                    }   
                },
                "columns": [
                        { "data": "created_at",
                            "render": function ( data, type, row ) {
                                return row.created_at != null && row.created_at != '' ? formatDateValue(row.created_at) : '-';
                            }
                        },
                        { "data": "subscription_name" },
                        { "data": "subscription_type",
                            "render": function ( data, type, row ) {

                                var html = '';

                                if(row.subscription_type == '{{config("custom.subscription.types.trial")}}'){
                                    html = 'Trial';
                                }else if(row.subscription_type == '{{config("custom.subscription.types.paid")}}'){
                                    html = 'Paid';
                                }
                                return html;
                            }
                        },
                        { "data": "price",
                            "render": function ( data, type, row ) {
                                return '£'+row.price;
                            }
                        },
                        { "data": "start_date",
                            "render": function ( data, type, row ) {
                                return row.start_date != null && row.start_date != '' ? formatDateValue(row.start_date) : '-';
                            }
                        },
                        { "data": "end_date",
                            "render": function ( data, type, row ) {
                                return row.end_date != null && row.end_date != '' ? formatDateValue(row.end_date) : '-';
                            }
                        },
                        { "data": "cancelled_on",
                            "render": function ( data, type, row ) {
                                return row.cancelled_on != null && row.cancelled_on != '' ? formatDateValue(row.cancelled_on) : '-';
                            }
                        },
                        { "data": "reason_of_cancellation" },
                        { "data": "subscription_status",
                            "render": function ( data, type, row ) {
                                var html = '';

                                if(row.subscription_status == '{{ config("custom.subscription.status.active")}}'){
                                    
                                    html += '<span class="text-success">Active</span>';

                                }else if(row.subscription_status == '{{ config("custom.subscription.status.expired")}}'){
                                    
                                    html += '<span class="text-danger">Expired</span>';

                                }else if(row.subscription_status == '{{ config("custom.subscription.status.cancelled")}}'){
                                    
                                    html += '<span class="text-danger">Cancelled</span>';

                                }else if(row.subscription_status == '{{ config("custom.subscription.status.pending")}}'){
                                    
                                    html += '<span class="text-warning">Pending</span>';

                                }

                                return html;
                            }
                        },
                        { "data": "is_paid",
                            "render": function ( data, type, row ) {
                                var html = '';

                                if(row.subscription_type == '{{config("custom.subscription.types.paid")}}'){
                                    if(row.is_paid == 1){
                                        
                                        html += 'Paid';

                                    }else if(row.is_paid == 0){
                                        
                                        html += 'Pending';

                                    }
                                    
                                }

                                return html;
                            }
                        },
                        { "data": "invoice_pdf",
                            "render": function ( data, type, row ) {

                                var html = '';
                                if(row.invoice_pdf){
                                    html += '<a href="#" class="btn btn-sm btn-outline-primary rounded-pill download-invoice" data-path="'+asset_url+row.invoice_pdf+'">Download</a>';
                                }
                                return html;
                            }
                        }
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
    
        BillingRef.initEvents();

    };

</script>
