 

/*$('.alphaonly').bind('keyup blur keydown onpaste',function(){ 
    var string=$(this).val();
    const noSpecialChars = string.replace(/[^a-zA-Z ]/g, '');
    $(this).val(noSpecialChars);
    //var regEx = /^[a-zA-Z\ s]*$/;
   // if(!$(this).val().match(regEx)){
    // $(this).val('');
   // } 
  });*/
var brandList=[];
function selectBrand(brand_id){
    $('#brand').val(brandList[brand_id]);
    $('#autsuggestion_section').html('');
}
$(window).on('load', function(){
    if(document.referrer!=''){
        if(document.referrer.replace(constants.base_url,'')=='/member-submit-request'){
            $('#submit-request-form').get(0).reset();
        }
    }
});
$(function(){
    $('#brand').keyup(function(){
        $('#autsuggestion_section').html('');
        var brand_search=$(this).val();
        if(brand_search.length>0){
            $.ajax({
                url : '/get-brands-list',
                method : "POST",
                data : {
                    'brand_search':brand_search,
                    '_token': constants.csrf_token
                },
                success : function (ajaxresponse){
                    response = JSON.parse(ajaxresponse);
    
                    if (response['status']) {
                        if(response['data'].length>0){
                            brandList=[];
                            var html='';
                            html +='<ul>';
                            for(i=0;i<response['data'].length;i++){
                                html +='<li class="select_brand" onClick="selectBrand('+response['data'][i]['id']+')" id="'+response['data'][i]['id']+'" title'+response['data'][i]['id']+'="">'+response['data'][i]['name']+'</li>';
                                brandList[response['data'][i]['id']]=response['data'][i]['name']
                            }
                            html +='<ul>';
                            $('#autsuggestion_section').html(html);
                        }
                    }
                }
            })
        }
    })

$("#source_image").change(function () {
    if (typeof (FileReader) != "undefined") {
        $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop');
        $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop');
        $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop_without_border');
        $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop_without_border');
      $('.error').html('');
        $('#source_image_preview_section').html('');
       var dvPreview = $("#source_image_preview_section");
        $('#image_error').html('');        
        // $($(this)[0].files).each(function () {
        var file = $(this)[0].files;//$(this); 
        var ext = $('#source_image').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            $('#image_error').html('Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.');
            var html ='';
            html +='<div class="Neon-input-text ">';
            html +='<h3>Upload an image of the</br> product here</h3>';
            html +='</div>';
            html +='<a class="Neon-input-choose-btn blue">';
            html +='<img  src="'+constants.base_url+'/stylist/website/assets/images/plus.png" alt="" id="image_preview">';
            html +='</a>';
            $("#source_image_preview_section").html(html);
            $("#source_image").val('');
            $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop');
            $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop');
            $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop_without_border');
             return false;
        }else{
            var image_size = (this.files[0].size);
            if(image_size>5000000){
                var html ='';
                html +='<div class="Neon-input-text ">';
                html +='<h3>Upload an image of the</br> product here</h3>';
                html +='</div>';
                html +='<a class="Neon-input-choose-btn blue">';
                html +='<img  src="'+constants.base_url+'/stylist/website/assets/images/plus.png" alt="" id="image_preview">';
                html +='</a>';
                $("#source_image_preview_section").html(html);
                $('#image_error').html('Maximum File Size Limit is 5 MB');
                $("#source_image").val('');
                $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop');
                $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop');
                $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop_without_border');
               return false;
            }else{
                var reader = new FileReader();
                reader.onload = function (e) {
                var html ='';
                html ='<img  src="'+e.target.result+'"/ style="width: 300px; height:300px; padding: 10px">';
                html +='<div class="text-center">';
                html +='<a href="javascript:void(0)" onClick="removeImage()" id="image_preview_remove">Remove</a>';
                html +='</div>';
                dvPreview.append(html);
                $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop');
                $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop_without_border');
                $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop_without_border');
                }
                reader.readAsDataURL(file[0]);
            }     
        }
   // });
    }
  });
    $("#deliver_date" ).datepicker({ startDate: new Date()});
    $('#submit-request-btn').click(function(){
       var status=sourceFormValidation();
        if(status){
            $('#sourceConfirmationPopUp').modal('show');
            return false;
        }else{
		    $('#message-box').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Please enter the mandatory fields!</div>');
            $(window).scrollTop(0);
        }
        return false;
    })
    $('#add-source-confirm-button').click(function(){
        var status=sourceFormValidation();
        if(status){
            $.ajax({
                type: 'POST',
                url: '/member-submit-request-post',                
                data: new FormData($("#submit-request-form")[0]),
                async : false,
                cache : false,
                contentType : false,
                processData : false,
                success: function(ajaxresponse) {
                    response = JSON.parse(ajaxresponse);
                    if (response['status']) {
                        $('#sourceConfirmationPopUp').modal('hide');
                        $("#submit-request-form").trigger("reset");
                        setTimeout(function(){
                            window.location = "/member-submit-request-complete";
                        }, 500);
                    } else {
                        $('#sourceConfirmationPopUp').modal('hide');
                        $('#message-box').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>' + response['message'] + '</div>');
                        return false;
                    }
                }
            });
        }else{
            $('#sourceConfirmationPopUp').modal('hide');
		    $('#message-box').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>Please enter the mandatory fields!</div>');
            $(window).scrollTop(0);
        }
        return false;
    })
    $('.accept-offer').click(function(){
        $('#selected_offer_id').val($(this).attr('data-id'));
        $('#acceptOffer').modal('show');
    })
    $('.decline-offer').click(function(){
        $('#decline_offer_id').val($(this).attr('data-id'));
        $('#declineOffer').modal('show');
    })
    
    $('#accept-offer-btn').click(function(){
        var selected_offer_id=$('#selected_offer_id').val();
        if(selected_offer_id>0){
            $.ajax({
                url : '/member-accept-offer',
                method : "POST",
                data : {
                    'selected_offer_id':selected_offer_id,
                    '_token': constants.csrf_token
                },
                success : function (ajaxresponse){
                    response = JSON.parse(ajaxresponse);
                    if (response['status']) {
                        setTimeout(function(){
                            window.location = "/member-offer-accepted";
                        }, 500);
                    }
                }
            })
        }
    })

    $('#decline-offer-btn').click(function(){
        var decline_offer_id=$('#decline_offer_id').val();
        if(decline_offer_id>0){
            $.ajax({
                url : '/member-decline-offer',
                method : "POST",
                data : {
                    'decline_offer_id':decline_offer_id,
                    '_token': constants.csrf_token
                },
                success : function (ajaxresponse){
                    response = JSON.parse(ajaxresponse);
                    if (response['status']) {
                        $('#declineOffer').modal('hide');
                        $('#declined_section'+decline_offer_id).html('<div class="ml-2"><div class="px-3 red-color"><b> Offer Declined </b></div></div>');
                        var total_class=$('.offer_class').length;
                        var total_decline_class=$('.decline').length;
                        if(total_class==total_decline_class){
                          setTimeout(function(){
                            window.location = "/member-sourcing";
                        }, 500);
                        }
                        
                    }
                }
            })
        }
    })
})

