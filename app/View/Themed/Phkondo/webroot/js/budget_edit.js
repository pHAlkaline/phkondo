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
    $("#BudgetBudgetStatusId").change(function () {
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
        scrollToAnchor('warningzone');
    });

    $("input[readonly]").click(function () {
        $("#disabledWarning").removeClass('hide');
        scrollToAnchor('warningzone');
    });

    function scrollToAnchor(aid) {
        var aTag = $("a[name='" + aid + "']");
        aTag.removeClass('hide');
        $('html,body').animate({scrollTop: aTag.offset().top}, 'slow');
    }

   


});







