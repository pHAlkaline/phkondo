/**
 *
 * pHKondo : pHKondo software for condominium property managers (http://phalkaline.net)
 * Copyright (c) pHAlkaline . (http://phalkaline.net)
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
 * @copyright     Copyright (c) pHAlkaline . (http://phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.View.Themed.webroot.js
 * @since         pHKondo v 0.0.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 * 
 */

$(function () {
    $("#InvoiceConferenceInvoiceConferenceStatusId").change(function () {
        $("#elem_payment_date").removeClass("hidden");
        switch ($(this).val()) {
            case '5':
//               $("#InvoiceConferencePaymentDateDay").prop('disabled', false);
//                $("#InvoiceConferencePaymentDateMonth").prop('disabled', false);
//                $("#InvoiceConferencePaymentDateYear").prop('disabled', false);
                $("#InvoiceConferencePaymentDate").prop('disabled', false);
                $("#elem_payment_date").show('slow');
                break;
            default:
//                $("#InvoiceConferencePaymentDateDay").prop('disabled', true);
//                $("#InvoiceConferencePaymentDateDay").prop('disabled', true);
//                $("#InvoiceConferencePaymentDateYear").prop('disabled', true);
                $("#InvoiceConferencePaymentDate").prop('disabled', true);
                $("#elem_payment_date").hide('fast');

        }


    });


});







