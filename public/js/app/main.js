var userInfo = {};
var ajaxUrls = {};

$.siteAjax = function (options) {
    if(!options.headers){
        options.headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };
    }

    return $.ajax(options);
}

$(document).ready(function() {
    userInfo = $("#user-info").data();
    ajaxUrls = $("#ajax-urls").data();
});