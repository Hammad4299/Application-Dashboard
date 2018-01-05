webpackJsonp([0],[
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });

var Globals = function Globals() {
    _classCallCheck(this, Globals);

    this.timeHelper = null;
};

var global = new Globals();
exports.default = global;

/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = moment;

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });
var moment = __webpack_require__(1);

var TimeHelper = function () {
    function TimeHelper(userTimezone) {
        _classCallCheck(this, TimeHelper);

        this.setTimezone(userTimezone);
        this.dateTimeFormat = 'YYYY-MM-DD hh:mm a';
    }

    _createClass(TimeHelper, [{
        key: "setTimezone",
        value: function setTimezone(userTimezone) {
            this.userTimezone = userTimezone;
        }
    }, {
        key: "getUserUtcOffset",
        value: function getUserUtcOffset() {
            var baseOffset = moment().utcOffset();
            if (this.userTimezone) {
                baseOffset = parseInt(this.userTimezone) * 60;
            }
            return baseOffset;
        }
    }, {
        key: "convertUtcToUserTime",
        value: function convertUtcToUserTime(utcdateTime, parseFormat) {
            return moment.utc(utcdateTime, parseFormat).utcOffset(this.getUserUtcOffset());
        }
    }, {
        key: "timestampToLocal",
        value: function timestampToLocal(timestamp) {
            return this.convertUtcToUserTime("" + timestamp, 'X').format(this.dateTimeFormat);
        }
    }, {
        key: "userTime",
        value: function userTime() {
            return moment.utc().utcOffset(this.getUserUtcOffset());
        }
    }, {
        key: "convertLocalToUtc",
        value: function convertLocalToUtc(localdateTime, parseFormat) {
            var localdateTime1 = moment(localdateTime, parseFormat);
            return TimeHelper.convertTimeToDifferentZone(localdateTime, parseFormat, localdateTime1.utcOffset(), this.getUserUtcOffset()).utcOffset(0);
        }
        /**
         * Jquery dependant
         */

    }, {
        key: "updateTimes",

        /**
         * Jquery dependant
         */
        value: function updateTimes(container) {
            var self = this;
            container.closest('[data-convert-time]').each(function () {
                var elem = $(this);
                var utcTime = elem.attr('data-convert-time');
                var timeToSet = null;
                if (utcTime.toLowerCase() === 'now') {
                    timeToSet = self.userTime();
                } else if (utcTime.toLowerCase() === 'utcnow') {
                    timeToSet = TimeHelper.utcTime();
                } else {
                    timeToSet = self.convertUtcToUserTime(utcTime, TimeHelper.getParsePattern(elem, false));
                }
                var formattedTime = timeToSet.format(elem.attr('data-format-pattern'));
                var attrib = elem.attr('data-attr');
                TimeHelper.setTimeData(formattedTime, attrib, elem);
            });
        }
        /**
         * Jquery dependant
         */

    }, {
        key: "setUserTimeToUtc",

        /**
         * Jquery dependant
         */
        value: function setUserTimeToUtc(elem) {
            var parent = TimeHelper.getParent(elem);
            var value = elem.val();
            var parsePattern = TimeHelper.getParsePattern(elem, true);
            var linked = null;
            if (elem.attr('data-linked')) {
                linked = parent.find(elem.attr('data-linked'));
                value += ' ' + linked.val();
                parsePattern += ' ' + TimeHelper.getParsePattern(linked, true);
            }
            function setInTarget(time, elem, parent) {
                var target = parent.find(elem.attr('data-target'));
                var attrib = target.attr('data-attr');
                var formattedTime = time.format(target.attr('data-format-pattern'));
                TimeHelper.setTimeData(formattedTime, attrib, target);
            }
            var utcTime = this.convertLocalToUtc(value, parsePattern);
            setInTarget(utcTime, elem, parent);
            if (linked) {
                setInTarget(utcTime, linked, parent);
            }
        }
    }], [{
        key: "utcTime",
        value: function utcTime() {
            return moment.utc();
        }
    }, {
        key: "convertTimeToDifferentZone",
        value: function convertTimeToDifferentZone(timestring, parseFormat, currentOffset, desiredOffset) {
            var localdateTime1 = moment(timestring, parseFormat);
            return localdateTime1.subtract(desiredOffset - currentOffset, 'minutes').utcOffset(desiredOffset);
        }
    }, {
        key: "setTimeData",
        value: function setTimeData(formattedTime, attrib, elem) {
            if (attrib && attrib.length > 0) {
                if (attrib == 'value') {
                    elem.val(formattedTime);
                } else elem.attr(attrib, formattedTime);
            } else {
                elem.text(formattedTime);
            }
        }
    }, {
        key: "getParsePattern",
        value: function getParsePattern(elem, forChange) {
            var parsePattern = elem.attr('data-change-parse-pattern');
            var pattern2 = elem.attr('data-parse-pattern');
            if (!parsePattern) parsePattern = elem.attr('data-parse-pattern');
            return forChange ? parsePattern : pattern2;
        }
        /**
         * Jquery dependant
         */

    }, {
        key: "getParent",
        value: function getParent(elem) {
            var parent = elem.parent();
            if (elem.attr('data-parent')) {
                parent = elem.parents(elem.attr('data-parent'));
            }
            return parent;
        }
    }]);

    return TimeHelper;
}();

