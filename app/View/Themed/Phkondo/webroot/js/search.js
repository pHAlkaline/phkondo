$(function() {
    $("form[role=search]").submit(function(event) {
        
        if ($('#keyword').val()==''){
            $('#keyword').attr("disabled", "disabled");
        }
        //event.preventDefault();
        
        if ($('#AdvancedSearchFields').is(":hidden")) {
            $("#AdvancedSearchFields select").attr("disabled", "disabled");
            $("#AdvancedSearchFields input").attr("disabled", "disabled");
        };
        $("#resultsContainer").html('<h1 class="col-sm-12 text-center"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></h1>');
        return true;
        
    });
   
    $("#searchFormClear").click(function(event){
        $("#AdvancedSearchFields").slideUp();
        $('#keyword').attr("disabled", "disabled");
        $('#keyword').val('');
        $("#AdvancedSearchFields select").attr("disabled", "disabled");
        $("#AdvancedSearchFields input").attr("disabled", "disabled");
        
    })
    
    $("#searchFormFilter").click(function (event) {
        $("#AdvancedSearchFields").slideToggle();
        
    });


});