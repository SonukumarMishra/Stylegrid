@include('stylist.postloginview.partials.header.header')
@include('stylist.postloginview.partials.navigate.navigate')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- BEGIN: Content-->
<style>
    .mjcheckinput {
        opacity: 0;
        margin-left: -50px;
    }

    .mjcheckatag {
        position: absolute;
        left: 45%;
        top: 31%;

    }
</style>
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class="flex-column-reverse flex-md-row mt-lg-3 row">
                <div class="col-md-8">
                    <div class="col-md-8">
                        <h1>Let&apos;s get styling.</h1>
                        <h3>Create a new StyleGrid and send to your clients via PDF or weblink.</h3>
                    </div>
                </div>
                <div class="col-md-4 quick-link text-right">
                    <span class="mr-5"><a hrf="">Quick Link</a></span>
                    <div class="row justify-content-end my-2">
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Chat.svg')}}"
                                alt=""></a>
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/File Invoice.svg')}}"
                                alt=""></a>
                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a>

                    </div>

                </div>
            </div>

            <!-------------------- fulfil souring request--------->
            <div id="main-grid" class="mt-5">
                <div class="row">

                    <div class="col-lg-11">

                        <div class="grid-bg mx-4 mt-3 mb-2 p-4">
                            <a href="grid-design.html">
                                <h1>STYLEGRID</h1>
                            </a>
                            <div class="row">
                                <div class="col-lg-6 d-flex align-items-center">
                                    <input type="text" placeholder="Name your grid here..." class="w-100 name-grid">

                                </div>
                                <div class="col-lg-6">

                                    <div class="Neon Neon-theme-dragdropbox mt-5 mx-lg-4">
                                        <!--   <input name="files[]" id="filer_input2" multiple="multiple" type="file">-->
                                        <div class="Neon-input-dragDrop py-5 px-4 mm">
                                            <div class="Neon-input-inner py-4">
                                                <div class="Neon-input-text">
                                                    <h3>Add your feature image here...</h3>
                                                </div><a class="Neon-input-choose-btn blue"><img
                                                        src="{{asset('stylist/app-assets/images/icons/plus.png')}}"
                                                        alt=""></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-1 d-lg-block d-flex justify-lg-content-start justify-content-center my-auto">

                        <div class='grid-numbering-container'></div>


                        <div class="gradiant-bg text-center mt-1 mx-lg-0 mx-2" id="addGridBtn"><span><img
                                    src="{{asset('stylist/app-assets/images/icons/green-logo.png')}}" class="img-fluid "
                                    alt="">
                            </span></div>

                    </div>
                </div>
                <div class="style-grids-container">
                    <div class="showmodal"></div>
                </div>


            </div>
        </div>
    </div>
</div>


<input type="hidden" value="2" id="randomnum" readonly>
<input type="hidden" value="2" id="randomnum_inner" readonly>

<!--------------------end of fulfil souring request--------->
<!--  Modal -->

@include('stylist.postloginview.partials.footer.footerjs')

@include('scripts.stylist.grid.create')
