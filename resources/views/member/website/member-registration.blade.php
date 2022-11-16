@extends('member.website.layouts.default')
@section('content')
<form id="member-registration-form" action="">
    @csrf
    <!-- One "tab" for each step in the form: -->
    <!-- <div class="mt-2"><h5>if you are a client,<a href="{{url('/member-login')}}"> Please click here to <br>Sign Up.</a></h5></div> -->

    <div class="tab">
        <div class="container mt-lg-5 mt-3">
            <div id="signup">
                <div class="row justify-content-center">
                    <h1>Sign up to StyleGrid</h1>
                    <p class="text-center px-3">Create your account today and enjoy a 30 day free trial, with access to a
                        dedicated stylist and<br class="d-lg-block d-none">
                        exclusive luxury product.</p>
                </div>
                <div id="first_step_message_box" class="message"></div>
                <div>
                    <h6 class="mt-lg-5">Let’s get started.</h6>
                </div>
                <div class="dis-flex mt-5">
                     
                        <div class="inputbox">
                            <div class="form-group">
                                <input type="text" name="full_name" id="full_name" placeholder="Full Name...">
                                <!-- <span>Full Name</span> -->
                            </div>
                            <div id="full_name_error" class="error"></div>
                        </div>
                        <div class="inputbox">
                            <div class="form-group">
                                
                                <input type="text" name="email" id="email" placeholder="Email Address....">
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
                        <div class="inputbox">
                            <div class="form-group">
                                <input type="password" id="password" name="password"placeholder="Create Password..." >
                                <div id="password_error" class="error"></div>
                                <!-- <span>Create Password</span> -->
                            </div>
                        </div>
                        <div class="inputbox">
                            <div class="form-group">
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Create Confirm Password...">
                                <div id="confirm_password_error" class="error"></div>
                                <!-- <span>Create Confirm Password</span> -->
                            </div>
                        </div>
                     

                </div>


            </div>
        </div>
    </div>
    <div class="tab">
        <div class="container mt-lg-5 mt-3">
            <div id="signup">
                <div class="row justify-content-center">
                    <h1>Welcome to StyleGrid</h1>
                    <p class="text-center">It’s time to get styling. For us to be able to find your perfect stylist,
                        we will need to find out a<br class="d-lg-block d-none">
                        little more information about your tastes and style preferences.</p>

                </div>
                <div id="second_step_message_box" class="message"></div>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="text-right">
                            <input type="checkbox" name="shop" id="shop" value="shop" checked="true">
                            <label for="shop"></label>
                        </div>
                        <label for="shop">
                            <div class="text-center"><img src="{{ asset('member/website/assets/images/shop.png') }}" class="img-fluid" alt="">
                                <h2 class="mt-2">Shop</h2>
                                <h5 class="mb-4">Browse luxury product that you can<br class="d-lg-block d-none"> access through your StyleGrid<br class="d-lg-block d-none"> membership.
                                </h5>
                                <a class="select-btn mt-2 ">Select</a>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="text-right">
                            <input type="checkbox" name="style" id="style" value="style">
                            <label for="style"></label>
                        </div>
                        <label for="style">
                            <div class="text-center"><img src="{{ asset('member/website/assets/images/style.png') }}" class="img-fluid" alt="">
                                <h2 class="mt-2">Style</h2>
                                <h5 class="mb-4">Receive personalised luxury fashion,<br class="d-lg-block d-none">beauty and homeware all in one<br class="d-lg-block d-none">place.</h5>
                                <a class="select-btn mt-2">Select</a>
                            </div>
                        </label>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="text-right">
                            <input type="checkbox" name="source" id="source" value="source">
                            <label for="source"></label>
                        </div>
                        <label for="source">
                            <div class="text-center"><img src="{{ asset('member/website/assets/images/source.png') }}" class="img-fluid" alt="">
                                <h2 class="mt-2">Source</h2>
                                <h5 class="mb-4">Source any item from around the<br class="d-lg-block d-none"> globe using our expansive shopper<br class="d-lg-block d-none"> network.</h5>
                                <a class="select-btn mt-2">Select</a>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab">
        <div class="container mt-lg-5 mt-3">
            <div id="signup">
                <div class=" justify-content-center">
                    <h1>What is your gender?</h1>
                    <p class="text-center">Understanding how you identify willhelp us match you with stylists and<br class="d-lg-block d-none">
                        brands that suit you best.</p>

                </div>
                <div id="third_step_message_box" class="message"></div>
                <div class="row mt-3">
                    <div class="col-md-4 text-center mt-2">
                    <label>
                        <input type="radio" name="gender" value="Male" checked>
                        <img src="{{ asset('member/website/assets/images/white-check.png') }}" alt="option1">
                        <div class="text-center">
                            <img src="{{ asset('member/website/assets/images/male.png') }}" alt="option 1">
                            <h2 class="mt-2 mb-4">Male</h2>
                            <a class="select-btn mt-2">Select</a>
                        </div>
                    </label>
                    </div>
                    <div class="col-md-4 text-center mt-2">
                        <label>
                              <input type="radio" name="gender" value="Female">
                                <img src="{{ asset('member/website/assets/images/white-check.png') }}" alt="option1">
                                <div class="text-center">
                                    <img src="{{ asset('member/website/assets/images/female.png') }}" class="img-fluid" alt="">
                                    <h2 class="mt-2 mb-4">Female</h2>
                                    <a class="select-btn mt-2">Select</a>
                                </div>
                        </label>
                    </div>
                    <div class="col-md-4 text-center mt-2">
                    <label>
                        <input type="radio" name="gender" value="Non Binary">
                        <img src="{{ asset('member/website/assets/images/white-check.png') }}" alt="option1">
                        <div class="text-center">
                            <img src="{{ asset('member/website/assets/images/non-binary.png') }}" class="img-fluid" alt="">
                            <h2 class="mt-2 mb-4">Non Binary</h2>

                            <a class="select-btn mt-2">Select</a>
                        </div>
                    </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab">
        <div class="container mt-lg-5 mt-3">
            <div id="signup">
                <div class="justify-content-center">
                    <h1>Where are you based?</h1>
                    <p class="text-center">Style and taste is often influenced by your environment. Let us know
                        where<br class="d-lg-block d-none"> you are based to help us understand more about you.</p>

                </div>
                <div>
                    <div id="fourth_step_message_box" class="message"></div>
                    <div class="form-group input-city mt-2 pl-2">
                        <select id="country_id" name="country_id" class="form-control icon">
                            <option value="">Enter your city and country here...</option>
                            <?php
                            foreach($country_list as $country){
                                ?>
                                <option value="<?php echo $country->id;?>"><?php echo $country->country_name;?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <!--<input type="text" class="form-control icon" id="" aria-describedby="emailHelp"
                            placeholder="Enter your city and country here...">-->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="tab">
        <div class="container mt-lg-5 mt-3">
            <div id="signup">
                <div class="row justify-content-center">
                    <h1>What are your favourite brands?</h1>
                    <p class="text-center">We want to know what brands you are most passionate about. Select from<br class="d-lg-block d-none">
                        our featured list below, or
                        use the search bar to expand your choice.</p>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div id="fifth_step_message_box" class="message"></div>
            <div class="row my-5">
                <?php 
               
                foreach($brand_list as $index => $brand){
                    ?>
                    <div class="col-md-3 text-center">
                        <div class="text-right">
                        
                            <input type="checkbox" name="brands[]" class="brand_list_check" id="check-<?php  echo $index;  ?>" value="{{$brand->id}}">
                            <label for="check-<?php  echo $index;  ?>"></label>
                        </div>
                        <label for="check-<?php  echo $index;  ?>">
                            <img src="{{asset('member/website/assets/images/'.$brand->logo)}}" alt="">

                        </label>
                    </div>
                    <?php
                    }    
                ?>
            </div>
        </div>
    </div>
    <div class="success_tab" style="display:none;">
        <div class="container mt-5">
            <div id="signup-5">
                <div class="row justify-content-center" style="margin:0px ;">
                    <h1>Thank you. It’s time to meet your stylist.</h1>
                    <p class="text-center">Welcome to StyleGrid. Using your information,
                        we have matched you with<br class="d-lg-block d-none"> one of our stylists. You will be able to request product, shop
                        luxury brands<br class="d-lg-block d-none"> and receive unlimited styling through your dedicated style dashboard.</p>

                </div>
                <div class="row my-4">
                    <div class="col-   md-5 text-lg-left text-center">
                        <img src="{{ asset('member/website/assets/images/IMG_0104 1.png') }}" alt="">
                    </div>
                    <div class="col-md-7 text-lg-left text-center">
                        <h4>Francesca</h4>
                        <p class="new-para text-lg-left text-center">Francesca’s extensive experience is afforded
                            through years of working with prestigious fashion houses including Browns and
                            Net-A-Porter in addition to privately dressing discerning men and women across the globe
                            <br class="d-lg-block d-none">
                            <br class="d-lg-block d-none"><br class="d-lg-block d-none">Your lifestyle, personality, needs and desires as the foremost priority.
                            Believing your wardrobe should resemble you, and enable you to enter a room with
                            confidence, poise, elegance and self-assurance. I believe everyone deserves an
                            individual style, which we can often easily get lost in this fast paced fashion
                            industry.
                        </p>
                        <div class="mt-5">
                            <a href="{{url('/member-login')}}"><button type="button"  class="styling-btn px-5 ">Let’s get
                                    styling</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="overflow:auto;" id="next-previous">
        <div style="float:right;" class="mt-5">
            <button type="button" id="prevBtn" class="next-btn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" class="next-btn" onclick="nextPrev(1)">Next</button>
        </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;" id="steps-next-previous">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>
@stop