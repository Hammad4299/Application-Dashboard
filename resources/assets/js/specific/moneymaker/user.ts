import {default as moneymaker} from './common';
import global from "../../globals";
import MoneyMakerPiwikHelper, {VisitsActivity, FlattenedActionData} from "./Piwik/MoneyMakerPiwikHelper";
import TimeHelper from "../../Utility/time";
declare var $:any;

var uid:any;
var email:any;
var username:any;

let piwikHelper = new MoneyMakerPiwikHelper();

$(document).on('click','.js-analytics-by-date',function () {
    let startdate = $(this).parent().find('.date').val().split(' to ')[0];
    let enddate = $(this).parent().find('.date').val().split(' to ')[1];
    if(startdate == "" || enddate == ""){
        return false;
    }
    global.timeHelper = new TimeHelper();

    console.log(startdate);
    console.log(enddate);

    piwikHelper.getUserAnalyticDetail(uid,startdate,enddate, (data:VisitsActivity) => {
        console.log(email);
        console.log(username);

        console.log(data.getFlattenedEvents());
        console.log(data.getVisitScreens());

        var screenDataSet:any = [];
        var eventDataSet:any = [];
        var flattendEvents = data.getFlattenedEvents();
        var visitedScreens = data.getVisitScreens();
        let arr:any = [];
        let map:any = {};
        visitedScreens.map((screen:FlattenedActionData)=>{
            let toIns = ['', '', '0'];
            if(map[screen.actionName]){
                toIns = map[screen.actionName];
            }else{
                arr.push(toIns);
            }
            toIns[0] = screen.actionName;
            toIns[1] = global.timeHelper.convertUtcToUserTime(screen.timestamp.toString(),"X").format('YYYY-MM-DD').toString();
            toIns[2] = (parseInt(toIns[2])+screen.duration).toString();
            map[screen.actionName] = toIns;
        });

        for(var i=0; i < flattendEvents.length; i++){
            eventDataSet.push([
                (flattendEvents[i].actionName != undefined)?flattendEvents[i].actionName: " ",
                (flattendEvents[i].actionPerformed != undefined)?flattendEvents[i].actionPerformed: " ",
                (flattendEvents[i].eventCategory != undefined)?flattendEvents[i].eventCategory: " ",
                (flattendEvents[i].timestamp != undefined)? global.timeHelper.convertUtcToUserTime(flattendEvents[i].timestamp,"X").format('YYYY-MM-DD'): " "
            ]);
        }

        // for(var i=0; i < visitedScreens.length; i++){
        //     screenDataSet.push([
        //         (visitedScreens[i].actionName != undefined)? visitedScreens[i].actionName: " ",
        //         (visitedScreens[i].timestamp  != undefined)? global.timeHelper.convertUtcToUserTime(visitedScreens[i].timestamp,"X").format('YYYY-MM-DD'): " ",
        //         (visitedScreens[i].duration != undefined)? visitedScreens[i].duration: " "
        //     ]);
        // }

        $('#screens').find('table').remove();
        $('#screens').find('.dataTables_wrapper').remove();
        $('#screens').find('.username').text(username);
        $('#screens').find('.email').text(email);
        $('#screens').append('<table class="display" style="width: 100%"></table>').find('table').DataTable( {
            data: arr,
            pageLength: 5,
            searching: false,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            columns: [
                { title: "Screen Name" },
                { title: "Visited At" },
                { title: "Duration" }
            ]
        } );

        $('#events').find('table').remove();
        $('#events').find('.dataTables_wrapper').remove();
        $('#events').find('.username').text(username);
        $('#events').find('.email').text(email);
        $('#events').append('<table class="display" style="width: 100%"></table>').find('table').DataTable( {
            data: eventDataSet,
            pageLength: 5,
            searching: false,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            columns: [
                { title: "Action Name" },
                { title: "Action Performed" },
                { title: "Event Category" },
                { title: "Timestamp" }
            ]
        } );
    });
});

$(document).on('click','.js-analytics-detail',function () {
    let elem:any = $(this);
    email = elem.parents('tr').find('td').eq(3).text();
    username = elem.parents('tr').find('td').eq(0).text();
    uid = $(this).attr('data-uid');
    piwikHelper.getUserAnalyticDetail(uid,null,null, (data:VisitsActivity) => {
        console.log(email);
        console.log(username);

        console.log(data.getFlattenedEvents());
        console.log(data.getVisitScreens());

        var screenDataSet:any = [];
        var eventDataSet:any = [];
        var eventsObject:any = {};
        var screensObject:any = {};
        var flattendEvents = data.getFlattenedEvents();
        var visitedScreens = data.getVisitScreens();
        let arr:any = [];
        let map:any = {};
        visitedScreens.map((screen:FlattenedActionData)=>{
            let toIns = ['', '', '0'];
            if(map[screen.actionName]){
                toIns = map[screen.actionName];
            }else{
                arr.push(toIns);
            }
            toIns[0] = screen.actionName;
            toIns[1] = global.timeHelper.convertUtcToUserTime(screen.timestamp.toString(),"X").format('YYYY-MM-DD').toString();
            toIns[2] = (parseInt(toIns[2])+screen.duration).toString();
            map[screen.actionName] = toIns;
        });


        for(var i=0; i < flattendEvents.length; i++){
            eventDataSet.push([
                (flattendEvents[i].actionName != undefined)?flattendEvents[i].actionName: " ",
                (flattendEvents[i].actionPerformed != undefined)?flattendEvents[i].actionPerformed: " ",
                (flattendEvents[i].eventCategory != undefined)?flattendEvents[i].eventCategory: " ",
                (flattendEvents[i].timestamp != undefined)? global.timeHelper.convertUtcToUserTime(flattendEvents[i].timestamp,"X").format('YYYY-MM-DD'): " "
            ]);
            eventsObject[flattendEvents[i].actionName] = {};
        }
        //
        // for(var i=0; i < visitedScreens.length; i++){
        //     screenDataSet.push([
        //         (visitedScreens[i].actionName != undefined)? visitedScreens[i].actionName: " ",
        //         (visitedScreens[i].timestamp  != undefined)? global.timeHelper.convertUtcToUserTime(visitedScreens[i].timestamp,"X").format('YYYY-MM-DD'): " ",
        //         (visitedScreens[i].duration != undefined)? visitedScreens[i].duration: " "
        //     ]);
        // }

        $('#screens').find('table').remove();
        $('#screens').find('.dataTables_wrapper').remove();
        $('#screens').find('.username').text(username);
        $('#screens').find('.email').text(email);
        $('#screens').append('<table class="display" style="width: 100%"></table>').find('table').DataTable( {
            data: arr,
            pageLength: 5,
            searching: false,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            columns: [
                { title: "Screen Name" },
                { title: "Visited At" },
                { title: "Duration" }
            ]
        } );

        $('#events').find('table').remove();
        $('#events').find('.dataTables_wrapper').remove();
        $('#events').find('.username').text(username);
        $('#events').find('.email').text(email);
        $('#events').append('<table class="display" style="width: 100%"></table>').find('table').DataTable( {
            data: eventDataSet,
            pageLength: 5,
            searching: false,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            columns: [
                { title: "Action Name" },
                { title: "Action Performed" },
                { title: "Event Category" },
                { title: "Timestamp" }
            ]
        } );

        $('#myModal').modal('show')
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