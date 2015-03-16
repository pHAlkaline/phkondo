

$(function(){
    $("#InvoiceConferenceInvoiceConferenceStatusId").change(function(){
         $("#elem_payment_date").removeClass( "hidden" );
        switch ($(this).val()) {
            case '5':
               $("#InvoiceConferencePaymentDateDay").prop('disabled', false);
                $("#InvoiceConferencePaymentDateMonth").prop('disabled', false);
                $("#InvoiceConferencePaymentDateYear").prop('disabled', false);
                $("#elem_payment_date").show('slow');
                break;
            default:
                $("#InvoiceConferencePaymentDateDay").prop('disabled', true);
                $("#InvoiceConferencePaymentDateDay").prop('disabled', true);
                $("#InvoiceConferencePaymentDateYear").prop('disabled', true);
                $("#elem_payment_date").hide('fast');
        
        } 
        
       
    });
    

});







