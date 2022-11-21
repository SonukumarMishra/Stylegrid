@extends('stylist.website.layouts.default')
@section('content')
<div class="container-fluid">
    <div id="signup">
        <h1>Create your password new password</h1>
        <p class="text-center">Enter the email address associated with your StyleGrid account. A password reset link
            will be sent.</p><br>
        <div class="dis-flex ">
            <div id="message_box" class="message"></div>
            <form action="" id="stylist-reset-password-form" method="POST">
                @csrf
                <div class="reset-inputbox">
                    <div class="form-group">
                        <input type="password" name="password" id="password" maxlength="25">
                        <div id="password_error" class="error"></div>
                        <span>New Password</span>
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_password" id="confirm_password" maxlength="25">
                        <div id="confirm_password_error" class="error"></div>
                        <span>Confirm Password</span>
                    </div
                </div>
                <div class="text-center mt-5"><a href="javascript:void(0)"><button  id="stylist-reset-password-btn" type="button" class="signup-btn">Create</button></a></div>
            </form>
        </div>
    </div>
</div>
@stop


