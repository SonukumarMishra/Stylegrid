<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('admin-section/app-assets/vendors/css/vendors.min.css');?>">
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset('admin-section/app-assets/css/bootstrap.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('admin-section/app-assets/css/bootstrap-extended.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('admin-section/app-assets/css/colors.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('admin-section/app-assets/css/components.css');?>">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset('admin-section/app-assets/css/core/menu/menu-types/vertical-menu.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('admin-section/app-assets/css/core/colors/palette-gradient.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('admin-section/app-assets/css/core/colors/palette-gradient.css');?>">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('admin-section/assets/css/style.css');?>">
    <!-- END: Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu"
    data-color="bg-gradient-x-purple-blue" data-col="2-columns">
<div class="container-fluid">
    <div id="signup">
        <div class="row justify-content-center flex-lg-row flex-column-reverse">
            <div class="col-lg-12 dis-flex mt-lg-5">
                <div class="signin mt-lg-5 mt-3">
                <h1>Sign in to your<br> Admin account</h1>
                <div class="dis-flex ">
                    <div id="message_box" class="message"></div>
                    <form id="admin-login-form">
                        @csrf
                        <div class="inputbox">
                            <div class="form-group">
                                <input type="text" name="email" id="email" placeholder="Email Address..." maxlength="50">
                                <div id="email_error" class="error" ></div>
                            </div>
                        </div>
                        <div class="inputbox mb-0">
                            <div class="form-group">
                                <input type="password" name="password" id="password" placeholder="Password...">
                                <div id="password_error" class="error"></div>
                            </div>
                        </div>
                        <div><a href="#" class="forgot-pass">
                            <h3 class=" mt-2">Forgot password?</h3>
                        </a></div>
                        <div class="text-center mt-4"><a href="javascript:void(0);"><button type="button" class="sign-in px-3" id="admin-login-btn">Sign In</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
        </div>

    </div>
</div>
@include('admin.includes.footer')
<script>
    $(function(){
        $('#admin-login-btn').click(function(){
            
    $('#admin-login-form input').css('border', '1px solid #ccc');
    $('.error').html('');
    $('.message').html('');
    var email=makeTrim($('#email').val());
    var password=makeTrim($('#password').val());
    var status=true;
    if(email==''){
      $('#email').css('border', '2px solid #cc0000');
      $('#email_error').html('Please enter email');
      status=false;
    }else{
      if (!validEmail(email)) {
        $('#email').css('border', '2px solid #cc0000');
        $('#email_error').html('Please enter a valid Email ID');
        status = false;
      }
    }
    if(password==''){
      $('#password').css('border', '2px solid #cc0000');
      $('#password_error').html('Please enter password');
      status=false;
    }
    if(status){
      $.ajax({
        url : '/admin-login-post',
        method : "POST",
        async: false,
        data : $('#admin-login-form').serialize(),
        success : function (ajaxresponse){
            response = JSON.parse(ajaxresponse);
            if(response['status']){
              $('#message_box').html('<div class="alert alert-success">'+response['message']+'</div>');
              setTimeout(function(){
                window.location = "/admin-dashboard";
            }, 500);
            }else{
              $('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
            }
        }
    })
    }
        })
       // alert('hello');
    })
</script>




