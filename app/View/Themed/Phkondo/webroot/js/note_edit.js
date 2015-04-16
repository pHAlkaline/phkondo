

$(function () {

    $("#NoteNoteStatusId").change(function () {
        $("#elem_payment_date").removeClass("hidden");
        switch ($(this).val()) {
            case '1':
//                $("#NotePaymentDateDay").prop('disabled', true);
//                $("#NotePaymentDateMonth").prop('disabled', true);
//                $("#NotePaymentDateYear").prop('disabled', true);
                $("#NotePaymentDate").prop('disabled', true);
                $("#elem_payment_date").hide('slow');

                break;
            case '3':
//               $("#NotePaymentDateDay").prop('disabled', false);
//                $("#NotePaymentDateMonth").prop('disabled', false);
//                $("#NotePaymentDateYear").prop('disabled', false);
                $("#NotePaymentDate").prop('disabled', false);
                $("#elem_payment_date").show('slow');
                break;
            default:
//                $("#NotePaymentDateDay").prop('disabled', true);
//                $("#NotePaymentDateDay").prop('disabled', true);
//                $("#NotePaymentDateYear").prop('disabled', true);
                $("#NotePaymentDate").prop('disabled', true);
                $("#elem_payment_date").hide('fast');

        }


    });


});







