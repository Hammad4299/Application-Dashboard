webpackJsonp([1],{16:function(t,e,n){"use strict";n(17)},17:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=n(5),i=n(0),r=n(18),o=n(4),s=new r.default,u=function(t,e){var n=t.getVisitScreens(),a=[],i={};n.map(function(t){var e=new r.FlattenedActionData;i[t.actionName]?e=i[t.actionName]:(e.actionName=t.actionName,e.duration=0,e.timestamp=t.timestamp,a.push(e),i[t.actionName]=e),console.log(t.duration),e.duration=e.duration+t.duration}),console.log(i),null!=c&&c.destroy(),c=e.find(".js-screens-table").DataTable({data:a,pageLength:10,searching:!1,lengthMenu:[[10,25,50,-1],[10,25,50,"All"]],columns:[{title:"Screen Name",data:"actionName"},{title:"Visited At",data:"timestampFormatted"},{title:"Duration",data:"durationFormatted"}]}),null!=l&&l.destroy(),l=e.find(".js-events-table").DataTable({data:t.getFlattenedEvents(),pageLength:50,searching:!1,lengthMenu:[[50,100,200,-1],[50,100,200,"All"]],columns:[{title:"Action Name",data:"actionName"},{title:"Timestamp",data:"timestampFormattedWithTime"},{title:"Value",data:"eventValue"}]})},c=null,l=null,f=null;$(document).on("click",".js-analytics-by-date",function(){var t=$(this).parent().find(".js-flatpickr"),e=t.val().split(" to ")[0],n=t.val().split(" to ")[1];if(""==e||""==n)return!1;var a=$("#myModal");s.getUserAnalyticDetail(f,e,n,function(t){u(t,a)})}),$(document).on("click",".js-analytics-detail",function(){var t=$(this),e=t.parents("tr").find("td").eq(3).text(),n=t.parents("tr").find("td").eq(0).text();f=$(this).attr("data-uid");var a=$("#myModal");a.find(".js-username").text(n),a.find(".js-email").text(e),a.find(".js-flatpickr")[0]._flatpickr.setDate([o().toDate(),o().add(-1,"month").toDate()],!0),a.find(".js-analytics-by-date").trigger("click"),$("#myModal").modal("show")}),$(document).on("click",".js-user-block,.js-user-unblock",function(){var t=i.default.ajaxUrls.moneymakerUserStateUrl,e=$(this);t=a.default.replaceUrlParams(t,e,"user-id");var n=e.data("state"),r=new FormData;r.append("state",n),$.siteAjax({url:t,method:"post",processData:!1,contentType:!1,data:r,success:function(t){"string"==typeof t&&(t=JSON.parse(t)),1==n?(e.html("Unblock"),e.data("state",2),e.removeClass("js-user-block btn-danger"),e.addClass("js-user-unblock btn-primary")):(e.html("Block"),e.data("state",1),e.removeClass("js-user-unblock btn-primary"),e.addClass("js-user-block btn-danger"))}})}),$(document).on("click",".js-user-delete",function(){var t=i.default.ajaxUrls.moneymakerUserDeleteUrl,e=$(this);t=a.default.replaceUrlParams(t,e,"user-id"),$.siteAjax({url:t,method:"delete",contentType:!1,success:function(t){"string"==typeof t&&(t=JSON.parse(t)),e.parents("tr").remove()}})})},18:function(t,e,n){"use strict";function a(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function i(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}function r(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}var o=function(){function t(t,e){for(var n=0;n<e.length;n++){var a=e[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}return function(e,n,a){return n&&t(e.prototype,n),a&&t(e,a),e}}();Object.defineProperty(e,"__esModule",{value:!0});var s=n(19),u=n(0),c=n(4),l=function(){function t(e){r(this,t),this.processResponse(e)}return o(t,[{key:"getVisitScreens",value:function(){return this.flattenedScreens}},{key:"getFlattenedEvents",value:function(){return this.flattenedEvents}}]),o(t,[{key:"processResponse",value:function(t){this.flattenedEvents=[];var e=this;this.flattenedScreens=[];var n={},a=[];t.map(function(t){var i=null;t.actionDetails.map(function(a){var r=new f;r.visitId=t.idVisit,r.visitIp=t.visitIp,r.visitorId=t.visitorId,r.type=a.type,r.timestamp=a.timestamp,r.idpageview=a.idpageview,"4"==r.type?(r.actionName=a.pageTitle,null!=i&&(i.duration=r.timestamp-i.timestamp,n[i.actionName]||(n[i.actionName]={count:0,duration:0}),n[i.actionName].duration+=i.duration,n[i.actionName].count++),i=r,e.flattenedScreens.push(r)):(r.actionName=a.eventName,r.actionPerformed=a.eventAction,r.eventValue=a.eventValue,r.eventCategory=a.eventCategory,e.flattenedEvents.push(r))}),null!=i&&a.push(i)}),a.map(function(t){n[t.actionName]&&(t.duration=Math.floor(n[t.actionName].duration/n[t.actionName].count),n[t.actionName].count++,n[t.actionName].duration+=t.duration)})}}]),t}();e.VisitsActivity=l;var f=function(){function t(){r(this,t)}return o(t,[{key:"eventValue",get:function(){return this._eventValue?this._eventValue:null},set:function(t){this._eventValue=t}},{key:"timestampFormatted",get:function(){return u.default.timeHelper.convertUtcToUserTime(this.timestamp.toString(),"X").format("YYYY-MM-DD")}},{key:"timestampFormattedWithTime",get:function(){return u.default.timeHelper.convertUtcToUserTime(this.timestamp.toString(),"X").format("YYYY-MM-DD hh:mm:ss a")}},{key:"durationFormatted",get:function(){return c.duration(this.duration,"s").humanize()}}]),t}();e.FlattenedActionData=f;var d=function(t){function e(){r(this,e);var t=a(this,(e.__proto__||Object.getPrototypeOf(e)).call(this));return t.userIdToVisitorMap={},t}return i(e,t),o(e,[{key:"getVisitor",value:function(t,e){if(this.userIdToVisitorMap[t])e(this.userIdToVisitorMap[t]);else{var n=this,a=new s.UserIdRequest(this.config),i=new s.Segment;i.and("userId","==",t),a.setSegment(i),this.executeRequest(a,function(a){a.length>0&&(n.userIdToVisitorMap[t]=a[0]),e(n.userIdToVisitorMap[t])})}}},{key:"getUserAnalyticDetail",value:function(t,e,n,a){var i=new s.LastVisitsDetailRequest(this.config),r=new s.Segment;r.and("userId","==",t),i.setSegment(r),i.setDateRange(e,n),this.executeRequest(i,function(t){a(new l(t))})}}],[{key:"getVisitorId",value:function(t){return t?t.idvisitor:null}}]),e}(s.PiwikHelper);e.default=d},19:function(t,e,n){"use strict";function a(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e}function i(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)}function r(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}var o=function(){function t(t,e){for(var n=0;n<e.length;n++){var a=e[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}return function(e,n,a){return n&&t(e.prototype,n),a&&t(e,a),e}}();Object.defineProperty(e,"__esModule",{value:!0});var s,u=n(0),c=n(3);!function(t){t.Range="range",t.Year="year",t.Month="month",t.Week="week",t.Day="day"}(s=e.DatePeriod||(e.DatePeriod={}));var l=function(){function t(){r(this,t),this.data=[]}return o(t,[{key:"and",value:function(t,e,n){this.data.push({name:t,operator:e,condition:";",value:n})}},{key:"or",value:function(t,e,n){this.data.push({name:t,operator:e,condition:",",value:n})}},{key:"build",value:function(){var t=!0,e="";return this.data.map(function(n){t||(e+=n.condition),e+=""+n.name+n.operator+n.value,t=!1}),e}}]),t}();e.Segment=l;var f=function(){function t(){r(this,t),this.siteId=$("#piwik-info").attr("data-site-id"),this.authToken=$("#piwik-info").attr("data-auth-token"),this.baseUrl=$("#piwik-info").attr("data-base-url"),this.timeOffset=0}return o(t,[{key:"getBaseUrl",value:function(){return this.baseUrl}},{key:"getAuthToken",value:function(){return this.authToken}},{key:"getTimeOffset",value:function(){return this.timeOffset}},{key:"getSiteId",value:function(){return this.siteId}}]),t}();e.PiwikConfig=f;var d=function(){function t(e,n){if(r(this,t),this.config=e,this.data={},this.setDate(u.default.timeHelper.userTime().format("YYYY-MM-DD"),s.Year),n)for(var a in n)n.hasOwnProperty(a)&&(this.data[a]=n[a])}return o(t,[{key:"setSegment",value:function(t){this.data.segment=t.build()}},{key:"setDateRange",value:function(t,e){this.data.period=s.Range;var n=u.default.timeHelper.getUserUtcOffset(),a=c.default.convertTimeToDifferentZone(t+" 00:00:00","YYYY-MM-DD HH:mm:ss",n,this.config.getTimeOffset()),i=c.default.convertTimeToDifferentZone(e+" 23:59:59","YYYY-MM-DD HH:mm:ss",n,this.config.getTimeOffset());this.data.date=a.format("YYYY-MM-DD")+","+i.format("YYYY-MM-DD")}},{key:"setDate",value:function(t,e){this.data.period=e;var n=u.default.timeHelper.getUserUtcOffset();this.data.date=c.default.convertTimeToDifferentZone(t+" 12:00:00","YYYY-MM-DD HH:mm:ss",n,this.config.getTimeOffset()).format("YYYY-MM-DD")}}]),o(t,[{key:"getData",value:function(){return this.data}}]),t}();e.ReportingRequest=d;var m=function(t){function e(){return r(this,e),a(this,(e.__proto__||Object.getPrototypeOf(e)).apply(this,arguments))}return i(e,t),o(e,[{key:"getMethodName",value:function(){return"UserId.getUsers"}}]),e}(d);e.UserIdRequest=m;var p=function(t){function e(){return r(this,e),a(this,(e.__proto__||Object.getPrototypeOf(e)).apply(this,arguments))}return i(e,t),o(e,[{key:"setVisitorId",value:function(t){this.data.visitorId=t}},{key:"getMethodName",value:function(){return"Live.getVisitorProfile"}}]),e}(d);e.VisitorProfileRequest=p;var h=function(t){function e(){return r(this,e),a(this,(e.__proto__||Object.getPrototypeOf(e)).apply(this,arguments))}return i(e,t),o(e,[{key:"getMethodName",value:function(){return"Live.getLastVisitsDetails"}}]),e}(d);e.LastVisitsDetailRequest=h;var v=function(){function t(){r(this,t),this.config=new f}return o(t,[{key:"executeRequest",value:function(t,e){var n=t.getData();n.method=t.getMethodName(),n.module="API",n.idSite=this.config.getSiteId(),n.token_auth=this.config.getAuthToken(),n.format="json",$.ajax({type:"get",data:n,url:this.config.getBaseUrl(),success:function(t){e(t)}})}}]),t}();e.PiwikHelper=v}},[16]);