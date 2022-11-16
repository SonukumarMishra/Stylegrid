@extends('stylist.website.layouts.default')
@section('content')
<div class="container-fluid">
</div>
<!-- Navbar -->
<form id="stylist-registration-form" action="">
    @csrf

    <!-- One "tab" for each step in the form: -->
    
    <div class="tab">
        <div class="container mt-lg-5 mt-3">
            <div id="signup">
                <div class="row justify-content-center">
                    <h1>Join our stylist network.</h1>
                    <p class="text-center px-3">When you join our platform as a stylist, you’ll join our network of
                        hundreds of other stylists<br class="d-lg-block d-none"> around the world building their fashion, home and beauty
                        businesses using StyleGrid. Get access<br class="d-lg-block d-none"> to our industry-leading platform allowing you to
                        service your current clients while also receiving<br class="d-lg-block d-none">  new clients through our platform every
                        month.

                    </p>
                    <p class="px-3 text-center">All applications will be subject to a vetting process to ensure a secure platform for our
                        members.</p>

                </div>
                <div id="first_step_message_box" class="message"></div>
                <div class="mt-lg-4">
                    <h6>Let’s get started.</h6>
                </div>
                <div class="dis-flex mt-5">
                     
                    <div class="inputbox">
                        <div class="form-group mb-0">
                            <input type="text" name="full_name" id="full_name" placeholder="Full Name...">
                            <!-- <span>Full Name</span> -->
                        </div>
                        <div id="full_name_error" class="error"></div>
                    </div>
                    <div class="inputbox">
                        <div class="form-group">
                            
                            <input type="text" name="email" id="email" placeholder="Email Address...">
                            <div id="email_error" class="error"></div>
                            <!-- <span>Email Address</span> -->
                        </div>
                    </div>
                    <div class="inputbox">
                        <div class="form-group">
                            <input type="text" id="phone" name="phone" placeholder="Phone Number...">
                            <div id="phone_error" class="error"></div>
                            <!-- <span>Phone Number</span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab">
        <div class="container mt-lg-5  mt-3">
            <div id="signup">
                <div class="justify-content-center">
                    <h1>Where are you based?</h1>
                    <p class="text-center px-3">Understanding where you are predominantly based helps us build your
                        business<br class="d-lg-block d-none">with clients in your region, while also tailoring your StyleGrid experience.
                    </p>
                   
                </div>
                <div>
                    <div id="second_step_message_box" class="message"></div>
                    <div class="form-group input-city mt-2 pl-2">
                        <select id="country_id" name="country_id" class="form-control icon" style="appearance:none !important;">
                            <option value="">Enter your city and country here...</option>
                            <?php
                            foreach($country_list as $country){
                                ?>
                                <option value="<?php echo $country->id;?>"><?php echo $country->country_name;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="tab">
        <div class="container mt-lg-5 mt-3">
            <div id="signup">
                <div class=" justify-content-center">
                    <h1>Tell us about you.</h1>
                    <p class="text-center px-3">Please give us some detailed information on your styling experience
                        and<br class="d-lg-block d-none">
                        passions, so we can ensure the right members are ssigned to you.
                </div>
                <div id="third_step_message_box" class="message"></div>
                <div class="dis-flex mt-5">
                        <div class="inputbox-1">
                            <div class="form-group text-center">
                                <label for="">Tell us about your styling experience.</label>
                                <div class="d-flex justify-content-center flex-column">
                                <textarea name="styling_experience" id="styling_experience" class="form-control mx-auto"
                                    placeholder="Type your answer here..."></textarea>
                                    <div class="error  mx-auto" id="styling_experience_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="inputbox-1 mt-5">
                            <div class="form-group text-center">
                                <label>Have you worked for a fashion or styling company previously?</label>
                                <div class="d-flex justify-content-center flex-column">
                                <textarea name="fashion_styling_brief" id="fashion_styling_brief" class="form-control mx-auto"
                                    placeholder="Type your answer here..."></textarea>
                                    <div class="error  mx-auto" id="fashion_styling_brief_error"></div>
                            </div>
                            </div>
                        </div>
                        <div class="inputbox-1 mt-5">
                            <div class="form-group text-center">
                                <label>How many clients, if any, will you service using StyleGrid?</label>
                                <div class="d-flex justify-content-center flex-column">
                                <textarea name="client_brief" id="client_brief" class="form-control mx-auto"
                                    placeholder="Type your answer here..."></textarea>
                                    <div class="error  mx-auto" id="client_brief_error"></div>
                                    </div>
                            </div>
                        </div>
                        <div class="inputbox-1 mt-5">
                            <div class="form-group text-center">
                                <label for="">Please list some of your fashion and beauty favourite brands
                                    below.</label>
                                    <div class="d-flex justify-content-center flex-column">
                                <textarea name="fashion_beauty_brands" id="fashion_beauty_brands" class="form-control mx-auto"
                                    placeholder="Type your answer here..."></textarea>
                                    <div class="error  mx-auto" id="fashion_beauty_brands_error"></div>
                                    </div>
                            </div>
                        </div>

                        <div class="inputbox-1 mt-5">
                            <div class="form-group text-center">
                                <label for="">Is your experience in stronger in fashion, home or beauty? List
                                    all if
                                    applicable.</label>
                                    <div class="d-flex justify-content-center flex-column">
                                <textarea name="stronger_experience" id="stronger_experience" class="form-control mx-auto"
                                    placeholder="Type your answer here..."></textarea>
                                    <div class="error mx-auto" id="stronger_experience_error"></div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="tab">
        <div class="container mt-lg-5 mt-3">
            <div id="signup">
                <div class=" justify-content-center">
                    <h1>Which elements of our platform would you use?</h1>
                    <p class="text-center px-3">It’s time to get styling. For us to be able to match you with our
                        members, we will need to<br class="d-lg-block d-none"> find out a little more information about your tastes and style
                        preferences.</p>
                </div>
                <div id="fourth_step_message_box" class="message"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-right">
                            <input type="checkbox" name="shop" id="shop" value="shop" checked="true">
                            <label for="shop"></label>
                        </div>
                        <label for="shop">
                            <div class="text-center"><img src="{{asset('stylist/website/assets/images/shop.png')}}" class="img-fluid" alt="">
                                <h2 class="mt-2">Shop</h2>
                                <h5>Sell luxury product that you can to StyleGrid members around the world, including your own clients,
                                </h5>
                                <a class="select-btn mt-2 " type="button">Select</a>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="text-right">
                            <input type="checkbox" name="style" id="style" value="style">
                            <label for="style"></label>
                        </div>
                        <label for="style">
                            <div class="text-center"><img src="{{asset('stylist/website/assets/images/style.png')}}" class="img-fluid" alt="">
                                <h2 class="mt-2">Style</h2>
                                <h5>Deliver personalised luxury fashion,<br class="d-lg-block d-none"> beauty and homeware style advice<br class="d-lg-block d-none"> all in one place.
                                </h5>
                                <a class="select-btn mt-2 " type="button">Select</a>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="text-right">
                            <input type="checkbox" name="source" id="source" value="source">
                            <label for="source"></label>
                        </div>
                        <label for="source">
                            <div class="text-center"><img src="{{asset('stylist/website/assets/images/source.png')}}" class="img-fluid" alt="">
                                <h2 class="mt-2">Source</h2>
                                <h5>Source any item from around the<br class="d-lg-block d-none"> globe using our expansive shopper<br class="d-lg-block d-none"> network.</h5>
                                <a class="select-btn mt-2 " type="button">Select</a>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    <div class="success_tab" style="display:none;">
        <div class="container mt-lg-5 mt-3">
            <div id="signup-1">
                <div class="justify-content-center">
                    <h1>Thank you. Your application is<br class="d-lg-block d-none"> now in review.</h1>
                    <p class="text-center px-3 py-4">Our team will be in touch within 24 hours to confirm your application
                        and
                        give<br class="d-lg-block d-none"> you access to the StyleGrid platform, where you’ll be able to service and grow<br class="d-lg-block d-none"> your
                        styling business all in one place.</p>
                     <div class="text-center"><a href="{{url('/stylist-registration')}}" class="mt-5" id="stylist-registration-success-url"><button class="back-to px-5 py-1" type="button">Return to Home</button></a></div>
                </div>

            </div>

        </div>
    </div>
    </div>
    <div style="overflow:auto;"  id="next-previous" class=" mt-5">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;" id="steps-next-previous">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        
    </div>
</form>

@stop