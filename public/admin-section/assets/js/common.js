$('.alphaonly').bind('keyup blur keydown onpaste',function(){ 
  var regEx = /^[a-z][a-z\s]*$/;
  if(!$(this).val().match(regEx)){
    $(this).val('');
  } 
});
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
  function viewStylistStatus(status){
    if(status==0){
      return "<span class='orange-color'>PENDING</span>";
    }
    if(status==1){
      return "<span class='green-color'>APPROVED</span>";    }
    if(status==2){
      return "<span class='red-color'>DENIED</span>";
    }
  }