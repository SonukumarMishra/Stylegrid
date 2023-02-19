@include("stylist.postloginview.partials.header.header")

@include("stylist.postloginview.partials.navigate.navigate")

<div class="app-content content bg-white">

    <div class="content-wrapper">



        <div class="content-header row">

        </div>

        <div class="content-body">

            <!-- Revenue, Hit Rate & Deals -->

            <div class="row my-3">

                <div class="col-md-8">

                    <h1>Sourcing Request Details</h1>

                </div>

                <div class="col-md-4 quick-link text-right">

                    <span class="mr-5"><a hrf="">Quick Link</a></span>

                    <div class="row justify-content-end mr-2 my-2">

                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Chat.svg')}}" alt=""></a>

                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/File Invoice.svg')}}" alt=""></a>

                        <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a>

                    </div>



                </div>

            </div>

            <!-------------------- fulfil souring request--------->

            <div id="browse-soursing" class="mt-5">

                <div class="row" id="fulfill-request">

                    <div class="row w-100">

                        <div class="col-lg-6">

                            <div class="border-right my-3">

                                <img src="{{ asset('attachments/source/'.$sourcing_details->p_image) }}" class="img-fluid" alt="">

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="p-3">

                                <h1><?php echo $sourcing_details->p_name;?></h1>

                                <h6><?php echo $sourcing_details->name;?></h6>

                                <h4 class="mt-3">Price: £ {{ isset($sourcing_details->sourcing_accepted_details) && !empty($sourcing_details->sourcing_accepted_details) ? number_format($sourcing_details->sourcing_accepted_details->price,2) : 0.00 }}</h4>

                                <h4>Offer Accepted Date: 
                                    
                                    {{ isset($sourcing_details->sourcing_accepted_details) && !empty($sourcing_details->sourcing_accepted_details) ? date('m-d-Y',strtotime($sourcing_details->sourcing_accepted_details->created_at)) : '' }}

                                </h4>

                                <div class="w-100">

                                    @if (isset($sourcing_details->sourcing_chat_room) && !empty($sourcing_details->sourcing_chat_room))
                                        
                                        <div class="mt-2">

                                            <a href="{{ route('stylist.messanger.index', ['chat_room_id' => $sourcing_details->sourcing_chat_room->chat_room_id])}}" class="accept-btn px-3">Chat with Stylist</a> 

                                        </div>
                                        
                                    @endif


                                </div>



                            </div>

                        </div>

                    </div>

                 </div>

            </div>

        </div>

    </div>

</div>

@include("stylist.postloginview.partials.footer.footerjs")