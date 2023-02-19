$('.alphaonly').bind('keyup blur keydown onpaste',function(){ 
  var regEx = /^[a-z][a-z\s]*$/;
  if(!$(this).val().match(regEx)){
    $(this).val('');
  } 
});
function checkArray(key,array){
  var status = false;
  for(var i=0; i<array.length; i++){
    var id = array[i];
    if(id == key){
      status = true;
      break;
    }
  }
  return status;
}

$(function(){
  $('#search_brand_list').keyup(function(){
    $('.message').html('');
    var selected_brand=[];
    $(".selected_brand").each(function(){
      selected_brand.push($(this).attr('data_id'));
    });
    var brand_search=$(this).val();
    //if(brand_search.length>0){
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
              $('#member_brand_search_data_list').html('');
                 if(response['data'].length>0){                    
                     var html='';
                     for(i=0;i<response['data'].length;i++){
                     var checked='';
                     if(selected_brand.length>0){
                      if(checkArray(response['data'][i]['id'],selected_brand)){
                        checked='checked';
                      }
                     }
                     
                      html +='<div class="col-md-3 text-center">';
                      html +='<div class="text-right">';

                      html +='<input type="checkbox" class="brand_list_check" id="check-'+response['data'][i]['id']+'" '+checked+' onclick="selectBrand(this)" value="'+response['data'][i]['id']+'">';
                      
                      html +='<label for="check-'+response['data'][i]['id']+'"></label>';
                      html +='</div>';
                      html +='<label for="check-'+response['data'][i]['id']+'">';
                      html +='<img src="'+constants['base_url']+'/member/website/assets/images/'+response['data'][i]['logo']+'" alt="">';
                      html +='</label>';
                      html +='</div>';
                  }
                  $('#member_brand_search_data_list').html(html);
                  
                }
             }
        }
    })
   // }
  })
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      if(constants.current_url=='/member-login'){
          $('#member-login-btn').trigger('click');
      }
    }
  });
  $('#member-login-btn').click(function(){
    $('#member-login-form input').css('border', '1px solid #ccc');
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
        url : '/member-login-post',
        method : "POST",
        async: false,
        data : $('#member-login-form').serialize(),
        success : function (ajaxresponse){
            response = JSON.parse(ajaxresponse);
            if(response['status']){
              $('#message_box').html('<div class="alert alert-success">'+response['message']+'</div>');
              setTimeout(function(){
                window.location = "/member-dashboard";
            }, 500);
            }else{
              $('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
              if(response['verification_url']!=''){
                $('#message_box').append("<p class='message'><a href='"+response['verification_url']+"' target='_blank'>Click here to verify your account!</a></p>");
              }
            }
        }
    })
    }else{
      $('#message_box').html('<div class="alert alert-danger">Please enter all the mandatory fields!</div>');
    }
  })

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
        url : '/member-forgot-password-post',
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
  $('#member-reset-password-btn').click(function(){
    $('#member-reset-password-form input').css('border', '1px solid #ccc');
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
    if(status){
      $.ajax({
        url : '/member-reset-password-post',
        method : "POST",
        async: false,
        data : $('#member-reset-password-form').serialize(),
        success : function (ajaxresponse){
            response = JSON.parse(ajaxresponse);
            if(response['status']){
              $('#message_box').html('<div class="alert alert-success">'+response['message']+'</div>');
              setTimeout(function(){
                window.location = "/member-login";
            }, 500);
            }else{
              $('#message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
            }
        }
    })
    }
  })
  

})
if(constants.current_url=='/member-registration'){
          var currentTab = 0; // Current tab is set to be the first tab (0)
          showTab(currentTab); // Display the current tab
        }
        
        function showTab(n) {
          // This function will display the specified tab of the form...
          var x = document.getElementsByClassName("tab");
          x[n].style.display = "block";
          //... and fix the Previous/Next buttons:
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
          //... and run a function that will display the correct step indicator:
          fixStepIndicator(n)
      }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            if (n == 1 && !validateForm()) {
              return false;
            }
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
              addMember();
              return false;
            }
            showTab(currentTab);
        }

        function validateForm() {
          $('#member-registration-form input').css('border', '1px solid #ccc');
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

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }

        function selectBrand(event){
          $('.message').html('');
          if($(event).is(':checked')){
              addselectedBrand($(event).val());
          }else{
              removeSelectedBrand($(event).val());
          }
      }
      function addselectedBrand(brand_id){
          if(brand_id>0){
              $('#selected_brand_section').addClass('brand-border');
              $('#selected_brand'+brand_id).remove();
              $.ajax({
                  url : '/get-brands-list',
                  method : "POST",
                  data : {
                      'brand_id':brand_id,
                      '_token': constants.csrf_token
                  },
                  success : function (ajaxresponse){
                      response = JSON.parse(ajaxresponse);
                      if (response['status']) {
                          if(response['data'].length>0){                    
                              var html='';
                              for(i=0;i<response['data'].length;i++){
                                  html +='<div class="my-2 selected_brand" data_id="'+response['data'][i]['id']+'" id="selected_brand'+response['data'][i]['id']+'">';
                                  html +='<img src="'+constants['base_url']+'/member/website/assets/images/'+response['data'][i]['logo']+'" alt="" class="img-fluid mx-2">';
                                  html +='<span onClick="removeSelectedBrand('+response['data'][i]['id']+')">X</span>';
                                  html +='</div>';
                              }
                              $('#selected_brand_section').append(html);
                          }
                      }
                  }
              })
          }
      }
      function removeSelectedBrand(brand_id){
          $('#selected_brand'+brand_id).remove();
          if($('#check-'+brand_id).is(':checked')){
              $('#check-'+brand_id).prop('checked', false);
          }
          if($('.selected_brand').length==0){
              $('#selected_brand_section').removeClass('brand-border');
          }
      }
