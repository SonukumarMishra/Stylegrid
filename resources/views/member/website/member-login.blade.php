@extends('member.website.layouts.default')
@section('content')
<div class="container-fluid">
    <div id="signup">
        <div class="row justify-content-center flex-lg-row flex-column-reverse">
            <div class="col-lg-6 dis-flex mt-lg-5">
                <div class="signin mt-lg-5 mt-3">
                <h1>Sign in to your<br> StyleGrid account</h1>
                <p class="text-center">Please enter your email and password to<br> log in to your StyleGrid                    account.</p><br>


                <div class="dis-flex ">
                    <div id="message_box" class="message"></div>
                    <form id="member-login-form">
                        @csrf
                        <div class="inputbox">
                            <div class="form-group">
                                <input type="text" name="email" id="email" placeholder="Email Address...">
                                <div id="email_error" class="error" ></div>
                                <!-- <span>Email Address</span> -->
                            </div>
                        </div>
                        <div class="inputbox mb-0">
                            <div class="form-group">
                                <input type="password" name="password" id="password" placeholder="Password...">
                                <div id="password_error" class="error"></div>
                                <!-- <span>Password</span> -->
                            </div>
                        </div>
                        <div><a href="#" class="forgot-pass">
                            <h3 class=" mt-2">Forgot password?</h3>
                        </a></div>
                        <div class="text-center mt-4"><a href="javascript:void(0);"><button type="button" class="sign-in px-3" id="member-login-btn">Sign In</button></a>
                        </div>
                        <div class="mt-4"><h5 class="click-to-signin">if you are a stylist,<a href="{{url('/stylist-login')}}" class="text-dark"><u> please click here to <br>sign in.</u></a></h5></div>
                    </form>
                </div>
            </div>
        </div>
            <div class="col-lg-6 mt-2">
                <div>
                    <img src="{{ asset('member/website/assets/images/login2.png') }}" class="" alt="" style="width:100% ;">
                </div>
            </div>
        </div>

    </div>
</div>
@stop