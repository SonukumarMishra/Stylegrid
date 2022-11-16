@extends('member.dashboard.layouts.default')
@section('content')
<!-- BEGIN: Content-->
<div class="content-wrapper">

    <div class="content-header row">
    </div>
    <div class="content-body">
        <!-- Revenue, Hit Rate & Deals -->
        <div class="row my-3">
            <div class="col-8">
                <h1>A stylist can fufill your sourcing request</h1>
                <h3>A stylist has submitted an offer to fufill your item. If you accept, you&apos;ll be able to chat
                    with them and complete the order.</h3>
            </div>
            <div class="col-4 quick-link text-right">
                <span class="mr-5"><a hrf="">Quick Link</a></span>
                <div class="row justify-content-end mr-2 my-2">
                    <a href="" class="mx-1"><img src="{{ asset('member/app-assets/images/icons/Chat.svg') }}" alt=""></a>
                    <!-- <a href="" class="mx-1"><img src="app-assets/images/icons/File Invoice.svg" alt=""></a> -->
                    <a href="" class="mx-1"><img src="{{ asset('member/app-assets/images/icons/Gear.svg') }}" alt=""></a>

                </div>

            </div>
        </div>
        <!-------------------- fulfil souring request--------->
        <div id="browse-soursing" class="mt-5">
            <div class="row">
                <div class=" col-7">
                     
                </div>
                <!-- Pills navs -->
                <div class="col-5 d-flex justify-content-end">
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
            <div class="row" id="fulfill-request">
                <div id="demo" class="carousel slide"  data-touch="false" data-interval="false" >

                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" class="active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                        <li data-target="#demo" data-slide-to="2"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        <?php
                        $counter=1;
                        foreach($offer_list as $offer){
                            $class='';
                            if($counter==1){
                                $class='active';
                            }
                            ?>
                            <div class="carousel-item {{$class;}}">
                                <div class="row">
                                <div class="col-lg-6">
                                    <div class="border-right my-3">
                                        <img src="{{ asset('attachments/source/'.$offer->p_image) }}" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-3">
                                        <div class="offer-slider">Offer #<?php echo $counter;?> of <?php echo count($offer_list);?></div>
                                        <h1><?php echo $offer->p_name;?></h1>
                                        <h6><?php echo $offer->name;?></h6>
                                        <h4 class="mt-3">Price offer: £<?php echo number_format($offer->price,2);?></h4>
                                        <h4>Shipping date: <?php echo date('d/m/Y',strtotime($offer->p_deliver_date));?></h4>
                                        <h4>Condition: New</h4>
    
                                        <div class="mt-3">
                                            <label for="">Please select if you are happy to accept or decline the
                                                quoted
                                                price.</label>
                                        </div>
                                        <div class="w-100">
                                            <div class="my-2 row offer_class <?php if($offer->status==2){ echo 'decline';}?>" id="declined_section<?php echo $offer->id;?>">
                                            <?php
                                            if($offer->status!=2){
                                                ?>
                                                    <div class="ml-2">
                                                        <!--<a href="javascript:void(0)" class="accept-btn px-3 accept-offer" data-id="<?php echo $offer->id;?>">Accept Offer</a>-->
                                                        <button type="button" class="accept-btn px-3 accept-offer" data-id="<?php echo $offer->id;?>">Accept Offer</button> 
                                                    </div>
        
                                                    <div class="ml-2 mt-lg-0 mt-2">
                                                        <button type="button" class="decline-btn px-3 decline-offer" data-id="<?php echo $offer->id;?>">Decline Offer</button>
                                                    </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="ml-2">
                                                    <div class="px-3 red-color"><b>Declined Offer</b></div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            </div>
    
                                            <p class="mt-2">Please note, if you decline the submitted stylist offer
                                                then your
                                                ticket
                                                will return to pending and be open for other stylists in our network
                                                to submit
                                                an
                                                offer. All offers expire after 48 hours.</p>
                                        </div>
    
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php
                            $counter++;
                        }
                        ?>
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <!-- <span class="carousel-control-prev-icon"><i class="bi bi-chevron-left"></i></span> -->
                        <svg width="14.6" height="27" viewBox="0 0 16 27" xmlns="http://www.w3.org/2000/svg" class=""><path d="M16 23.207L6.11 13.161 16 3.093 12.955 0 0 13.161l12.955 13.161z" fill="#fff" class="FXox6K"></path></svg>
            
                    </a>
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <!-- <span class="carousel-control-next-icon"><i class="bi bi-chevron-right"></i></span> -->
                        <svg width="14.6" height="27" viewBox="0 0 16 27" xmlns="http://www.w3.org/2000/svg" class="_2-wzdc"><path d="M16 23.207L6.11 13.161 16 3.093 12.955 0 0 13.161l12.955 13.161z" fill="#fff" class="FXox6K"></path></svg>

                    </a>
                </div>
             </div>
        </div>
    </div>
</div>
@stop