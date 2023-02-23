$(function(){
  $('.alphaonly').bind('keyup blur keydown onpaste',function(){ 
    var string=$(this).val();
    const noSpecialChars = string.replace(/[^a-zA-Z ]/g, '');
    $(this).val(noSpecialChars); 
  });
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      if(constants.current_url=='/stylist-login'){
          $('#stylist-login-btn').trigger('click');
      }
    }
  });
  $('#stylist-login-btn').click(function(){
    $('#stylist-login-form input').css('border', '1px solid #ccc');
    $('.error').html('');
    $('.message').html('');
    var email=makeTrim($('#email').val());
    var password=makeTrim($('#password').val());
    var status=true;
    if(email==''){
      $('#email').css('border', '2px solid #cc0000');
      $('#email_error').html('Please enter email');
      status=false;
    }else{
      if (!validEmail(email)) {
        $('#email').css('border', '2px solid #cc0000');
        $('#email_error').html('Please enter a valid Email ID');
        status = false;
      }
    }
    if(password==''){
      $('#password').css('border', '2px solid #cc0000');
      $('#password_error').html('Please enter password');
      status=false;
    }
    if(status){
      $.ajax({
        url : '/stylist-login-post',
        method : "POST",
        async: false,
        data : $('#stylist-login-form').serialize(),
        success : function (ajaxresponse){
            response = JSON.parse(ajaxresponse);
            if(response['status']){
              $('#message_box').html('<div class="alert alert-success">'+response['message']+'</div>');
              setTimeout(function(){
                window.location = "/stylist-dashboard";
            }, 500);
            }else{
              $('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
              //$('#message_box').after("<a href='"+response['verification_url']+"' target='_blank'>Click here to verify your account!</a></p>");
            }
        }
    })
    }else{
      $('#message_box').html('<div class="alert alert-danger">Please enter all the mandatory fields!</div>');
    }
  })
  
$("#frame-image").change(function () {
  if (typeof (FileReader) != "undefined") {
    $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop');
    $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop');
    $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop_without_border');
    $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop_without_border');
    $('.error').html('');
      $('#profile_image_preview_section').html('');
     var dvPreview = $("#profile_image_preview_section");
      $('#image_error').html('');        
      // $($(this)[0].files).each(function () {
      var file = $(this)[0].files;//$(this); 
      var ext = $('#frame-image').val().split('.').pop().toLowerCase();
      if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
          $('#image_error').html('Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.');
          var html ='';
          html +='<div class="Neon-input-text ">';
          html +='<h3>Upload your profile</br> picture here</h3>';
          html +='</div>';
          html +='<a class="Neon-input-choose-btn blue">';
          html +='<img  src="'+constants.base_url+'/stylist/website/assets/images/plus.png" alt="" id="image_preview">';
          html +='</a>';
          $("#profile_image_preview_section").html(html);
          $("#frame-image").val('');
          $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop');
          $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop');
          $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop_without_border');
          return false;
      }else{
          var image_size = (this.files[0].size);
          if(image_size>5000000){
              var html ='';
              html +='<div class="Neon-input-text ">';
              html +='<h3>Upload your profile</br> picture here</h3>';
              html +='</div>';
              html +='<a class="Neon-input-choose-btn blue">';
              html +='<img  src="'+constants.base_url+'/stylist/website/assets/images/plus.png" alt="" id="image_preview">';
              html +='</a>';
          $("#profile_image_preview_section").html(html);
              $('#image_error').html('Maximum File Size Limit is 5 MB');
              $("#frame-image").val('');
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
              $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop_without_border');
              }
              reader.readAsDataURL(file[0]);
          }     
      }
 // });
  }
});


