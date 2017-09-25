import {default as moneymaker} from './common';
import global from "../../globals";
import MoneyMakerPiwikHelper, {VisitsActivity} from "./Piwik/MoneyMakerPiwikHelper";

declare var $:any;

let piwikHelper = new MoneyMakerPiwikHelper();

$(document).on('click','.js-analytics-detail',function () {
    piwikHelper.getUserAnalyticDetail($(this).attr('data-uid'),null,null,function (data:VisitsActivity) {
        console.log(data.getVisitData());
    });
});

$(document).on('click','.js-user-block,.js-user-unblock',function(){
    let url = global.ajaxUrls.moneymakerUserStateUrl;
    let button = $(this);
    url = moneymaker.replaceUrlParams(url,button,'user-id');
    let state=button.data('state');

    let fD=new FormData();
    fD.append('state',state);

    $.siteAjax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        data: fD,
        success: function (data:any) {
            if ((typeof data) == 'string')
                data = JSON.parse(data);

            if(state==1) {
                button.html('Unblock');
                button.data('state', 2);
                button.removeClass('js-user-block btn-danger');
                button.addClass('js-user-unblock btn-primary');
            }
            else
            {
                button.html('Block');
                button.data('state', 1);
                button.removeClass('js-user-unblock btn-primary');
                button.addClass('js-user-block btn-danger');
            }
        },
    });
});

$(document).on('click','.js-user-delete',function(){
    let url = global.ajaxUrls.moneymakerUserDeleteUrl;
    let button = $(this);

    url =moneymaker.replaceUrlParams(url,button,'user-id');
    $.siteAjax({
        url: url,
        method: 'delete',
        contentType: false,
        success: function (data:any) {
            if ((typeof data) == 'string')
                data = JSON.parse(data);

            button.parents('tr').remove();
        },
    });
});