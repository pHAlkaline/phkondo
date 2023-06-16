/**
 *
 * pHKondo : pHKondo software for condominium hoa association management (https://phalkaline.net)
 * Copyright (c) pHAlkaline . (https://phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (https://phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.View.Themed.webroot.js
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

$(function () {

    $('.footable').footable().on('ready.ft.table', function (e, ft) {
        $('.loading').remove();
        $('.footable').parent().removeClass('hidden').fadeIn('slow');

        $("input[data-context=disenalllines]").change(function () {
            var status = $(this).is(":checked") ? true : false;
            $("input[data-context=disenline]").prop("checked", status).trigger('change');
        });

        $("input[data-context=disenline]").change(function () {
            var line = $(this).closest('tr');
            line.find("input[data-context=note]").attr('disabled', !$(this).is(':checked')).css({ 'opacity': !$(this).is(':checked') ? 0.5 : 1 });
            line.find("input[type=text]").css({ 'opacity': !$(this).is(':checked') ? 0.5 : 1 }).first().trigger('change');
            var lineResponsive = line.next('.footable-detail-row');
            lineResponsive.find("input[data-context=note]").attr('disabled', !$(this).is(':checked')).css({ 'opacity': !$(this).is(':checked') ? 0.5 : 1 });
            lineResponsive.find("input[type=text]").css({ 'opacity': !$(this).is(':checked') ? 0.5 : 1 }).first().trigger('change');
        });

        $("input[data-context=note]").change(function () {

            var isShare = this.id.match(/Shares/);
            var val = $(this).val();
            if (val == '' || isNaN(val)) {
                val = 0
            }
            val = parseFloat(val).toFixed(2);
            if (isShare) {
                val = parseFloat(val).toFixed(0);
                var periodicity = $("#NoteBudgetPeriodicity").val();

                if (periodicity == 1) {
                    //alert(periodicity);
                    val = 1;
                }
            }
            $(this).val(val);

            var index = $(this).attr('id').replace(/[^0-9]/g, '');
            var amount = parseFloat($("#Note" + index + "Amount").val());
            var commonReserveFund = parseFloat($("#Note" + index + "CommonReserveFund").val());
            var shares = parseFloat($("#Note" + index + "Shares").val());


            var total = ((amount + commonReserveFund) * shares).toFixed(2);
            //alert(total);
            $("#Note" + index + "Total").val(total);

            var notesTotal = 0;
            $('input').filter(function () {
                return this.id.match(/Total/);
            }).each(function (index) {
                var val = 0;
                var checked = $(this).closest('tr').find("input[data-context=disenline]").is(':checked');
                if (checked) {
                    val = $(this).val();
                }
                notesTotal = parseFloat(notesTotal) + parseFloat(val);
                notesTotal = notesTotal.toFixed(2);
                //console.log( notesTotal );
            });
            $('#notesTotal').html(notesTotal);
            $('#notesTotal').removeClass('text-danger');
            $('input[type="submit"]').prop('disabled', false).find('.fa-spinner').first().remove();
            if (notesTotal != $("#NoteBudgetAmount").val()) {
                $("#NoteBudgetNotesAmount").val(notesTotal);
                //$('input[type="submit"]').prop('disabled', true);  
                $('#notesTotal').parent().addClass('text-danger');
            }
            ;

            // Check input( $( this ).val() ) for validity here
        });

        $("input[data-context='note']").keypress(function (event) {
            if (event.which == 46 && !this.id.match(/Shares/)) {
                return true;
            }
            if (event.which < 48 || event.which > 57) {
                event.preventDefault();
                return false;
            }
            return true;
        });
    });



});