$('#send-reset-link-btn').click(function(){
  $('#send-reset-link-form input').css('border', '1px solid #ccc');
  $('.error').html('');
  $('.message').html('');
  var email=makeTrim($('#email').val());
  var status=true;
  if(email==''){
    $('#email').css('border', '2px solid #cc0000');
    $('#email_error').html('Please enter email');
    status=false;
  }else{
    if (!validEmail(email)) {
      $('#email').css('border', '2px solid #cc0000');
      $('#email_error').html('Please enter a valid Email ID');
      status = false;
    }
  }
  if(status){
    $.ajax({
      url : '/stylist-forgot-password-post',
      method : "POST",
      async: false,
      data : $('#send-reset-link-form').serialize(),
      success : function (ajaxresponse){
          response = JSON.parse(ajaxresponse);
          if(response['status']){
            $('#message_box').html('<div class="alert alert-success">'+response['message']+'</div>');
            $('#signup').html($('#forgot_password_success_section').html());
          }else{
            $('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
           }
      }
  })
  } 
})
$('#stylist-reset-password-btn').click(function(){
  $('#stylist-reset-password-form input').css('border', '1px solid #ccc');
  $('.error').html('');
  $('.message').html('');
  var password=makeTrim($('#password').val());
  var confirm_password=makeTrim($('#confirm_password').val());
  var status=true;
  
if(password==''){
  $('#password').css('border', '2px solid #cc0000');
  $('#password_error').html('Please enter Password');
  status=false;
}else{
  if (password.length < 8) {
      $('#password').css('border', '2px solid #cc0000');
      $('#password_error').html('Your password must be at least 8 characters.');
      status = false;
  }
  else if (password.search(/[a-z]/i) < 0) {
      $('#password').css('border', '2px solid #cc0000');
      $('#password_error').html('Your password must contain at least one letter.');
      status = false;
  }else if(password.search(/[0-9]/) < 0){
      $('#password').css('border', '2px solid #cc0000');
      $('#password_error').html('Your password must contain at least one digit.');
      status = false;
  }
}
if (confirm_password == '') {
  $('#confirm_password').css('border', '2px solid #cc0000');
  $('#confirm_password_error').html('Please enter Confirm Password');
  status = false;
}
if (password != '') {
  if (confirm_password != password) {
    $('#confirm_password').css('border', '2px solid #cc0000');
    $('#confirm_password_error').html('Password and Confirm Password do not match.');
    status = false;
  }
}
  if(status){
    $.ajax({
      url : '/stylist-reset-password-post',
      method : "POST",
      async: false,
      data : $('#stylist-reset-password-form').serialize(),
      success : function (ajaxresponse){
          response = JSON.parse(ajaxresponse);
          if(response['status']){
            $('#message_box').html('<div class="alert alert-success">'+response['message']+'</div>');
            setTimeout(function(){
              window.location = "/stylist-login";
          }, 500);
          }else{
            $('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
          }
      }
  })
  }
})

})
if(constants.current_url=='/stylist-registration' || constants.current_url.search('/stylist-account-confirmation')!=-1){
  var currentTab = 0;
  showTab(currentTab);
}

