$(function() {
    $("form[role=search]").submit(function(event) {
        //if($('#keyword').attr("keyword")==$('#keyword').val()){
            //$('#keyword').val('');
        //}
        //event.preventDefault();
        return true;
        
    });
    
    $("#searchFormClear").click(function(event){
        $('#keyword').attr("disabled", "disabled");
        $('#keyword').val('');
        
    })


});