function removeImage(){
    var html ='';
     html +='<div class="Neon-input-text ">';
     html +='<h3>Upload an image of the</br> product here</h3>';
     html +='</div>';
     html +='<a class="Neon-input-choose-btn blue">';
     html +='<img  src="'+constants.base_url+'/stylist/website/assets/images/plus.png" class="img-fluid" alt="" id="image_preview">';
     html +='</a>';
     $("#source_image_preview_section").html(html);
     $("#source_image").val('');
     $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop');
    $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop');
    $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop_without_border');
    }

function sourceFormValidation(){
    $('.error').html('');
    $('#submit-request-form input, select ').css('border', '1px solid #ccc');
    var product_name=makeTrim($('#product_name').val());
    var brand=makeTrim($('#brand').val());
    var product_type=makeTrim($('#product_type').val());
    var country=makeTrim($('#country').val());
    var deliver_date=makeTrim($('#deliver_date').val());
 
    var status=true;
    if(product_name==''){
        $('#product_name').css('border', '2px solid #cc0000');
        $('#product_name_error').html('Please enter Product name!');

        status=false;
    }else{
        if(product_name.length<4){
            $('#product_name').css('border', '2px solid #cc0000');
            $('#product_name_error').html('Length of product name should be greater than 3!');
            status=false;
        }
    }
    if(brand==''){
        $('#brand').css('border', '2px solid #cc0000');
        $('#brand_error').html('Please enter brand name!');
        status=false;
    }
    if(product_type==''){
        $('#product_type').css('border', '2px solid #cc0000');
        $('#product_type_error').html('Please enter product type!');
        status=false;
    }
    if(country==''){
        $('#country').css('border', '2px solid #cc0000');
        $('#country_error').html('Please select country name!');
        status=false;
    }
    if(deliver_date==''){
        $('#deliver_date').css('border', '2px solid #cc0000');
        $('#deliver_date_error').html('Please select due date!');
        status=false;
    }
    return status;
}
function makeTrim(x) {
    if (x) {
        return x.replace(/^\s+|\s+$/gm, '');
    } else {
        return x;
    }
}
function closePopup(id) {
    $("#" + id).fadeTo(5000, 500).slideUp(500, function() {
        $("#" + id).slideUp(5000);
    });
}
function lettersOnly(evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
       ((evt.which) ? evt.which : 0));
    if (charCode > 31 && (charCode < 65 || charCode > 90) &&
       (charCode < 97 || charCode > 122)) {
       return false;
    }
    return true;
  }
  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
  }

$(document).ready(function(){
    // Event for pushed the video
    $('.carousel').carousel({
        interval: false,
      });
      $('#referModalclick').click(function(){
        $('#referModal').modal('show');
    })
    $('#demo.carousel.slide').carousel({
        interval: false,
      });
});


//   $(function () {
//     $('.datepicker').datepicker({
//       language: "es",
//       autoclose: true,
//       format: "dd/mm/yyyy",
//       minDate: 0
//     });
//   });