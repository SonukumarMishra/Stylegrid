@extends('admin.layouts.default')
@section('content')
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class=" mt-lg-3 ">
                <div class="">
                    <h1>Settings</h1>
                    <h3>Update admin settings.</h3>
                    <!-- <a href=""><button class="grid-btn">Create Grid</button></a> -->
                </div>

            </div>
            <div id="welcome-setting" class="mt-4">
                <div class="welcome-setting-bg">
                    <div class="setting-text-pos">
                        <div class="setting-text">Welcome to your settings hub.</div>
                        <div class="setting-text-1">Update promotions, manage membership,<br
                                class="d-md-block d-none"> payments and more.</div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-4  mb-2">
                        <div class="welcome-setting-grid-bg">
                            <div class="setting-inner-text-pos">
                                <div class="setting-inner-text">Profile</div>
                                <div class="d-flex"><a href="<?php echo url('admin-profile-settings')?>">
                                        <div class="setting-inner-text-1">Update your profile settings. <img
                                                src="<?php echo  asset('admin-section/assets/images/arrow.png')?>" class="img-fluid ml-5"
                                                alt=""></div>
                                    </a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <div class="welcome-setting-grid-bg-grey">
                            <div class="setting-inner-text-pos">
                                <div class="setting-inner-text">Promotions</div>
                                <div class="d-flex"><a href="./admin-profile-setting.html">
                                        <div class="setting-inner-text-1">Update your profile settings. <img
                                                src="<?php echo  asset('admin-section/assets/images/arrow.png')?>" class="img-fluid ml-5"
                                                alt=""></div>
                                    </a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mb-2">
                        <div class="welcome-setting-grid-bg-light-grey">
                            <div class="setting-inner-text-pos">
                                <div class="setting-inner-text">Payments</div>
                                <div class="d-flex"><a href="">
                                        <div class="setting-inner-text-1">Update your profile settings. <img
                                                src="<?php echo  asset('admin-section/assets/images/arrow.png')?>" class="img-fluid ml-5"
                                                alt=""></div>
                                    </a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mb-2">
                        <div class="welcome-setting-grid-bg-light-green">
                            <div class="setting-inner-text-pos">
                                <div class="setting-inner-text">Rewards</div>
                                <div class="d-flex"><a href="">
                                        <div class="setting-inner-text-1">Update your profile settings. <img
                                                src="<?php echo  asset('admin-section/assets/images/arrow.png')?>" class="img-fluid ml-5"
                                                alt=""></div>
                                    </a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mb-2">
                        <div class="welcome-setting-grid-bg-light-greenn">
                            <div class="setting-inner-text-pos">
                                <div class="setting-inner-text">Order Settings</div>
                                <div class="d-flex"><a href="">
                                        <div class="setting-inner-text-1">Update your profile settings. <img
                                                src="<?php echo  asset('admin-section/assets/images/arrow.png')?>" class="img-fluid ml-5"
                                                alt=""></div>
                                    </a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4  mb-2">
                        <div class="welcome-setting-grid-bg-dark-green">
                            <div class="setting-inner-text-pos">
                                <div class="setting-inner-text">Client Assignment</div>
                                <div class="d-flex"><a href="">
                                        <div class="setting-inner-text-1">Update your profile settings. <img
                                                src="<?php echo  asset('admin-section/assets/images/arrow.png')?>" class="img-fluid ml-5"
                                                alt=""></div>
                                    </a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
         <!--  Cancel Modal -->
         
</div>
@include('admin.includes.footer')
<script>
 </script>
@stop