exports.default = TimeHelper;

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

/**
 * Created by talha on 4/5/2017.
 */

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });
/**
 * Jquery Dependant
 */

var FormSubmitter = function () {
    function FormSubmitter() {
        _classCallCheck(this, FormSubmitter);

        this.form = null;
        this.type = 'ajaxformsubmitter';
        this.errorAttr = 'data-error';
        this.clientValidationErrors = {};
    }

    _createClass(FormSubmitter, [{
        key: "setForm",
        value: function setForm(jForm) {
            this.form = jForm;
        }
    }, {
        key: "addError",
        value: function addError(field, message) {
            if (!this.clientValidationErrors[field]) this.clientValidationErrors[field] = [];
            this.clientValidationErrors[field].push(message);
        }
    }, {
        key: "validate",
        value: function validate() {
            this.clientValidationErrors = {};
            return true;
        }
    }, {
        key: "getData",
        value: function getData() {
            if (this.getMethod() == 'get') {
                return null;
            } else {
                return new FormData(this.form[0]);
            }
        }
    }, {
        key: "getMethod",
        value: function getMethod() {
            return this.form.attr('method');
        }
    }, {
        key: "getUrl",
        value: function getUrl() {
            var method = this.getMethod();
            var url = this.form.attr('action');
            if (method == 'get') {
                return url + "?" + this.form.serialize();
            } else {
                return url;
            }
        }
    }, {
        key: "processSuccessResponse",
        value: function processSuccessResponse(data, callback) {
            this.processResponseData(data);
            var event = $.Event("formSubmitted:" + this.type);
            if (this.form.attr('data-event') != undefined && this.form.attr('data-event').length > 0) event = $.Event(this.form.attr('data-event'));else event = $.Event("formSubmitted:" + this.type);
            event.cusData = {
                data: data,
                submitter: this
            };
            $(document).trigger(event, [event.cusData.data, event.cusData.submitter]);
        }
    }, {
        key: "processResponseData",
        value: function processResponseData(data, callback) {
            if (data.status) {
                if (callback) callback(data);
                if (data.reload) {
                    window.location.reload();
                } else if (data.redirectUrl) {
                    window.location.href = data.redirectUrl;
                }
            } else {
                this.showErrors(data.errors);
            }
            if (data.message && data.message.length > 0) {
                alert(data.message);
            }
        }
    }, {
        key: "showErrors",
        value: function showErrors(errors) {
            var self = this;
            for (var field in errors) {
                var container = self.getElement("[" + this.errorAttr + "='" + field + "']");
                if (errors[field].length > 0) {
                    container.removeClass("field-validation-valid").addClass("field-validation-error");
                    container.html(errors[field][0].message);
                }
            }
        }
    }, {
        key: "getElement",
        value: function getElement(selector) {
            var pref1 = this.form.find(selector);
            var pref2 = this.form.parents('.js-form').find(selector);
            return pref1.length > 0 ? pref1 : pref2;
        }
    }, {
        key: "resetFormErrors",
        value: function resetFormErrors() {
            this.getElement("[" + this.errorAttr + "]").addClass("field-validation-valid").removeClass("field-validation-error");
            this.getElement("[" + this.errorAttr + "]").text('');
        }
    }, {
        key: "submit",
        value: function submit(callback) {
            this.clientValidationErrors = {};
            this.resetFormErrors();
            var self = this;
            $.siteAjax({
                url: this.getUrl(),
                method: this.getMethod(),
                success: function success(data) {
                    if (typeof data == 'string') data = JSON.parse(data);
                    self.processSuccessResponse(data, callback);
                },
                processData: false,
                contentType: false,
                data: this.getData()
            });
        }
    }]);

    return FormSubmitter;
}();

