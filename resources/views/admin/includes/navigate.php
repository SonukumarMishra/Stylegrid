
<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu"
    data-color="bg-gradient-x-purple-blue" data-col="2-columns">
    <!-- BEGIN: Header-->
    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="collapse navbar-collapse show d-flex" id="navbar-mobile">
                    <ul class="nav navbar-nav  float-left">

                        <li class="nav-item  d-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                href="#"><i class="ft-menu"></i></a></li>

                        <li class="dropdown nav-item mega-dropdown d-lg-block d-none"><a
                                class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Hi Georgia! Welcome to
                                your StyleGrid Dashboard.</a>

                        </li>


                    </ul>
                    <ul class="style-logo mx-auto list-unstyled d-flex">
                        <li><a href=""><img src="<?php echo   asset('admin-section/app-assets/images/icons/logo.png')?>" alt="" class="logo1"></a></li>
                        <!-- <li><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/logo.png')?>" alt=""
                                    class="logo2 pl-1 d-lg-block d-none my-1"></a></li> -->
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li>
                            <div class="search-container">
                                <form action="/action_page.php">
                                    <input type="text" placeholder="Search anything" name="search "
                                        class="px-2 search-top">
                                    <button type="submit"><img src="<?php echo  asset('admin-section/app-assets/images/icons/Search-right.png')?>"
                                            alt=""></button>
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
        <div class="main-menu-content">

            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                <a class="nav-link close-navbar text-right pr-2 d-lg-none d-block"><i class="ft-x"></i></a>
                <li class="nav-item"><a href=""><i class="box-shadow mr-5"><img src="<?php echo  asset('admin-section/app-assets/images/icons/User.svg')?>"
                                alt=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/Bell.svg')?>" alt=""
                                style="margin-left: 3px"></i><span class="menu-title">
                            <i class="box-shadow ml-5"><img src="<?php echo  asset('admin-section/app-assets/images/icons/Gear.svg')?>" alt="">
                                <img src="<?php echo  asset('admin-section/app-assets/images/icons/Help.svg')?>" style="margin-left: 3px" alt=""></i>
                        </span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <div class="stylish-img"><img src="<?php echo  asset('admin-section/app-assets/images/gallery/admin-profile-photo.png')?>"
                            class="img-fluid" alt="">
                    </div>
                </li>    
                <li class="nav-item"><a href="" class="py-0 pl-5 text-center" style="line-height: 0px;"><span
                            class="menu-title" data-i18n="">
                            <h2 class="stylish-name">Georgia Fox</h2><br>

                        </span></a> </li>
                <li class="nav-item"><a href="" class="py-0 pl-5 text-center"><span class="menu-title profession"
                            data-i18n="">Admin</span></a> </li>

                <li class=" nav-item mt-5"><a href="{{url('/admin-dashboard')}}"class="active"><i class="ft-home active"></i><span class="menu-title"
                            data-i18n="">Home</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="ft-layers"></i><span class="menu-title"
                            data-i18n="">Product</span></a>
                </li>
                <li class="snav-item"><a href="<?php echo url('/admin-member-list')?>"><i class="ft-monitor"></i><span class="menu-title"
                            data-i18n="">Members</span></a>
                </li>
                <li class=" nav-item"><a href="<?php echo url('/admin-stylist')?>" ><i class="ft-layout "></i><span
                            class="menu-title" data-i18n="">Stylists</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-zap"></i><span class="menu-title"
                            data-i18n="">Orders</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-aperture"></i><span class="menu-title"
                            data-i18n="">Chats</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-box"></i><span class="menu-title"
                            data-i18n="">Finances</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-edit"></i><span class="menu-title" data-i18n="">Settings</span></a>

                </li>
                <li class=" nav-item mt-5"><a href="#"><i class="ft-grid"></i><span class="menu-title"
                            data-i18n="">Website Admin</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-bar-chart-2"></i><span class="menu-title"
                            data-i18n="">Support Tickets</span></a>

                </li>
                <li class="nav-item"><a href="<?php echo url('/admin-logout');?>"><i class="ft-sidebar"></i><span class="menu-title" data-i18n="">Sign
                            Out</span></a>
                </li>
            </ul>
            <div class="row mx-1 py-1 social-media-border my-4">
                <div class="mx-auto"><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/Instagram.png')?>" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/facebook.png')?>" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/Twitter Squared.png')?>" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/TikTok.png')?>" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/LinkedIn.png')?>" alt=""></a></div>
            </div>
            <div class="text-center my-2 term-policies"><span>Terms & Conditions</span><br>
                <span>Policies</span>
            </div>
        </div>
    </div>