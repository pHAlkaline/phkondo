

$(function () {
    $('#send-all-btn').on('click', function (ev) {
        ev.preventDefault();
        $('.send-ajax-btn').trigger('click');
        return false;
    });
    $('.footable').on('ready.ft.table', function (e, ft) {
        $('.send-ajax-btn').on('click', function (ev) {
            var target = $(this);
            var target_href = $(this).attr("href");
            var options = {
                cache: false,
                type: 'get',
                dataType: 'HTML',
                url: target_href,
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    target.removeClass('btn-primary').removeClass('btn-danger').removeClass('btn-success').addClass('btn-info').addClass('disabled').prop('disabled', true);

                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.error) {
                        alert(response.error);
                        console.log(response.error);
                    }
                    if (response.result) {
                        target.removeClass('btn-primary').addClass('btn-success').addClass('disabled').prop('disabled', true);
                    }
                },
                error: function (e) {
                    alert("An error occurred: " + e.responseText.message);
                    console.log(e);
                    target.removeClass('btn-primary').addClass('btn-danger').removeClass('disabled').prop('disabled', false);
                }
            };
            // same param as $.ajax(option); see http://api.jquery.com/jQuery.ajax/
            $.ajaxQueue.addRequest(options);

            // start processing one by one requests
            //$.ajaxQueue.run();

            // stop at actual position @TODO use .pause() instend
            //$.ajaxQueue.stop();

            //delete all unprocessed requests from cache
            //$.ajaxQueue.clear();
            //$.ajax(options);
            ev.preventDefault();
            return false;

        })


    });

});