function removeImage(){
  $("#frame-image").val('');
  var html ='';
  var html ='';
  html +='<div class="Neon-input-text ">';
  html +='<h3>Upload your profile</br> picture here</h3>';
  html +='</div>';
  html +='<a class="Neon-input-choose-btn blue">';
  html +='<img  src="'+constants.base_url+'/stylist/website/assets/images/plus.png" alt="" id="image_preview">';
  html +='</a>';
  $("#profile_image_preview_section").html(html);
  $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop');
  $('#source_image_preview_section_dynamic_class').addClass('Neon-input-dragDrop');
  $('#source_image_preview_section_dynamic_class').removeClass('Neon-input-dragDrop_without_border');
}
function showTab(n) {
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }
    fixStepIndicator(n)
}


  function fixStepIndicator(n) {
      // This function removes the "active" class of all steps...
      var i, x = document.getElementsByClassName("step");
      for (i = 0; i < x.length; i++) {
          x[i].className = x[i].className.replace(" active", "");
      }
      //... and adds the "active" class on the current step:
      x[n].className += " active";
  }


        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            if (n == 1 && !validateForm()) {
              return false;
            }
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
              addStylist();
              return false;
            }
            showTab(currentTab);
        }
        function nextPrevStep(n) {
          var x = document.getElementsByClassName("tab");
          if (n == 1 && !stylistValidateForm()) {
            return false;
          }
          x[currentTab].style.display = "none";
          currentTab = currentTab + n;
          if (currentTab >= x.length) {
            addStylistSecondProcess();
            return false;
          }
          showTab(currentTab);
      }

      
      function stylistValidateForm() {
        $('#stylist-registration-final-step-form input').css('border', '1px solid #ccc');
        $('.error').html('');
        $('.message').html('');
        var x, y, i, valid = true;
        if(currentTab==0){
          valid = false
          return  stylistSetpOneValidation();
        }
        if(currentTab==1){
          valid = false
          return  stylistSetpTwoValidation();
        }      
        if (valid) {
          document.getElementsByClassName("step")[currentTab].className += " finish";
      }
      return valid; 
      }
        function validateForm() {
          $('#stylist-registration-form input').css('border', '1px solid #ccc');
          $('.error').html('');
          $('.message').html('');
          var x, y, i, valid = true;
          if(currentTab==0){
            valid = false
            return  setpOneValidation();
          }
          if(currentTab==1){
            valid = false
            return  setpTwoValidation();
          }
          if(currentTab==2){
            valid = false
            return  setpThreeValidation();
          }
          if(currentTab==3){
            valid = false
            return  setpFourValidation();
          }
          if(currentTab==4){
            valid = false
            return  setpFiveValidation();
          }     
          if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; 
        }

