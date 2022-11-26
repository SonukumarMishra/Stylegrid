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
</body>

<!-- BEGIN: Vendor JS-->
<script src="{{ asset('member/dashboard/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('member/dashboard/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
<script src="{{ asset('member/dashboard/app-assets/js/core/app.js') }}" type="text/javascript"></script>

{{-- <script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> --}}

<script src="{{ asset('member/dashboard/app-assets/js/core/libraries/jquery_3_6.min.js') }}"></script>
<script src="{{ asset('member/dashboard/app-assets/js/core/libraries/jquery_ui_1_13.min.js') }}"></script>
<script src="{{ asset('member/dashboard/app-assets/js/core/libraries/bootstrap_3.4.min.js') }}"></script>
<script src="{{ asset('member/dashboard/app-assets/js/core/libraries/jquery_validate_1_19_5.min.js') }}" ></script>
<script src="{{ asset('extensions/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('extensions/toastr/js/toastr.js') }}"></script>
<script src="{{ asset('extensions/sweetalert/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('extensions/moment/js/moment.min.js') }}"></script>

<!-- END: Theme JS-->
<script>

    var constants = {
        csrf_token: '{{ csrf_token() }}',
        base_url: '{{ URL::to("/") }}',
        current_url:'{{str_replace(URL::to("/"),'',URL::current())}}',
    };

    var asset_url = "{{URL::to('/')}}"+'/';

  </script>
  <script src="{{ asset('member/dashboard/assets/js/common.js') }}" type="text/javascript"></script>

  @include('scripts.common_scripts')

  
    {{-- Pusher code for realtime chat --}}

    <script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>

    <script >
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        
        var pusher = new Pusher("{{ config('chat.pusher.key') }}", {
            encrypted: true,
            cluster: "{{ config('chat.pusher.options.cluster') }}",
            authEndpoint: '{{route("member.messanger.pusher.auth")}}',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        });

        var auth_id = {{ Session::get("member_id") }},
            chat_baseurl = constants.base_url+'/',
            auth_user_type = 'member';

        console.log("pusher obj ", pusher);
        // Bellow are all the methods/variables that using php to assign globally.
        const allowedImages = {!! json_encode(config('chat.attachments.allowed_images')) !!} || [];
        const allowedFiles = {!! json_encode(config('chat.attachments.allowed_files')) !!} || [];
        const getAllowedExtensions = [...allowedImages, ...allowedFiles];
        const getMaxUploadSize = {{ config('chat.attachments.max_upload_size') * 1048576 }};
    </script>
      
    @include('scripts.member.messanger.index')

</html>