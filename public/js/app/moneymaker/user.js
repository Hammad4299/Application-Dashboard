webpackJsonp([1],{

/***/ 16:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(17);

/***/ }),

/***/ 17:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var common_1 = __webpack_require__(5);
var globals_1 = __webpack_require__(0);
var MoneyMakerPiwikHelper_1 = __webpack_require__(18);
var moment = __webpack_require__(4);
var piwikHelper = new MoneyMakerPiwikHelper_1.default();
{
    var loadDataInDatatable = function loadDataInDatatable(data, container) {
        var visitedScreens = data.getVisitScreens();
        var screensData = [];
        var map = {};
        visitedScreens.map(function (screen) {
            var toIns = new MoneyMakerPiwikHelper_1.FlattenedActionData();
            if (map[screen.actionName]) {
                toIns = map[screen.actionName];
            } else {
                toIns.actionName = screen.actionName;
                toIns.duration = 0;
                toIns.timestamp = screen.timestamp;
                screensData.push(toIns);
                map[screen.actionName] = toIns;
            }
            //console.log(screen.actionName);
            console.log(screen.duration);
            //console.log(toIns.duration);
            toIns.duration = toIns.duration + screen.duration;
        });
        console.log(map);
        if (screensTable != null) {
            screensTable.destroy();
        }
        screensTable = container.find('.js-screens-table').DataTable({
            data: screensData,
            pageLength: 10,
            searching: false,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            columns: [{ title: "Screen Name", data: "actionName" }, { title: "Visited At", data: "timestampFormatted" }, { title: "Duration", data: "durationFormatted" }]
        });
        if (eventsTable != null) {
            eventsTable.destroy();
        }
        eventsTable = container.find('.js-events-table').DataTable({
            data: data.getFlattenedEvents(),
            pageLength: 50,
            searching: false,
            lengthMenu: [[50, 100, 200, -1], [50, 100, 200, "All"]],
            columns: [{ title: "Action Name", data: "actionName" }, { title: "Action Performed", data: "actionPerformed" }, { title: "Timestamp", data: "timestampFormattedWithTime" }, { title: "Value", data: "eventValue" }]
        });
    };

    var screensTable = null;
    var eventsTable = null;
    var uid = null;

    $(document).on('click', '.js-analytics-by-date', function () {
        var dateElem = $(this).parent().find('.js-flatpickr');
        var startdate = dateElem.val().split(' to ')[0];
        var enddate = dateElem.val().split(' to ')[1];
        if (startdate == "" || enddate == "") {
            return false;
        }
        var modal = $('#myModal');
        piwikHelper.getUserAnalyticDetail(uid, startdate, enddate, function (data) {
            loadDataInDatatable(data, modal);
        });
    });
    $(document).on('click', '.js-analytics-detail', function () {
        var elem = $(this);
        var email = elem.parents('tr').find('td').eq(3).text();
        var username = elem.parents('tr').find('td').eq(0).text();
        uid = $(this).attr('data-uid');
        var modal = $('#myModal');
        modal.find('.js-username').text(username);
        modal.find('.js-email').text(email);
        var flatPickr = modal.find('.js-flatpickr')[0]._flatpickr;
        flatPickr.setDate([moment().toDate(), moment().add(-1, 'month').toDate()], true);
        modal.find('.js-analytics-by-date').trigger('click');
        $('#myModal').modal('show');
    });
}
$(document).on('click', '.js-user-block,.js-user-unblock', function () {
    var url = globals_1.default.ajaxUrls.moneymakerUserStateUrl;
    var button = $(this);
    url = common_1.default.replaceUrlParams(url, button, 'user-id');
    var state = button.data('state');
    var fD = new FormData();
    fD.append('state', state);
    $.siteAjax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        data: fD,
        success: function success(data) {
            if (typeof data == 'string') data = JSON.parse(data);
            if (state == 1) {
                button.html('Unblock');
                button.data('state', 2);
                button.removeClass('js-user-block btn-danger');
                button.addClass('js-user-unblock btn-primary');
            } else {
                button.html('Block');
                button.data('state', 1);
                button.removeClass('js-user-unblock btn-primary');
                button.addClass('js-user-block btn-danger');
            }
        }
    });
});
$(document).on('click', '.js-user-delete', function () {
    var url = globals_1.default.ajaxUrls.moneymakerUserDeleteUrl;
    var button = $(this);
    url = common_1.default.replaceUrlParams(url, button, 'user-id');
    $.siteAjax({
        url: url,
        method: 'delete',
        contentType: false,
        success: function success(data) {
            if (typeof data == 'string') data = JSON.parse(data);
            button.parents('tr').remove();
        }
    });
});