function addMember(){
  var selected_brand=[];
  $(".selected_brand").each(function(){
    selected_brand.push($(this).attr('data_id'));
  });
  if(selected_brand.length>0){
    $('#selected_brand_list').val(selected_brand.toString());
  }
  $.ajax({
    url : '/add-member',
    method : "POST",
    async: false,
    data : $('#member-registration-form').serialize(),
    success : function (ajaxresponse){
        response = JSON.parse(ajaxresponse);
        if(response['status']){
          $('#next-previous').remove();
          $('#steps-next-previous').remove();
          $('.success_tab').show();
          if(response['stylist_data']){
            $('#stylist_name').html(response['stylist_data']['name']);
            var image='default_image.png';
            if(response['stylist_data']['profile_image']!=''){
              image=response['stylist_data']['profile_image'];
            }
            $('#stylist_image').html('<img src="http://stylist.stylegrid.com/stylist/attachments/profileImage/'+image+'" alt="" style="width:50%;">');
            $('#stylist_sort_bio').html(response['stylist_data']['short_bio']);
          }else{
            $('#stylist_name').html('We will assign Stylist for you soon.');
            $('#stylist_image').html('<img src="http://stylist.stylegrid.com/stylist/attachments/profileImage/default_image.png" alt="" style="width:50%;">');
            $('#stylist_sort_bio').html('need to set default update Sort bio');
          }
        }else{
          $('#fifth_step_message_box').html('<div class="alert alert-danger">'+response['message']+'</div>');
          currentTab = currentTab - 1;
          showTab(currentTab);
        }
    }
})
}
function setpOneValidation(){
  $('#member-registration-form input').css('border', '1px solid #ccc');
  $('.error').html('');
  $('.message').html('');
  var full_name=makeTrim($('#full_name').val());
  var email=makeTrim($('#email').val());
  var phone=makeTrim($('#phone').val());
  var password=makeTrim($('#password').val());
  var confirm_password=makeTrim($('#confirm_password').val());

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
        url : '/check-member-existance',
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
      url : '/check-member-existance',
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

function setpTwoValidation(){
  $('.message').html('');
  var status=true;
  if (!$('#shop').is(':checked') && !$('#style').is(':checked') && !$('#source').is(':checked')) {
    status=false;
  }
  if(!status){
    $('#second_step_message_box').html('<div class="alert alert-danger">Please select at least one!</div>');
  }
  return status;
}
function setpThreeValidation(){
  var status=true;
  if($("input[name='gender']:checked").val()==undefined){
    status=false;
    $('#third_step_message_box').html('<div class="alert alert-danger">Please select your gender!</div>');
  }
  return status;
}

function setpFourValidation(){
  var status=true;
  if($("#country_id").val()==''){
    status=false;
    $('#fourth_step_message_box').html('<div class="alert alert-danger">Please select your country!</div>');
  }
  return status;
}

function setpFiveValidation(){
  var selected_brand=[];
  $(".selected_brand").each(function(){
    selected_brand.push($(this).attr('data_id'));
  });
  var status=true;
  if(selected_brand.length==0){
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

