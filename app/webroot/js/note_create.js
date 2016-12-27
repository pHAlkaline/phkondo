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
    $( "input[data-type='note']" ).change(function() {
        
        var isShare=this.id.match(/Shares/);
        var val=$( this ).val();
        if (val=='' || isNaN(val)){
            val=0
        }
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







