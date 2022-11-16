var brandList=[];
function selectBrand(brand_id){
    $('#brand').val(brandList[brand_id]);
    $('#autsuggestion_section').html('');
}
$(window).load(function() {
  if(document.referrer!=''){
      if(document.referrer.replace(constants.base_url,'')=='/stylist-create-source-request'){
          $('#submit-request-form').get(0).reset();
      }
  }
});
$(function(){
  $('#submit_offer_btn').click(function(){
    $('#stylist-fulfill-source-request-form input').css('border', '1px solid #ccc');
    $('.error').html('');
    $('.message').html('');
    var source_price=makeTrim($('#source_price').val());
    var status=true;
    if(source_price==''){
      $('#source_price').css('border', '2px solid #cc0000');
      $('#source_price_error').html('Please enter Price');
      status=false;
    }else{
      if (source_price<1) {
        $('#source_price').css('border', '2px solid #cc0000');
        $('#source_price_error').html('Please enter a valid source price');
        status = false;
      }
    }
    if(status){
      $.ajax({
        url : '/stylist-fulfill-source-request-post',
        method : "POST",
        async: false,
        data : $('#stylist-fulfill-source-request-form').serialize(),
        success : function (ajaxresponse){
            response = JSON.parse(ajaxresponse);
            if(response['status']){
              $('#message_box').html('<div class="alert alert-success">'+response['message']+'</div>');
              setTimeout(function(){
              window.location = "/stylist-source-request-submit";
            }, 500);
            }else{
              $('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
            }
        }
    })
    }else{
      //$('#message_box').html('<div class="alert alert-danger">Please enter all the mandatory fields!</div>');
    }
  })

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


  $('#image_preview_remove').click(function(){
    $("#frame-image").val('');
    $('#image_preview_remove').hide();
    $("#divImageMediaPreview").html('');
})
$("#source_image").change(function () {
  if (typeof (FileReader) != "undefined") {
      var dvPreview = $("#divImageMediaPreview");
      dvPreview.html("");            
     // $($(this)[0].files).each(function () {
          var file = $(this)[0].files;//$(this); 
          var ext = $('#source_image').val().split('.').pop().toLowerCase();
          if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
              $('#image_error').html('Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.');
              $("#source_image").val('');
              return false;
          }else{
              var image_size = (this.files[0].size);
              if(image_size>1000000){
                  $('#image_error').html('Maximum File Size Limit is 1MB');
                  $("#source_image").val('');
                  return false;
              }else{
                  var reader = new FileReader();
                  reader.onload = function (e) {
                      var img = $("<img />");
                      img.attr("style", "width: 150px; height:100px; padding: 10px");
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
$("#deliver_date" ).datepicker({ minDate: 0});
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
          url: '/stylist-submit-request-post',                
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
                      window.location = "/stylist-submit-request-complete";
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
            url : '/stylist-accept-offer',
            method : "POST",
            data : {
                'selected_offer_id':selected_offer_id,
                '_token': constants.csrf_token
            },
            success : function (ajaxresponse){
                response = JSON.parse(ajaxresponse);
                if (response['status']) {
                    setTimeout(function(){
                        window.location = "/stylist-offer-accepted";
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
            url : '/stylist-decline-offer',
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
                        window.location = "/stylist-sourcing";
                    }, 500);
                    }
                    
                }
            }
        })
    }
})
})

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
function validEmail(email) {
  var re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  return re.test(email);
}

 