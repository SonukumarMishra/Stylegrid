
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
                                class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Hi {{Session::get('member_data')->name}}! Welcome to
                                your StyleGrid Dashboard.</a>
    
                        </li>
    
    
                    </ul>
                    <ul class="style-logo mx-auto list-unstyled d-flex">
                        <li><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/logo.png') }}" alt="" class="logo1"></a></li>
                          <li><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/STYLEGRID-LOGO.png') }}" alt="" class="logo2 pl-1 d-lg-block d-none my-1"></a></li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-notification nav-item">
                            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                                <img src="{{ asset('/member/dashboard/app-assets/images/icons/Bell.svg') }}" alt="">
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
                                <a class="p-50  d-flex justify-content-center notification-footer" href="{{ route('member.notifications.index') }}">View all notifications</a>
                              </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-notification nav-item">
                            @php
                                $header_cart_count = \Helper::getUserCartItemsCount([
                                                                                        'auth_id' => Session::get("member_id"),
                                                                                        'auth_user' =>  'member'
                                                                                    ]);

                            @endphp
                            <a class="nav-link nav-link-label" href="{{ route('member.cart.index') }}">                               
                                <img src="{{ asset('member/dashboard/app-assets/images/gallery/Shopping Bag.png') }}" height="20" width="20" alt="">
                                <span class="badge badge-pill badge-danger badge-up cart-badge-count" style="display:{{ $header_cart_count == 0 ? 'none' : 'block'}};">{{ $header_cart_count }}</span>
                            </a>
                        </li>       
                        <li>
                            <div class="search-container">
                                <form action="/action_page.php">
                                    <input type="text" placeholder="Search anything" name="search "
                                        class="px-2 search-top">
                                    <button type="submit"><img src="{{ asset('member/dashboard/app-assets/images/icons/Search-right.png') }}"
                                            alt=""></button>
                                </form>
                            </div>
                        </li>
    
                    </ul>
                </div>
            </div>
        </div>
    </nav>