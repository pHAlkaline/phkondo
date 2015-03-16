

$(function(){
    $( "input[type='checkbox']" ).change(function() {
        $("#addNotesTotalAmount").html(' '+totalAmount());
    // Check input( $( this ).val() ) for validity here
    });
    
    $("#addNotesTotalAmount").html(' '+totalAmount());

});

function totalAmount(){
    var totalAmount=0;
    var boxes = $(":checkbox:checked");
    boxes.each(function() {
        var index=$( this ).attr('id').replace(/[^0-9]/g, '');
        var type=$( "#Note"+index+"Type" ).val(); 
        
        switch (type){
            case "1":
                totalAmount = parseFloat(totalAmount) - parseFloat($( "#Note"+index+"Amount" ).val());
                break;
            case "2":
                totalAmount =  parseFloat(totalAmount) + parseFloat($( "#Note"+index+"Amount" ).val());
                break;
            default:
                break;
        }
        
        
     
        
        
        totalAmount = totalAmount.toFixed(2);
        
        
    });
    return (parseFloat($("#ReceiptAmount").val()) + parseFloat(totalAmount)).toFixed(2);
}







