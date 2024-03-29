<!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
        <div class="main-menu-content">

            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <!-- <a class="nav-link close-navbar text-right pr-2 d-lg-none d-block"><i class="ft-x"></i></a> -->
                <!--li class="nav-item"><a href=""><i class="box-shadow mr-5">
                    <img src="{{ asset('/member/dashboard/app-assets/images/icons/User.svg') }}"
                                alt=""><img src="{{ asset('/member/dashboard/app-assets/images/icons/Bell.svg') }}" alt=""
                                style="margin-left: 3px"></i><span class="menu-title">
                            <i class="box-shadow ml-5"><img src="{{ asset('/member/dashboard/app-assets/images/icons/Gear.svg') }}" alt="">
                                <img src="{{ asset('/member/dashboard/app-assets/images/icons/Help.svg') }}" style="margin-left: 3px" alt=""></i>
                        </span>
                    </a>
                </li-->

                <li class="nav-item text-center" style="margin-top: 50px;">
                    <div class="stylish-img">
                        <img src="{{ asset('common/images/default_user.jpeg') }}" class="img-fluid sidemnu_img_avtar" alt="">
                    </div>

                <li class="nav-item"><a href="" class="py-0 pl-3 text-center" style="line-height: 0px;"><span
                            class="menu-title" data-i18n="">
                            <h2 class="stylish-name">{{Session::get('member_data')->name}}</h2><br>

                        </span></a> </li>
                <li class="nav-item"><a href="" class="py-0 pl-3 text-center"><span class="menu-title profession"
                            data-i18n="">Member</span></a> </li>
                </li>
                <!-- <li class="nav-item"><a href="" class="py-1 pl-5 text-center"><span
                        class="menu-title profession" data-i18n=""><img
                            src="app-assets/images/gallery/check-mark.png" alt=""></span></a> </li> -->
                </li>
                <li class=" nav-item mt-2"><a href="{{ url('/member-dashboard') }}" class="{{ request()->is('member-dashboard*') ? 'active' : '' }}"><i class="ft-home {{ request()->is('member-dashboard*') ? 'active' : '' }}"></i><span class="menu-title"
                            data-i18n="">Home</span></a>
                </li>
                <li class=" nav-item"><a href="{{ route('member.messanger.index') }}" class="{{ request()->is('member-messanger*') ? 'active' : '' }}"><i class="ft-layers {{ request()->is('member-messanger*') ? 'active' : '' }}"></i><span class="menu-title"
                            data-i18n="">Messenger</span></a>
                </li>
                <li class=" nav-item"><a href="{{ route('member.cart.index') }}" class="{{ request()->is('member-cart*') ? 'active' : '' }}"><i class="ft-monitor"></i><span class="menu-title"
                            data-i18n="">Shop</span></a>
                </li>
                <li class=" nav-item"><a href="{{ url('/member-grid') }}" class="{{ request()->is('member-grid*') ? 'active' : '' }}"><i class="ft-layout {{ request()->is('member-grid*') ? 'active' : '' }}"></i><span class="menu-title"
                            data-i18n="">Grids</span></a>

                </li>
                <li class=" nav-item"><a href="{{ url('/member-sourcing') }}" class="{{ request()->is('member-sourcing*') ? 'active' : '' }}"><i class="ft-zap {{ request()->is('member-sourcing*') ? 'active' : '' }}"></i><span
                            class="menu-title" data-i18n="">Sourcing</span></a>

                </li>
                <li class=" nav-item "><a href="{{ url('/member-orders') }}" class="{{ request()->is('member-orders*') ? 'active' : '' }}"><i class="ft-aperture {{ request()->is('member-orders*') ? 'active' : '' }}"></i><span class="menu-title"
                            data-i18n="">Orders</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-box"></i><span class="menu-title"
                            data-i18n="">Settings</span></a>

                </li>
                <li class=" nav-item"><a href="https://stylegrid.com/editorial/" target="_blank"><i class="ft-edit"></i><span class="menu-title" data-i18n="">Style
                            News</span></a>

                </li>
                <li class=" nav-item"><a href="javascript:void(0)" id="referModalclick"><i class="ft-grid"></i><span class="menu-title"
                            data-i18n="">Refer</span></a>

                </li>
                <li class=" nav-item"><a href="#"><i class="ft-bar-chart-2"></i><span class="menu-title"
                            data-i18n="">Help Centre</span></a>

                </li>

                <li class=" nav-item"><a href="{{ route('member.notifications.index') }}" class="{{ request()->is('member-notifications*') ? 'active' : '' }}"><i class="ft-layers {{ request()->is('member-notifications*') ? 'active' : '' }}"></i><span class="menu-title"
                    data-i18n="">Notifications</span></a>
                   

                <li class=" nav-item"><a href="{{url('/member-logout')}}" class="{{ request()->is('member-logout*') ? 'active' : '' }}"><i class="ft-sidebar {{ request()->is('member-logout*') ? 'active' : '' }}"></i><span class="menu-title" data-i18n="">Sign
                            Out</span></a>
                </li>

            </ul>
            <div class="row mx-1 py-1 social-media-border my-4">
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/Instagram.png') }}" alt=""></a></div>
                <div class="mx-auto"><a href=""><img src="{{ asset('member/dashboard/app-assets/images/icons/Facebook.png') }}" alt=""></a></div>
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