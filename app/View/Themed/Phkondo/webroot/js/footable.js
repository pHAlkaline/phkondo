$(function () {
    $('.footable').footable().on('ready.ft.table',function(e, ft){
        $('.loading').remove();
        $('.footable').parent().removeClass('hidden').fadeIn('slow');
    });
});

