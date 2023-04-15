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



    .style-grid-block-input-file{

        z-index: 999;

        opacity: 0;

        width: auto !important;

        height: 200px;

        position: absolute;

        right: 0px;

        left: 40px;

        margin-right: auto;

        margin-left: auto;

        cursor: pointer;

    }

    .Neon-input-choose-btn{
        padding : 0 !important;
    }

    .Neon-input-dragDrop{
        padding : 0 !important;
        overflow: hidden;
    }

    .p_25{
        padding: 25px !important;
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

            <div id="create-grid" class="mt-5">



                <form action="{{ route('stylist.grid.save') }}" method="POST" id="stylegrid_main_frm">



                    <input type="hidden" name="stylegrid_json">



                    <div class="row">



                        <div class="col-lg-11">



                            <div class="grid-bg mx-4 mt-3 mb-2 p-4">

                                <a href="grid-design.html">

                                    <h1>STYLEGRID</h1>

                                </a>

                                <div class="row">

                                    <div class="col-lg-6 d-flex align-items-center">

                                        <div class="col-12">

                                            <input type="text" name="title" placeholder="Name your grid here..." class="w-100 name-grid" required>

                                        </div>

                                    </div>

                                    <div class="col-lg-6">



                                        <div class="Neon Neon-theme-dragdropbox mt-5 mx-lg-4">

                                            <input name="feature_image" class="style-grid-block-input-file" data-img-preview-selector=".feature-image-src" type="file" accept="image/png,image/jpg,image/jpeg,image/gif" >

                                            <div class="Neon-input-dragDrop d-flex align-items-center height_300 style-grid-main-feature-image-block p_25">

                                                <div class="Neon-input-inner">

                                                    <div class="Neon-input-text">

                                                        <h3 class="style-grid-main-feature-image-title">Add your feature image here...</h3>

                                                    </div>

                                                    <a class="Neon-input-choose-btn blue mt-2"> <img src="{{asset('stylist/app-assets/images/icons/plus.png')}}" class="feature-image-src img_preview"></a>

                                                </div>

                                            </div>

                                            <img src="{{asset('stylist/app-assets/images/icons/Empty-Trash.png')}}" class="img-fluid delete-grid-feature-img d-none" data-index="0" style="position: absolute;top: 0;" alt=""/>

                                            <p style="font-family: 'Genos';">Image size recommendadtion is 1170px X 570px(min) </p>

                                        </div>



                                    </div>

                                </div>

                            </div>



                        </div>



                        <div class="col-lg-1 d-lg-block d-flex justify-lg-content-start justify-content-center my-auto">

                            <div class='grid-numbering-container'></div>



                            <div class="gradiant-bg text-center mt-1 mx-lg-0 mx-2" id="add_grid_btn">

                                <span><img src="{{asset('stylist/app-assets/images/icons/green-logo.png')}}" class="img-fluid" alt=""></span>

                            </div>

                        </div>

                        

                    </div>

                    <div class="style-grids-container">

                    </div>

                    <div class="row col-12 justify-content-end mb-3 mt-2">



                        <div class="">

                            <button class="submit-request" id="stylegrid_main_frm_btn">Save Stylegrid</button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<!--------------------end of fulfil souring request--------->



<div class="modal" id="grid_item_details_modal" tabindex="-1" role="dialog" style="top: 5% !important;">

    <div class="modal-dialog" role="document">

        <div class="modal-content pt-1">

            <div class="mr-2">



                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body py-2">

                <h1 class="text-center modal-submit-request">Product Details <span id="modal_stylegrid_item_title"></span></h1>

                <div id="browse-soursing" class="mt-2">



                    <form action="#" method="POST" id="stylegrid_item_frm">



                        <input type="hidden" id="modal_stylegrid_index">

                        <input type="hidden" id="modal_stylegrid_item_index">

                        <div class="row align-items-center">

                            <div class="col-lg-6 ">

                                <div class="Neon Neon-theme-dragdropbox">

                                    <input name="product_image" class="style-grid-block-input-file" type="file" accept="image/png,image/jpg,image/jpeg,image/gif"   data-img-preview-selector=".item-modal-image-src" data-width="400"  data-height="400">

                                    <div class="Neon-input-dragDrop d-flex align-items-center height_300 p_25" id="modal_product_img_block">

                                        <div class="Neon-input-inner">

                                            <div class="Neon-input-text ">

                                                <h3 id="item-modal-image-title">Upload an image of the product here</h3>

                                            </div>

                                            <a class="Neon-input-choose-btn blue"><img src="{{asset('stylist/app-assets/images/icons/plus.png')}}" class="item-modal-image-src img_preview" data-image-selected="0" id="product_image_preview" alt=""></a>

                                        </div>

                                    </div>

                                    <div class="text-danger text-center" id="modal_product_img_error">

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-6">

                                <div class="p-2 lg-border-left">

                                    <div class="form-group">

                                        <label for="">Enter the name of the product here:</label>

                                        <input type="text" name="product_name" class="form-control submit-input"

                                             placeholder="Enter product name..."  required>



                                    </div>

                                    <div class="form-group">

                                        <label for="">Tell us the brand of the product:</label>

                                        <input type="text"  name="product_brand" class="form-control submit-input"

                                             placeholder="Enter brand name..."  required>



                                    </div>

                                    <div class="form-group">

                                        <label for="">What is the product type? (Bag, Dress, Heels etc)</label>

                                        <input type="text"  name="product_type" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" class="form-control submit-input"

                                             placeholder="Enter product type..."  required>



                                    </div>

                                    <div class="form-group">

                                        <label for="">Enter the price of product here:</label>

                                        <input type="number" name="product_price" min="0" class="form-control submit-input"

                                             placeholder="Enter product price..." required>



                                    </div>

                                    <div class="form-group">

                                        <label for="">Does the product have a size? Leave blank if none.</label>

                                        <input type="text" name="product_size" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)"  maxlength="25"  class="form-control submit-input"

                                             placeholder="Enter product size...">



                                    </div>

                                    <!-- <div class="form-group">

                                        <label for="">What region the product needs to be delivered to:</label>

                                        <input type="text" class="form-control submit-input" 

                                            placeholder="Enter region...">



                                    </div>

                                    <div class="form-group">

                                        <label for="">When do you require the product by?</label>

                                        <input type="text" class="form-control submit-input" id="" placeholder="Enter due date...">

                                    </div> -->                                    

                                </div>



                            </div>

                        </div>

                        <div class="row justify-content-center">

                            <button class="submit-request" id="stylegrid_item_frm_btn">Save</button>

                            <button class="back-btn ml-2" class="close" data-dismiss="modal" aria-label="Close">Close</button>

                        </div>

                    </form>

                </div>



            </div>



        </div>

    </div>

</div>



@include('stylist.postloginview.partials.footer.footerjs')

@include('scripts.stylist.grid.create_js')