exports.default = FormSubmitter;

/***/ }),
/* 4 */,
/* 5 */,
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
__webpack_require__(7);
__webpack_require__(8);
__webpack_require__(9);
__webpack_require__(0);

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var time_1 = __webpack_require__(2);
var globals_1 = __webpack_require__(0);
$(document).ready(function () {
    globals_1.default.userInfo = $("#user-info").data();
    globals_1.default.ajaxUrls = $("#ajax-urls").data();
    globals_1.default.timeHelper = new time_1.default();
    $(".js-flatpickr").each(function () {
        // debugger
        var se = $(this);
        var enableTime = $(this).attr('data-enableTime') != undefined ? $(this).attr('data-enableTime') : true;
        var noCalendar = $(this).attr('data-noCalendar') != undefined ? $(this).attr('data-noCalendar') : false;
        var altFormat = $(this).attr('data-altFormat') != undefined ? $(this).attr('data-altFormat') : "Y-m-d h:i K";
        var dateFormat = $(this).attr('data-dateFormat') != undefined ? $(this).attr('data-dateFormat') : "U";
        var mode = $(this).attr('data-mode') != undefined ? $(this).attr('data-mode') : "";
        var s = flatpickr(this, {
            enableTime: enableTime,
            noCalendar: noCalendar,
            altInput: true,
            altFormat: altFormat,
            mode: mode,
            dateFormat: dateFormat
        });
    });
    $(document).on('click', '[data-click]', function () {
        $($(this).attr('data-click')).trigger('click');
    });
    $(document).on('change', '[data-change-converted-time]', function () {
        globals_1.default.timeHelper.setUserTimeToUtc($(this));
    });
    $('[data-convert-time]').each(function () {
        globals_1.default.timeHelper.updateTimes($(this));
    });
});

/***/ }),
/* 8 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
__webpack_require__(3);
var FormSubmitter_1 = __webpack_require__(3);
/**
 * Jquery Dependant
 */
var formSubmittersMap = {};
$(document).ready(function () {
    $.siteAjax = function (settings) {
        if (!settings.headers) {
            settings.headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }
        return $.ajax(settings);
    };
    var formSubmitters = [function () {
        return new FormSubmitter_1.default();
    }];
    formSubmitters.map(function (d) {
        var de = d();
        formSubmittersMap[de.type] = d;
    });
    $(document).on('submit', '.js-ajax-form', function (e) {
        e.preventDefault();
        var form = $(this);
        submitFormUsingAjax(form);
        return false;
    });
});
function submitFormUsingAjax(jForm) {
    var form = jForm;
    console.log(formSubmittersMap);
    var submitter = formSubmittersMap[form.attr('data-form')]();
    submitter.setForm(form);
    if (submitter.validate()) {
        submitter.submit();
    } else {
        submitter.showErrors(submitter.clientValidationErrors);
    }
}
exports.default = submitFormUsingAjax;

/***/ })
],[6]);
//# sourceMappingURL=commons.js.map