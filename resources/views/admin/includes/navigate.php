
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
                    <ul class="style-logo mr-auto ml-5 list-unstyled d-flex">
                        <li class="ml-5"><a href="" class="ml-4"><img src="<?php echo   asset('admin-section/app-assets/images/icons/logo.png')?>" alt="" class="logo1 ml-5"></a></li>
                        <li><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/STYLEGRID-LOGO.png')?>" alt=""
                                    class="logo2 pl-1 d-lg-block d-none my-1"></a></li>
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

                <!-- <a class="nav-link close-navbar text-right pr-2 d-lg-none d-block"><i class="ft-x"></i></a>
                <li class="nav-item"><a href=""><i class="box-shadow mr-5"><img src="<?php echo  asset('admin-section/app-assets/images/icons/User.svg')?>"
                                alt=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/Bell.svg')?>" alt=""
                                style="margin-left: 3px"></i><span class="menu-title">
                            <i class="box-shadow ml-5"><img src="<?php echo  asset('admin-section/app-assets/images/icons/Gear.svg')?>" alt="">
                                <img src="<?php echo  asset('admin-section/app-assets/images/icons/Help.svg')?>" style="margin-left: 3px" alt=""></i>
                        </span>
                    </a>
                </li> -->
                <li class="nav-item text-center" style="margin-top:50px;">
                <?php
                    if(is_file('attachments/admin/profile/'.Session::get("admin_data")->image)){
                        $image='attachments/admin/profile/'.Session::get("admin_data")->image; 
                    }else{
                        $image='admin-section/app-assets/images/gallery/admin-profile-photo.png'; 
                    }
                    ?>
                    <div class="stylish-img"><img src="<?php echo  asset($image)?>"
                            class="img-fluid sidemnu_img_avtar" alt="" style="width:111px;">
                    </div>
                </li>

                <li class="nav-item"><a href="" class="py-0 pl-3 text-center" style="line-height: 0px;"><span
                            class="menu-title" data-i18n="">
                            <h2 class="stylish-name">Georgia Fox</h2><br>

                        </span></a> </li>
                <li class="nav-item"><a href="" class="py-0 pl-3 text-center"><span class="menu-title profession"
                            data-i18n="">Admin</span></a> </li>

                <li class=" nav-item mt-5">
                    <a href="<?php echo url('/admin-dashboard');?>" <?php if(Request::path()=='admin-dashboard') { ?>class="active"<?php } ?> >
                        <i class="ft-home <?php if(Request::path()=='admin-dashboard') { ?>active<?php } ?>"></i>
                        <span class="menu-title" data-i18n="">Home</span>
                    </a>
                </li>
                <li class=" nav-item"><a href="<?php echo url('/admin-upload-product');?>" <?php if(Request::path()=='admin-upload-product') { ?>class="active"<?php } ?>><i class="ft-layers <?php if(Request::path()=='admin-upload-product') { ?>active<?php } ?>"></i><span class="menu-title"
                            data-i18n="">Product</span></a>
                </li>
                <li class="nav-item"><a href="<?php echo url('/admin-member-list')?>" <?php if(Request::path()=='admin-member-list') { ?>class="active"<?php } ?>><i class="ft-monitor <?php if(Request::path()=='admin-member-list') { ?>active<?php } ?>"></i><span class="menu-title"
                            data-i18n="">Members</span></a>
                </li>
                <li class=" nav-item"><a href="<?php echo url('/admin-stylist')?>" <?php if(Request::path()=='admin-stylist') { ?>class="active"<?php } ?>><i class="ft-layout <?php if(Request::path()=='admin-stylist') { ?>active<?php } ?>"></i><span
                            class="menu-title" data-i18n="">Stylists</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-zap"></i><span class="menu-title"
                            data-i18n="">Orders</span></a>

                </li>
                <li class=" nav-item"><a href="<?php echo url('/admin-messanger')?>" <?php if(Request::path()=='admin-messanger') { ?>class="active"<?php } ?>><i class="ft-layers <?php if(Request::path()=='admin-messanger') { ?>active<?php } ?>"></i><span class="menu-title"
                            data-i18n="">Chats</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-box"></i><span class="menu-title"
                            data-i18n="">Finances</span></a>

                </li>
                <li class=" nav-item"><a href="<?php echo url('/admin-settings');?>" <?php if(Request::path()=='admin-settings' || 'admin-profile-settings') { ?>class="active"<?php } ?>><i class="ft-edit <?php if(Request::path()=='admin-settings' || 'admin-profile-settings') { ?>active<?php } ?>"></i><span class="menu-title" data-i18n="">Settings</span></a>

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
                <div class="mx-auto"><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/Facebook.png')?>" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/Twitter Squared.png')?>" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/TikTok.png')?>" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="<?php echo  asset('admin-section/app-assets/images/icons/LinkedIn.png')?>" alt=""></a></div>
            </div>
            <div class="text-center my-2 term-policies"><span>Terms & Conditions</span><br>
                <span>Policies</span>
            </div>
        </div>
    </div>