@extends('stylist.website.layouts.default')
@section('content')
<div class="container-fluid">
</div>
<form id="stylist-registration-final-step-form" action="">
    @csrf
    <!-- One "tab" for each step in the form: -->
    <div class="tab">
        <div class="container">
            <div id="signup">
                <div class="row justify-content-center">
                    <h1>Welcome to StyleGrid.</h1>
                    <p class="text-center">Congratulations on your successful application. You are now officially
                        part of our global stylist<br> network. Fill in a few details so we can make your profile
                        informative for members. </p>
                </div>
                <div id="first_step_message_box" class="message"></div>
                <div>
                    <h6>Let’s get started.</h6>
                </div>
                <div class="dis-flex mt-5">
                     
                        <div class="inputbox">
                            <div class="form-group">
                                <input type="text" name="user_name" id="user_name" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" placeholder="Create username..."  maxlength="25">
                                <div id="user_name_error" class="error"></div>
                            </div>
                            
                        </div>
                        
                        <div class="inputbox">
                            <div class="form-group">
                                <input type="text" name="email_address" placeholder="Email Address..." readonly value="{{$stylist_data->email}}">
                                <div id="email_address_error" class="error"></div>
                            </div>
                        </div>
                        <div class="inputbox">
                            <div class="form-group">
                                <input type="text" name="phone_number" placeholder="Phone Number..." readonly  value="{{$stylist_data->phone}}">
                                <div id="phone_number_error" class="error"></div>
                            </div>
                        </div>
                        <div class="inputbox">
                            <div class="form-group">
                                <input type="password" id="password" name="password" placeholder="Create Password..." >
                                <div id="password_error" class="error"></div>
                            </div>
                        </div>

                        <div class="inputbox">
                            <div class="form-group">
                                <input type="password" id="confirm_password" name="confirm_password"  placeholder="Create confirm Password..." >
                                <div id="confirm_password_error" class="error"></div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab">
        <div class="container mt-4">
            <div id="signup">
                <div class="row justify-content-center">
                    <h1>Add some information about yourself.</h1>
                    <p class="text-center">Build your stylist profile by adding a profile picture, short bio and
                        some of your favourite<br> brands. This will be visible to Stylegrid members and your clients.
                    </p>
                    <br>
                    <div id="second_step_message_box" class="message"></div>
                </div>
                <div class="row">
                    <div class="col-lg-6 ">
                        <div class="Neon Neon-theme-dragdropbox mt-lg-5">
                            <input name="profile_image" id="frame-image" multiple="multiple"  type="file">
                            <div class="Neon-input-dragDrop py-5 " id="source_image_preview_section_dynamic_class">
                                <div class="Neon-input-inner py-4 px-4" id="profile_image_preview_section">
                                    <div class="Neon-input-text ">
                                        <h3>Upload your profile</br> picture here</h3>
                                    </div>
                                    <a class="Neon-input-choose-btn blue">
                                        <img  src="{{ asset('/stylist/website/assets/images/plus.png') }}" alt="" id="image_preview">
                                    </a>
                                </div>
                                <div id="image_error" class="error"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                            <div class="inputbox-1 mt-5">
                                <div class="form-group text-center">
                                    <div class="d-flex justify-content-center flex-column">
                                        <textarea name="short_bio" id="short_bio" class="form-control"
                                            placeholder="Type your short bio here" ></textarea>
                                        <div id="short_bio_error" class="error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="inputbox-1 mt-5">
                                <div class="tags-input" id="myTags">
                                    <span class="data" style="width:90%;float:left;">
                                    </span>
                                    <span class="autocomplete">
                                        <input type="text" id="favourite_brands"  onkeypress="return lettersOnly(event)" maxlength="10" class="form-control" placeholder="Add your favourite brands here">
                                        <div class="autocomplete-items"></div>
                                    </span>
                                    <div id="favourite_brands_error" class="error"></div>
                                </div>
                            </div>
                            <div class="inputbox-1 mt-5">
                                <div class="form-group text-center">
                                    <div class="d-flex justify-content-center flex-column">
                                    <div id="preferred_style_section" class="d-flex justify-content-center preferred_style">
                                    </div>
                                        <div id="preferred_style_error" class="error"></div>
                                    </div>
                                </div>
                            </div>
							Select your preferred style type's here
                            <div class="add-items py-2 px-3 mt-1">
                                <div class="row" id="preferred_style_list_section">
                                    <!--<div class="text-right">
                                        <input type="checkbox" name="source" id="source" value="source">
                                        <label for="source"></label>
                                    </div>
                                    <label for="source">
                                        <div class="text-center">
                                        <h2 class="mt-2">Source</h2>
                                        </div>
                        </label>-->

                        <?php
                                    if(count($preferred_style)){
                                        foreach($preferred_style as $preferred){
                                        ?>
                                        <div class="col-4" id="add-preferred">
                                            <div class="d-flex">
                                        <div class="text-center">
                                        <input type="checkbox" name="preferred_style[]" id="add-preferred_style{{$preferred->id}}" class="preferred_style_type"  onClick="addPreferredStyle(this)" data_id="{{$preferred->id}}" value="{{$preferred->id}}">
                                        <label for="add-preferred_style{{$preferred->id}}"></label>
                                        </div>
                                    <label for="add-preferred_style{{$preferred->id}}">
                                        <div class="text-center">
                                            <h2 class="mt-2 tag-h2">{{$preferred->name}}</h2>
                                        </div>
                                    </label>
                                    </div>
                                    </div>
                                    <?php
                                        }
                                    }
                                    ?>
                         </div>
                            </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="success_tab" style="display:none;">
        <div class="container my-lg-5 py-lg-5">
            <div id="signup-1">
                <div class="justify-content-center">
                    <h1>Your account is now live!</h1>
                    <p class="text-center pt-3">Your account is now created and is now live. Jump straight in and
                        start
                        using the<br> StyleGrid dashboard to grow your styling business and service your clients below.
                    </p>
                    <br>
                    <div class="text-center">
                    <a href="{{url('stylist-login')}}" class="mt-5"><button class="back-to px-5 py-1">Log into your stylist
                            account</button></a></div>
                </div>
            </div>
        </div>
    </div>
   
    <div style="overflow:auto;" id="next-previous">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrevStep(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrevStep(1)">Next</button>
            <input type="hidden" id="favourite_brand_list" name="favourite_brand_list">
            <input type="hidden" id="preferred_style_type_list" name="preferred_style_type_list">
        </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;" id="steps-next-previous">
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>
@stop