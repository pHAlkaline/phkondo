/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){

$("#ReceiptFractionId").on("change", function (event) {
        $("#ReceiptChangeFilter").val('1');
        $(this).closest("form").submit();
        return false;
    });
});