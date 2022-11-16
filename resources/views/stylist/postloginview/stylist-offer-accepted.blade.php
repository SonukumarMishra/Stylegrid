@include("stylist.postloginview.partials.header.header")
@include("stylist.postloginview.partials.navigate.navigate")
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class="row my-3">
                <div class="col-md-8">
                    <h1>Congratulations! You have accepted an offer.</h1>
                    <h3>You are one step closer to receving your dream product. The stylist who is fufilling your
                        request has been notified and will be in touch shortly. Feel free to drop them a message
                        now.</h3>
                </div>
                <div class="col-md-4 quick-link text-right">
                    <span class="mr-5"><a hrf="">Quick Link</a></span>
                    <div class="row justify-content-end mr-2 my-2">
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Chat.svg')}}" alt=""></a>
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/File Invoice.svg')}}" alt=""></a>
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a>
                    </div>

                </div>
            </div>
            <!-------------------- fulfil souring request--------->
            <div id="create-grid-1" class="mt-2">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="accept-grid-img1">
                            <div class="layer-1">
                                <div class="row bottom-text w-100">
                                    <div class="col-md-8 mb-2">
                                        <h1 class="mb-0 ml-2">Say hello to your product sourcer</h1>
                                        <p class="mt-1 ml-2">Say hello ahead of finalising your order.</p>
                                    </div>
                                    <div class="col-md-4 text-center mt-lg-2 mb-lg-0 mb-2">
                                        <a href="#"><button class="go-to-grid-btn mt-4 px-2">Chat Now</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-lg-0 mt-2">
                        <div class="accept-grid-img2">
                            <div class="layer-1">
                                <div class="row bottom-text w-100">
                                    <div class="col-md-8 mb-2">
                                        <h1 class="mb-0 ml-2">Submit another request</h1>
                                        <p class="mt-1 ml-2">Submit another sourcing request.</p>
                                    </div>
                                    <div class="col-md-4  text-center mt-lg-2 mb-lg-0 mb-2">
                                        <a href="#"><button class="go-to-grid-btn mt-4 px-2">Make Request</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row justify-content-center">
                    <a href="{{url('/stylist-sourcing')}}"><button class="back-to-client-dash">Back to dashboard</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@include("stylist.postloginview.partials.footer.footerjs")