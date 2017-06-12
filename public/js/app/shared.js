var userInfo = {};
var ajaxUrls = {};

var timeHelper = null;
$(document).ready(function() {
    userInfo = $("#user-info").data();
    ajaxUrls = $("#ajax-urls").data();
    timeHelper = new TimeHelper();

    $(document).on('click','[data-click]',function () {
        $($(this).attr('data-click')).trigger('click');
    })

    $(document).on('change','[data-change-converted-time]',function () {
        timeHelper.setUserTimeToUtc($(this));
    })

    $('[data-convert-time]').each(function () {
        timeHelper.updateTimes($(this));
    })
});