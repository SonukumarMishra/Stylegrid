<script>
    window.onload = function() {
        'use strict';

        var SourcingRef = window.SourcingRef || {};
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
        
        SourcingRef.liveRequestsCurrentPage = 1;
        SourcingRef.liveRequestsList = 1;

        SourcingRef.stripeRef = Stripe('{{ config("custom.stripe.publishableKey")}}');

        // SourcingRef.stripeElementstyle = {
        //     base: {
        //         color: "#32325d",
        //     }
        // };

        SourcingRef.initEvents = function() {

            channel.bind("sourcing_updates", function (pusher_data) {

                // Handle pusher events for sourcing request updates
                var payload = pusher_data.data;

                if(pusher_data.action == "{{ config('custom.sourcing_pusher_action_type.offer_received') }}" && payload.notify_user_id == auth_id && payload.notify_user_type == auth_user_type){
                    
                    SourcingRef.getLiveRequests();
                }

            });

            SourcingRef.getLiveRequests();

            $('body').on('click', '.page-link', function (e) {
                e.preventDefault();
                SourcingRef.liveRequestsCurrentPage = $(this).attr('data-page');
                SourcingRef.getLiveRequests();
            });

            
            $('body').on('click', '.pay-invoice-btn', function (e) {

                e.preventDefault();

                var sourcing_id = $(this).data('sourcing-id');
                var amount = $(this).data('amount');
                
                var sourcing_dtls = getDetailsFromObjectByKey(SourcingRef.liveRequestsList, sourcing_id, 'id');
                
                if(sourcing_dtls.sourcing_invoice != undefined && sourcing_dtls.sourcing_invoice != ''){

                    $('#modal_sourcing_payment_invoice_title').html('Pay invoice for '+sourcing_dtls.p_name);

                    SourcingRef.getStripePaymentIntent(amount);

                }
                
            });

            $('body').on('click', '#sourcing_payment_invoice_frm_btn', function (e) {
                e.preventDefault();
                SourcingRef.confirmStripePaymentIntent();
            });
            
        }
       
        
        SourcingRef.getStripePaymentIntent = function(amount) {

            var formData = new FormData();            
            formData.append('amount', amount);

            window.getResponseInJsonFromURL('{{ route("stripe_create_payment_intent") }}', formData, (response) => {
               
               $('#live_requests_tbl_container').html('');
               
               if (response.status == '1') {

                    SourcingRef.clientSecret = response.data.client_secret;

                    SourcingRef.renderInvoiceCheckoutUI();

               } else {
                   showErrorMessage(response.message);
                   return false;
               }
           }, processExceptions, 'POST');

        }

        SourcingRef.renderInvoiceCheckoutUI = function(e) {

            var options = {
                clientSecret: SourcingRef.clientSecret,
                // Fully customizable with appearance API.
                appearance: {/*...*/},
            };

            const elements = SourcingRef.stripeRef.elements(options);
            SourcingRef.paymentElement = elements.create('payment');
            SourcingRef.paymentElement.mount('#payment-element');

            $('#sourcing_payment_invoice_modal').modal('show');

        }

        SourcingRef.confirmStripePaymentIntent = function() {

            SourcingRef.stripeRef
                .confirmCardPayment(SourcingRef.clientSecret, {
                    payment_method: {
                        card: SourcingRef.paymentElement,
                        // billing_details: {
                        //     name: 'Jenny Rosen',
                        // },
                    },
                })
                .then(function(result) {
                    console.log(result);
                    // Handle result.error or result.paymentIntent
                });

        }

        SourcingRef.getLiveRequests = function(e) {
            
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('page', SourcingRef.liveRequestsCurrentPage);

            window.getResponseInJsonFromURL('{{ route("member.sourcing.live.requests") }}', formData, (response) => {
               
                $('#live_requests_tbl_container').html('');
                
                if (response.status == '1') {

                    $('#live_requests_tbl_container').html(response.data.view);

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
                            
                            pagination_html += '<li class="page-item '+(list.active ? 'active' : (list.url == null ? 'disabled' : '') )+'"><a class="page-link" href="#" data-page="'+url_page+'">'+list.label+'</a></li>';

                        });

                        pagination_html += '</ul>';
                        pagination_html += '</nav>';
                            
                        $('#live_requests_pagination_container').html(pagination_html);

                    }

                    SourcingRef.liveRequestsList = response.data.json.list.data;

                } else {
                    showErrorMessage(response.message);
                    return false;
                }
            }, processExceptions, 'POST');
           
        };

        SourcingRef.initEvents();
    };

</script>