/***/ }),

/***/ 18:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });
var ReportingApiHelper_1 = __webpack_require__(19);
var globals_1 = __webpack_require__(0);
var moment = __webpack_require__(4);
/**
 * Created by talha on 9/25/2017.
 */

var VisitsActivity = function () {
    _createClass(VisitsActivity, [{
        key: "getVisitScreens",
        value: function getVisitScreens() {
            return this.flattenedScreens;
        }
    }, {
        key: "getFlattenedEvents",
        value: function getFlattenedEvents() {
            return this.flattenedEvents;
        }
    }]);

    function VisitsActivity(visits) {
        _classCallCheck(this, VisitsActivity);

        this.processResponse(visits);
    }

    _createClass(VisitsActivity, [{
        key: "processResponse",
        value: function processResponse(visits) {
            this.flattenedEvents = [];
            var self = this;
            this.flattenedScreens = [];
            var timeOnScreens = {};
            var remainingScreensApproxAvg = [];
            visits.map(function (visit) {
                var pre = null;
                visit.actionDetails.map(function (action) {
                    var toIns = new FlattenedActionData();
                    toIns.visitId = visit.idVisit;
                    toIns.visitIp = visit.visitIp;
                    toIns.visitorId = visit.visitorId;
                    toIns.type = action.type;
                    toIns.timestamp = action.timestamp;
                    toIns.idpageview = action.idpageview;
                    if (toIns.type == '4') {
                        toIns.actionName = action.pageTitle;
                        if (pre != null) {
                            pre.duration = toIns.timestamp - pre.timestamp;
                            if (!timeOnScreens[pre.actionName]) {
                                timeOnScreens[pre.actionName] = { count: 0, duration: 0 };
                            }
                            timeOnScreens[pre.actionName].duration += pre.duration;
                            timeOnScreens[pre.actionName].count++;
                        }
                        pre = toIns;
                        self.flattenedScreens.push(toIns);
                    } else {
                        toIns.actionName = action.eventName;
                        toIns.actionPerformed = action.eventAction;
                        toIns.eventValue = action.eventValue;
                        toIns.eventCategory = action.eventCategory;
                        self.flattenedEvents.push(toIns);
                    }
                });
                if (pre != null) remainingScreensApproxAvg.push(pre);
            });
            remainingScreensApproxAvg.map(function (d) {
                if (timeOnScreens[d.actionName]) {
                    d.duration = Math.floor(timeOnScreens[d.actionName].duration / timeOnScreens[d.actionName].count);
                    timeOnScreens[d.actionName].count++;
                    timeOnScreens[d.actionName].duration += d.duration;
                }
            });
        }
    }]);

    return VisitsActivity;
}();

exports.VisitsActivity = VisitsActivity;

var FlattenedActionData = function () {
    function FlattenedActionData() {
        _classCallCheck(this, FlattenedActionData);
    }

    _createClass(FlattenedActionData, [{
        key: "eventValue",
        get: function get() {
            return this._eventValue ? this._eventValue : null;
        },
        set: function set(value) {
            this._eventValue = value;
        }
    }, {
        key: "timestampFormatted",
        get: function get() {
            return globals_1.default.timeHelper.convertUtcToUserTime(this.timestamp.toString(), 'X').format('YYYY-MM-DD');
        }
    }, {
        key: "timestampFormattedWithTime",
        get: function get() {
            return globals_1.default.timeHelper.convertUtcToUserTime(this.timestamp.toString(), 'X').format('YYYY-MM-DD hh:mm:ss a');
        }
    }, {
        key: "durationFormatted",
        get: function get() {
            return moment.duration(this.duration, 's').humanize();
        }
    }]);

    return FlattenedActionData;
}();

exports.FlattenedActionData = FlattenedActionData;

