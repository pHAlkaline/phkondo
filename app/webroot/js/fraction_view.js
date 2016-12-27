$(function () {
    $('#viewCommentsBtn').click(function () {
        $('.comments').toggleClass("hide");
    });

    if (window.location.hash) {
        // hash found
        var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
        if (hash.toLowerCase().indexOf("comment") >= 0) {
            $('.comments').toggleClass("hide");
        }
        
    } else {
        // No hash found
    }

    
});

