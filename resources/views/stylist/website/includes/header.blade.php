<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('stylist/website/assets/css/style.css')}}">
</head>
<body>
    <div class="container-fluid px-0">
<nav class="navbar navbar-expand-lg navbar-dark d-flex">
   
   <div class="col-3 d-lg-flex   d-none justify-content-start">
      <!-- <div><img src="{{ asset('member/website/assets/images/user.png')}}" alt="" class="pr-4"></div> -->
      <div><img src="{{ asset('member/website/assets/images/english-flag.svg')}}" alt="" style="height:17px;"></div>
      <!-- <div><img src="{{ asset('member/website/assets/images/polygon.png')}}" alt="" class="px-2"></div> -->
          <select class="browser-default  d-lg-block d-none" >
          
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
          <div class="form-group has-search col-5">
              <img src="{{ asset('member/website/assets/images/search.png')}}" alt="" class="px-2">
              <input type="text" class="form-control mt-2" placeholder="Search">
          </div>
          <div>
              <img src="{{ asset('member/website/assets/images/beg.png')}}" alt="" class="h-25 mx-2 mt-4">
          </div>
          <div>
              <img src="{{ asset('member/website/assets/images/star.png')}}" alt="" class="h-25 ml-2 mt-4">
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
                <li class="px-3 nav-item py-2"><a href="#" class="nav-link">GRIDS</a></li>
                <li class="px-3 nav-item py-2"><a href="#" class="nav-link">SHOP</a></li>
                <li class="px-3 nav-item py-2"><a href="#" class="nav-link">STYLE</a></li>
                <li class="px-3 nav-item py-2"><a href="#" class="nav-link">SOURCE</a></li>
                <li class="px-3 nav-item py-2"><a href="#" class="nav-link">MEMBERSHIP</a></li>
                <li class="px-3 nav-item py-2"><a href="#" class="nav-link">EDITORIAL</a></li>
                <!-- <li class="px-3 nav-item py-2"><a href="#" class="nav-link">BRANDS</a></li>
                <li class="px-3 nav-item py-2"><a href="#" class="nav-link"></a></li> -->
                <li class="px-3 nav-item py-2"><a href="{{url('/member-login')}}" class="nav-link">SIGN IN</a></li>
                <li class="px-3 nav-item py-2"><a href="{{url('/sign-up')}}" class="nav-link"><button class="signup-btn ">Sign
                            Up</button></a></li>
            </ul>
        </div>
    </nav>
