

$(function(){
    $( "input[data-type='note']" ).change(function() {
        
        var isShare=this.id.match(/Shares/);
        var val=$( this ).val();
        val = parseFloat(val).toFixed(2);
        if (isShare){ 
            val = parseFloat(val).toFixed(0); 
            var periodicity=$( "#NoteBudgetPeriodicity" ).val();
            
            if (periodicity==1){ 
                //alert(periodicity);
                val=1;
            }
        }
        $( this ).val(val);   
        
        var index=$( this ).attr('id').replace(/[^0-9]/g, '');
        var amount=parseFloat($( "#Note"+index+"Amount" ).val());
        var commonReserveFund=parseFloat($( "#Note"+index+"CommonReserveFund" ).val());
        var shares=parseFloat($( "#Note"+index+"Shares" ).val());
        
        
       
        
        var total=((amount+commonReserveFund)*shares).toFixed(2);
        //alert(total);
        $( "#Note"+index+"Total" ).val(total);
        
        var notesTotal=0;
        $('input').filter(function() {
            return this.id.match(/Total/);
        }).each(function( index ) {
            notesTotal = parseFloat(notesTotal) + parseFloat($( this ).val());
            notesTotal = notesTotal.toFixed(2);
        //console.log( notesTotal );
        });
        $('#notesTotal').html(notesTotal);
        $('#notesTotal').removeClass('text-danger');
        $('input[type="submit"]').prop('disabled', false);
        if (notesTotal!=$( "#NoteBudgetAmount" ).val()){
            $( "#NoteBudgetNotesAmount" ).val(notesTotal);
            //$('input[type="submit"]').prop('disabled', true);  
            $('#notesTotal').parent().addClass('text-danger');
        } 
    ;
        
    // Check input( $( this ).val() ) for validity here
    });
    
    $( "input[data-type='note']" ).keypress(function( event ) {
        if ( event.which == 46 && !this.id.match(/Shares/)) {
            return true;
        }
        if ( event.which < 48 || event.which > 57 ) {
            event.preventDefault();
            return false;
        }
        return true;
    });
    

});







