

$(function () {

    $(".select2-phkondo").select2({
        ajax: {
            url: phkondo.APP_PATH + 'fraction_owners/search_clients/?fraction_id=' + $('#EntitiesFractionFractionId').val(),
            // url: "https://api.github.com/search/repositories",
            dataType: 'json',
            quietMillis: 1500,
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
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
        },
        templateResult: formatResult,
        templateSelection: formatSelection,
        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        escapeMarkup: function (m) {
            return m;
        },
        theme: 'bootstrap',
        placeholder: phkondo.SEARCH_HERE_FOR_A_CLIENT,
        minimumInputLength: 3,
        // we do not want to escape markup since we are displaying html in results
    });

    function formatResult(item) {
        if (item.loading) {
            return item.text;
        }
        if (typeof item.name == 'undefined') {
            item.name = '...';
        }
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

    function formatSelection(item) {
        return item.name;
    }

});






