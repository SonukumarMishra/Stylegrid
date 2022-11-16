$(function(){
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


  $('#image_preview_remove').click(function(){
    $("#frame-image").val('');
    $('#image_preview_remove').hide();
    $("#divImageMediaPreview").html('');
})
  $("#frame-image").change(function () {
    $('.error').html('');
    if (typeof (FileReader) != "undefined") {
        var dvPreview = $("#divImageMediaPreview");
        dvPreview.html("");            
       // $($(this)[0].files).each(function () {
            var file = $(this)[0].files;//$(this); 
            var ext = $('#frame-image').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
                $('#image_error').html('Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.');
                $("#frame-image").val('');
                return false;
            }else{
                var image_size = (this.files[0].size);
                if(image_size>1000000){
                    $('#image_error').html('Maximum File Size Limit is 1 MB');
                    $("#frame-image").val('');
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
})
if(constants.current_url=='/stylist-registration' || constants.current_url.search('/stylist-account-confirmation')!=-1){
  var currentTab = 0;
  showTab(currentTab);
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
    $('#confirm_password_error').html('Required*');
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
 // var favourite_brands=makeTrim($('#favourite_brands').val());
  var preferred_style=makeTrim($('#preferred_style').val());
  if(short_bio==''){
    $('#short_bio').css('border', '2px solid #cc0000');
    $('#short_bio_error').html('This field is required');
    status=false;
  }
  //if(favourite_brands==''){
   // $('#favourite_brands').css('border', '2px solid #cc0000');
   // $('#favourite_brands_error').html('This field is required');
   // status=false;
  //}
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
              $('#email_error').html('Email Address already exists!');
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
              $('#phone_error').html('Phone Number already exists!');
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

function setpFiveValidation(){
  var status=true;
  var total_selected_brand=$('.brand_list_check').filter(':checked').length;
  if(total_selected_brand==0){
    status=false;
    $('#fifth_step_message_box').html('<div class="alert alert-danger">Please select at least one brand!</div>');
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
 