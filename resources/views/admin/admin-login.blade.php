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
    <link rel="stylesheet" href="{{ asset('member/website/assets/css/style.css') }}">
    <!-- END: Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 2-columns   fixed-navbar mt-0 pt-0" data-open="click" data-menu="vertical-menu"
    data-color="bg-gradient-x-purple-blue" data-col="2-columns">
    <div class="container-fluid px-0">
<nav class="navbar navbar-expand-lg navbar-dark d-flex">
   
   <div class="col-3 d-lg-flex   d-none justify-content-start">
      <!-- <div><img src="{{ asset('member/website/assets/images/user.png')}}" alt="" class="pr-4"></div> -->
      <div><img src="{{ asset('member/website/assets/images/english-flag.svg')}}" alt="" style="height:17px;"></div>
      <!-- <div><img src="{{ asset('member/website/assets/images/polygon.png')}}" alt="" class="px-2"></div> -->
          <select class="browser-default  d-lg-block d-none pl-1" >
          
              <option selected class="px-2" style="padding:20px">English</option>
              <option value="1">Spanish</option>
          </select>
      
      </div>
      <div class="col-6 text-center">
          <a class="navbar-brand " href="{{url('/')}}">
            <img src="{{ asset('member/website/assets/images/logo2.png')}}" style="height:25px" alt="" class="mr-3">
          <img src="{{ asset('member/website/assets/images/STYLEGRID-LOGO.png')}}" alt="">
        </a>
      </div>      
      <div class="d-lg-flex d-none col-3 justify-content-end">
          <div class="form-group has-search col-5" id="admin-img">
              <img src="{{ asset('member/website/assets/images/search.png')}}" alt="" class="admin-search-img">
              <input type="text" class="form-control mt-2" placeholder="Search">
          </div>
          <div>
              <img src="{{ asset('member/website/assets/images/beg.png')}}" alt="" class="h-25 mx-2 admin-beg">
          </div>
          <div>
              <img src="{{ asset('member/website/assets/images/star.png')}}" alt="" class="h-25  admin-beg">
          </div>
      </div>
      <a class="d-lg-none d-block collapsed" data-toggle="collapse" href="#navbarSupporthbvbedContent">
          <span class="if-collapsed"><span>&#9776;</span></span>
          <span class="if-not-collapsed">
              <span>&#9747;</span>
          </span>
      </a>
</nav>
</div>
    <!--Second navbar-->
    <nav class="navbar navbar-expand-lg">
        <div class="collapse navbar-collapse ml-lg-5  justify-content-lg-center" id="navbarSupporthbvbedContent">
            <ul class="navbar-nav">
                <li class="active nav-item px-3 py-2"><a href="#" class="nav-link">About <span
                            class="sr-only">(current)</span></a></li>
                <li class="px-2 nav-item py-2"><a href="#" class="nav-link">GRIDS</a></li>
                <li class="px-2 nav-item py-2"><a href="#" class="nav-link">SHOP</a></li>
                <li class="px-2 nav-item py-2"><a href="#" class="nav-link">STYLE</a></li>
                <li class="px-2 nav-item py-2"><a href="#" class="nav-link">SOURCE</a></li>
                <li class="px-2 nav-item py-2"><a href="#" class="nav-link">MEMBERSHIP</a></li>
                <li class="px-2 nav-item py-2"><a href="#" class="nav-link">EDITORIAL</a></li>
                <!-- <li class="px-3 nav-item py-2"><a href="#" class="nav-link">BRANDS</a></li>
                <li class="px-3 nav-item py-2"><a href="#" class="nav-link"></a></li> -->
                <li class="px-2 nav-item py-2"><a href="{{url('/member-login')}}" class="nav-link">SIGN IN</a></li>
                <li class="px-2 nav-item py-2"><a href="{{url('/sign-up')}}" class="nav-link"><button class="signup-btn ">Sign
                            Up</button></a></li>
            </ul>
        </div>
    </nav>

<div class="container-fluid bg-black pb-5 pt-3">
    <div id="signup">
        <div class="row">
            <div class="col-lg-12 text-center mt-5">
               
                <h1 class="text-white">StyleGrid Admin Login</h1>
                <p class="grey-color">Please enter your email and password to<br> log in to your StyleGrid admin Account</p>
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
                            <h3 class=" mt-2 text-white">Forgot password?</h3>
                        </a></div>
                        <div class="text-center my-2"><a href="javascript:void(0);"><button type="button" class="sign-in grey-color-bg" id="admin-login-btn">Sign In</button></a>
                        </div>
                    </form>
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
      $('#password').css('border'
       '2px solid #cc0000');
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




