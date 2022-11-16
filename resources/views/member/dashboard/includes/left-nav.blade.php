<!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
        <div class="main-menu-content">

            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <a class="nav-link close-navbar text-right pr-2 d-lg-none d-block"><i class="ft-x"></i></a>
                <li class="nav-item"><a href=""><i class="box-shadow mr-5"><img src="{{ asset('/member/dashboard/app-assets/images/icons/User.svg') }}"
                                alt=""><img src="{{ asset('/member/dashboard/app-assets/images/icons/Bell.svg') }}" alt=""
                                style="margin-left: 3px"></i><span class="menu-title">
                            <i class="box-shadow ml-5"><img src="{{ asset('/member/dashboard/app-assets/images/icons/Gear.svg') }}" alt="">
                                <img src="{{ asset('/member/dashboard/app-assets/images/icons/Help.svg') }}" style="margin-left: 3px" alt=""></i>
                        </span>
                    </a>
                </li>

                <li class="nav-item text-center">
                    <div class="stylish-img"><img src="{{ asset('/member/dashboard/app-assets/images/gallery/Profile Picture (1).png') }}"
                            class="img-fluid" alt="">
                    </div>

                <li class="nav-item"><a href="" class="py-0 pl-5 text-center" style="line-height: 0px;"><span
                            class="menu-title" data-i18n="">
                            <h2 class="stylish-name">{{Session::get('member_data')->name}}</h2><br>

                        </span></a> </li>
                <li class="nav-item"><a href="" class="py-0 pl-5 text-center"><span class="menu-title profession"
                            data-i18n="">Member</span></a> </li>
                </li>
                <!-- <li class="nav-item"><a href="" class="py-1 pl-5 text-center"><span
                        class="menu-title profession" data-i18n=""><img
                            src="app-assets/images/gallery/check-mark.png" alt=""></span></a> </li> -->
                </li>
                <li class=" nav-item mt-5"><a href="{{ url('/member-dashboard') }}"><i class="ft-home"></i><span class="menu-title"
                            data-i18n="">Home</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="ft-layers"></i><span class="menu-title"
                            data-i18n="">Messenger</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="ft-monitor"></i><span class="menu-title"
                            data-i18n="">Shop</span></a>
                </li>
                <li class=" nav-item"><a href="{{ url('/member-grid') }}"><i class="ft-layout"></i><span class="menu-title"
                            data-i18n="">Grids</span></a>

                </li>
                <li class=" nav-item"><a href="{{ url('/member-sourcing') }}" class="active"><i class="ft-zap active"></i><span
                            class="menu-title" data-i18n="">Sourcing</span></a>

                </li>
                <li class=" nav-item "><a href="{{ url('/member-orders') }}" class=""><i class="ft-aperture "></i><span class="menu-title"
                            data-i18n="">Orders</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-box"></i><span class="menu-title"
                            data-i18n="">Settings</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-edit"></i><span class="menu-title" data-i18n="">Style
                            News</span></a>

                </li>
                <li class=" nav-item mt-5"><a href="#"><i class="ft-grid"></i><span class="menu-title"
                            data-i18n="">Refer</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-bar-chart-2"></i><span class="menu-title"
                            data-i18n="">Help Centre</span></a>

                </li>
                <li class=" nav-item"><a href="{{url('/member-logout')}}"><i class="ft-sidebar"></i><span class="menu-title" data-i18n="">Sign
                            Out</span></a>
                </li>

            </ul>
            <div class="row mx-1 py-1 social-media-border my-4">
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/Instagram.png') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/facebook.png') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/Twitter Squared.png') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/TikTok.png') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/LinkedIn.png') }}" alt=""></a></div>
            </div>
            <div class="text-center my-2 term-policies"><span>Terms & Conditions</span><br>
                <span>Policies</span>
            </div>
        </div>
    </div>
    <!-- END: Main Menu-->