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
        
        PaymentRef.paymentListCurrentPage = 1;

        PaymentRef.initEvents = function() {

            PaymentRef.getPaymentList();
          
            $('body').on('click', '.page-link', function (e) {
                e.preventDefault();

                PaymentRef.paymentListCurrentPage = $(this).attr('data-page');
                PaymentRef.getPaymentList();

            });

            $('body').on('click', '.generate-invoice-btn', function (e) {
                e.preventDefault();
                
                $('#modal_sourcing_invoice_title').html($(this).data('title'));
                $('#sourcing_invoice_frm input[name="sourcing_id"]').val($(this).data('sourcing-id'));
                $('#sourcing_invoice_frm input[name="invoice_amount"]').val($(this).data('amount'));
                $('#sourcing_invoice_modal').modal('show');

            });

        }
                
        PaymentRef.getPaymentList = function(e) {
        
            var formData = new FormData();            
            formData.append('stylist_id', auth_id);
            formData.append('page', PaymentRef.paymentListCurrentPage);
           
            window.getResponseInJsonFromURL('{{ route("stylist.payment.list") }}', formData, (response) => {
               
                $('#payment_list_tbl_container').html('');
                
                if (response.status == '1') {

                    $('#payment_list_tbl_container').html(response.data.view);

                    if(response.data.json.list.links != undefined){

                        var pagination_html = '';

                        pagination_html += '<nav>';
                        pagination_html += '<ul class="pagination">';

                        $.each(response.data.json.list.links, function(indexInArray, list) {

                            var url_page = '';

                            if(list.url != null){
                                var url = list.url;
                                var qs = url.substring(url.indexOf('?') + 1).split('&');
                                for(var i = 0, result = {}; i < qs.length; i++){
                                    qs[i] = qs[i].split('=');
                                    result[qs[i][0]] = decodeURIComponent(qs[i][1]);
                                }
                                url_page = result.page;
                            }
                            
                            pagination_html += '<li class="page-item '+(list.active ? 'active' : (list.url == null ? 'disabled' : '') )+'"><a class="page-link" href="#" data-table="live_requests" data-page="'+url_page+'">'+list.label+'</a></li>';

                        });

                        pagination_html += '</ul>';
                        pagination_html += '</nav>';
                            
                        $('#payment_list_pagination_container').html(pagination_html);

                    }

                } else {
                    showErrorMessage(response.message);
                }
            }, processExceptions, 'POST');
           
        };


        PaymentRef.initEvents();
    };

</script>
