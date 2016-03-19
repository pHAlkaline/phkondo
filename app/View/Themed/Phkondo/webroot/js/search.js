$(function() {
    $("form[role=search]").submit(function(event) {
        if($('#keyword').attr("keyword")==$('#keyword').val()){
            $('#keyword').val('');
        }
        //event.preventDefault();
        
        
    });
    
    $("#searchFormClear").click(function(event){
        $('#keyword').val('');
        
    })


});