@extends('admin.layouts.default')
@section('content')
<div class="app-content content bg-white">
    <div class="content-wrapper">

        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Revenue, Hit Rate & Deals -->
            <div class=" mt-lg-3">
                <div class="text-center">
                    <h1 class="admin-head"><?php echo explode(" ",$stylist_details->full_name)[0];?>’s Application</h1>
                    <h3 class="admin-text">Review the answers he gave bellow.</h3>
                </div>
            </div>
            <div class="row mt-lg-4">
                <div class="col-lg-12">
                         <div class="member-detail pt-2 pb-3">
                                <div class="mt-2 text-center mb-5">
                                    <div class="max-data mb-2 ">Tell us about your styling experience.</div>
                                    <div class="max-info"><textarea  disabled name="" id="" class="form-control mx-auto" placeholder="I have worked in a number of styling companies over the last 5 years, including Threads and Moda Operandi.">{{$stylist_details->styling_experience}}</textarea></div>
                                </div>
                                <div class=" mt-2 text-center mb-5">
                                    <div class="max-data mb-2">Have you worked for a fashion or styling company previously?</div>
                                    <div class="max-info "><textarea disabled name="" id="" class="form-control mx-auto" placeholder="Threads, Modi Operandi">{{$stylist_details->fashion_styling_brief}}</textarea>
                                    </div>
                                </div>
                                <div class="mt-2 text-center mb-5">
                                    <div class="max-data mb-2">How many clients, if any, will you service using StyleGrid?</div>
                                    <div class="max-info"><textarea disabled name="" id="" class="form-control mx-auto" placeholder="Around 20">{{$stylist_details->client_brief}}</textarea></div>
                                </div>
                                <div class=" mt-2 text-center mb-5">
                                    <div class="max-data mb-2">Please list some of your fashion and beauty favourite brands below.</div>
                                        <div class="max-info"><textarea disabled name="" id="" class="form-control mx-auto" placeholder="Chanel, Dior, Tom Ford, Casablanca, Jennifer Chamandi, Common Projects, Barbara Sturm">{{$stylist_details->fashion_beauty_brands}}</textarea></div>
                                    </div>
                                <div class="mt-2 text-center mb-5">
                                    <div class="max-data mb-2">Are you able to source luxury product for clients?</div>
                                    <div class="max-info"><textarea disabled name="" id="" class="form-control mx-auto" placeholder="Yes, I have a number of contacts to help me fulfill specific client requests made on the platform.">{{$stylist_details->stronger_experience}}</textarea></div>
                                </div>
                                <div class="mt-2 text-center mb-5">
                                    <div class="max-data mb-2">Is your experience stronger in fashion, home or beauty? List all if applicable.</div>
                                    <div class="max-info"><textarea disabled name="" id="" class="form-control mx-auto" placeholder="My experience is stronger in fashion.">{{$stylist_details->stronger_experience}}</textarea></div>
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