var MoneyMakerPiwikHelper = function (_ReportingApiHelper_) {
    _inherits(MoneyMakerPiwikHelper, _ReportingApiHelper_);

    function MoneyMakerPiwikHelper() {
        _classCallCheck(this, MoneyMakerPiwikHelper);

        var _this = _possibleConstructorReturn(this, (MoneyMakerPiwikHelper.__proto__ || Object.getPrototypeOf(MoneyMakerPiwikHelper)).call(this));

        _this.userIdToVisitorMap = {};
        return _this;
    }

    _createClass(MoneyMakerPiwikHelper, [{
        key: "getVisitor",
        value: function getVisitor(userId, callback) {
            if (this.userIdToVisitorMap[userId]) {
                callback(this.userIdToVisitorMap[userId]);
            } else {
                var self = this;
                var r = new ReportingApiHelper_1.UserIdRequest(this.config);
                var segment = new ReportingApiHelper_1.Segment();
                segment.and('userId', '==', userId);
                r.setSegment(segment);
                this.executeRequest(r, function (d) {
                    if (d.length > 0) self.userIdToVisitorMap[userId] = d[0];
                    callback(self.userIdToVisitorMap[userId]);
                });
            }
        }
    }, {
        key: "getUserAnalyticDetail",
        value: function getUserAnalyticDetail(userId, startDate, endDate, callback) {
            var r = new ReportingApiHelper_1.LastVisitsDetailRequest(this.config);
            var s = new ReportingApiHelper_1.Segment();
            s.and('userId', '==', userId);
            r.setSegment(s);
            r.setDateRange(startDate, endDate);
            this.executeRequest(r, function (d) {
                callback(new VisitsActivity(d));
            });
        }
    }], [{
        key: "getVisitorId",
        value: function getVisitorId(visitor) {
            if (visitor) return visitor.idvisitor;
            return null;
        }
    }]);

    return MoneyMakerPiwikHelper;
}(ReportingApiHelper_1.PiwikHelper);

exports.default = MoneyMakerPiwikHelper;

/***/ }),

/***/ 19:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });
var globals_1 = __webpack_require__(0);
var time_1 = __webpack_require__(3);
var DatePeriod;
(function (DatePeriod) {
    DatePeriod["Range"] = "range";
    DatePeriod["Year"] = "year";
    DatePeriod["Month"] = "month";
    DatePeriod["Week"] = "week";
    DatePeriod["Day"] = "day";
})(DatePeriod = exports.DatePeriod || (exports.DatePeriod = {}));

var Segment = function () {
    function Segment() {
        _classCallCheck(this, Segment);

        this.data = [];
    }

    _createClass(Segment, [{
        key: "and",
        value: function and(name, operator, value) {
            this.data.push({
                name: name,
                operator: operator,
                condition: ';',
                value: value
            });
        }
    }, {
        key: "or",
        value: function or(name, operator, value) {
            this.data.push({
                name: name,
                operator: operator,
                condition: ',',
                value: value
            });
        }
    }, {
        key: "build",
        value: function build() {
            var first = true;
            var str = '';
            this.data.map(function (part) {
                if (!first) str += part.condition;
                str += "" + part.name + part.operator + part.value;
                first = false;
            });
            return str;
        }
    }]);

    return Segment;
}();

exports.Segment = Segment;

var PiwikConfig = function () {
    function PiwikConfig() {
        _classCallCheck(this, PiwikConfig);

        this.siteId = $('#piwik-info').attr('data-site-id');
        this.authToken = $('#piwik-info').attr('data-auth-token');
        this.baseUrl = $('#piwik-info').attr('data-base-url');
        this.timeOffset = 0;
    }

    _createClass(PiwikConfig, [{
        key: "getBaseUrl",
        value: function getBaseUrl() {
            return this.baseUrl;
        }
    }, {
        key: "getAuthToken",
        value: function getAuthToken() {
            return this.authToken;
        }
    }, {
        key: "getTimeOffset",
        value: function getTimeOffset() {
            return this.timeOffset;
        }
    }, {
        key: "getSiteId",
        value: function getSiteId() {
            return this.siteId;
        }
    }]);

    return PiwikConfig;
}();

exports.PiwikConfig = PiwikConfig;

