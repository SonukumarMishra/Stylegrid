<script>
    window.onload = function() {
        'use strict';

        var ProfileRef = window.ProfileRef || {};
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

        ProfileRef.initEvents = function() {

            ProfileRef.getBillingDetailes();

            $('body').on('click', '.cancel-subscription', function(e) {

                e.preventDefault();

                var user_subscription_id = $(this).data('user-subscription-id');

                $('#user_subscription_id').val(user_subscription_id);
                $('#error_message_box').html('');
                $('#cancelSubscriptionModal').modal('show');

            });


            $('body').on('click', '.download-invoice',function(e){

                e.preventDefault();

                var url = $(this).data('path');

                downloadFromUrl(url, $(this).data('file-name'));

            });

            $('#reason_for_cancellation').change(function(){
                $('#error_message_box').html('');
            })

            $('body').on('click', '#cancel_membership', function(e) {

                e.preventDefault();

                $('#error_message_box').html('');

                var reason_for_cancellation=$('#reason_for_cancellation').val();

                if(reason_for_cancellation!=''){

                    showLoadingDialog();

                    var formData = new FormData();            
                    formData.append('user_subscription_id', $('#user_subscription_id').val());
                    formData.append('reason_for_cancellation', reason_for_cancellation);
                    formData.append('user_id', $('#user_id').val());
                    formData.append('user_type',  $('#user_type').val());

                    window.getResponseInJsonFromURL('{{ route("admin.member.subscription.cancel") }}', formData, (response) => {

                        hideLoadingDialog();
                        
                        if (response.status == '1') {

                            showSuccessMessage(response.message);
                            $('#cancelSubscriptionModal').modal('hide');
                            ProfileRef.getBillingDetailes();

                        } else {
                        
                            showErrorMessage(response.message);
                        }

                    }, processExceptions, 'POST');

                }else{
                    $('#error_message_box').html('Please select reason of cancellation.');
                    return false;
                }
            });

            $('#member_favroute_brand_table').DataTable({
                "bLengthChange": false,
                "pageLength":5,
                "searching": false,
                "columnDefs": [
                    { orderable: false, targets: 1 }
                ],
            });

            $('#member-order-list').DataTable({
                "bLengthChange": false,
                "pageLength":10,
                "searching": false,
                "columnDefs": [
                    { orderable: false, targets: 1 }
                ],
            });  


        }
          
        ProfileRef.getBillingDetailes = function(e) {
        
            $('#billing-tab-container').html('');

            showSpinner('#billing-tab-container', 'lg');

            var formData = new FormData();            
            formData.append('user_id', $('#user_id').val());
            formData.append('user_type',  $('#user_type').val());

            window.getResponseInJsonFromURL('{{ route("admin.member.subscription.billing") }}', formData, (response) => {

                hideSpinner('#billing-tab-container');
   
                if (response.status == '1') {

                    $('#billing-tab-container').append(response.data.view);
                    ProfileRef.loadInvoiceHistoryTable();
                    
                } else {
                    showErrorMessage(response.message);
                }
             
            }, processExceptions, 'POST');
           
        };
        
        ProfileRef.loadInvoiceHistoryTable = function() {
        
            if ( $.fn.DataTable.isDataTable('#billing_history_tbl') ) {
                $('#billing_history_tbl').DataTable().destroy();
            }

            ProfileRef.gridClientsTbl = $('#billing_history_tbl').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                "ajax": {
                    "type" : "POST",
                    "url" : "{{ route('admin.member.subscription.invoice.history') }}",
                    "data": function ( d ) {
                        d._token = $('meta[name="csrf-token"]').attr('content'),
                        d.user_id = $('#user_id').val(),
                        d.user_type = $('#user_type').val()
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

                                if(row.is_paid == 1){
                                    
                                    html += 'Paid';

                                }else if(row.is_paid == 0){
                                    
                                    html += 'Pending';

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
    
        ProfileRef.initEvents();

    };

</script>
