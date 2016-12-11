/**
 * Select2 <It> translation.
 *
 * Author: Ivo Barone <ivo.barone@gmail.com>
 */
(function ($) {
    "use strict";

    $.fn.select2.locales['it'] = {
        formatMatches: function (matches) { if (matches === 1) { return "Un risultato trovato, premi invio per selezionarlo."; } return matches + " risultati disponibili, usa i pulsanti su e giu' per scorrerli."; },
        formatNoMatches: function () { return "Nessun risultato trovato"; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Seleziona " + n + " o piu' caratter"+ (n == 1 ? "e" : "i"); },
        formatInputTooLong: function (input, max) { var n = input.length - max; return "Cancella " + n + " charatter" + (n == 1 ? "e" : "i"); },
        formatSelectionTooBig: function (limit) { return "Puoi selezionare solo " + limit + " valor" + (limit == 1 ? "e" : "i"); },
        formatLoadMore: function (pageNumber) { return "Caricamento altri risultati…"; },
        formatSearching: function () { return "Ricerca in corso…"; }
    };

    $.extend($.fn.select2.defaults, $.fn.select2.locales['it']);
})(jQuery);