var ReportingRequest = function () {
    _createClass(ReportingRequest, [{
        key: "setSegment",
        value: function setSegment(s) {
            this.data.segment = s.build();
        }
    }, {
        key: "setDateRange",
        value: function setDateRange(userStartDate, userEndDate) {
            this.data.period = DatePeriod.Range;
            var userOffset = globals_1.default.timeHelper.getUserUtcOffset();
            var start = time_1.default.convertTimeToDifferentZone(userStartDate + ' 00:00:00', 'YYYY-MM-DD HH:mm:ss', userOffset, this.config.getTimeOffset());
            var end = time_1.default.convertTimeToDifferentZone(userEndDate + ' 23:59:59', 'YYYY-MM-DD HH:mm:ss', userOffset, this.config.getTimeOffset());
            this.data.date = start.format('YYYY-MM-DD') + "," + end.format('YYYY-MM-DD');
        }
    }, {
        key: "setDate",
        value: function setDate(date, period) {
            this.data.period = period;
            var userOffset = globals_1.default.timeHelper.getUserUtcOffset();
            this.data.date = time_1.default.convertTimeToDifferentZone(date + ' 12:00:00', 'YYYY-MM-DD HH:mm:ss', userOffset, this.config.getTimeOffset()).format('YYYY-MM-DD');
        }
    }]);

    function ReportingRequest(config, data) {
        _classCallCheck(this, ReportingRequest);

        this.config = config;
        this.data = {};
        this.setDate(globals_1.default.timeHelper.userTime().format('YYYY-MM-DD'), DatePeriod.Year);
        if (data) {
            for (var i in data) {
                if (data.hasOwnProperty(i)) this.data[i] = data[i];
            }
        }
    }

    _createClass(ReportingRequest, [{
        key: "getData",
        value: function getData() {
            return this.data;
        }
    }]);

    return ReportingRequest;
}();

exports.ReportingRequest = ReportingRequest;

var UserIdRequest = function (_ReportingRequest) {
    _inherits(UserIdRequest, _ReportingRequest);

    function UserIdRequest() {
        _classCallCheck(this, UserIdRequest);

        return _possibleConstructorReturn(this, (UserIdRequest.__proto__ || Object.getPrototypeOf(UserIdRequest)).apply(this, arguments));
    }

    _createClass(UserIdRequest, [{
        key: "getMethodName",
        value: function getMethodName() {
            return 'UserId.getUsers';
        }
    }]);

    return UserIdRequest;
}(ReportingRequest);

exports.UserIdRequest = UserIdRequest;

var VisitorProfileRequest = function (_ReportingRequest2) {
    _inherits(VisitorProfileRequest, _ReportingRequest2);

    function VisitorProfileRequest() {
        _classCallCheck(this, VisitorProfileRequest);

        return _possibleConstructorReturn(this, (VisitorProfileRequest.__proto__ || Object.getPrototypeOf(VisitorProfileRequest)).apply(this, arguments));
    }

    _createClass(VisitorProfileRequest, [{
        key: "setVisitorId",
        value: function setVisitorId(id) {
            this.data.visitorId = id;
        }
    }, {
        key: "getMethodName",
        value: function getMethodName() {
            return 'Live.getVisitorProfile';
        }
    }]);

    return VisitorProfileRequest;
}(ReportingRequest);

exports.VisitorProfileRequest = VisitorProfileRequest;

var LastVisitsDetailRequest = function (_ReportingRequest3) {
    _inherits(LastVisitsDetailRequest, _ReportingRequest3);

    function LastVisitsDetailRequest() {
        _classCallCheck(this, LastVisitsDetailRequest);

        return _possibleConstructorReturn(this, (LastVisitsDetailRequest.__proto__ || Object.getPrototypeOf(LastVisitsDetailRequest)).apply(this, arguments));
    }

    _createClass(LastVisitsDetailRequest, [{
        key: "getMethodName",
        value: function getMethodName() {
            return 'Live.getLastVisitsDetails';
        }
    }]);

    return LastVisitsDetailRequest;
}(ReportingRequest);

exports.LastVisitsDetailRequest = LastVisitsDetailRequest;

var PiwikHelper = function () {
    function PiwikHelper() {
        _classCallCheck(this, PiwikHelper);

        this.config = new PiwikConfig();
    }

    _createClass(PiwikHelper, [{
        key: "executeRequest",
        value: function executeRequest(request, callback) {
            var d = request.getData();
            d.method = request.getMethodName();
            d.module = 'API';
            d.idSite = this.config.getSiteId();
            d.token_auth = this.config.getAuthToken();
            d.format = 'json';
            $.ajax({
                type: 'get',
                data: d,
                url: this.config.getBaseUrl(),
                success: function success(da) {
                    callback(da);
                }
            });
        }
    }]);

    return PiwikHelper;
}();

exports.PiwikHelper = PiwikHelper;

/***/ })

},[16]);
//# sourceMappingURL=user.js.map