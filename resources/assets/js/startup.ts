import TimeHelper from './Utility/time'
import global from './globals'
declare var flatpickr:any;

$(document).ready(function() {
    global.userInfo = $("#user-info").data();
    global.ajaxUrls = $("#ajax-urls").data();
    global.timeHelper = new TimeHelper();

    $(".js-flatpickr").each(function () {
        // debugger
        const se = $(this);
        const enableTime = ( $(this).attr('data-enableTime') != undefined)? $(this).attr('data-enableTime') : true;
        const noCalendar = ( $(this).attr('data-noCalendar') != undefined)? $(this).attr('data-noCalendar'): false;
        const altFormat = ( $(this).attr('data-altFormat') != undefined)? $(this).attr('data-altFormat'): "Y-m-d h:i K";
        const dateFormat = ( $(this).attr('data-dateFormat') != undefined)? $(this).attr('data-dateFormat'): "U";
        const mode = ( $(this).attr('data-mode') != undefined)? $(this).attr('data-mode'): "";

        const s = flatpickr(this, {
            enableTime: enableTime,
            noCalendar: noCalendar,
            altInput: true,
            altFormat: altFormat,
            mode:   mode,
            dateFormat: dateFormat
        });
    });

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