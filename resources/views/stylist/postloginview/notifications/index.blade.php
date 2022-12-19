@include("stylist.postloginview.partials.header.header")
@include("stylist.postloginview.partials.navigate.navigate")
 <!-- BEGIN: Content-->
 <div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class="mt-lg-3 row">
                <div class="col-8">
                    <h1>Hi</h1>
                    <h3>Notifications.</h3>
                </div>
                <div class="col-4 quick-link text-right">
                    <span class="mr-lg-5"><a hrf="">Quick Link</a></span>
                    <div class="d-flex justify-content-end my-2">
                        <a href="" class="mx-lg-1"><img src="{{asset('stylist/app-assets/images/icons/Chat.svg')}}" alt=""></a>
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/File Invoice.svg')}}" alt=""></a>
                        <a href="" class="mx-lg-1"><img src="{{asset('stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a>

                    </div>

                </div>
            </div>
            
            <!--------------------souring hub--------->
            <div class="mt-5">
                <div class="row" id="notifications_container">
                    
                </div>
            </div>
            <!--------------------end of souring Hub--------->
        </div>
    </div>
    
    {{-- page scripts --}}
    @section('page-scripts')

        @include('scripts.stylist.notifications_js')

    @endsection

</div>
@include("stylist.postloginview.partials.footer.footerjs")