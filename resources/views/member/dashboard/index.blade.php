@extends('member.dashboard.layouts.default')
@section('content')
<!-- BEGIN: Content-->
<div class="content-wrapper">

    <div class="content-header row">
    </div>
    <div class="content-body">
        <!-- Revenue, Hit Rate & Deals -->
        <div class="row mt-md-3">
            <div class="col-8 mt-md-3">
                <h1>Good morning Georgia.</h1>
                <h3>Check out your StyleGrid dashboard.</h3>
            </div>
            <div class="col-4 quick-link text-right mt-md-3">
                <span class="mr-md-5"><a hrf="">Quick Link</a></span>
                <div class="d-flex justify-content-end my-2">
                    <a href="" class="mx-lg-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/Chat.svg') }}" alt=""></a>
                    <a href="" class="mx-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/File Invoice.svg') }}" alt=""></a>
                    <a href="" class="mx-lg-1"><img src="{{ asset('member/dashboard/app-assets/images/icons/Gear.svg') }}" alt=""></a>

                </div>

            </div>
        </div>
        
        <div class="row mt-lg-4 mt-2 ">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-7  img-width">
                                <div class="client-dash-bg-img">
                                    <div class="layer"></div>
                                </div>
                                <div class="carousel-caption  d-block text-left">

                                    <div class="row">
                                        <div class="col-8">
                                            <button class="text-uppercase style-btn p-0">Style</button>
                                            <h5 class="mt-1">Talk to your stylist</h5>
                                            <p class="">Request product and style advice.</p>
                                        </div>
                                        <div class="text-right col-4 mt-5">
                                            <a href="client-grid.html"> <button class=" px-1 grey-bg">Chat
                                                    Now</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 mt-lg-0 mt-2 img-width">

                                <div class="client-dash-bg-img-1">
                                    <div class="layer"></div>
                                </div>
                                <div class="caro-caption  d-block text-left">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mt-1">Browse the latest drops</h5>
                                            <p class="">Check out this weeks drops in fashion and home.</p>
                                        </div>
                                        <div class="text-lg-left text-right pl-0 col-4 mt-5">
                                            <a href="client-grid.html"> <button
                                                    class=" px-2 grey-bg">Browse</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-----------make request-------->
                        <div class="row mt-2">
                            <div class="col-lg-8 img-width ">
                                <div class="client-dash-bg-img-2">
                                    <div class="layer"></div>
                                </div>
                                <div class="carousel-caption d-block text-left">

                                    <a href="client-grid.html">
                                        <h5 class="mt-1">View your StyleGrids</h5>
                                    </a>
                                    <div class="row">
                                        <div class="col-8 ">
                                            <p class="">Browse your custom StyleGrids.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 my-lg-0 my-2">
                                <div class="raise-bg-img">
                                    <div class="raise-bg-img">
                                        <div class="layer"></div>
                                        <div class="text-over-img px-lg-2 px-3 py-2">
                                            <h1>Make a sourcing request</h1>
                                            <p>Looking for your dream product?</p>

                                            <a href="client-sourcing.html"><button class="btn">Explore</button></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-----------end of make request-------->
                        </div>
                    </div>
                    <!-------------------inbox------------>
                    <div class="col-lg-4">
                        <div id="inbox-msg" class="py-2 px-3">
                            <h3 class="text-center">Your Stylist</h3>
                            <div class="text-center stylish-img">
                                <img src="{{ asset('member/dashboard/app-assets/images/gallery/stylist.png') }}" class="img-fluid" alt="">
                                <h6 style="font-size:16px" class="mt-1">Max</h6>
                                <h6>Stylist</h6>
                            </div>

                            <h1>Monday 31st January 2023</h1>
                            <div class="row">
                                <div class="col-lg-2 col-1">
                                    <img src="{{ asset('member/dashboard/app-assets/images/gallery/progil2.png') }}" alt="Avatar">
                                </div>
                                <div class=" col-10 pr-1 pl-md-0">
                                    <div class="container">
                                        <p class="pt-1">Hi Georgia! Hope you had a good weekend.</p>
                                    </div>
                                    <!-- <span class="time-right">11:00</span> -->
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-lg-2 col-1">
                                    <img src="{{ asset('member/dashboard/app-assets/images/gallery/progil2.png') }}" alt="Avatar">
                                </div>
                                <div class=" col-10 pr-1 pl-md-0">
                                    <div class="container">
                                        <p class="pt-1">Bottega have just released their SS/23 collection and there’s
                                            some bits that I think you’d love 😍 I have attached a Grid for you below.
                                        </p>
                                    </div>
                                    <!-- <span class="time-right">11:00</span> -->
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-lg-2 col-1">
                                    <img src="{{ asset('member/dashboard/app-assets/images/gallery/progil2.png') }}" alt="Avatar">
                                </div>
                                <div class=" col-10 pr-1 pl-md-0">
                                    <div class="container">
                                        <p class="pt-1">Georgia (Bottega StyleGrid)</p>
                                    </div>
                                    <!-- <span class="time-right">11:00</span> -->
                                </div>
                            </div>

                            <div class="row mt-1">

                                <div class=" col-10 pr-0 pl-md-5">
                                    <div class="container darker">
                                        <p class="pt-1">Write a reply...</p>
                                    </div>
                                    <!-- <span class="time-right">11:00</span> -->
                                </div>
                                <div class="col-2">
                                    <img src="{{ asset('member/dashboard/app-assets/images/gallery/Profile Picture.png') }}" alt="Avatar">
                                </div>
                            </div>
                            <div class="border mt-2"></div>
                            <div class="text-center mt-2">
                                <a href=""><button class="go-to-msg">Go To Messenger</button></a>
                            </div>

                        </div>
                    </div>
                    <!-------------------end of inbox------------>
                </div>
                <!--------------------style news---------------->
                <div class=" mt-3" id="style-news">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 text-lg-left text-center">
                            <h1>Style News</h1>
                        </div>
                        <!-- Pills navs -->
                        <div class="col-lg-6 d-flex justify-content-center justify-content-lg-end col-sm-12 mt-lg-0 mt-2">
                            <ul id="myTab_1" role="tablist"
                                class="nav nav-tabs  flex-sm-row text-center  rounded-nav">
                                <li class="nav-item ">
                                    <a id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                                        aria-selected="true"
                                        class="nav-link border-0 cyan-blue active font-weight-bold">Home</a>
                                </li>
                                <li class="nav-item ">
                                    <a id="Fashion-tab" data-toggle="tab" href="#Fashion" role="tab"
                                        aria-controls="Fashion" aria-selected="false"
                                        class="nav-link border-0 cyan-blue font-weight-bold ">Fashion</a>
                                </li>
                                <li class="nav-item ">
                                    <a id="Beauty-tab" data-toggle="tab" href="#Beauty" role="tab"
                                        aria-controls="Beauty" aria-selected="false"
                                        class="nav-link border-0 cyan-blue font-weight-bold ">Beauty</a>
                                </li>
                                <li class="nav-item ">
                                    <a id="Travel-tab" data-toggle="tab" href="#Travel" role="tab"
                                        aria-controls="Travel" aria-selected="false"
                                        class="nav-link border-0 cyan-blue font-weight-bold">Travel</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div id="TabContent" class="tab-content mt-2">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div id="onePagecarousel" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="one-caroImg">
                                                <div class="layer"></div>
                                            </div>
                                            <div class="carousel-caption d-block text-left w-100">

                                                <div class="row pt-3 pb-1">
                                                    <div class="col-6">
                                                        <h1>The best bedroom pieces<br> from Soho Home</h1>
                                                    </div>
                                                    <div class="text-right col-4 mt-5 pt-md-2">
                                                        <button class=" px-3 grey-bg browse-btn-1">Browse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="carousel-item">
                                        <img class="d-block" src="member/app-assets/images/gallery/1.jpg" alt="Second slide">
                                      </div>
                                      <div class="carousel-item">
                                        <img class="d-block" src="member/app-assets/images/gallery/11.jpg" alt="Third slide">
                                      </div> -->
                                    </div>
                                    <a class="carousel-control-prev" href="#onePagecarousel" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#onePagecarousel" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-pane fade " id="Beauty" role="tabpanel" aria-labelledby="Beauty-tab">
                                <div id="onePagecarousel" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block " src="{{ asset('member/dashboard/app-assets/images/gallery/best-bedroom.svg') }}"
                                                alt="First slide">
                                            <div class="carousel-caption d-none d-md-block text-left w-100">

                                                <div class="row py-3">
                                                    <div class="col-6">
                                                        <h1>Beauty</h1>
                                                    </div>
                                                    <div class="text-right col-4 mt-3">
                                                        <button class="py-1 px-3 grey-bg">Browse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="carousel-item">
                                        <img class="d-block" src="member/app-assets/images/gallery/1.jpg" alt="Second slide">
                                      </div>
                                      <div class="carousel-item">
                                        <img class="d-block" src="member/app-assets/images/gallery/11.jpg" alt="Third slide">
                                      </div> -->
                                    </div>
                                    <a class="carousel-control-prev" href="#onePagecarousel" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#onePagecarousel" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-pane fade " id="Fashion" role="tabpanel" aria-labelledby="Fashion-tab">
                                <div id="onePagecarousel" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block " src="{{ asset('member/dashboard/app-assets/images/gallery/best-bedroom.svg') }}"
                                                alt="First slide">
                                            <div class="carousel-caption d-none d-md-block text-left w-100">

                                                <div class="row py-3">
                                                    <div class="col-6">
                                                        <h1>Fashion</h1>
                                                    </div>
                                                    <div class="text-right col-4 mt-3">
                                                        <button class="py-1 px-3 grey-bg">Browse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="carousel-item">
                                        <img class="d-block" src="member/app-assets/images/gallery/1.jpg" alt="Second slide">
                                      </div>
                                      <div class="carousel-item">
                                        <img class="d-block" src="member/app-assets/images/gallery/11.jpg" alt="Third slide">
                                      </div> -->
                                    </div>
                                    <a class="carousel-control-prev" href="#onePagecarousel" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#onePagecarousel" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-pane fade " id="Travel" role="tabpanel" aria-labelledby="Travel-tab">
                                <div id="onePagecarousel" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block " src="{{ asset('member/dashboard/app-assets/images/gallery/best-bedroom.svg') }}"
                                                alt="First slide">
                                            <div class="carousel-caption d-none d-md-block text-left w-100">

                                                <div class="row py-3">
                                                    <div class="col-6">
                                                        <h1>Travel</h1>
                                                    </div>
                                                    <div class="text-right col-4 mt-3">
                                                        <button class="py-1 px-3 grey-bg">Browse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="carousel-item">
                                        <img class="d-block" src="member/app-assets/images/gallery/1.jpg" alt="Second slide">
                                      </div>
                                      <div class="carousel-item">
                                        <img class="d-block" src="member/app-assets/images/gallery/11.jpg" alt="Third slide">
                                      </div> -->
                                    </div>
                                    <a class="carousel-control-prev" href="#onePagecarousel" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#onePagecarousel" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--------------------end of style news---------------->
                <!--------------------Browse souring request--------->
                <div id="browse-soursing" class="mt-3">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="d-lg-flex text-lg-left text-center">
                                <h1>Browse Latest Drops</h1>
                                <h2 class="px-2 mt-lg-1 text-lg-left text-center ">Across Fashion, Home & Beauty</h2>
                            </div>
                        </div>
                        <!-- Pills navs -->
                        <div class="col-lg-4 d-flex justify-lg-content-end justify-content-center mt-lg-0 mt-2">
                            <ul id="myTab_1" role="tablist" class="nav nav-tabs   flex-sm-row text-center  rounded-nav">
                                <li class="nav-item ">
                                    <a id="home-tab" data-toggle="tab" href="#home_1" role="tab" aria-controls="home"
                                        aria-selected="true"
                                        class="nav-link border-0 cyan-blue  font-weight-bold">Home</a>
                                </li>
                                <li class="nav-item ">
                                    <a id="Fashion-tab" data-toggle="tab" href="#Fashion_1" role="tab"
                                        aria-controls="Fashion" aria-selected="false"
                                        class="nav-link border-0 cyan-blue font-weight-bold active ">Fashion</a>
                                </li>
                                <li class="nav-item ">
                                    <a id="Beauty-tab" data-toggle="tab" href="#Beauty_1" role="tab"
                                        aria-controls="Beauty" aria-selected="false"
                                        class="nav-link border-0 cyan-blue font-weight-bold ">Beauty</a>
                                </li>
                                <li class="nav-item ">
                                    <a id="Travel-tab" data-toggle="tab" href="#Travel_1" role="tab"
                                        aria-controls="Travel" aria-selected="false"
                                        class="nav-link border-0 cyan-blue font-weight-bold">Travel</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div id="TabContent" class="tab-content my-2 w-100">
                            <div class="tab-pane fade active show" id="Fashion_1" role="tabpanel"
                                aria-labelledby="Fashion-tab">
                                <div class="row mx-md-0 mx-2">
                                    <div class="col-md col-6">
                                        <div class="card">
                                            <img class="card-img-top"
                                                src="{{ asset('member/dashboard/app-assets/images/gallery/client-dash-browse1.png') }}"
                                                alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">BOTTEGA VENETA</h5>
                                                <p class="card-text">Jodie mini knotted intrecciato leather tote</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md col-6">
                                        <div class="card">
                                            <img class="card-img-top"
                                                src="{{ asset('member/dashboard/app-assets/images/gallery/client-dash-browse2.png') }}"
                                                alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">BOTTEGA VENETA</h5>
                                                <p class="card-text">Cotton-twill jacket</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md col-6">
                                        <div class="card">
                                            <img class="card-img-top"
                                                src="{{ asset('member/dashboard/app-assets/images/gallery/client-dash-browse3.png') }}"
                                                alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">BOTTEGA VENETA</h5>
                                                <p class="card-text">Pleated cotton-twill wide-leg pants</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md col-6">
                                        <div class="card">
                                            <img class="card-img-top"
                                                src="{{ asset('member/dashboard/app-assets/images/gallery/client-dash-browse4.png') }}"
                                                alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">LOEWE</h5>
                                                <p class="card-text">Wool-blend turtleneck sweater
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md col-6">
                                        <div class="card">
                                            <img class="card-img-top"
                                                src="{{ asset('member/dashboard/app-assets/images/gallery/client-dash-browse5.png') }}"
                                                alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title">LOEWE</h5>
                                                <p class="card-text"> Wool-blend turtleneck sweater</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex px-2 mt-2">
                                    <div class="show-bg"><img src="{{ asset('member/dashboard/app-assets/images/icons/show-more.svg') }}" alt="">
                                    </div>
                                    <span class="show px-1">See more</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--------------------end of Browse souring request--------->
                <!-------------------payment-center-box=-------------->
                <div id="payment-center" class="mt-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="client-raise-bg raise-bg px-md-3 px-2 py-2">
                                <h1 class=""> Wool-blend turtleneck sweater</h1>

                                <div class="row">
                                    <div class="col">
                                        <p class="">Earnt every time you spend, check what your rewards points are
                                            worth.</p>
                                        <a href=""><button class="btn">View Points</button></a>
                                        <h2 class="pt-2">Current points</h2>
                                        <h3>4,598</h3>
                                        <h4>+2,188 this month</h4>
                                        
                                    </div>
                                    <div class="col mt-2 text-lg-left text-right">
                                        <img src="{{ asset('member/dashboard/app-assets/images/gallery/Shopping Bag.png') }}" class="img-fluid" alt="">
                                    </div>
                                </div>

                            </div>
                            <div class="my-2">
                                <div class="client-raise-bg raise-bg px-md-3 px-2 py-2">
                                    <h1 class="">Settings</h1>

                                    <div class="row">
                                        <div class="col">
                                            <p class="">Check or change your settings, including billing and profile
                                                information.</p>
                                            <a href=""><button class="btn">Explore</button></a>
                                            <h2 class="pt-2">Current membership</h2>
                                            <h3>Black Tier</h3>
                                           
                                        </div>
                                        <div class="col mt-2 text-lg-left text-right">
                                            <img src="{{ asset('member/dashboard/app-assets/images/gallery/logo2.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div id="notice-board" class="raise-bg_1 pb-1">
                                <div class="">
                                    <div class=" px-md-3 px-2 py-1">
                                        <a href=""><button><span>UPDATES</span></button></a>
                                        <h1>Member Noticeboard</h1>
                                        <p class="mt-2">Live updates about our platform and new features coming soon.
                                        </p>
                                    </div>
                                    <!-- <div class="col-3">
                                        <img src="member/app-assets/images/icons/Pin.svg" class="img-fluid" alt="">
                                    </div> -->

                                </div>
                                <div class="mx-md-2" id="board-detail">
                                    <div class="row mx-md-2 mx-1 my-1">
                                        <div class="col-9 px-2 py-1">
                                            <span>26/02/23</span>
                                            <h1>We are adding a task management feature!</h1>
                                            <p>Plan your day to give your clients the best service.</p>
                                        </div>
                                        <div class="col-3">
                                            <img src="{{ asset('member/dashboard/app-assets/images/icons/notice-board.svg') }}" class="img-fluid py-1"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="row mx-2 my-1">
                                        <div class="col-9 px-2 py-1">
                                            <span>26/02/23</span>
                                            <h1>We are adding a task management feature!</h1>
                                            <p>Plan your day to give your clients the best service.</p>
                                        </div>
                                        <div class="col-3">
                                            <img src="{{ asset('member/dashboard/app-assets/images/icons/notice-board1.png') }}" class="img-fluid py-1"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="row mx-2 mt-1">
                                        <div class="col-9 px-2 py-1">
                                            <span>26/02/23</span>
                                            <h1>We are adding a task management feature!</h1>
                                            <p>Plan your day to give your clients the best service.</p>
                                        </div>
                                        <div class="col-3">
                                            <img src="{{ asset('member/dashboard/app-assets/images/icons/notice2.svg') }}" class="img-fluid py-1"
                                                alt="">
                                        </div>
                                    </div>
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-------------------end of payment-center-box=-------------->
                <!------------------refer-client------------->
                <div id="refer-client" class="mt-3">
                    <div class="row py-5 px-md-4">
                        <div class="col-lg-6">

                            <div>
                                <h1 class="py-2 px-2">Earn points as you shop on StyleGrid. </h1>
                                <p class="px-2 w-75 pb-2">When you buy product using StyleGrid, you’ll earn one point
                                    per pound spent. As you accrue points, you’ll be able to redeem these against future
                                    purchases you make.</p>
                                <a href="" class="px-2 py-2"> <button class="refer-btn  px-2">View Points</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-lg-end justify-content-left pr-lg-2">
                        <h2 class="pr-md-5 pl-md-0 pl-3 pb-2">Terms & Condtions apply.</h2>
                    </div>
                </div>
                <!------------------end of refer-client------------->

            </div>
        </div>
        

    </div>
</div>
@stop