<div class="modal" id="acceptOffer" tabindex="-1" role="dialog" aria-labelledby="acceptLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content pt-1">
                    <div class="mr-2">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body py-2">
                        <h1>Are you sure you’d like to accept this offer?</h1>
                        <p class="px-3">Once you have accepted this offer you will be able to chat to the stylist who
                            submitted it.
                            They will be shown in your messenger tab and the order can be completed there.</p>
                        <h6>Accept offer?</h6>
                        <div class="row justify-content-center mt-2">
                            <div>
                              <a href="javascript:void(0)"><button class="accept-btn" id="accept-offer-btn">Accept Offer</button></a>
                              <input type="hidden" id="selected_offer_id">
                            </div>

                            <div><a href=""><button class="back-btn ml-2" type="button" class="close" data-dismiss="modal" aria-label="Close">Go Back</button></a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal" id="declineOffer" tabindex="-1" role="dialog" aria-labelledby="declineLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content pt-1">
                    <div class="mr-2">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body py-2">
                        <h1>Are you sure you&apos;d like to decline this offer?</h1>
                        <p class="px-3">Once you have declined this offer, your request will return to our fufillment
                            database for
                            other stylists and shoppers to submit offers.</p>
                        <h6>Decline offer?</h6>
                        <div class="row justify-content-center mt-2">
                            <div>
                                <a href="javascript:void(0)">
                                    <button class="decline-btn" id="decline-offer-btn">Decline Offer</button>
                                </a>
                                <input type="hidden" id="decline_offer_id">
                            </div>
                            <div><a href=""><button class="back-btn ml-2 " type="button" class="close" data-dismiss="modal" aria-label="Close">Go Back</button></a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
<div class="modal" id="sourceConfirmationPopUp" tabindex="-1" role="dialog" aria-labelledby="acceptLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content pt-1">
                    <div class="mr-2">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body py-2">
                        <h1>Are you sure you want to add this source?</h1>
                        <div class="row justify-content-center mt-2">
                            <div><a href="javascript:void(0)" id="add-source-confirm-button"><button class="accept-btn">YES
                                        </button></a></div>
                            <div><a href=""><button class="back-btn ml-2" type="button" class="close" data-dismiss="modal" aria-label="Close">No</button></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body><!-- BEGIN: Vendor JS-->
<script src="{{ asset('stylist/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('stylist/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
<script src="{{ asset('stylist/app-assets/js/core/app.js') }}" type="text/javascript"></script>
<!-- END: Theme JS-->
<!---->

<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    var constants = {
        base_url:"{{URL::to('/')}}",
        current_url:'{{str_replace(URL::to("/"),'',URL::current())}}',
        csrf_token: '{{ csrf_token() }}',
    };
  </script>
 
  <script src="{{asset('stylist/assets/js/common.js')}}"></script>

</html>


