@extends('member.website.layouts.default')
@section('content')
<div class="container-fluid">
    <div id="signup">
        <h1>Reset your password</h1>
        <p class="text-center">Enter the email address associated with your StyleGrid account. A password reset link
            will be sent.</p><br>
        <div class="dis-flex ">
            <div id="message_box" class="message"></div>
            <form action="" id="send-reset-link-form" method="POST">
                @csrf
                <div class="reset-inputbox inputbox">
                    <div class="form-group">
                        <input type="text" name="email" id="email" maxlength="40">
                        <div id="email_error" class="error"></div>
                        <span>Email Address</span>
                    </div>
                </div>
                <div class="text-center mt-5"><a href="javascript:void(0)"><button  id="send-reset-link-btn" type="button" class="reset-btn">Send Reset Link</button></a></div>
            </form>
        </div>
    </div>
</div>
<div id="forgot_password_success_section" style="display:none;">
<h1>Your password reset link has been sent</h1>
            <p class="text-center">Check your email to reset password.</p>
            <div class="text-center">
                <img src="{{asset('member/website/assets/images/TickBox.png')}}" alt="">
            </div>
            <div class="text-center mt-5"><a href="{{url('/member-login')}}"><button class="reset-btn">Go to back to Sign In</button></a>
            </div>
        </div>
@stop


