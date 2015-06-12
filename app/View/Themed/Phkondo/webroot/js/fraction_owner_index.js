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

$(function () {
    
    $("#EntitiesFractionClient").select2({
        placeholder: phkondo.SEARCH_HERE_FOR_A_CLIENT,
        minimumInputLength: 3,
        ajax: {
            url: phkondo.APP_PATH + 'fraction_owners/search_clients',
            // url: "https://api.github.com/search/repositories",
            dataType: 'json',
            quietMillis: 250,
            data: function (term, page) { // page is the one-based page number tracked by Select2
                return {
                    q: term, //search term
                    page: page // page number
                };
            },
            results: function (data, page) {
                //var more = (page * 30) < data.total_count; // whether or not there are more results available
                var more = false;
                // notice we return the value of more so Select2 knows if more results can be loaded
                return {results: data.items, more: more};
            }
        },
        formatResult: repoFormatResult, // omitted for brevity, see the source of this page
        formatSelection: repoFormatSelection, // omitted for brevity, see the source of this page
        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        escapeMarkup: function (m) {
            return m;
        } // we do not want to escape markup since we are displaying html in results
    });

    function repoFormatResult(item) {
        var markup = '<div class="row-fluid">' +
                '<div class="span10">' +
                '<div class="row-fluid">' +
                '<div class="span3"><i class="fa fa-user"></i>&nbsp;' + item.name + '</div>' +
                '</div>';

        if (item.address) {
            markup += '<div>' + item.address + '</div>';
        }

        markup += '</div></div>';

        return markup;
    }

    function repoFormatSelection(item) {
        return item.name;
    }

});







