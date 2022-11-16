@extends('member.dashboard.layouts.default')
@section('content')
<!-- BEGIN: Content-->

    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class="mt-lg-3 row">
                <div class="col-8">
                    <h1>Welcome to your product sourcing overview</h1>
                    <h3>Check the status on your existing sourcing requests or submit a new request.</h3>
                    <?php
                    if($day_left>-1){
                    ?>
                    <div class="mt-3">
                        <a href="member-submit-request"><button class="make-request">Make New Request</button></a>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="col-4 quick-link text-right">
                    <span class="mr-lg-5"><a hrf="">Quick Link</a></span>
                    <div class="d-flex justify-content-end my-2 mr-lg-2">
                        <a href="" class="mx-1"><img src="{{ asset('member/app-assets/images/icons/Chat.svg') }}" alt=""></a>
                        <!-- <a href="" class="mx-1"><img src="app-assets/images/icons/File Invoice.svg" alt=""></a> -->
                        <a href="" class="mx-lg-1"><img src="{{ asset('member/app-assets/images/icons/Gear.svg') }}" alt=""></a>
                    </div>

                </div>
            </div>
            <!--------------------souring hub--------->
            <div id="browse-soursing" class="mt-lg-5 mt-2">
                <div class="row">
                    <div class="col-lg-6 text-lg-left text-center">
                          <h1>Live Requests</h1>
                          </div>
                    <!-- Pills navs -->
                    <div class="col-lg-6 d-flex justify-content-lg-end justify-content-center mt-lg-0 mt-2">
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
                <div class="row w-100">
                    <div id="TabContent" class="tab-content my-2 w-100">
                        <div class="tab-pane fade active show" id="Fashion_1" role="tabpanel"
                            aria-labelledby="Fashion-tab">
                            <div class="text-center ml-2 add-table-border">
                                <table class="table  w-100 table-responsive">
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
                                        <?php
                                        if($source_list_data){
                                            foreach($source_list_data as $source_row){
                                            ?>
                                            <tr>
                                                <td class="d-flex"><span class="dot"></span>{{$source_row['p_name']}}</td>
                                                <td>{{$source_row['p_size']}}</td>
                                                <td>{{$source_row['p_type']}}</td>
                                                <td>{{$source_row['name']}}</td>
                                                <td>{{$source_row['country_name']}}</td>
                                                <td>{{date('d/m/Y',strtotime($source_row['p_deliver_date']))}}</td>
                                                <?php

                                                if($source_row['total_offer']>0 && $source_row['p_status']!='Fulfilled'){
                                                     $balance_offer=$source_row['total_offer']-$source_row['decline_offer'];
                                                    if($balance_offer==0){
                                                        ?>
                                                        <td class="orange-color">{{$source_row['p_status']}}</td>
                                                        <?php
                                                    }else{
                                                        if($source_row['total_offer']==1){
                                                        ?>
                                                        <td class="green-color">Offer Received</td> 
                                                        <?php
                                                    }else{

                                                        ?>
                                                        <td class="green-color">
                                                            <?php
                                                             $balance_offer=$source_row['total_offer']-$source_row['decline_offer'];
                                                            if($balance_offer==1){
                                                                echo "Offer Received";
                                                            }else{
                                                                echo $balance_offer. " Offers Received";
                                                            } 
                                                            if($source_row['decline_offer']){
                                                                 echo "/ ".$source_row['decline_offer']." Declined";
                                                            }
                                                            ?>
                                                        </td> 
                                                        <?php
                                                    }
                                                    ?>
                                                    <td><a href="{{'/offer-received/'.$source_row['p_slug']}}"><button class="">View Order</button></a></td> 
                                                    <?php
                                                    }
                                                ?>
                                                <?php
                                                }else{
                                                    if($source_row['p_status']=='Fulfilled'){
                                                        ?>
                                                        <td class="blue-color">{{$source_row['p_status']}}</td>
                                                        
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <td class="orange-color">{{$source_row['p_status']}}</td>
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                        } 
                                        }else{
                                            ?>
                                            <td class="d-flex" colspan="6" style="text-align:center">No Source Found</td>
                                            <?php
                                        }
                                           
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                           </div>
                    </div>
                </div>
                <!-----------------new table-------------->
                <div class="text-lg-left text-center mt-3">
                    <h1 class=" pl-1">Previous Requests</h1>
                </div>
                <div class="row w-100">
                    <div id="TabContent" class="tab-content my-2 w-100">
                        <div class="tab-pane fade active show" id="Fashion_1" role="tabpanel"
                            aria-labelledby="Fashion-tab">
                            <div class="text-center ml-2 add-table-border">
                                <table class="table  w-100 table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-left pl-4">PRODUCT NAME</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Brand</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Due Date</th>
                                            <th scope="col">Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(count($previous_source_list)){
                                            foreach($previous_source_list as $source_row){
                                                ?>
                                                <tr>
                                                    <td class="d-flex"><span class="dot"></span>{{$source_row->p_name}}</td>
                                                    <td>{{$source_row->p_size}}</td>
                                                    <td>{{$source_row->p_type}}</td>
                                                    <td>{{$source_row->name}}</td>
                                                    <td>{{$source_row->country_name}}</td>
                                                    <td>{{date('d/m/Y',strtotime($source_row->p_deliver_date))}}</td>
                                                    <?php
                                                    if($source_row->p_status=='Expired'){
                                                        ?><td class="red-color">{{$source_row->p_status}}</td><?php
                                                    }
                                                    if($source_row->p_status=='Fufilled'){
                                                        ?><td class="blue-color">{{$source_row->p_status}}</td><?php
                                                    }
                                                    if($source_row->p_status=='Fulfilled'){
                                                        ?><td class="blue-color">{{$source_row->p_status}}</td><?php
                                                    }
                                                    if($source_row->p_status=='Pending'){
                                                        ?><td class="red-color">Expired</td><?php
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <td class="d-flex" colspan="6" style="text-align:center">No Source Found</td>
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
            <!--------------------end of souring Hub--------->
        </div>
    </div>
    @stop