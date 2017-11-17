import {default as moneymaker} from './common';
import global from "../../globals";
import MoneyMakerPiwikHelper, {VisitsActivity, FlattenedActionData} from "./Piwik/MoneyMakerPiwikHelper";
import DataTable = DataTables.Api;
declare var flatpickr:any;
import moment = require("moment");
declare var window:any;

let piwikHelper = new MoneyMakerPiwikHelper();

{
    let screensTable:DataTable = null;
    let eventsTable:DataTable = null;
    let uid:any = null;
    function loadDataInDatatable(data:VisitsActivity,container:JQuery):void{
        const visitedScreens = data.getVisitScreens();
        let screensData:FlattenedActionData[] = [];
        let map:any = {};

        visitedScreens.map((screen:FlattenedActionData)=>{
            let toIns = new FlattenedActionData();
            if(map[screen.actionName]){
                toIns = map[screen.actionName];
            }else{
                toIns.actionName = screen.actionName;
                toIns.duration = 0;
                toIns.timestamp = screen.timestamp;
                screensData.push(toIns);
                map[screen.actionName] = toIns;
            }

            //console.log(screen.actionName);
            console.log(screen.duration);
            //console.log(toIns.duration);
            toIns.duration = toIns.duration+screen.duration;
        });

        console.log(map);


        if(screensTable!=null){
            screensTable.destroy();
        }
        screensTable = container.find('.js-screens-table').DataTable( {
            data: screensData,
            pageLength: 10,
            searching: false,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            columns: [
                { title: "Screen Name", data: "actionName" },
                { title: "Visited At", data: "timestampFormatted" },
                { title: "Duration", data: "durationFormatted" }
            ]
        } );


        if(eventsTable!=null){
            eventsTable.destroy();
        }

        eventsTable = container.find('.js-events-table').DataTable( {
            data: data.getFlattenedEvents(),
            pageLength: 50,
            searching: false,
            lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "All"]],
            columns: [
                { title: "Action Name", data: "actionName" },
                { title: "Timestamp",data: "timestampFormattedWithTime" },
                { title: "Value",data: "eventValue" },
            ]
        } );
    }

    $(document).on('click','.js-analytics-by-date',function () {
        let dateElem = $(this).parent().find('.js-flatpickr');
        let startdate = (<string>dateElem.val()).split(' to ')[0];
        let enddate = (<string>dateElem.val()).split(' to ')[1];
        if(startdate == "" || enddate == ""){
            return false;
        }
        const modal = $('#myModal');
        piwikHelper.getUserAnalyticDetail(uid,startdate,enddate, (data:VisitsActivity) => {
            loadDataInDatatable(data,modal);
        });
    });

    $(document).on('click','.js-analytics-detail',function () {
        let elem:any = $(this);
        let email = elem.parents('tr').find('td').eq(3).text();
        let username = elem.parents('tr').find('td').eq(0).text();
        uid = $(this).attr('data-uid');
        const modal = $('#myModal');
        modal.find('.js-username').text(username);
        modal.find('.js-email').text(email);

        let flatPickr:any = (<any>modal.find('.js-flatpickr')[0])._flatpickr;
        flatPickr.setDate([
            moment().toDate(),moment().add(-1,'month').toDate()
        ],true);
        modal.find('.js-analytics-by-date').trigger('click');
        $('#myModal').modal('show');
    });
}


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