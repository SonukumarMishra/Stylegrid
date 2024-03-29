@extends('admin.layouts.default')
@section('content')


<style>
    #billing-tab-container .table thead th, #billing-tab-container .table tbody tr{
        text-align: center;
    }
    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6{
        font-family: 'Silk Serif';
    }
</style>

<div class="app-content content bg-white">
    
    <div class="content-wrapper">

        <div class="content-header row">
        </div>

        <div class="content-body">

            <input type="hidden" id="user_id" value="{{ $member_details->id }}">
            <input type="hidden" id="user_type" value="{{ config('custom.user_type.member') }}">

            <!-- Revenue, Hit Rate & Deals -->
            <div class=" mt-lg-3 row">
                <div class="col-lg-8">
                    <h1>StyleGrid Member: {{$member_details->full_name}}</h1>
                    <h3>View <?php echo explode(" ",$member_details->full_name)[0];?>’s platform history.</h3>
                    <!-- <a href=""><button class="grid-btn">Create Grid</button></a> -->
                </div>
                <div class="col-lg-4">
                    <div class="d-flex">
                        {{-- <div class="m-1">
                            <?php
                            if($member_details->membership_cancelled){
                                ?>
                                Membership Cancelled on <?php echo $member_details->cancellation_datetime;?><br>
                                <b>Reason:</b><?php echo $member_details->reason_of_cancellation;?>
                                <?php
                            }else{
                                ?>
                                <button class="cancel-btn" type="submit" data-toggle="modal" data-target="#cancel">Cancel Membership</button>
                                <?php
                            }
                            ?>
                            
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="row mt-4">

                <div class="col-lg-12  border-light border-bottom border-2">
                    <ul id="myTab_1" role="tablist" class="nav nav-pills flex-sm-row text-center" style="padding-bottom: 2px;">
                        <li class="nav-item ">
                            <a id="home-tab" data-toggle="tab" href="#profile_tab" role="tab" aria-controls="home"
                                aria-selected="true"
                                class="nav-link border-0 cyan-blue  font-weight-bold active">Profile</a>
                        </li>
                        <li class="nav-item ">
                            <a id="Fashion-tab" data-toggle="tab" href="#subscription_tab" role="tab"
                                aria-controls="Fashion" aria-selected="false"
                                class="nav-link border-0 cyan-blue font-weight-bold ">Subscription & Billing</a>
                        </li>
                    </ul>
                </div>

                <div id="TabContent" class="tab-content my-2 w-100">
                    <div class="tab-pane fade active show" id="profile_tab" role="tabpanel" aria-labelledby="Fashion-tab">
                        <div class="col-12 row">
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="member-detail py-3">
                                            <div class="text-center">
                                                <a href="">
                                                        <?php
                                                        if($member_details->subscription=='Gold Tier'){
                                                          ?>
                                                        <img src="{{asset('/admin-section/app-assets/images/gallery/stylist-profile.png')}}" alt="" >
                                                        <?php 
                                                        }else if($member_details->subscription=='Black Tier'){
                                                            ?>
                                                            <img src="{{asset('/admin-section/app-assets/images/gallery/member-profile.png')}}" alt="" >
                                                            <?php
                                                        }else{
                                                            ?>
                                                        <img src="{{asset('/admin-section/app-assets/images/gallery/stylist-profile.png')}}" alt="" >
                                                            <?php
                                                        }
                                                        ?>                                
                                                    </a>                                
                                           
                                            </div>
                                            <div class="mem-name mt-2"><?php echo $member_details->full_name;?></div>
                                            <div class="mem-add my-1">StyleGrid Member since <?php echo date('Y',strtotime($member_details->added_date));?></div>
                                        </div>
                                        <div class="member-detail py-2 mt-3">
                                            <div class="d-flex justify-content-around mb-2">
                                                <div class="mem-name">Assigned Stylist</div>
                                                <div><a href="#"><button class="assign-new-sty-btn">Assign New
                                                            Stylist</button></a></div>
                                            </div>
                                            <?php
                                            //http://local.stylegrid.com/stylist/attachments/profileImage/1665461135.png
                                             if(is_file(public_path().'/'.$member_details->stylist_profile_image)){
                                              //  $image=asset('/'.$member_details->stylist_profile_image);
                                            }else{
                                               // $image=asset('/stylist/attachments/profileImage/default_image.png');
                                            }
                                            ?>
                                            <div class="text-center"> <a href=""><img src="{{$member_details->stylist_profile_image}}"
                                                class="assign-sty-img" alt="" style="height: 100px;width: 100px;"></a>
                                            </div>
                                            <?php
                                            if(!empty($member_details->stylist_name)){
                                                ?>
                                                <div class="mem-name mt-2">{{$member_details->stylist_name}}</div>
                                                <div class="mem-add my-1">Verified Stylist</div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="mem-name mt-2">Not assigned Stylist</div>
                                                <?php
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="member-detail pt-2 pb-3">
                                            <div class="mem-name text-left ml-2 pl-1"><?php echo explode(" ",$member_details->full_name)[0];?>’s Data</div>
                                            <div class="d-flex mt-2 ml-2">
                                                <div class="max-data col-4 ">Full name</div>
                                                <div class="max-info col-8"><?php echo $member_details->full_name;?></div>
                                            </div>
                                            <div class="d-flex mt-2 ml-2">
                                                <div class="max-data col-4">Gender</div>
                                                <div class="max-info col-8"><?php echo $member_details->gender;?></div>
                                            </div>
                                            <div class="d-flex mt-2 ml-2">
                                                <div class="max-data col-4 ">Location</div>
                                                <div class="max-info col-8"><?php echo $member_details->country_name;?></div>
                                            </div>
                                            <div class="d-flex mt-2 ml-2">
                                                <div class="max-data col-4 ">Email</div>
                                                <div class="max-info col-8"><?php echo $member_details->email;?></div>
                                            </div>
                                            <div class="d-flex mt-2 ml-2">
                                                <div class="max-data col-4">Phone</div>
                                                <div class="max-info col-8"><?php echo $member_details->phone;?></div>
                                            </div>
                                            <div class="d-flex mt-2 ml-2">
                                                <div class="max-data col-4">Date joined</div>
                                                <div class="max-info col-8"><?php echo date('m/d/Y',strtotime($member_details->added_date));?></div>
                                            </div>
                                            {{-- <div class="d-flex mt-2 ml-2">
                                                <div class="max-data col-4">Status</div>
                                                <div class="max-info col-8"><?php echo $member_details->subscription;?></div>
                                            </div> --}}
                                            <div class="d-flex mt-2 ml-2">
                                                <div class="max-data col-4 pr-0">Current spend</div>
                                                <div class="max-info col-8">£<?php echo number_format($member_details->id,2);?></div>
                                            </div>
                                        </div>
                                        <div class="member-detail py-2 mt-3">
                                            <div class="mem-name text-left ml-3">Favourite Brands</div>
                                            <div class="row">
                                                <div class="col-12 pr-0 mt-1">
                                                    <div class="outer-border">
                                                        <table class="table  w-100 table-responsive" id="member_favroute_brand_table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="text-left pl-4">Name</th>
                                                                    <th scope="col">Logo</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                 foreach($member_brands as $brand){
                                                                    ?> 
                                                                <tr>
                                                                    <td class="d-flex">{{$brand->name}}</td>
                                                                    <td><img class="img-fluid max-img"
                                                                        src="{{asset('member/website/assets/images/'.$brand->logo)}}" alt=""></td>
                                                                </tr>
                                                                <?php
                                                            }    
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                 
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 mt-lg-0 mt-3">
                                <div class="member-detail pt-2 px-1">
                                    <div class="mem-name text-left ml-3">Order History</div>
                                    <div class="text-center add-table-border mt-3 px-1" id="order-history-table">
                                        <table class="table  w-100 table-responsive" id="member-order-list">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="">ORDER #</th>
                                                    <th scope="col">DATE</th>
                                                    <th scope="col">TOTAL</th>
                                                    <th scope="col">STATUS</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#0012</td>
                                                    <td>22/02/23</td>
                                                    <td>£12,659</td>
                                                    <td class="orange-color">Processing</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>#0018</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="orange-color">Processing</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View </button></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>#0001</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="">Dispatched</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View</button></a></td>
                                                </tr>
                                                <tr class="">
                                                    <td>#0061</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="">Dispatched</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View</button></a></td>
                                                </tr>
                                                <tr>
                                                    <td>#0011</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="green-color">Delivered</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View</button></a></td>
                                                </tr>
                                                <tr>
                                                    <td>#0011</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="green-color">Delivered</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View</button></a></td>
                                                </tr>
                                                <tr>
                                                    <td>#0011</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="green-color">Delivered</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View</button></a></td>
                                                </tr>
                                                <tr>
                                                    <td>#0011</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="green-color">Delivered</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View</button></a></td>
                                                </tr>
                                                <tr>
                                                    <td>#0011</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="green-color">Delivered</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View</button></a></td>
                                                </tr>
                                                <tr>
                                                    <td>#0011</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="green-color">Delivered</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View</button></a></td>
                                                </tr>
                                                <tr>
                                                    <td>#0011</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="green-color">Delivered</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">View</button></a></td>
                                                </tr>
            
                                                <tr class="border-bottom-zero">
                                                    <td>#0011</td>
                                                    <td>22/02/23</td>
                                                    <td>£1,449</td>
                                                    <td class="green-color">Delivered</td>
                                                    <td><a href="{{url('admin-member-order-details/test')}}"><button class="">Views</button></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-------------pagination---------->
                                    
                                    <!--------------end of pagination--->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="subscription_tab" role="tabpanel" aria-labelledby="Fashion-tab">

                        <div class="col-12 row m-0 p-1" id="billing-tab-container">
                        
                        </div>

                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <!--  Cancel Modal -->
    <div class="modal fade" id="cancelSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="cancelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-1">
               
                <div class="modal-body">
                    <h1>Are you sure you&apos;d like to cancel <?php echo explode(" ",$member_details->full_name)[0];?>’s membership?</h1>
                    <p class="pt-1">Once you confirm cancellation of their membership, their plan will expire at the next monthly billing date without charge. They will receive an email notifying them of this action.</p>
                    <div>
                        <div class="form-group my-3">
                            <select class="form-control" id="reason_for_cancellation">
                                <option value="">Define reason for cancellation</option>
                                <option value="Fraudulent Behaviour">Fraudulent Behaviour</option>
                                <option value="Platform Misuse">Platform Misuse</option>
                                <option value="Abusive Behaviour">Abusive Behaviour</option>
                                <option value="Prefer not to say">Prefer not to say</option>
                            </select>
                            <div id="error_message_box" class="mt-1 text-danger"></div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-2">
                        <input type="hidden" id="user_subscription_id">
                        <div><button class="cancel-btn px-3" type="button" id="cancel_membership">Cancel</button></div>
                        <div><button class="back-btn ml-2" type="button" class="close" data-dismiss="modal" aria-label="Close">Go Back</button></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@section('page-scripts')

    @include('scripts.admin.member.profile_js')

@endsection

@include('admin.includes.footer')

@stop




