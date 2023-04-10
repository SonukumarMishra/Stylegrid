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
                    <h1>Profile Settings</h1>
                    <h3>View or update your profile settings.</h3>
                    <!-- <a href=""><button class="grid-btn">Create Grid</button></a> -->
                </div>

            </div>
            <!**************profile tabs----->
                <div id="profile-tabs" class="mt-4">

                    <div class="row px-3">
                        <div class="col-lg-2 mb-3 border-right">
                            <ul class="nav nav-pills flex-column py-3" id="myprofileTab" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile"
                                        role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="promotion-tab" data-toggle="tab" href="#promotion"
                                        role="tab" aria-controls="promotion" aria-selected="true">Promotions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Payments-tab" data-toggle="tab" href="#Payments"
                                        role="tab" aria-controls="Payments" aria-selected="false">Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Rewards-tab" data-toggle="tab" href="#Rewards"
                                        role="tab" aria-controls="Rewards" aria-selected="false">Rewards</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Order-tab" data-toggle="tab" href="#Order" role="tab"
                                        aria-controls="Order" aria-selected="false">Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Settings-tab" data-toggle="tab" href="#Settings"
                                        role="tab" aria-controls="Settings" aria-selected="false">Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Client-tab" data-toggle="tab" href="#Client" role="tab"
                                        aria-controls="Client" aria-selected="false">Client</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Assignment-tab" data-toggle="tab" href="#Assignment"
                                        role="tab" aria-controls="Assignment" aria-selected="false">Assignment</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.col-md-4 -->
                        <div class="col-lg-10">
                            <div class="tab-content py-3 px-3" id="myTabContent">
                                <div id="message-box" class="message"></div>
                                <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <form class="mt-3" id="update_admin_profile_form">
                                        @csrf
                                        <div class="profile-tab-info">
                                            <div class="profile-img">Profile Picture</div>
                                            <div class="row">
                                                    <div class=" w-25 mt-2 col-lg-4 col-6 mb-2">
                                                        <div class="profile-img-bg">
                                                         <div class="update-new pr-1">Upload New </div>
                                                         <input type="file" name="admin_image" id="admin_image" class="file-upload style-grid-block-input-file pr-2" >
                                                            <div id="admin_selected_image_section">
                                                                <?php
                                                                if(is_file('attachments/admin/profile/'.Session::get("admin_data")->image)){
                                                                    $image=Session::get("admin_data")->image; 
                                                                }else{
                                                                    $image='profile-img.png'; 
                                                                } 
                                                                ?>
                                                                <img src="<?php echo  asset('attachments/admin/profile/'.$image)?>" class="img-fluid"
                                                                alt="">
                                                            </div>
                                                            <div id="admin_image_error" class="error">
                                                               
                                                            </div>
                                                           
                                                        <div>
                                                       
                                                    </div>
                                                    
                                                </div>
                                                <div class="text-center">
                                                    <a href="javascript:void(0)" style="display:none;" id="image_preview_remove">Remove</a>
                                                </div>
                                                </div>
                                            </div>
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-2">
                                                        <label for="formGroupExampleInput">Username</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Username" value="<?php echo Session::get("admin_data")->username;?>">
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="formGroupExampleInput">Email</label>
                                                        <input type="text" class="form-control" placeholder="Email" name="admin_email" id="admin_email" value="<?php echo Session::get("admin_data")->email;?>">
                                                        <div id="admin_email_error" class="error"></div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-2">
                                                        <label for="formGroupExampleInput">Country</label>
                                                        <select name="admin_country_id" id="admin_country_id" class="form-control">
                                                            <option value="">select Country</option>
                                                            <?php
                                                            foreach($country_list as $country){
                                                                ?>
                                                                <option value="<?php echo $country->id;?>" <?php if($country->id==Session::get("admin_data")->country_id){ echo "selected";}?>><?php echo $country->country_name;?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <div id="admin_country_id_error" class="error"></div>

                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="formGroupExampleInput">Platform Currency</label>
                                                        <input type="text" class="form-control" placeholder="Platform Currency" name="admin_currency" id="admin_currency" value="<?php echo Session::get("admin_data")->currency;?>">
                                                        <div id="admin_currency_error" class="error"></div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-2">
                                                        <label for="formGroupExampleInput">Enter the email where all admin emails are received</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="info@stylegrid.com" placeholder="Receive Email" id="admin_received_email" name="admin_received_email" value="<?php echo Session::get("admin_data")->admin_received_email;?>">
                                                            <div id="admin_received_email_error" class="error"></div>
                                                        </div>
                                                </div>
                                                <div class="text-right mt-2">
                                                    <button class="save-btn" type="button" id="update_admin_profile">Save</button>
                                                </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="promotion" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <h2>promotion</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet
                                        earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora
                                        placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                                </div>
                                <div class="tab-pane fade" id="Payments" role="tabpanel"
                                    aria-labelledby="contact-tab">
                                    <h2>Contact</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet
                                        earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora
                                        placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                                </div>
                                <div class="tab-pane fade" id="Rewards" role="tabpanel"
                                    aria-labelledby="contact-tab">
                                    <h2>Contact</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet
                                        earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora
                                        placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                                </div>
                                <div class="tab-pane fade" id="Order" role="tabpanel" aria-labelledby="contact-tab">
                                    <h2>Contact</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet
                                        earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora
                                        placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                                </div>
                                <div class="tab-pane fade" id="Settings" role="tabpanel"
                                    aria-labelledby="contact-tab">
                                    <h2>Contact</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet
                                        earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora
                                        placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                                </div>
                                <div class="tab-pane fade" id="Client" role="tabpanel"
                                    aria-labelledby="contact-tab">
                                    <h2>Contact</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet
                                        earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora
                                        placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                                </div>
                                <div class="tab-pane fade" id="Assignment" role="tabpanel"
                                    aria-labelledby="contact-tab">
                                    <h2>Contact</h2>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet
                                        earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora
                                        placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>
                                9863962
                            +
                        .</div>
                            </div>
                        </div>
                        <!-- /.col-md-8 -->
                    </div>



                </div>
                <!-- /.container -->
                <!-----------end tabs-->
        </div>
    </div>     
</div>
@include('admin.includes.footer')
<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->

<script>
    $(function(){
        
        $("#admin_image").change(function () {
            if (typeof (FileReader) != "undefined") {
                var dvPreview = $("#admin_selected_image_section");
                dvPreview.html("");    
                $('#admin_image_error').html('');        
                // $($(this)[0].files).each(function () {
                var file = $(this)[0].files;//$(this); 
                var ext = $('#admin_image').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
                    $('#admin_image_error').html('Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.');
                    $("#admin_image").val('');
                    return false;
                }else{
                    var image_size = (this.files[0].size);
                    if(image_size>3000000){
                        $('#admin_image_error').html('Maximum File Size Limit is 3 MB');
                        $("#admin_image").val('');
                        return false;
                    }else{
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = $("<img />");
                            img.attr("style", "width: 300px; height:250px; padding: 10px");
                            img.attr("src", e.target.result);
                            dvPreview.append(img);
                        }
                        $('#image_preview_remove').show();
                        reader.readAsDataURL(file[0]);
                    }     
                }
           // });
            }
        });
        $('#update_admin_profile').click(function(){
            var status=true;
            $('.message').html('');
            $('.error').html('');
            $('input, select').removeClass('err');
            var admin_email=makeTrim($('#admin_email').val());
            var admin_country_id=makeTrim($('#admin_country_id').val());
            var admin_currency=makeTrim($('#admin_currency').val());
            if(admin_email==''){
                $('#admin_email').addClass('err');
                $('#admin_email_error').html('Please enter Email!');
                status=false;
            }else{
                if(!validEmail(admin_email)){
                    $('#admin_email').addClass('err');
                    $('#admin_email_error').html('Please enter valid Email!');  
                }
            }
            if(admin_country_id==''){
                $('#admin_country_id').addClass('err');
                $('#admin_country_id_error').html('Please select country!');
                status=false;
            }
            if(admin_currency==''){
                $('#admin_currency').addClass('err');
                $('#admin_currency_error').html('Please enter currency!');
                status=false;
            }
            if(status){
                $.ajax({
                    type: 'POST',
                    url: '/admin-update-profile-settings-ajax',                
                    data: new FormData($("#update_admin_profile_form")[0]),
                    async : false,
                    cache : false,
                    contentType : false,
                    processData : false,
                    success: function(ajaxresponse) {
                        response = JSON.parse(ajaxresponse);
                        if (response['status']) {
                            //$('#sourceConfirmationPopUp').modal('hide');
                            $("#update_admin_profile_form").trigger("reset");
                            setTimeout(function(){
                                //swal(response['message']);
                                $('#message-box').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>' + response['message'] + '</div>');
                                location.reload(true);
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                                }, 2000);
                        } else {
                            //$('#sourceConfirmationPopUp').modal('hide');
                            $('#message-box').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>' + response['message'] + '</div>');
                            return false;
                        }
                    }
                });
            }else{
                //swal(response['message']);
               // return false;
                $('#message-box').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Please enter all the mandatory fields!</div>');
            }
            
            
        })
        $('#image_preview_remove').click(function(){
            $("#admin_image").val('');
            // $('#image_preview_remove').hide();
            $("#admin_selected_image_section").html('<img src="'+constants.base_url+'/admin-section/assets/images/profile-img.png" class="img-fluid" alt="">');
            
        })
    })
</script>
@stop


