@include("stylist.postloginview.partials.header.header")
@include("stylist.postloginview.partials.navigate.navigate")
 <!-- BEGIN: Content-->
  <div class="app-content content bg-white">
    <div class="content-wrapper">

            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Revenue, Hit Rate & Deals -->
                <div class="row mt-3">
                    <div class="col-lg-8 col-md-12 mt-3">
                        <h1>Good morning Max.</h1>
                        <h3>Check out your stylist summary dashboard.</h3>
                    </div>
                    <div class="col-lg-4 col-md-12 quick-link text-right mt-3">
                        <span class="mr-5"><a hrf="">Quick Link</a></span>
                        <div class="row justify-content-end my-2">
                            <a href="" class="mx-1"><img src="stylist/app-assets/images/icons/Chat.svg" alt=""></a>
                            <a href="" class="mx-1"><img src="stylist/app-assets/images/icons/File Invoice.svg" alt=""></a>
                            <a href="" class="mx-1"><img src="stylist/app-assets/images/icons/Gear.svg" alt=""></a>

                        </div>

                    </div>
                </div>
                <div class="row margin-top-text">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-6  img-width">
                                <div class="bg-img">
                                    <div class="layer"></div>
                                </div>
                                <div class="carousel-caption d-none d-md-block text-left">
                                    <button class="text-uppercase style-btn p-0">Style</button>
                                    <h5 class="mt-1">Create a new StyleGrid</h5>
                                    <div class="row">
                                        <div class="col">
                                            <p class="">Style a new look for your clients.</p>
                                        </div>
                                        <div class="text-right col">
                                           <a href="loadgridview"> <button class=" px-2 grey-bg">Create Grid</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!---------------carousel------------------->
                            <div class="col-6">
                                <div id="twoPagecarousel" class="carousel slide " data-ride="carousel">

                                    <!-- <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol> -->
                                    <div class="carousel-inner">

                                        <div class="carousel-item active">
                                            <div class="">
                                                <div class="caro1">
                                                    <div class="layer"></div>
                                                </div>
                                                <h2 class="px-2 py-2">Pablo’s <br>Ibiza Grid</h2>
                                                <div class="carousel-caption d-none d-md-block text-left">

                                                    <h5 class="mt-1">Your Recent Grids</h5>
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <p class="">Jump to your most recently created StyleGrids.
                                                            </p>
                                                        </div>
                                                        <div class="text-right col-5">
                                                         <a href="caro-create-grid.html">
                                                               <button class="px-2 grey-bg">Go to Grid</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="carousel-item ">
                                            <div class="">
                                                <div class="caro1">
                                                    <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <a class="carousel-control-prev" href="#twoPagecarousel" role="button"
                                        data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#twoPagecarousel" role="button"
                                        data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <!---------------end of carousel------------------->
                        <!-----------make request-------->
                        <div class="row mt-2">
                            <div class="col-lg-4  ">
                                <div class="raise-bg px-1 py-1">
                                    <h1 class="">Raise An Invoice</h1>
                                    <p class="">Create and send an invoice to your clients for their latest order.
                                    </p>
                                    
                                    <div class="row">
                                        <div class="col-7 pr-0">
                                            <a href=""><button class="btn">Raise Invoice</button></a>
                                            <h2>This month’s sales</h2>
                                            <h3>£28,782.92</h3>
                                            <h4>+£6,288,12 (32.11%)</h4>
                                        </div>
                                        <div class="col-5 mt-1">
                                            <img src="stylist/app-assets/images/gallery/file-sheet.svg" class="img-fluid"
                                                alt="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4 my-lg-0 my-2">
                                <div class="raise-bg  px-1 py-1">
                                    <h1 class="">Clients</h1>
                                    <p class="">Browse your current clients and pending new client requests</p>
                                    <div class="row">
                                        <div class="col-7 pr-0">
                                            <a href="client-page.html"><button class="btn">Browse</button></a>
                                            <h2>Current clients</h2>
                                            <h3>29</h3>
                                            <h4>+10 this month</h4>
                                        </div>
                                        <div class="col-5 mt-2">
                                            <img src="stylist/app-assets/images/gallery/people.svg" class="img-fluid" alt="">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4 my-lg-0 my-2">
                                <div class="raise-bg-img">
                                    <div class="raise-bg-img">
                                        <div class="layer"></div>
                                        <div class="text-over-img px-2 py-2">
                                            <h1>Make a sourcing request</h1>
                                            <p>Make or fufill luxury item source requests.</p>

                                            <a href="sourcing.html"><button class="btn">Explore</button></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-----------end of make request-------->
                        </div>
                    </div>
                    <!-------------------inbox------------>
                    <div class="col-lg-4">
                        <div id="inbox" class="py-2 px-2">
                            <h3>Inbox</h3>
                            <form action="">
                                <div class="row my-1">
                                    <div class="col-auto py-1">
                                        <img src="stylist/app-assets/images/icons/search.svg" class="img-fluid" alt="">
                                    </div>
                                    <!--end of col-->
                                    <div class="col-8">
                                        <input class="form-control form-control-borderless" type="search"
                                            placeholder="Search in Messages">
                                    </div>
                                    <!--end of col-->
                                    <div class="col-auto py-1">
                                        <a href=""><img src="stylist/app-assets/images/icons/navigator.svg" alt=""></a>
                                    </div>
                                </div>
                                <!--end of col-->
                            </form>
                            <div class="row">
                                <div class="col-6">
                                    <h2 class="">Direct Messages</h2>
                                </div>
                                <div class="col-6 text-right pr-3"><img src="stylist/app-assets/images/icons/add-content.svg"
                                        class="" alt=""></div>
                            </div>
                            <div class="row my-1">
                                <div class="col-6">
                                    <div class="row">
                                        <div>
                                            <img src="stylist/app-assets/images/gallery/input-img-1.svg"
                                                class="img-fluid mx-2 img-1" alt="">
                                            <div class="navigate"><span>3</span></div>
                                        </div>
                                        <h6 class="pt-1">Ina Perry</h6>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="row justify-content-end mx-1 pt-1">
                                        <h4 class="mx-2">Online</h4>
                                        <h5>12:45</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-6">
                                    <div class="row">
                                        <div>
                                            <img src="stylist/app-assets/images/gallery/input-img-3.svg"
                                                class="img-fluid mx-2 img-1" alt="">
                                            <div class="navigate"><span>2</span></div>
                                        </div>
                                        <h6 class="pt-1">Wesley Ray</h6>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="row justify-content-end mx-1 pt-1">
                                        <h4 class="mx-2">Online</h4>
                                        <h5>12:45</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-6">
                                    <div class="row">
                                        <div>
                                            <img src="stylist/app-assets/images/gallery/input-img-2.svg"
                                                class="img-fluid mx-2 img-1" alt="">
                                            <div class="navigate"><span>3</span></div>
                                        </div>
                                        <h6 class="pt-1">Eula Burton</h6>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="row justify-content-end mx-1 pt-1">
                                        <h4 class="mx-2 yellow-color">Work</h4>
                                        <h5>12:45</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-6">
                                    <div class="row">
                                        <div>
                                            <img src="stylist/app-assets/images/gallery/input-img-3.svg"
                                                class="img-fluid mx-2 img-1" alt="">
                                            <div class="navigate"><span>3</span></div>
                                        </div>
                                        <h6 class="pt-1">Ina Perry</h6>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="row justify-content-end mx-1 pt-1">
                                        <h4 class="mx-2">Online</h4>
                                        <h5>12:45</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-6">
                                    <div class="row">
                                        <div>
                                            <img src="stylist/app-assets/images/gallery/input-img-2.svg"
                                                class="img-fluid mx-2 img-1" alt="">
                                            <div class="navigate"><span>3</span></div>
                                        </div>
                                        <h6 class="pt-1">Eula Burton</h6>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="row justify-content-end mx-1 pt-1">
                                        <h4 class="mx-2 yellow-color">Work</h4>
                                        <h5>12:45</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col-6">
                                    <div class="row">
                                        <div>
                                            <img src="stylist/app-assets/images/gallery/input-img-2.svg"
                                                class="img-fluid mx-2 img-1" alt="">
                                            <div class="navigate"><span>3</span></div>
                                        </div>
                                        <h6 class="pt-1">Eula Burton</h6>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="row justify-content-end mx-1 pt-1">
                                        <h4 class="mx-2 yellow-color">Work</h4>
                                        <h5>12:45</h5>
                                    </div>
                                </div>
                            </div>
                            <div><a href=""><button class="show-more px-2">Show More Channels</button></a>
                            </div>
                            <div class=" mx-2 my-1"><a href="">
                                    <h6 class="support">Contact Support</h6>
                                </a></div>
                        </div>
                    </div>
                    <!-------------------end of inbox------------>
                </div>
                <!--------------------style news---------------->
                <div class=" mt-3" id="style-news">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>Style News</h1>
                        </div>
                        <!-- Pills navs -->
                        <div class="col-md-6 d-flex justify-content-end">
                            <ul id="myTab_1" role="tablist"
                                class="nav nav-tabs  flex-column flex-sm-row text-center  rounded-nav">
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
                                            <div class="carousel-caption d-none d-md-block text-left w-100">

                                                <div class="row pt-3 pb-1">
                                                    <div class="col-6">
                                                        <h1>The best bedroom pieces<br> from Soho Home</h1>
                                                    </div>
                                                    <div class="text-right col-4 mt-5">
                                                        <button class=" px-3 grey-bg">Browse</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="carousel-item">
                                        <img class="d-block" src="stylist/app-assets/images/gallery/1.jpg" alt="Second slide">
                                      </div>
                                      <div class="carousel-item">
                                        <img class="d-block" src="stylist/app-assets/images/gallery/11.jpg" alt="Third slide">
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
                                            <img class="d-block " src="stylist/app-assets/images/gallery/best-bedroom.svg"
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
                                        <img class="d-block" src="stylist/app-assets/images/gallery/1.jpg" alt="Second slide">
                                      </div>
                                      <div class="carousel-item">
                                        <img class="d-block" src="stylist/app-assets/images/gallery/11.jpg" alt="Third slide">
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
                                            <img class="d-block " src="stylist/app-assets/images/gallery/best-bedroom.svg"
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
                                        <img class="d-block" src="stylist/app-assets/images/gallery/1.jpg" alt="Second slide">
                                      </div>
                                      <div class="carousel-item">
                                        <img class="d-block" src="stylist/app-assets/images/gallery/11.jpg" alt="Third slide">
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
                                            <img class="d-block " src="stylist/app-assets/images/gallery/best-bedroom.svg"
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
                                        <img class="d-block" src="stylist/app-assets/images/gallery/1.jpg" alt="Second slide">
                                      </div>
                                      <div class="carousel-item">
                                        <img class="d-block" src="stylist/app-assets/images/gallery/11.jpg" alt="Third slide">
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
                            <div class="d-flex">
                                <h1>Browse Sourcing Requests</h1>
                                <h2 class="px-2 mt-1">1,092 requests this week</h2>
                                <a href="" class="browse-btn mt-2"><button class="browse px-2">Browse all
                                        requests</button></a>
                            </div>
                        </div>
                        <!-- Pills navs -->
                        <div class="col-lg-4 d-flex justify-content-end">
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
                                <div class="text-center mx-2 add-table-border">
                                    <table class="table  w-100 table-responsive borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-left pl-4">PRODUCT NAME</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Destination</th>
                                                <th scope="col">Due Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Hermes Mini Kelly 22
                                                </td>
                                                <td>N/A</td>
                                                <td>@Beg</td>
                                                <td>Hermes</td>
                                                <td>UAE</td>
                                                <td>31/09/22</td>
                                                <td class="green-color">Open</td>
                                                <td><button class="px-2">Fufill</button></td>
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Hermes Mini Kelly 22
                                                </td>
                                                <td>N/A</td>
                                                <td>@Beg</td>
                                                <td>Hermes</td>
                                                <td>UAE</td>
                                                <td>31/09/22</td>
                                                <td class="green-color">Open</td>
                                                <td><button class="px-2">Fufill</button></td>
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Hermes Mini Kelly 22
                                                </td>
                                                <td>N/A</td>
                                                <td>@Beg</td>
                                                <td>Hermes</td>
                                                <td>UAE</td>
                                                <td>31/09/22</td>
                                                <td class="green-color">Open</td>
                                                <td><button class="px-2">Fufill</button></td>
                                            </tr>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>Hermes Mini Kelly 22
                                                </td>
                                                <td>N/A</td>
                                                <td>@Beg</td>
                                                <td>Hermes</td>
                                                <td>UAE</td>
                                                <td>31/09/22</td>
                                                <td class="green-color">Open</td>
                                                <td><button class="px-2">Fufill</button></td>
                                            </tr>
                                            <tr style="border-bottom: 0px !important;">
                                                <td class="d-flex"><span class="dot"></span>Hermes Mini Kelly 22
                                                </td>
                                                <td>N/A</td>
                                                <td>@Beg</td>
                                                <td>Hermes</td>
                                                <td>UAE</td>
                                                <td>31/09/22</td>
                                                <td class="blue-color">Fufilled</td>
                                                <td><button class=" ticket-btn">Ticket Closed </button></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex px-2 mt-2">
                                    <div class="show-bg"><img src="stylist/app-assets/images/icons/show-more.svg" alt="">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="raise-bg px-1 py-1">
                                        <h1 class="">Payments Centre</h1>
                                        <p class="">See live updates about your raised invoices and their payment
                                            status.</p>
                                        <div class="row">
                                            <div class="col">
                                                <a href=""><button class="btn">Explore</button></a>
                                                <h2 class="pt-2">Orders this month</h2>
                                                <h3>237</h3>
                                                <h4>+39 this month</h4>
                                            </div>
                                            <div class="col mt-2">
                                                <img src="stylist/app-assets/images/icons/Card Payment.svg" class="img-fluid"
                                                    alt="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="my-2">
                                        <div class="raise-bg px-1 py-1">
                                            <h1 class="">Help Centre</h1>
                                            <p class="">Create and send an invoice to your clients for their latest
                                                order.</p>
                                            <div class="row">
                                                <div class="col">
                                                    <a href=""><button class="btn">Raise Invoice</button></a>
                                                    <h2 class="pt-2">Resource docs</h2>
                                                    <h3>130</h3>
                                                    <h4></h4>
                                                </div>
                                                <div class="col mt-2">
                                                    <img src="stylist/app-assets/images/icons/Help (2).svg" class="img-fluid"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="raise-bg px-1 py-1">
                                        <h1 class="">Reviews</h1>
                                        <p class="">Request positive client reviews to build your profile and get
                                            more
                                            clients.</p>
                                        <div class="row">
                                            <div class="col">
                                                <a href=""><button class="btn">Browse</button></a>
                                                <h2 class="pt-2">5* reviews</h2>
                                                <h3>11</h3>
                                                <h4>+7 this month</h4>
                                            </div>
                                            <div class="col mt-2">
                                                <img src="stylist/app-assets/images/icons/Very Popular Topic.svg"
                                                    class="img-fluid" alt="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="my-2">
                                        <div class="raise-bg px-1 py-1">
                                            <h1 class="">Affiliate</h1>
                                            <p class="">Browse StyleGrid’s partners where you can generate bonus
                                                affiliate income on top of sales commission.</p>
                                            <div class="row">
                                                <div class="col">
                                                    <a href=""><button class="btn">Browse</button></a>
                                                    <h2 class="pt-2">Affiliate partners</h2>
                                                    <h3>20</h3>
                                                    <h4>+10 this month</h4>
                                                </div>
                                                <div class="col mt-2">
                                                    <img src="stylist/app-assets/images/icons/Shopping Bag.svg"
                                                        class="img-fluid" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div id="notice-board" class="raise-bg_1 py-2">
                                <div class="row">
                                    <div class="col-9 px-3 py-1">
                                        <a href=""><button><span>UPDATES</span></button></a>
                                        <h1>Stylist Noticeboard</h1>
                                        <p class="mt-2">Live updates about our platform and new features coming soon.
                                        </p>
                                    </div>
                                    <div class="col-3">
                                        <img src="stylist/app-assets/images/icons/Pin.svg" class="img-fluid" alt="">
                                    </div>

                                </div>
                                <div class="mx-2" id="board-detail">
                                    <div class="row mx-2 my-1">
                                        <div class="col-9 px-3 py-1">
                                            <span>26/02/23</span>
                                            <h1>We are adding a task management feature!</h1>
                                            <p>Plan your day to give your clients the best service.</p>
                                        </div>
                                        <div class="col-3">
                                            <img src="stylist/app-assets/images/icons/notice-board.svg" class="img-fluid py-1"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="row mx-2 my-1">
                                        <div class="col-9 px-3 py-1">
                                            <span>26/02/23</span>
                                            <h1>We are adding a task management feature!</h1>
                                            <p>Plan your day to give your clients the best service.</p>
                                        </div>
                                        <div class="col-3">
                                            <img src="stylist/app-assets/images/icons/notice-board1.png" class="img-fluid py-1"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="row mx-2 my-1">
                                        <div class="col-9 px-3 py-1">
                                            <span>26/02/23</span>
                                            <h1>We are adding a task management feature!</h1>
                                            <p>Plan your day to give your clients the best service.</p>
                                        </div>
                                        <div class="col-3">
                                            <img src="stylist/app-assets/images/icons/notice2.svg" class="img-fluid py-1"
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
                    <div class="row py-5 px-4">
                        <div class="col-lg-6">

                            <div>
                                <h1 class="py-2 px-2">Bring your clients over to StyleGrid today.</h1>
                                <p class="px-2 w-75 pb-2">Use StyleGrid to manage your clients while harnessing the
                                    power of the grid to make
                                    sales. When your clients join StyleGrid, they pay no monthly membership.</p>
                                <a href="" class="px-2 py-2"> <button class="refer-btn  px-2">Refer
                                        Clients</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end pr-lg-2">
                        <h2 class="pr-5 pb-2">Terms & Condtions apply.</h2>
                    </div>
                </div>
                <!------------------end of refer-client------------->

            </div>
        </div>
        <!---------------footer----------->
        <div id="footer" class="mt-1 py-1">
            <div class="text-center py-4">
                <h1>STYLEGRID</h1>
            </div>
            <div class="row px-3">
                <div class="col">
                    <!-- Links -->
                    <h5 class="text-uppercase text-md-left text-center my-2">SHOPPING ONLINE</h5>

                    <ul class="list-unstyled text-md-left text-center">
                        <li>
                            <a href="#!">Track Your Order</a>
                        </li>
                        <li>
                            <a href="#!">Return Your Order</a>
                        </li>
                        <li>
                            <a href="#!">Delivery</a>
                        </li>
                        <li>
                            <a href="#!">Returns</a>
                        </li>
                        <li>
                            <a href="#!">Cookie Policy</a>
                        </li>
                        <li>
                            <a href="#!">Membership</a>
                        </li>
                    </ul>

                </div>
                <div class="col">
                    <!-- Links -->
                    <h5 class="text-uppercase text-md-left text-center my-2">SHOP</h5>

                    <ul class="list-unstyled text-md-left text-center">
                        <li>
                            <a href="#!">Brands</a>
                        </li>
                        <li>
                            <a href="#!">Mens Fashion</a>
                        </li>
                        <li>
                            <a href="#!">Womens Fashion</a>
                        </li>
                        <li>
                            <a href="#!">Interiors</a>
                        </li>
                        <li>
                            <a href="#!">Beauty</a>
                        </li>
                        <li>
                            <a href="#!">Travel</a>
                        </li>
                    </ul>

                </div>
                <div class="col">
                    <!-- Links -->
                    <h5 class="text-uppercase text-md-left text-center my-2">STYLE</h5>

                    <ul class="list-unstyled text-md-left text-center">
                        <li>
                            <a href="#!">Talk to a Stylist</a>
                        </li>
                        <li>
                            <a href="#!">Style Advice</a>
                        </li>
                        <li>
                            <a href="#!">Membership</a>
                        </li>
                        <li>
                            <a href="#!">Pricing</a>
                        </li>
                        <li>
                            <a href="#!">How it works</a>
                        </li>
                        <li>
                            <a href="#!">Editorial</a>
                        </li>
                    </ul>

                </div>
                <div class="col">
                    <!-- Links -->
                    <h5 class="text-uppercase text-md-left text-center my-2">SOURCE</h5>

                    <ul class="list-unstyled text-md-left text-center">
                        <li>
                            <a href="#!">Make Product Request</a>
                        </li>
                        <li>
                            <a href="#!">Browse Catalog</a>
                        </li>
                        <li>
                            <a href="#!">Fufill Request</a>
                        </li>
                        <li>
                            <a href="#!">Terms & Conditions</a>
                        </li>
                        <li>
                            <a href="#!">Verification</a>
                        </li>
                        <li>
                            <a href="#!">Search</a>
                        </li>
                    </ul>

                </div>
                <div class="col">
                    <!-- Links -->
                    <h5 class="text-uppercase text-md-left text-center my-2">CUSTOMER SERVICE</h5>

                    <ul class="list-unstyled text-md-left text-center">
                        <li>
                            <a href="#!">Chat with us 24/7 worldwide:</a>
                        </li>
                        <li>
                            <a href="#!">support@stylegrid.com</a>
                        </li>
                        <li>
                            <a href="#!">+44 322 022 5700</a>
                        </li>
                        <li>
                            <a href="#!">Returns</a>
                        </li>
                        <li>
                            <a href="#!">Shipping</a>
                        </li>
                        <li>
                            <a href="#!">FAQ’s</a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="row pt-3 justify-content-center">
                <div class="px-4 d-flex justify-content-center">
                    <p>Shop luxury brands. Talk to the best fashion & interior stylists. Source the most
                        in-demand products.</p>
                </div>
                <a href="" class="mt-2"><button class="talk-stylish py-1 px-2">Talk to a
                        stylist</button></a>
            </div>
            <hr>
            <div class="row justify-content-center mt-5" class="brands">
                <img src="stylist/app-assets/images/icons/pay.svg" alt="" class="mx-1">
                <img src="stylist/app-assets/images/icons/visa.svg" alt="" class="mx-1">
                <img src="stylist/app-assets/images/icons/america.svg" alt="" class="mx-1">
                <img src="stylist/app-assets/images/icons/mastercard.svg" alt="" class="mx-1">
                <img src="stylist/app-assets/images/icons/paypal.svg" alt="" class="mx-1">
            </div>
            <div class="row mt-4">
                <div class="col">
                    <a href="">
                        <h4>Accessibility</h4>
                    </a>
                </div>
                <div class="col">
                    <a href="">
                        <h4>Terms & Conditions</h4>
                    </a>
                </div>
                <div class="col">
                    <a href="">
                        <h4>Security & Privacy Policy</h4>
                    </a>
                </div>
                <div class="col">
                    <a href="">
                        <h4>© 2022 StyleGrid Limited. All Rights Reserved Website by APEX Marketing</h4>
                    </a>
                </div>
                <div class="col">
                    <a href="">
                        <h4>FOLLOW US</h4>
                    </a>
                </div>
                <div class="col">
                    <a href="">
                        <img src="stylist/app-assets/images/icons/facebook.svg" alt="">
                    </a>
                    <a href="">
                        <img src="stylist/app-assets/images/icons/instagram.svg" alt="">
                    </a>
                    <a href="">
                        <img src="stylist/app-assets/images/icons/twitter.svg" alt="">
                    </a>
                    <a href="">
                        <img src="stylist/app-assets/images/icons/linked.svg" alt="">
                    </a>
                    <a href="">
                        <img src="stylist/app-assets/images/icons/pp.svg" alt="">
                    </a>
                    <a href="">
                        <img src="stylist/app-assets/images/icons/youtube.svg" alt="">
                    </a>
                </div>
            </div>
        </div>
        <!---------------end of footer----------->
    </div>
	   @include("stylist.postloginview.partials.footer.footerjs")
 