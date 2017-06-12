import TimeHelper from './Utility/time'
import * as global from './globals'

$(document).ready(function() {
    global.userInfo = $("#user-info").data();
    global.ajaxUrls = $("#ajax-urls").data();
    global.timeHelper = new TimeHelper();


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
