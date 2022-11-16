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
                    <h1>Submit sourcing request</h1>
                    <h3>Upload an image and add product details of what you need.</h3>
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
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row  text-aligns-center">
                            <h1 class="col-6">Hermes Mini Kelly 20</h1>
                            <h2 class="px-2 mt-1 col-2">Hermes</h2>
                            <a href="" class=" col-4 text-right mt-2"><button class="request-btn px-3">Make
                                    Request</button></a>
                        </div>
                    </div>
                    <!-- Pills navs -->
                    <div class="col-lg-4 d-flex justify-content-end mt-lg-0 mt-2">
                        <ul id="myTab_1" role="tablist" class="nav nav-tabs   flex-sm-row text-center  rounded-nav">
                            <li class="nav-item ">
                                <a id="home-tab" data-toggle="tab" href="#home_1" role="tab" aria-controls="home"
                                    aria-selected="true"
                                    class="nav-link border-0 cyan-blue  font-weight-bold">Home</a>
                            </li>
                            <li class="nav-item ">
                                <a id="Fashion-tab" data-toggle="tab" href="#Fashion_1" role="tab"
                                    aria-controls="Fashion" aria-selected="false"
                                    class="nav-link border-0 cyan-blue font-weight-bold active ">Fashion</a>
                            </li>
                            <li class="nav-item ">
                                <a id="Beauty-tab" data-toggle="tab" href="#Beauty_1" role="tab"
                                    aria-controls="Beauty" aria-selected="false"
                                    class="nav-link border-0 cyan-blue font-weight-bold ">Beauty</a>
                            </li>
                            <li class="nav-item ">
                                <a id="Travel-tab" data-toggle="tab" href="#Travel_1" role="tab"
                                    aria-controls="Travel" aria-selected="false"
                                    class="nav-link border-0 cyan-blue font-weight-bold">Travel</a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div id="message-box"></div>
                <form id="submit-request-form" action="" class=" ">
                    @csrf
                <div class="row align-items-center" id="fulfill-request">
                    
                    
                    <div class="col-lg-6 ">
                        <div class="Neon Neon-theme-dragdropbox mt-lg-5">
                            <input name="source_image" id="source_image" multiple="multiple"  type="file">
                            <div class="Neon-input-dragDrop py-5 px-4">
                                <div class="Neon-input-inner py-4">
                                    <div class="Neon-input-text ">
                                        <h3>Upload an image of the product here</h3>
                                    </div><a class="Neon-input-choose-btn blue"><img  src="{{ asset('member/dashboard/app-assets/images/icons/plus.png') }}" alt="" id="image_preview"></a>
                                    <div id="image_error" class="error"></div>
                                    <div id="divImageMediaPreview"></div>
                                    <a href="javascript:void(0)" style="display: none;" id="image_preview_remove">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-3 lg-border-left ">
                                <div class="form-group">
                                    <label for="">Enter the name of the product here:</label>
                                    <input type="text" class="form-control submit-input" aria-describedby="emailHelp"
                                        placeholder="Enter product name..."  id="product_name" name="product_name">
                                    <div id="product_name_error" class="error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Tell us the brand of the product:</label>
                                    <input type="text" class="form-control submit-input" aria-describedby="emailHelp"
                                        placeholder="Enter brand name..." id="brand" name="brand">
                                    <div id="autsuggestion_section"></div>
                                    <div id="brand_error" class="error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">What is the product type? (Bag, Dress, Heels etc)</label>
                                    <input type="text" class="form-control submit-input" aria-describedby="emailHelp"
                                        placeholder="Enter product type..." id="product_type" name="product_type">
                                        <div id="product_type_error" class="error"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Does the product have a size? Leave blank if none.</label>
                                    <input type="text" class="form-control submit-input" aria-describedby="emailHelp"
                                        placeholder="Enter product size..." id="product_size" name="product_size">
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
                                    <input type="text"  onpaste="return false;" onkeydown="return false;" class="form-control submit-input" id="deliver_date" name="deliver_date" placeholder="Enter due date...">
                                    <div id="deliver_date_error" class="error"></div>
                                </div>
                                <button type="button" class="submit-request px-3  mt-2" id="submit-request-btn">Submit request</button>
                        </div>
                    </div>
                    
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@include("stylist.postloginview.partials.footer.footerjs")