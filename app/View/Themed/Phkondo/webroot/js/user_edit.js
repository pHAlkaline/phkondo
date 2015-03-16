

$(function(){
    $("#UserEdpassword").click(function(){
        
        if ($("#UserEdpassword").is(':checked')){
           $("#UserPassword").removeAttr("disabled"); 
           $("#UserVerifyPassword").removeAttr("disabled"); 
        } else {
           $("#UserPassword").attr("disabled",true);
           $("#UserVerifyPassword").attr("disabled",true);
           $("#UserPassword").val('');
           $("#UserVerifyPassword").val('')
        }
        
        
       
    });
    

});







