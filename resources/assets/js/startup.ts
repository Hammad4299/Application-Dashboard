import TimeHelper from './Utility/time'
import global from './globals'
declare var $:any;

$(document).ready(function() {
    global.userInfo = $("#user-info").data();
    global.ajaxUrls = $("#ajax-urls").data();
    global.timeHelper = new TimeHelper();

    $(document).on('click','[data-click]',function () {
        $($(this).attr('data-click')).trigger('click');
    })

    $(document).on('change','[data-change-converted-time]',function () {
        global.timeHelper.setUserTimeToUtc($(this));
    })

    $('[data-convert-time]').each(function () {
        global.timeHelper.updateTimes($(this));
    })
});