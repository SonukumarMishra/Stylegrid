@include("stylist.postloginview.partials.header.header")
@include("stylist.postloginview.partials.navigate.navigate")
 <!-- BEGIN: Content-->
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class="row my-3">
                <div class="col-md-8">
                    <h1>Request submitted</h1>
                    <h3>Your request has now been submitted. You will be notified when a your product has been
                        sourced.</h3>
                </div>
                <div class="col-md-4 quick-link text-right">
                    <span class="mr-5"><a hrf="">Quick Link</a></span>
                    <div class="row justify-content-end my-2">
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Chat.svg')}}" alt=""></a>
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/File Invoice.svg')}}" alt=""></a>
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a>

                    </div>

                </div>
            </div>
            <!-------------------- fulfil souring request--------->
            <div id="browse-soursing" class="mt-5">
                
                <div class="row align-items-center justify-content-center mt-5 pt-5" id="request-submit">
                    <div class="col-12">
                        <h1>Your product request has been submitted.</h1>
                    </div>
                    <div class="col-12">
                        <h3 class="px-5 pt-2">Your request has now been submitted. You will be notified when a</h3>
                    </div>

                    <div class="col-12">
                        <h3>your product has been sourced.</h3>
                    </div>
                    <div class="col-12 text-center">
                        <img src="{{asset('stylist/app-assets/images/gallery/TickBox.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-12 text-center mt-3">
                        <a href="/stylist-sourcing"><button class="back-dashboard px-2">Back to dashboard</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include("stylist.postloginview.partials.footer.footerjs")