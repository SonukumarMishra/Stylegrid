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

        PaymentRef.stripeRef = Stripe('{{ config("custom.stripe.publishableKey")}}');
        
        PaymentRef.totalInvoiceAmount = 0;
        PaymentRef.sourcingId = 0;
        PaymentRef.productInvoiceId = 0;

        PaymentRef.stripeElementstyle = {
            base: {
                color: "#32325d",
            }
        };


        PaymentRef.initEvents = function() {

            PaymentRef.getPaymentList();
          
            $('body').on('click', '.page-link', function (e) {
                e.preventDefault();

                PaymentRef.paymentListCurrentPage = $(this).attr('data-page');
                PaymentRef.getPaymentList();

            });

            $('body').on('click', '.pay-invoice-btn', function (e) {

                e.preventDefault();

                var title = $(this).data('title');
                var amount = $(this).data('amount');

                $('#modal_sourcing_payment_invoice_title').html('Pay invoice for '+title+' - £'+amount);
                    
                PaymentRef.totalInvoiceAmount = amount;

                PaymentRef.productInvoiceId = $(this).data('invoice-id');

                PaymentRef.renderInvoiceCheckoutUI();


            });

            
            $("#sourcing_payment_invoice_frm").submit(function(event) {

                event.preventDefault();

                if(PaymentRef.cardElement._complete == false){

                    showErrorMessage("Please fill all card details.");

                    return false;

                }else{

                    showSpinner('#sourcing_payment_invoice_frm_btn', 'sm', 'light', 'span');

                    PaymentRef.stripeRef
                        .createToken(PaymentRef.cardElement)
                        .then(function(result) {
                            console.log(result);
                            // Handle result.error or result.paymentMethod
                            if(result.hasOwnProperty("token")){

                                PaymentRef.checkoutStripePayment(result.token.id);
                                
                            }else{
                                showErrorMessage(result.error);
                                hideSpinner('#sourcing_payment_invoice_frm_btn');
                            }

                        });
                }

            });

        }
                
        PaymentRef.checkoutStripePayment = function(payment_method_token) {

            var formData = new FormData();            
            formData.append('amount', PaymentRef.totalInvoiceAmount);
            formData.append('payment_method_token', payment_method_token);
            formData.append('product_invoice_id', PaymentRef.productInvoiceId);
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);

            window.getResponseInJsonFromURL('{{ route("member.order.pay_invoice") }}', formData, (response) => {
            
                hideSpinner('#sourcing_payment_invoice_frm_btn');

            if (response.status == '1') {

                    showSuccessMessage(response.message);
                    PaymentRef.getPaymentList();
                    $('#sourcing_payment_invoice_modal').modal('hide');

            } else {
                showErrorMessage(response.message);
                return false;
            }
            }, processExceptions, 'POST');

        }

        PaymentRef.getPaymentList = function(e) {
        
            var formData = new FormData();            
            formData.append('member_id', auth_id);
            formData.append('page', PaymentRef.paymentListCurrentPage);
           
            window.getResponseInJsonFromURL('{{ route("member.orders.list") }}', formData, (response) => {
               
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


        
        PaymentRef.renderInvoiceCheckoutUI = function(e) {

            $('#card-ui-element').html("");
                            
            $('#sourcing_payment_invoice_modal').modal('show');

            showSpinner('#card-ui-element');

            PaymentRef.stripeElements = PaymentRef.stripeRef.elements();

            PaymentRef.cardElement = PaymentRef.stripeElements.create('card',  {
                                                        style: {
                                                            base: {
                                                                color: "#2E4836",
                                                                fontWeight: 500,
                                                                fontFamily: '"Comfortaa", cursive, "Times New Roman", Times, serif',
                                                                fontSize: "16px",
                                                                fontSmoothing: "antialiased",
                                                                "::placeholder": {
                                                                    color: "#2E4836"
                                                                }
                                                            },
                                                            invalid: {
                                                                color: "#fa755a",
                                                                iconColor: '#fa755a'
                                                            }
                                                        }
                                                    } );

            // Add an instance of the card Element into the `card-ui-element` <div>.
            PaymentRef.cardElement.mount('#card-ui-element');

            PaymentRef.cardElement.on('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            PaymentRef.cardElement.on('ready', function(event) {

                hideSpinner('#card-ui-element');
                
            });

            }

        PaymentRef.initEvents();
    };

</script>