function addStylistSecondProcess(){
    var  brands_arr = $('#myTags').tagsValues();
    var brands_list='';
    if(brands_arr.length>0){
      brands_list= brands_arr.toString();
      $('#favourite_brand_list').val(brands_list);
    }
    /*
    var preferred_style_arr=[];
      $(".selected_preferred_style_type").each(function(){
      preferred_style_arr.push($(this).attr('data_id'));
    });
    var preferred_style_type_list='';
    if(preferred_style_arr.length>0){
      preferred_style_type_list=preferred_style_arr.toString();
    }
    $('#preferred_style_type_list').val(preferred_style_type_list);
    */
 
    $.ajax({
      type: 'POST',
      url : '/add-stylist-second-process',
      data: new FormData($("#stylist-registration-final-step-form")[0]),
      async : false,
      cache : false,
      contentType : false,
      processData : false,
      success : function (ajaxresponse){
          response = JSON.parse(ajaxresponse);
          if(response['status']){
            $('#next-previous').remove();
            $('#steps-next-previous').remove();
            $('.success_tab').show();
           $("#stylist-registration-success-url").prop("href", response['url']);
          }else{
            $('#second_step_message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
            currentTab = currentTab - 1;
            showTab(currentTab);
          }
      }
  })
}

function addStylist(){
  $.ajax({
    url : '/add-stylist',
    method : "POST",
    async: false,
    data : $('#stylist-registration-form').serialize(),
    success : function (ajaxresponse){
        response = JSON.parse(ajaxresponse);
        if(response['status']){
          $('#next-previous').remove();
          $('#steps-next-previous').remove();
          $('.success_tab').show();
         $("#stylist-registration-success-url").prop("href", response['url']);
        }else{
          $('#fourth_step_message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
          currentTab = currentTab - 1;
          showTab(currentTab);
        }
    }
})
}
function stylistSetpOneValidation(){
  $('#stylist-registration-final-step-form input ').css('border', '1px solid #ccc');
  $('.error').html('');
  $('.message').html('');
  var user_name=makeTrim($('#user_name').val());
  var password=makeTrim($('#password').val());
  var confirm_password=makeTrim($('#confirm_password').val());
  var status=true;
  if(user_name==''){
    $('#user_name').css('border', '2px solid #cc0000');
    $('#user_name_error').html('Please enter username');
    status=false;
  }else{
    $.ajax({
      url : '/check-stylist-existance',
      method : "POST",
      async: false,
      data : {
        'key':'user_name',
        'value':user_name,
        '_token': constants.csrf_token
      },
      success : function (ajaxresponse){
          response = JSON.parse(ajaxresponse);
          if (!response['status']) {
            $('#user_name').css('border', '2px solid #cc0000');
            $('#user_name_error').html('User name already exists!');
            status = false; 
          }
      }
  })
  }
  
  if(password==''){
    $('#password').css('border', '2px solid #cc0000');
    $('#password_error').html('Please enter Password');
    status=false;
  }else{
    if (password.length < 8) {
        $('#password').css('border', '2px solid #cc0000');
        $('#password_error').html('Your password must be at least 8 characters.');
        status = false;
    }
    else if (password.search(/[a-z]/i) < 0) {
        $('#password').css('border', '2px solid #cc0000');
        $('#password_error').html('Your password must contain at least one letter.');
        status = false;
    }else if(password.search(/[0-9]/) < 0){
        $('#password').css('border', '2px solid #cc0000');
        $('#password_error').html('Your password must contain at least one digit.');
        status = false;
    }
  }
  if (confirm_password == '') {
    $('#confirm_password').css('border', '2px solid #cc0000');
    $('#confirm_password_error').html('Please enter Confirm Password');

    status = false;
  }
  if (password != '') {
    if (confirm_password != password) {
      $('#confirm_password').css('border', '2px solid #cc0000');
      $('#confirm_password_error').html('Password and Confirm Password do not match.');
      status = false;
    }
  }
  if(!status){
    $('#first_step_message_box').html('<div class="alert alert-danger">Please enter all the mandatory fields!</div>');
  }
  return status;

}
function stylistSetpTwoValidation(){
  var status=true;
  var short_bio=makeTrim($('#short_bio').val());
  var preferred_style=makeTrim($('#preferred_style').val());
  if(short_bio==''){
    $('#short_bio').css('border', '2px solid #cc0000');
    $('#short_bio_error').html('This field is required');
    status=false;
  }
  if(preferred_style==''){
    $('#preferred_style').css('border', '2px solid #cc0000');
    $('#preferred_style_error').html('This field is required');
    status=false;
  }
  if(!status){
    $('#third_step_message_box').html('<div class="alert alert-danger">Please enter all the mandatory fields!</div>');
  }
  return status;

}
function setpOneValidation(){
  $('#stylist-registration-form input ').css('border', '1px solid #ccc');
  $('.error').html('');
  $('.message').html('');
  var full_name=makeTrim($('#full_name').val());
  var email=makeTrim($('#email').val());
  var phone=makeTrim($('#phone').val());

  var status=true;
  if(full_name==''){
    $('#full_name').css('border', '2px solid #cc0000');
    $('#full_name_error').html('Please enter name');
    status=false;
  }
  if(email==''){
    $('#email').css('border', '2px solid #cc0000');
    $('#email_error').html('Please enter Email');
    status=false;
  }else {
    if (!validEmail(email)) {
      $('#email').css('border', '2px solid #cc0000');
      $('#email_error').html('Please enter a valid Email ID');
      status = false;
    }else{
      $.ajax({
        url : '/check-stylist-existance',
        method : "POST",
        async: false,
        data : {
          'key':'email',
          'value':email,
          '_token': constants.csrf_token
        },
        success : function (ajaxresponse){
            response = JSON.parse(ajaxresponse);
            if (!response['status']) {
              $('#email').css('border', '2px solid #cc0000');
              $('#email_error').html(response['message']);
              status = false; 
            }
        }
    })
    }
  }
  if(phone==''){
    $('#phone').css('border', '2px solid #cc0000');
    $('#phone_error').html('Please enter Phone');
    status=false;
  }else{
      $.ajax({
        url : '/check-stylist-existance',
        method : "POST",
        async: false,
        data : {
          'key':'phone',
          'value':phone,
          '_token': constants.csrf_token
        },
        success : function (ajaxresponse){
            response = JSON.parse(ajaxresponse);
            if (!response['status']) {
              $('#phone').css('border', '2px solid #cc0000');
              $('#phone_error').html(response['message']);
              status = false; 
            }
        }
    })
  }
  if(!status){
    $('#first_step_message_box').html('<div class="alert alert-danger">Please enter all the mandatory fields!</div>');
  }
  return status;
}

function setpFourValidation(){
  $('.message').html('');
  var status=true;
  if (!$('#shop').is(':checked') && !$('#style').is(':checked') && !$('#source').is(':checked')) {
    status=false;
  }
  if(!status){
    $('#fourth_step_message_box').html('<div class="alert alert-danger">Please select at least one!</div>');
  }
  return status;
}

function setpFiveValidation(){
  $('.message').html('');
  var status=true;
  if($("input[name='gender']:checked").val()==undefined){
    status=false;
    $('#fifth_step_message_box').html('<div class="alert alert-danger">Please select your gender!</div>');
  }
  return status;
}

function setpThreeValidation(){
  var status=true;
  var styling_experience=makeTrim($('#styling_experience').val());
  //var fashion_styling_brief=makeTrim($('#fashion_styling_brief').val());
  //var client_brief=makeTrim($('#client_brief').val());
  var fashion_beauty_brands=makeTrim($('#fashion_beauty_brands').val());
  var stronger_experience=makeTrim($('#stronger_experience').val());
  if(styling_experience==''){
    $('#styling_experience').css('border', '2px solid #cc0000');
    $('#styling_experience_error').html('This field is required');
    status=false;
  }
  if(fashion_beauty_brands==''){
    $('#fashion_beauty_brands').css('border', '2px solid #cc0000');
    $('#fashion_beauty_brands_error').html('This field is required');
    status=false;
  }
  if(stronger_experience==''){
    $('#stronger_experience').css('border', '2px solid #cc0000');
    $('#stronger_experience_error').html('This field is required');
    status=false;
  }
  if(!status){
    $('#third_step_message_box').html('<div class="alert alert-danger">Please enter all the mandatory fields!</div>');
  }
  return status;
}

function setpTwoValidation(){
  var status=true;
  if($("#country_id").val()==''){
    status=false;
    $('#second_step_message_box').html('<div class="alert alert-danger">Please select your country!</div>');
  }
  return status;
}

/*
function setpFiveValidation(){
  var status=true;
  var total_selected_brand=$('.brand_list_check').filter(':checked').length;
  if(total_selected_brand==0){
    status=false;
    $('#fifth_step_message_box').html('<div class="alert alert-danger">Please select at least one brand!</div>');
  }
  return status;
}
*/

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
function runSuggestions(element,query) {

  let sug_area=$(element).parents().eq(2).find('.autocomplete .autocomplete-items');
  $.ajax({
    url : '/get-brands-list',
    method : "POST",
    async: false,
    data : {
      'brand_search':query,
      'existing_data':$('#myTags').tagsValues(),
      '_token': constants.csrf_token
    },
    success : function (ajaxresponse){
        response = JSON.parse(ajaxresponse);
        if(response['data'].length>0){
          _tag_input_suggestions_data = response['data'];
          for(i=0;i<response['data'].length;i++){
            let template = $("<div>"+response['data'][i]['name']+"</div>").hide();
            sug_area.append(template);
            template.show();
          }
        }
         
    }
  })
  
}

function removePreferredStyle(id){
  $('.error').html('');
  $('#add-preferred_style'+id).prop('disabled', false);
  $('#select_preferred_data'+id).remove();
}
function addPreferredStyle(add_preferred_style){
  $('.error').html('');
  if($(".preferred_style_type:checkbox").filter(":checked").length>3){
    var data_id=$(add_preferred_style).attr('data_id');
    $('#add-preferred_style'+data_id).prop('checked', false);
    $('#preferred_style_error').html('You can not select more than 3 preferred style type!')
  }
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
 