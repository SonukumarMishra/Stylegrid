<body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu"
    data-color="bg-gradient-x-purple-blue" data-col="2-columns">
    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="collapse navbar-collapse show d-flex" id="navbar-mobile">
                    <ul class="nav navbar-nav  float-left">
                        
                        <li class="nav-item  d-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                href="#"><i class="ft-menu"></i></a></li>
    
                        <li class="dropdown nav-item mega-dropdown d-lg-block d-none"><a
                                class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Hi {{Session::get('stylist_data')->name}}! Welcome to
                                your StyleGrid Dashboard.</a>
    
                        </li>
    
    
                    </ul>
                    <ul class="style-logo mr-auto ml-5 list-unstyled d-flex">
                        <li class="ml-5"><a href="" class="ml-4"><img src="{{ asset('stylist/app-assets/images/icons/logo.png') }}" alt="" class="logo1 ml-5"></a></li>
                          <li><a href=""><img src="{{ asset('stylist/app-assets/images/icons/STYLEGRID-LOGO.png') }}" alt="" class="logo2 pl-1 d-lg-block d-none my-1"></a></li>
                    </ul>
                    <ul class="nav navbar-nav float-right">

                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="{{ route('stylist.subscription.index') }}">
                                <img src="{{ asset('/member/dashboard/app-assets/images/icons/subscription.png') }}" title="subscription" height="20" width="20">
                            </a>
                        </li>
                        
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                                <img src="{{ asset('stylist/app-assets/images/icons/Bell.svg') }}" alt="">
                              <span class="badge badge-pill badge-danger badge-up notify-badge hidden" id="notify-badge-count"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right header-notiifcation-container">
                              <li class="dropdown-menu-header hidden" id="notify-read-all-container">
                                <div class="dropdown-header px-1 py-75 d-flex justify-content-between">
                                  <span class="notification-title" id="notify-badge-count-title"></span>
                                  <span class="text-bold-400 cursor-pointer" id="notify-all-read-btn">Mark all as read</span>
                                </div>
                              </li>
                              <li class="scrollable-container media-list" id="unread-notifications-container">
                              
                              
                              </li>
                              <li class="dropdown-menu-footer">
                                <a class="p-50  d-flex justify-content-center notification-footer" href="{{ route('stylist.notifications.index') }}">View all notifications</a>
                              </li>
                            </ul>
                        </li> 
                        <!--li>
                            <div class="search-container">
                                <form action="/action_page.php">
                                    <input type="text" placeholder="Search anything" name="search "
                                        class="px-2 search-top">
                                    <button type="submit"><img src="{{ asset('stylist/app-assets/images/icons/Search-right.png') }}"
                                            alt=""></button>
                                </form>
                            </div>
                        </li-->
    
                    </ul>
                </div>
            </div>
        </div>
    </nav><!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
        <div class="main-menu-content">

            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <a class="nav-link close-navbar text-right pr-2 d-lg-none d-block"><i class="ft-x"></i></a>
                <!--li class="nav-item"><a href=""><i class="box-shadow mr-5"><img src="{{ asset('stylist/app-assets/images/icons/User.svg') }}"
                                alt=""><img src="{{ asset('stylist/app-assets/images/icons/Bell.svg') }}" alt=""
                                style="margin-left: 3px"></i><span class="menu-title">
                            <i class="box-shadow ml-5"><img src="{{ asset('stylist/app-assets/images/icons/Gear.svg') }}" alt="">
                                <img src="{{ asset('stylist/app-assets/images/icons/Help.svg') }}" style="margin-left: 3px" alt=""></i>
                        </span>
                    </a>
                </li-->

                <li class="nav-item text-center" style="margin-top: 50px;">
                    <div class="stylish-img">
                        <?php 
                        if(Session::get('stylist_data')->profile_image != ''){
                            $image = Session::get('stylist_data')->profile_image;
							// $image= asset('stylist/app-assets/images/gallery/stylist.png');
                        }else{
                            $image = asset('common/images/default_user.jpeg');
                        }
                       
                        ?>
                        <!-- <img src="{{ $image }}" class="img-fluid sidemnu_img_avtar" alt=""> -->
                        
                        <img src="{{ $image }}" class="img-fluid sidemnu_img_avtar" alt="">
                    </div>

                <li class="nav-item"><a href="" class="py-0 pl-3 text-center" style="line-height: 0px;"><span
                            class="menu-title" data-i18n="">
                            <h2 class="stylish-name">{{Session::get('stylist_data')->name}}</h2><br>

                        </span></a> </li>
                <li class="nav-item"><a href="" class="py-0 pl-3 text-center"><span class="menu-title profession"
                            data-i18n="">Stylist</span></a> </li>
                </li>
                <li class="nav-item"><a href="" class="py-1 pl-3 text-center"><span class="menu-title profession"
                            data-i18n=""><img src="{{ asset('stylist/app-assets/images/gallery/check-mark.png') }}" alt=""></span></a> </li>
                </li>
                <li class=" nav-item mt-5"><a href="/stylist-dashboard" class="{{ request()->is('stylist-dashboard*') ? 'active' : '' }}"><i class="ft-home {{ request()->is('stylist-dashboard*') ? 'active' : '' }}"></i><span class="menu-title"
                            data-i18n="">Home</span></a>
                </li>
                <li class=" nav-item"><a href="{{ route('stylist.messanger.index') }}" class="{{ request()->is('stylist-messanger*') ? 'active' : '' }}"><i class="ft-layers {{ request()->is('stylist-messanger*') ? 'active' : '' }}"></i><span class="menu-title"
                            data-i18n="">Messenger</span></a>
                </li>
                <li class=" nav-item"><a href="{{ route('stylist.grid.index') }}" class="{{ request()->is('stylist-grid*') ? 'active' : '' }}"><i class="ft-monitor {{ request()->is('stylist-grid*') ? 'active' : '' }}"></i><span
                            class="menu-title" data-i18n="">Grids</span></a>
                </li>
                <li class=" nav-item"><a href="{{ route('stylist.payment.index') }}" class="{{ request()->is('stylist-payment*') ? 'active' : '' }}"><i class="ft-layout  {{ request()->is('stylist-payment*') ? 'active' : '' }}"></i><span class="menu-title"
                            data-i18n="">Payments</span></a>

                </li>
                <li class=" nav-item"><a href="{{ route('stylist.client.index') }}" class="{{ request()->is('stylist-client*') ? 'active' : '' }}"><i class="ft-zap {{ request()->is('stylist-client*') ? 'active' : '' }}"></i><span class="menu-title"
                            data-i18n="">Clients</span></a>

                </li>
                <li class=" nav-item"><a href="{{url('/stylist-sourcing')}}" class="{{ request()->is('stylist-sourcing*') ? 'active' : '' }}"><i class="ft-aperture {{ request()->is('stylist-sourcing*') ? 'active' : '' }}"></i><span class="menu-title" data-i18n="">Sourcing</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-box"></i><span class="menu-title"
                            data-i18n="">Settings</span></a>

                </li>
                <li class=" nav-item"><a href="https://stylegrid.com/editorial/" target="_blank"><i class="ft-edit"></i><span class="menu-title" data-i18n="">Style
                            News</span></a>
                            <!-- <button class="refer-btn  px-2 ml-2" data-toggle="modal" data-target="#referModal">Refer Clients</button> -->
                </li>
                 <li class=" nav-item">
                    <a href="javascript:void(0)" id="referModalclick">
                        <i class="ft-grid"></i><span class="menu-title"
                            data-i18n="">Refer</span></a>
                             <!-- <button class="px-2 ml-2" data-toggle="modal" data-target="#referModal"><i class="ft-grid"></i> <span class="menu-title"
                            data-i18n="">Refer</span></button> -->
                </li>
                <li class=" nav-item"><a href="#"><i class="ft-bar-chart-2"></i><span class="menu-title"
                            data-i18n="">Help Centre</span></a>

                </li>
                <li class=" nav-item"><a href="{{ route('stylist.notifications.index') }}" class="{{ request()->is('stylist-notifications*') ? 'active' : '' }}"><i class="ft-layers {{ request()->is('stylist-notifications*') ? 'active' : '' }}"></i><span class="menu-title"
                    data-i18n="">Notifications</span></a>
                    
                <!-- <li class=" nav-item"><a href="{{url('stylist-logout')}}" class="{{ request()->is('stylist-logout*') ? 'active' : '' }}"><i class="ft-sidebar"></i><span class="menu-title" data-i18n="">Sign -->
                    <li class=" nav-item"><a href="{{url('stylist-logout')}}" class="{{ request()->is('stylist-logout*') ? 'active' : '' }}"><i class="ft-sidebar "></i><span class="menu-title" data-i18n="">Sign
                            Out</span></a>

                </li>
                <li>
                    
                </li>

            </ul>

             <div class="row mx-1 py-1 social-media-border my-4">
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/Instagram.png') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/Facebook.png') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/Twitter Squared.png') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/TikTok.png') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/LinkedIn.png') }}" alt=""></a></div>
            </div>
            <!--div class="row mx-1 py-1 social-media-border my-4">
                <div class="mx-auto"><a href=""><img src="{{ asset('stylist/app-assets/images/icons/call.svg') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('stylist/app-assets/images/icons/email.svg') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('stylist/app-assets/images/icons/telegram.svg') }}" alt=""></a></div>
               
                <div class="mx-auto"><a href=""><img src="{{ asset('stylist/app-assets/images/icons/action.svg') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('stylist/app-assets/images/icons/whatsap.png') }}" alt=""></a></div>
            </div-->
            <div class="text-center my-2 term-policies"><span>Terms & Conditions</span><br>
                <span>Policies</span>
            </div>
        </div>
          <!-- Refer Client Modal -->
<div class="modal fade" id="referModal" tabindex="-1" role="dialog" aria-labelledby="referModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="">
            <div class="modal-content">
                <div class="modal-header">
                        <button type="button" class="close mt-1" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                        <h5 class="modal-title text-center refer-modal-title" id="referModalLabel">Refer and save!</h5>
                        <p class="px-4">Share your unique referral code to your network and receive a month free for each sign up.</p>
                </div>
                <div class="modal-footer pt-0 ">
                    <div class="container text-center pb-3">
                        <input type="text" id="copy-refer-code" value="Unique code to go here" readonly/>
                        <button onclick="copy('copy-refer-code')" class="pl-0 copy-refer-code">Copy</button>
                        <div class="share-power mt-2">Share the power of StyleGrid today!</div>
                    </div>
                   
                </div>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
    </div>
</div>
    </div>
   
    <!-- END: Main Menu-->