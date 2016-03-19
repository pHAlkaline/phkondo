/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.eu)
 * Copyright (c) pHAlkaline . (http://phalkaline.eu)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.eu)
 * @link          http://phkondo.net pHKondo Project
 * @package       app.View.Themed.webroot.js
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */


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