@extends('member.website.layouts.default')
@section('content')
<div class="container-fluid">
    <div id="signup">
        <h1>Create your password new password</h1>
        <p class="text-center">Enter the email address associated with your StyleGrid account. A password reset link
            will be sent.</p><br>
        <div class="dis-flex ">
            <div id="message_box" class="message"></div>
            <form action="" id="member-reset-password-form" method="POST">
                @csrf
                <div class="reset-inputbox">
                    <div class="form-group">
                        <input type="password" name="password" id="password">
                        <div id="password_error" class="error"></div>
                        <span>New Password</span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_password" id="confirm_password">
                        <div id="confirm_password_error" class="error"></div>
                        <span>Confirm Password</span>
                    </div
                </div>
                <div class="text-center mt-5"><a href="javascript:void(0)"><button  id="member-reset-password-btn" type="button" class="signup-btn">Create</button></a></div>
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


