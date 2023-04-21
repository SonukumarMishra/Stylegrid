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

                    <h1>Fufill sourcing request</h1>

                    <h3>Review the product details below and submit a price and schedule.</h3>

                </div>

                <div class="col-md-4 quick-link text-right d-none">

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

                            <!-- <h1 class="col-9">{{$source_data->p_name}}</h1> -->

                            <!-- <h2 class="px-2 mt-1 col-2">{{$source_data->name}}</h2> -->

                            <!-- <a href="{{url('/stylist-create-source-request')}}" class=" col-lg-4 text-lg-right text-center mt-2"><button class="request-btn px-3">Make

                                    Request</button></a> -->

                        </div>

                    </div>

                    <!-- Pills navs -->

                    <div class="col-lg-4 d-flex justify-lg-content-end justify-content-center mt-lg-0 mt-2">

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

                <div id="message-box" class="message"></div>

                <div class="row" id="fulfill-request">

                    <div class="col-lg-6 text-center">

                        <!-- <div class="border-right1 my-3"> -->
                        <div class=" my-3">

                            <img src="{{asset('attachments/source/'.$source_data->p_image)}}" class="img-fluid" alt="">

                        </div>

                    </div>

                    <div class="col-lg-6 text-lg-left text-center">

                        <div class="p-3">

                            <h1>{{ucfirst($source_data->p_name)}}</h1>

                            <h6>{{ucfirst($source_data->name)}}</h6>

                            <h4 class="mt-3">Required in: {{$source_data->country_name}}</h4>

                            <h4>Date required: {{date('m/d/Y',strtotime($source_data->p_deliver_date))}}</h4>

                            <h4>Detaile: {{ $source_data->p_details }}</h4>

                            <h4>Condition requested: New</h4>

                            <form id="stylist-fulfill-source-request-form" class="mt-3">

                                @csrf

                                <div>

                                    <label for="">Please detail the price you can supply this product for.</label>

                                </div>

                                <div class="w-100">

                                    <input type="number" placeholder="Input price here..." id="source_price" name="source_price"

                                        class="w-100 form-control submit-input" maxlength="6">

                                        <div id="source_price_error" class="error"></div>

                                </div>
                                    <div class="mt-2">
                                     <label for=""> Add any additional information and specs about what you can supply.</label>

                                    </div>
                               
                                <div class="w-100">

                                    <textarea  placeholder="Enter Additional Informtaion...." id="additional_info_stylist" name="offer_details" class="w-100 form-control additional_info_stylist" col="50" rows="5"> </textarea>
                                        <div id="additional_info_error" class="error"></div>
                                        
                                        

                                </div>

                                <div class="my-2">

                                    <a href="javascript:void(0)">

                                        <input type="hidden" name="source_id" id="source_id" value="{{$source_data->id}}">

                                        <button type="button" class="submit-btn px-3" id="submit_offer_btn">Submit offer</button></a>

                                </div>

                            </form>

                            <p class="mt-2">Please note, all products must adhere to the client request made and

                                must be legitmate. Failure to adhere to our terms & conditions will result in

                                removal from the platform and further legal action.</p>

                        </div>



                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@include("stylist.postloginview.partials.footer.footerjs")