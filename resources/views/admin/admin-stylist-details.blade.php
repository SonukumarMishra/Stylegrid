@extends('admin.layouts.default')
@section('content')
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class=" mt-lg-3 row">
                <div class="col-lg-8">
                    <h1>StyleGrid Stylist: {{$stylist_details->full_name}}</h1>
                    <h3>View <?php echo explode(" ",$stylist_details->full_name)[0];?>’s platform history.</h3>
                    <!-- <a href=""><button class="grid-btn">Create Grid</button></a> -->
                </div>
                <div class="col-lg-4">
                    <div class="d-flex">
                        <div class="m-1"> <a href=""><button class="billing-btn">Billing History</button></a></div>
                        <div class="m-1">
                            <?php
                            if($stylist_details->membership_cancelled){
                                ?>
                                Membership Cancelled on <?php echo $stylist_details->cancellation_datetime;?><br>
                                <b>Reason:</b><?php echo $stylist_details->reason_of_cancellation;?>
                                <?php
                            }else{
                                ?>
                                <button class="cancel-btn" type="submit" data-toggle="modal" data-target="#cancel">Cancel Membership</button>
                                <?php
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="member-detail py-3">
                                <div class="text-center">
                                <a href="">
                                    <?php
                                    if($stylist_details->subscription=='Gold Tier'){
                                       ?>
                                    <img src="{{asset('/admin-section/app-assets/images/gallery/stylist-profile.png')}}" alt="" >
                                    <?php 
                                    }else if($stylist_details->subscription=='Black Tier'){
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
                                <div class="mem-name mt-2">{{$stylist_details->full_name}}</div>
                                <div class="mem-add my-1">StyleGrid Stylist since <?php echo date('Y',strtotime($stylist_details->added_date));?></div>
                                <div class="mem-add">{{$stylist_details->subscription}}</div>
                            </div>
                            <div class="member-detail pt-2 mt-3">
                                <div class=" mb-2">
                                    <div class="mem-name text-left ml-3">Client List</div>
                                </div>
                                <div class="outer-border">
                                    <table class="table  w-100 table-responsive" id="stylist_client_list_table">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-left pl-4">Name</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($stylist_clients as $clients){
                                        ?> 
                                        <tr>
                                            <td class="d-flex">{{$clients->full_name}}</td>
                                            <td><img class="img-fluid max-img" src="{{asset('admin-section/app-assets/images/gallery/msg.png')}}" alt=""></td>
                                            </tr>
                                    <?php
                                    }    
                                    ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 mt-md-0 mt-3">
                            <div class="member-detail pt-2 pb-3">
                                <div class="mem-name text-left ml-2 pl-1"><?php echo explode(" ",$stylist_details->full_name)[0];?>’s Data</div>
                                <div class="d-flex mt-2 ml-2">
                                    <div class="max-data col-4 ">Full name</div>
                                    <div class="max-info col-8">{{$stylist_details->full_name}}</div>
                                </div>
                                <div class="d-flex mt-2 ml-2">
                                    <div class="max-data col-4">Gender</div>
                                    <div class="max-info col-8">{{$stylist_details->gender}}</div>
                                </div>
                                <div class="d-flex mt-2 ml-2">
                                    <div class="max-data col-4 ">Location</div>
                                    <div class="max-info col-8">{{$stylist_details->country_name}}</div>
                                </div>
                                <div class="d-flex mt-2 ml-2">
                                    <div class="max-data col-4 ">Email</div>
                                    <div class="max-info col-8">{{$stylist_details->email}}</div>
                                </div>
                                <div class="d-flex mt-2 ml-2">
                                    <div class="max-data col-4">Phone</div>
                                    <div class="max-info col-8">{{$stylist_details->phone}}</div>
                                </div>
                                <div class="d-flex mt-2 ml-2">
                                    <div class="max-data col-4">Date joined</div>
                                    <div class="max-info col-8"><?php echo date('m-d-Y',strtotime($stylist_details->added_date));?></div>
                                </div>
                                <div class="d-flex mt-2 ml-2">
                                    <div class="max-data col-4">Status</div>
                                    <div class="max-info col-8">Gold Tier</div>
                                </div>
                                <div class="d-flex mt-2 ml-2">
                                    <div class="max-data col-4 pr-0">Current spend</div>
                                    <div class="max-info col-8">£32,659</div>
                                </div>
                            </div>
                            <div class="member-detail py-2 mt-3">
                                <div class="mem-name text-left ml-3">Favourite Brands</div>
                                <div class="row">
                                    <div class="col-12 pr-0 mt-1">
                                        <div class="outer-border">

                                            <table class="table  w-100 table-responsive" id="stylist_favroute_brand_table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-left pl-4">Name</th>
                                                        <th scope="col">Logo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach($stylist_brands as $brand){
                                                ?> 
                                                <tr>
                                                    <td class="d-flex">{{$brand->name}}</td>
                                                    <td><img class="img-fluid max-img" src="{{asset('member/website/assets/images/'.$brand->logo)}}" alt=""></td>
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
                            <table class="table  w-100 table-responsive" id="stylist-order-list">
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
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>
                                    <tr>
                                        <td>#0018</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="orange-color">Processing</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>
                                    </tr>
                                    <tr>
                                        <td>#0001</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="">Dispatched</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>
                                    <tr class="">
                                        <td>#0061</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="">Dispatched</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>

                                    </tr>

                                    <tr class="border-bottom-zero">
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href="{{url('admin-stylist-order-details/test')}}"><button class="">View </button></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
         <!--  Cancel Modal -->
         <div class="modal fade" id="cancel" tabindex="-1" role="dialog" aria-labelledby="cancelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content pt-1">
                    <div class="mr-2">
        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body py-2">
                        <div class="message" id="message_box"></div>
                        <h1>Are you sure you&apos;d like to cancel <?php echo explode(" ",$stylist_details->full_name)[0];?>’s membership?</h1>
                        <p class="px-3">Once you confirm cancellation of their membership, their plan will expire at the next monthly billing date without charge. They will receive an email notifying them of this action.</p>
                        <div>
                            <div class="form-group my-3 mx-5">
                              <select class="form-control" id="reason_for_cancellation">
                                  <option value="">Define reason for cancellation</option>
                                  <option value="Fraudulent Behaviour">Fraudulent Behaviour</option>
                                  <option value="Platform Misuse">Platform Misuse</option>
                                  <option value="Abusive Behaviour">Abusive Behaviour</option>
                                  <option value="Prefer not to say">Prefer not to say</option>
                                </select>
                              </div>
                        </div>
                        <h6>Cancel membership?</h6>
                        <div class="row justify-content-center mt-2">
                            <div><a href="javascript:void(0)"><button class="cancel-btn px-3" type="button" id="cancel_membership">Cancel</button></a></div>
                            <div><a href=""><button class="back-btn ml-2" type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">Go Back</button></a></div>
                        </div>
                    </div>
        
                </div>
            </div>
        </div>
</div>
@include('admin.includes.footer')
<script>
    $(function(){
        $('#reason_for_cancellation').change(function(){
            $('#message_box').html('');
        })
        $('#cancel_membership').click(function(){
            var reason_for_cancellation=$('#reason_for_cancellation').val();
            if(reason_for_cancellation!=''){
                $.ajax({
                    url : '/admin-cancel-stylist-membership',
                    method : "POST",
                    async: false,
                    data : {
                        'stylist_id':'<?php echo $stylist_details->id;?>',
                        'reason_for_cancellation':reason_for_cancellation,
                        '_token': constants.csrf_token
                    },
                    success : function (ajaxresponse){
                        response = JSON.parse(ajaxresponse);
                        if (response['status']) {
                            $('#message_box').html('<div class="alert alert-success">'+response['message']+'</div>');
                            setTimeout(function(){
                                location.reload();
                            }, 500);
                        }else{
                            $('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
                        }
                    }
                })
            }else{
                $('#message_box').html('<div class="alert alert-danger">Please select reason of cancellation!</div>');
            }
        })
        $('#stylist_favroute_brand_table, #stylist_client_list_table').DataTable({
        "bLengthChange": false,
        "pageLength":5,
        "searching": false,
        "columnDefs": [
            { orderable: false, targets: 1 }
        ],
     });        
     $('#stylist-order-list').DataTable({
        "bLengthChange": false,
        "pageLength":10,
        "searching": false,
        "columnDefs": [
            { orderable: false, targets: 1 }
        ],
     });  
    })
</script>
@stop


