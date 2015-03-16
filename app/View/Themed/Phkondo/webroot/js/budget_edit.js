

$(function(){
    $("#BudgetBudgetStatusId").change(function(){
        $("#cancelWarning").addClass('hide');
        $("#pendingWarning").addClass('hide');
        switch ($(this).val()) {
        
            case '1':
                $("#pendingWarning").removeClass('hide');
                $("#cancelWarning").addClass('hide');
                break;
            case '4':
                $("#pendingWarning").addClass('hide');
                $("#cancelWarning").removeClass('hide');
                break;
            default:
                $("#pendingWarning").addClass('hide');
                $("#cancelWarning").addClass('hide');
                break;
        
        } 
        
       
    });
    

});







