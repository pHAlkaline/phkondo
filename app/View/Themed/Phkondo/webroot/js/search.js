$(function () {
    $("form[role=search]").submit(function (event) {

        if ($('#keyword').val() == '') {
            $('#keyword').attr("disabled", true);
        }
        //event.preventDefault();

        if ($('#AdvancedSearchFields').is(":hidden")) {
            $("#AdvancedSearchFields select").prop('selectedIndex', 0).attr("disabled", true);
            $("#AdvancedSearchFields input").attr("disabled", true).val('');
        };
        $("#resultsContainer").html('<h1 class="col-sm-12 text-center"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></h1>');


    });

    $("#searchFormClear").click(function (event) {
        $("#AdvancedSearchFields").slideUp('fast');
        $('#keyword').attr("disabled", true).val('');
        $("#AdvancedSearchFields select").prop('selectedIndex', 0).attr("disabled", true);
        $("#AdvancedSearchFields input").attr("disabled", true).val('');

        $("form[role=search]").trigger('submit');
    })

    $("#searchFormFilter").click(function (event) {
        $("#AdvancedSearchFields").slideToggle();

    });


});