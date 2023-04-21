<script>
    window.onload = function() {
        'use strict';

        var SubscriptionRef = window.SubscriptionRef || {};
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

        SubscriptionRef.stripeRef = Stripe('{{ config("custom.stripe.publishableKey")}}');
        SubscriptionRef.selectedSubscriptionId = '';

        SubscriptionRef.stripeElementstyle = {
            base: {
                color: "#32325d",
            }
        };

        SubscriptionRef.initEvents = function() {

            SubscriptionRef.getSubscriptionPackages();

            $('body').on('click', '.buy-subscription', function(e) {

                e.preventDefault();
            
                SubscriptionRef.selectedSubscriptionId = $(this).data('subscription-id');

                var formData = new FormData();
                formData.append('subscription_id', SubscriptionRef.selectedSubscriptionId);
                
                getResponseInJsonFromURL('{{ route("stylist.subscription.check_already_purchased_cancelled") }}', formData, (response) => {
                    
                    if(response.status == 1){

                        if(response.data.subscription_purchased != undefined && response.data.subscription_purchased == 1){

                            var sub_dtls = response.data.subscription_dtls;

                            $('#payment_modal_title').html('Buy '+$(this).data('title')+' Subscription - £'+$(this).data('price')+' /'+$(this).data('interval-type'));

                            var html = '';
                            html += '<h6 class="text-center text-danger">You have already purchased this subscription on '+formatDateValue(sub_dtls.invoice_date)+' and will be activated on '+formatDateValue(sub_dtls.start_date)+'.</h6>';
                            html += '<h6 class="text-center"><a href="{{route('stylist.subscription.billing.index')}}">Click Here</a>  to view billing details.</h6>';
                            
                            $('#card-ui-element').html(html);

                            $('#stylegrid_item_frm_btn').hide();

                            $('#payment_modal').modal('show');

                        }else if(response.data.subscription_purchased != undefined && response.data.subscription_cancelled == 1){

                            var sub_dtls = response.data.subscription_dtls;

                            $('#payment_modal_title').html('Buy '+$(this).data('title')+' Subscription - £'+$(this).data('price')+' /'+$(this).data('interval-type'));

                            var html = '';
                            html += '<h6 class="text-center text-danger">You\'re '+sub_dtls.subscription_name+' subscription already cancelled on '+formatDateValue(sub_dtls.cancelled_on)+'. Subscription access will end on '+formatDateValue(sub_dtls.end_date)+'.</h6>';
                            html += '<h6 class="text-center"><a href="{{route('stylist.subscription.billing.index')}}">Click Here</a>  to view billing details.</h6>';

                            $('#card-ui-element').html(html);

                            $('#stylegrid_item_frm_btn').hide();

                            $('#payment_modal').modal('show');

                        }else{
                             
                            $('#payment_modal_title').html('Buy '+$(this).data('title')+' Subscription - £'+$(this).data('price')+' /'+$(this).data('interval-type'));

                            $('#card-ui-element').html("");
                            
                            $('#stylegrid_item_frm_btn').show();
                            
                            $('#payment_modal').modal('show');

                            showSpinner('#card-ui-element');

                            SubscriptionRef.stripeElements = SubscriptionRef.stripeRef.elements();

                            SubscriptionRef.cardElement = SubscriptionRef.stripeElements.create('card',  {
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
                            SubscriptionRef.cardElement.mount('#card-ui-element');

                            SubscriptionRef.cardElement.on('change', function(event) {
                                var displayError = document.getElementById('card-errors');
                                if (event.error) {
                                    displayError.textContent = event.error.message;
                                } else {
                                    displayError.textContent = '';
                                }
                            });

                            SubscriptionRef.cardElement.on('ready', function(event) {
                            
                                hideSpinner('#card-ui-element');
                                
                            });
                        }

                    }else{
                        showErrorMessage(response.message);
                        return false;
                    }

                }, processExceptions);
               
                
            });

            $("#subscription-buy-form").submit(function(event) {

                event.preventDefault();

                if(SubscriptionRef.cardElement._complete == false){

                    showErrorMessage("Please fill all card details.");

                    return false;

                }else{

                    showSpinner('#stylegrid_item_frm_btn', 'sm', 'light', 'span');

                    SubscriptionRef.stripeRef
                        .createPaymentMethod({
                            type: 'card',
                            card: SubscriptionRef.cardElement,
                        })
                        .then(function(result) {

                            // Handle result.error or result.paymentMethod
                            if(result.hasOwnProperty("paymentMethod")){

                                var formData = new FormData();
                                formData.append('subscription_id', SubscriptionRef.selectedSubscriptionId);
                                formData.append('payment_method_id', result.paymentMethod.id);
                                
                                getResponseInJsonFromURL('{{ route("stylist.subscription.buy") }}', formData, (response) => {
                                    
                                    hideSpinner('#stylegrid_item_frm_btn');

                                    if(response.status == 1){

                                        showSuccessMessage(response.message);
                                        SubscriptionRef.getSubscriptionPackages();
                                        $('#payment_modal').modal('hide');

                                    }else{
                                        showErrorMessage(response.message);
                                    }

                                }, processExceptions);
                                
                            }else{
                                showErrorMessage(result.error);
                                hideSpinner('#stylegrid_item_frm_btn');

                            }

                        });
                }

            });
            
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

                            SubscriptionRef.getSubscriptionPackages();
                            
                        } else {
                            showErrorMessage(response.message);
                        }


                    }, processExceptions, 'POST');
                    
                }, '', 'Not Now');

            });

        }
          
        SubscriptionRef.getSubscriptionPackages = function(e) {
        
            var formData = new FormData();            
            formData.append('user_id', auth_id);
            formData.append('user_type', auth_user_type);
            
            $('#subscription_container').html('');

            showSpinner('#subscription_container', 'lg');

            window.getResponseInJsonFromURL('{{ route("stylist.subscription.list") }}', formData, (response) => {

                hideSpinner('#subscription_container');
   
                if (response.status == '1') {

                    $('#subscription_container').append(response.data.view);
                    
                } else {
                    showErrorMessage(response.message);
                }
             
            }, processExceptions, 'POST');
           
        };
        
        SubscriptionRef.initEvents();

    };

</script>
