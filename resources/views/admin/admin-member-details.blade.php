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
                    <h1>StyleGrid Member: Max Melia</h1>
                    <h3>View Max’s platform history.</h3>
                    <!-- <a href=""><button class="grid-btn">Create Grid</button></a> -->
                </div>
                <div class="col-lg-4">
                    <div class="d-flex">
                        <div class="m-1"> <a href=""><button class="billing-btn">Billing History</button></a></div>
                        <div class="m-1"><button class="cancel-btn" type="submit" data-toggle="modal"
                                    data-target="#cancel">Cancel Membership</button></div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="member-detail py-3">
                                <div class="text-center"><a href=""><img
                                            src="<?php echo asset('/admin-section/app-assets/images/gallery/member-profile-photo.png');?>" alt=""></a>
                                </div>
                                <div class="mem-name mt-2"><?php echo $member_details->full_name;?></div>
                                <div class="mem-add my-1">StyleGrid Member since <?php echo date('Y',strtotime($member_details->added_date));?></div>
                                <div class="mem-add"><?php echo $member_details->subscription;?></div>
                            </div>
                            <div class="member-detail py-2 mt-3">
                                <div class="d-flex justify-content-around mb-2">
                                    <div class="mem-name">Assigned Stylist</div>
                                    <div><a href=""><button class="assign-new-sty-btn">Assign New
                                                Stylist</button></a></div>
                                </div>
                                <?php
                                 if(is_file(public_path().'/stylist/attachments/profileImage/'.$member_details->stylist_profile_image)){
                                    $image=asset('/stylist/attachments/profileImage/'.$member_details->stylist_profile_image);
                                }else{
                                    $image=asset('/stylist/attachments/profileImage/default_image.png');
                                }
                                ?>
                                <div class="text-center"> <a href=""><img src="{{$image}}"
                                    class="assign-sty-img" alt="" style="height: 100px;width: 100px;"></a>
                                </div>
                                <?php
                                if(!empty($member_details->stylist_name)){
                                    ?>
                                    <div class="mem-name mt-2">{{$member_details->stylist_name}}</div>
                                    <div class="mem-add my-1">Verified Stylist</div>
                                    <div class="mem-add pb-1">Black Tier</div>
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
                                <div class="mem-name text-left ml-2 pl-1"><?php echo $member_details->full_name;?> Data</div>
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
                                    <div class="max-info col-8"><?php echo $member_details->added_date;?></div>
                                </div>
                                <div class="d-flex mt-2 ml-2">
                                    <div class="max-data col-4">Status</div>
                                    <div class="max-info col-8"><?php echo $member_details->subscription;?></div>
                                </div>
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
                                            <?php
                                            $counter=1;
                                            foreach($member_brands as $brand){
                                                ?>
                                                <div class="d-flex  ml-1">
                                                    <div class="max-data col-6 ">{{$brand->name;}}</div>
                                                    <div class=" col-6"><img class="img-fluid max-img"
                                                            src="{{asset('member/website/assets/images/'.$brand->logo)}}" alt="">
                                                    </div>
                                                </div>
                                                <?php
                                                if(count($member_brands)!=$counter){
                                                    ?>
                                                    <hr>
                                                    <?php
                                                }
                                                ?>
                                                
                                                <?php
                                                $counter++;
                                            }    
                                            ?>
                                             
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
                            <table class="table  w-100 table-responsive">
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
                                        <td><a href="member-dashboard-home.html"><button class="">View </button></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#0018</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="orange-color">Processing</td>
                                        <td><a href="member-dashboard-home.html"><button class="">View </button></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#0001</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="">Dispatched</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>
                                    <tr class="">
                                        <td>#0061</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="">Dispatched</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>
                                    <tr>
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>

                                    <tr class="border-bottom-zero">
                                        <td>#0011</td>
                                        <td>22/02/23</td>
                                        <td>£1,449</td>
                                        <td class="green-color">Delivered</td>
                                        <td><a href=""><button class="">View</button></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-------------pagination---------->
                        <nav aria-label="Page navigation d-flex " id="pagination">
                            <ul class="pagination justify-content-end pb-2">
                                <h6 class="px-2 pt-1">12 Orders</h6>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <img src="../Admin/app-assets/images/gallery/prev1.png" class="img-fluid"
                                            alt="">
                                        <!-- <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span> -->
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <img src="../Admin/app-assets/images/gallery/prev.png" class="img-fluid"
                                            alt="">
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link">of</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <img src="../Admin/app-assets/images/gallery/next.png" alt="">
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <img src="../Admin/app-assets/images/gallery/next.png" alt="">
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <!--------------end of pagination--->
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
                <h1>Are you sure you&apos;d like to cancel Max’s membership?</h1>
                <p class="px-3">Once you confirm cancellation of their membership, their plan will expire at the next monthly billing date without charge. They will receive an email notifying them of this action.</p>
                <div>
                    <div class="form-group my-3 mx-5">
                      <select class="form-control" id="exampleFormControlSelect1">
                          <option>Define reason for cancellation</option>
                          <option>Fraudulent Behaviour</option>
                          <option>Platform Misuse</option>
                          <option>Abusive Behaviour</option>
                          <option>Prefer not to say</option>
                        </select>
                      </div>
                </div>
                <h6>Cancel membership?</h6>
                <div class="row justify-content-center mt-2">
                    <div><a href="client-offer-accepted.html"><button class="cancel-btn px-3">Cancel</button></a></div>
                    <div><a href=""><button class="back-btn ml-2" type="button" class="close" data-dismiss="modal"
                                aria-label="Close">Go Back</button></a></div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
@include('admin.includes.footer')
@stop




