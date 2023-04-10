@extends('member.dashboard.layouts.default')
@section('content')
<!-- BEGIN: Content-->

<div class="content-wrapper">

    <div class="content-header row">
    </div>
    <div class="content-body">
        <!-- Revenue, Hit Rate & Deals -->
        <div class=" mt-lg-3 row">
            <div class="col-8">
                <h1>Submit sourcing request</h1>
                <h3>Upload an image and add product details of what you need.</h3>
                <!-- <div class="mt-3">
                    <a href=""><button class="make-request">Make New Request</button></a>
                </div> -->
            </div>
            <div class="col-4 quick-link text-right">
                <span class="mr-lg-5"><a hrf="">Quick Link</a></span>
                <div class="d-flex justify-content-end my-2 mr-lg-2">
                    <a href="" class="mx-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/Chat.svg') }}" alt=""></a>
                    <!-- <a href="" class="mx-1"><img src="app-assets/images/icons/File Invoice.svg" alt=""></a> -->
                    <a href="" class="mx-lg-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/Gear.svg') }}" alt=""></a>
                </div>
            </div>
        </div>
        <!--------------------souring hub--------->
        <div id="browse-soursing" class="mt-lg-5 mt-2">
            <div id="message-box"></div>
            <form id="submit-request-form" action="" class=" ">
            @csrf
            <div class="row align-items-center" id="fulfill-request">
                <div class="col-lg-6 ">
                    <div class="Neon Neon-theme-dragdropbox mt-lg-5">
                        <input name="source_image" id="source_image" multiple="multiple"  type="file">
                        <div class="Neon-input-dragDrop py-5" id="source_image_preview_section_dynamic_class">
                            <div class="Neon-input-inner py-4" id="source_image_preview_section">
                                <div class="Neon-input-text ">
                                    <h3>Upload an image of the product here</h3>
                                </div><a class="Neon-input-choose-btn blue"><img  src="{{ asset('member/dashboard/app-assets/images/icons/plus.png') }}" alt="" class="img-fluid" id="image_preview"></a>
                            </div>
                            <div id="image_error" class="error"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-3 lg-border-left ">
                            <div class="form-group">
                                <label for="">Enter the name of the product here:</label>
                                <input type="text" class="form-control submit-input alphaonly"   aria-describedby="emailHelp"
                                    placeholder="Enter product name..."  id="product_name" name="product_name" maxlength="40">
                                <div id="product_name_error" class="error"></div>
                            </div>
                            <div class="form-group">
                                <label for="">Tell us the brand of the product:</label>
                                <input type="text" class="form-control submit-input" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" aria-describedby="emailHelp"
                                    placeholder="Enter brand name..." id="brand" name="brand" maxlength="10">
                                <div id="autsuggestion_section"></div>
                                <div id="brand_error" class="error"></div>
                            </div>
                            <div class="form-group">
                                <label for="">What is the product type? (Bag, Dress, Heels etc)</label>
                                <input type="text" class="form-control submit-input alphaonly" aria-describedby="emailHelp"
                                    placeholder="Enter product type..." id="product_type" name="product_type"  maxlength="10">
                                    <div id="product_type_error" class="error"></div>
                            </div>
                            <div class="form-group">
                                <label for="">Does the product have a size? Leave blank if none.</label>
                                <input type="text" class="form-control submit-input" aria-describedby="emailHelp"
                                    placeholder="Enter product size..." id="product_size" name="product_size" maxlength="4">
                            </div>
                            <div class="form-group">
                                <label for="">What region the product needs to be delivered to:</label>
                                <select id="country" class="form-control submit-input" name="country">
                                    <option value="">Select Country</option>
                                    <?php
                                    foreach($country_list as $country){
                                        ?>
                                        <option value="{{$country->id}}">{{$country->country_name}}</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div id="country_error" class="error"></div>
                            </div>
                            <div class="form-group">
                                <label for="">When do you require the product by?</label>
                                <!-- <input type="text"  onpaste="return false;" onkeydown="return false;" class="form-control submit-input" id="deliver_date" name="deliver_date" placeholder="Enter due date...">
                                 -->
                                  <!-- Date Picker -->
        <div class="form-group mb-4">
          <div class="datepicker date input-group">
            <input type="text" placeholder="Enter due date..." class="form-control submit-input" id="deliver_date" onpaste="return false;" onkeydown="return false;" name="deliver_date">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
            </div>
          </div>
        </div>
        <!-- // Date Picker -->
                                <div id="deliver_date_error" class="error"></div>
                            </div>
                            <button type="button" class="submit-request px-3  mt-2" id="submit-request-btn">Submit request</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
        <!--------------------end of souring Hub--------->
    </div>
</div>
@stop