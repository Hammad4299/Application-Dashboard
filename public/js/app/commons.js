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

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),
/* 2 */
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
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });
var moment = __webpack_require__(4);

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
/* 4 */
/***/ (function(module, exports) {

module.exports = moment;

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });

var MoneymakerFunctions = function () {
    function MoneymakerFunctions() {
        _classCallCheck(this, MoneymakerFunctions);
    }

    _createClass(MoneymakerFunctions, [{
        key: "replaceUrlParams",
        value: function replaceUrlParams(url, btn, dataName) {
            var appId = $('#appId').val();
            // let appSlug = $('#appSlug').val();
            //
            // url = url.replace('####', appSlug);
            url = url.replace('###', appId);
            if (dataName.length > 0) {
                var userId = $(btn).data(dataName);
                url = url.replace('##', userId);
            }
            return url;
        }
    }]);

    return MoneymakerFunctions;
}();

var moneymaker = new MoneymakerFunctions();
exports.default = moneymaker;

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
__webpack_require__(7);
__webpack_require__(8);
__webpack_require__(0);
__webpack_require__(9);
__webpack_require__(10);
__webpack_require__(11);
__webpack_require__(12);
__webpack_require__(14);

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var time_1 = __webpack_require__(3);
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
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
__webpack_require__(2);
var FormSubmitter_1 = __webpack_require__(2);
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

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["Globals"] = __webpack_require__(0);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["TimeHelper"] = __webpack_require__(3);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["FormSubmitter"] = __webpack_require__(2);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["BaseModalHandler"] = __webpack_require__(13);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });

var BaseModalHandler = function () {
    function BaseModalHandler(container) {
        _classCallCheck(this, BaseModalHandler);

        this.container = container;
        this.editableData = null;
        this.name = "BaseModelHandler";
    }

    _createClass(BaseModalHandler, [{
        key: "initView",
        value: function initView(data, callback) {
            var self = this;
            var form = self.container.find('form');
            this.setEditableData(data);
            if (callback) callback();
        }
    }, {
        key: "setEditableData",
        value: function setEditableData(data) {
            this.editableData = data;
        }
    }, {
        key: "hookEvents",
        value: function hookEvents() {
            var self = this;
            self.container.on('click', '.js-submit-form', function () {
                self.submit(self.container.find('form'));
            });
        }
    }, {
        key: "submit",
        value: function submit(form) {
            form.trigger('submit');
        }
    }]);

    return BaseModalHandler;
}();

exports.default = BaseModalHandler;

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["CrudHelper"] = __webpack_require__(15);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

Object.defineProperty(exports, "__esModule", { value: true });
//Requirement. Creation model and override open modal. addViewForData, removeViewForData.   'js-crudable-item' class. Add event for form submition of modal
var FormSubmitter_1 = __webpack_require__(2);

var CrudHelper = function () {
    function CrudHelper(containers) {
        _classCallCheck(this, CrudHelper);

        this.data = {};
        this.containers = containers;
        this.helperData = {
            listingElem: null,
            editClass: null,
            listClass: null,
            deleteClass: null,
            deletionUrl: null,
            creationClass: null
        };
    }

    _createClass(CrudHelper, [{
        key: "init",
        value: function init() {
            this.helperData.listingElem = this.containers.listing.find(this.helperData.listClass);
        }
    }, {
        key: "refreshData",
        value: function refreshData(callback) {}
        //Calls addData

    }, {
        key: "setData",
        value: function setData(data) {
            var _this = this;

            var self = this;
            self.data = {};
            self.clearListingView();
            data.map(function (item) {
                _this.addData(item);
            });
        }
        //Calls addViewFofData

    }, {
        key: "addData",
        value: function addData(data) {
            var self = this;
            self.addReplaceViewForData(data);
            self.data[data[this.getIdPropertyName()]] = data;
        }
    }, {
        key: "getIdPropertyName",
        value: function getIdPropertyName() {
            return 'id';
        }
        //Calls removeViewForData

    }, {
        key: "removeData",
        value: function removeData(data) {
            var self = this;
            self.removeViewForData(data);
            delete self.data[data.id];
        }
    }, {
        key: "clearListingView",
        value: function clearListingView() {
            this.helperData.listingElem.html('');
        }
    }, {
        key: "addReplaceViewForData",
        value: function addReplaceViewForData(data) {
            var view = this.getViewToAddReplace(data);
            var existing = this.helperData.listingElem.find(".js-crudable-item[data-id='" + data[this.getIdPropertyName()] + "']");
            if (existing.length > 0) {
                existing.replaceWith(view);
            } else {
                this.helperData.listingElem.append(view);
            }
        }
    }, {
        key: "removeViewForData",
        value: function removeViewForData(data) {
            this.containers.listing.find("[data-id='" + data[this.getIdPropertyName()] + "']").remove();
        }
    }, {
        key: "getDataByID",
        value: function getDataByID(id) {
            return this.data[id];
        }
    }, {
        key: "getDeletionUrl",
        value: function getDeletionUrl(id) {
            return this.helperData.deletionUrl;
        }
    }, {
        key: "getSelectedID",
        value: function getSelectedID(clickedElem) {
            return clickedElem.parents('.js-crudable-item').attr('data-id');
        }
    }, {
        key: "handleDeletion",
        value: function handleDeletion(clickedElement) {
            var self = this;
            var submitter = new FormSubmitter_1.default();
            submitter.setForm(clickedElement.parents('.js-crudable-item'));
            var id = self.getSelectedID(clickedElement);
            var initiatedData = this.getDataByID(id);
            var res = confirm('Are you sure you want to delete this?');
            if (res) {
                $.siteAjax({
                    type: 'delete',
                    url: self.getDeletionUrl(id),
                    success: function success(response) {
                        var data = JSON.parse(response);
                        submitter.processResponseData(data, function (dd) {
                            self.removeData(initiatedData);
                        });
                    }
                });
            }
        }
    }, {
        key: "hookEvents",
        value: function hookEvents() {
            var self = this;
            if (this.containers.edit) {
                this.containers.edit.on('click', self.helperData.editClass, function (e) {
                    var id = self.getSelectedID($(this));
                    var d = self.getDataByID(id);
                    self.viewForCreateEdit(d);
                });
            }
            if (this.containers.deletion) {
                this.containers.deletion.on('click', self.helperData.deleteClass, function (e) {
                    self.handleDeletion($(this));
                });
            }
            if (this.containers.create) {
                this.containers.create.on('click', self.helperData.creationClass, function () {
                    self.viewForCreateEdit();
                });
            }
        }
    }]);

    return CrudHelper;
}();

exports.default = CrudHelper;

/***/ }),
/* 16 */,
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */
/***/ (function(module, exports) {


/**
 * When source maps are enabled, `style-loader` uses a link element with a data-uri to
 * embed the css on the page. This breaks all relative urls because now they are relative to a
 * bundle instead of the current page.
 *
 * One solution is to only use full urls, but that may be impossible.
 *
 * Instead, this function "fixes" the relative urls to be absolute according to the current page location.
 *
 * A rudimentary test suite is located at `test/fixUrls.js` and can be run via the `npm test` command.
 *
 */

module.exports = function (css) {
  // get current location
  var location = typeof window !== "undefined" && window.location;

  if (!location) {
    throw new Error("fixUrls requires window.location");
  }

	// blank or null?
	if (!css || typeof css !== "string") {
	  return css;
  }

  var baseUrl = location.protocol + "//" + location.host;
  var currentDir = baseUrl + location.pathname.replace(/\/[^\/]*$/, "/");

	// convert each url(...)
	/*
	This regular expression is just a way to recursively match brackets within
	a string.

	 /url\s*\(  = Match on the word "url" with any whitespace after it and then a parens
	   (  = Start a capturing group
	     (?:  = Start a non-capturing group
	         [^)(]  = Match anything that isn't a parentheses
	         |  = OR
	         \(  = Match a start parentheses
	             (?:  = Start another non-capturing groups
	                 [^)(]+  = Match anything that isn't a parentheses
	                 |  = OR
	                 \(  = Match a start parentheses
	                     [^)(]*  = Match anything that isn't a parentheses
	                 \)  = Match a end parentheses
	             )  = End Group
              *\) = Match anything and then a close parens
          )  = Close non-capturing group
          *  = Match anything
       )  = Close capturing group
	 \)  = Match a close parens

	 /gi  = Get all matches, not the first.  Be case insensitive.
	 */
	var fixedCss = css.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function(fullMatch, origUrl) {
		// strip quotes (if they exist)
		var unquotedOrigUrl = origUrl
			.trim()
			.replace(/^"(.*)"$/, function(o, $1){ return $1; })
			.replace(/^'(.*)'$/, function(o, $1){ return $1; });

		// already a full url? no change
		if (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/)/i.test(unquotedOrigUrl)) {
		  return fullMatch;
		}

		// convert the url to a full url
		var newUrl;

		if (unquotedOrigUrl.indexOf("//") === 0) {
		  	//TODO: should we add protocol?
			newUrl = unquotedOrigUrl;
		} else if (unquotedOrigUrl.indexOf("/") === 0) {
			// path should be relative to the base url
			newUrl = baseUrl + unquotedOrigUrl; // already starts with '/'
		} else {
			// path should be relative to current directory
			newUrl = currentDir + unquotedOrigUrl.replace(/^\.\//, ""); // Strip leading './'
		}

		// send back the fixed url(...)
		return "url(" + JSON.stringify(newUrl) + ")";
	});

	// send back the fixed css
	return fixedCss;
};


/***/ }),
/* 25 */,
/* 26 */,
/* 27 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/

var stylesInDom = {};

var	memoize = function (fn) {
	var memo;

	return function () {
		if (typeof memo === "undefined") memo = fn.apply(this, arguments);
		return memo;
	};
};

var isOldIE = memoize(function () {
	// Test for IE <= 9 as proposed by Browserhacks
	// @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
	// Tests for existence of standard globals is to allow style-loader
	// to operate correctly into non-standard environments
	// @see https://github.com/webpack-contrib/style-loader/issues/177
	return window && document && document.all && !window.atob;
});

var getElement = (function (fn) {
	var memo = {};

	return function(selector) {
		if (typeof memo[selector] === "undefined") {
			var styleTarget = fn.call(this, selector);
			// Special case to return head of iframe instead of iframe itself
			if (styleTarget instanceof window.HTMLIFrameElement) {
				try {
					// This will throw an exception if access to iframe is blocked
					// due to cross-origin restrictions
					styleTarget = styleTarget.contentDocument.head;
				} catch(e) {
					styleTarget = null;
				}
			}
			memo[selector] = styleTarget;
		}
		return memo[selector]
	};
})(function (target) {
	return document.querySelector(target)
});

var singleton = null;
var	singletonCounter = 0;
var	stylesInsertedAtTop = [];

var	fixUrls = __webpack_require__(24);

module.exports = function(list, options) {
	if (typeof DEBUG !== "undefined" && DEBUG) {
		if (typeof document !== "object") throw new Error("The style-loader cannot be used in a non-browser environment");
	}

	options = options || {};

	options.attrs = typeof options.attrs === "object" ? options.attrs : {};

	// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
	// tags it will allow on a page
	if (!options.singleton) options.singleton = isOldIE();

	// By default, add <style> tags to the <head> element
	if (!options.insertInto) options.insertInto = "head";

	// By default, add <style> tags to the bottom of the target
	if (!options.insertAt) options.insertAt = "bottom";

	var styles = listToStyles(list, options);

	addStylesToDom(styles, options);

	return function update (newList) {
		var mayRemove = [];

		for (var i = 0; i < styles.length; i++) {
			var item = styles[i];
			var domStyle = stylesInDom[item.id];

			domStyle.refs--;
			mayRemove.push(domStyle);
		}

		if(newList) {
			var newStyles = listToStyles(newList, options);
			addStylesToDom(newStyles, options);
		}

		for (var i = 0; i < mayRemove.length; i++) {
			var domStyle = mayRemove[i];

			if(domStyle.refs === 0) {
				for (var j = 0; j < domStyle.parts.length; j++) domStyle.parts[j]();

				delete stylesInDom[domStyle.id];
			}
		}
	};
};

function addStylesToDom (styles, options) {
	for (var i = 0; i < styles.length; i++) {
		var item = styles[i];
		var domStyle = stylesInDom[item.id];

		if(domStyle) {
			domStyle.refs++;

			for(var j = 0; j < domStyle.parts.length; j++) {
				domStyle.parts[j](item.parts[j]);
			}

			for(; j < item.parts.length; j++) {
				domStyle.parts.push(addStyle(item.parts[j], options));
			}
		} else {
			var parts = [];

			for(var j = 0; j < item.parts.length; j++) {
				parts.push(addStyle(item.parts[j], options));
			}

			stylesInDom[item.id] = {id: item.id, refs: 1, parts: parts};
		}
	}
}

function listToStyles (list, options) {
	var styles = [];
	var newStyles = {};

	for (var i = 0; i < list.length; i++) {
		var item = list[i];
		var id = options.base ? item[0] + options.base : item[0];
		var css = item[1];
		var media = item[2];
		var sourceMap = item[3];
		var part = {css: css, media: media, sourceMap: sourceMap};

		if(!newStyles[id]) styles.push(newStyles[id] = {id: id, parts: [part]});
		else newStyles[id].parts.push(part);
	}

	return styles;
}

function insertStyleElement (options, style) {
	var target = getElement(options.insertInto)

	if (!target) {
		throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
	}

	var lastStyleElementInsertedAtTop = stylesInsertedAtTop[stylesInsertedAtTop.length - 1];

	if (options.insertAt === "top") {
		if (!lastStyleElementInsertedAtTop) {
			target.insertBefore(style, target.firstChild);
		} else if (lastStyleElementInsertedAtTop.nextSibling) {
			target.insertBefore(style, lastStyleElementInsertedAtTop.nextSibling);
		} else {
			target.appendChild(style);
		}
		stylesInsertedAtTop.push(style);
	} else if (options.insertAt === "bottom") {
		target.appendChild(style);
	} else if (typeof options.insertAt === "object" && options.insertAt.before) {
		var nextSibling = getElement(options.insertInto + " " + options.insertAt.before);
		target.insertBefore(style, nextSibling);
	} else {
		throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");
	}
}

function removeStyleElement (style) {
	if (style.parentNode === null) return false;
	style.parentNode.removeChild(style);

	var idx = stylesInsertedAtTop.indexOf(style);
	if(idx >= 0) {
		stylesInsertedAtTop.splice(idx, 1);
	}
}

function createStyleElement (options) {
	var style = document.createElement("style");

	options.attrs.type = "text/css";

	addAttrs(style, options.attrs);
	insertStyleElement(options, style);

	return style;
}

function createLinkElement (options) {
	var link = document.createElement("link");

	options.attrs.type = "text/css";
	options.attrs.rel = "stylesheet";

	addAttrs(link, options.attrs);
	insertStyleElement(options, link);

	return link;
}

function addAttrs (el, attrs) {
	Object.keys(attrs).forEach(function (key) {
		el.setAttribute(key, attrs[key]);
	});
}

function addStyle (obj, options) {
	var style, update, remove, result;

	// If a transform function was defined, run it on the css
	if (options.transform && obj.css) {
	    result = options.transform(obj.css);

	    if (result) {
	    	// If transform returns a value, use that instead of the original css.
	    	// This allows running runtime transformations on the css.
	    	obj.css = result;
	    } else {
	    	// If the transform function returns a falsy value, don't add this css.
	    	// This allows conditional loading of css
	    	return function() {
	    		// noop
	    	};
	    }
	}

	if (options.singleton) {
		var styleIndex = singletonCounter++;

		style = singleton || (singleton = createStyleElement(options));

		update = applyToSingletonTag.bind(null, style, styleIndex, false);
		remove = applyToSingletonTag.bind(null, style, styleIndex, true);

	} else if (
		obj.sourceMap &&
		typeof URL === "function" &&
		typeof URL.createObjectURL === "function" &&
		typeof URL.revokeObjectURL === "function" &&
		typeof Blob === "function" &&
		typeof btoa === "function"
	) {
		style = createLinkElement(options);
		update = updateLink.bind(null, style, options);
		remove = function () {
			removeStyleElement(style);

			if(style.href) URL.revokeObjectURL(style.href);
		};
	} else {
		style = createStyleElement(options);
		update = applyToTag.bind(null, style);
		remove = function () {
			removeStyleElement(style);
		};
	}

	update(obj);

	return function updateStyle (newObj) {
		if (newObj) {
			if (
				newObj.css === obj.css &&
				newObj.media === obj.media &&
				newObj.sourceMap === obj.sourceMap
			) {
				return;
			}

			update(obj = newObj);
		} else {
			remove();
		}
	};
}

var replaceText = (function () {
	var textStore = [];

	return function (index, replacement) {
		textStore[index] = replacement;

		return textStore.filter(Boolean).join('\n');
	};
})();

function applyToSingletonTag (style, index, remove, obj) {
	var css = remove ? "" : obj.css;

	if (style.styleSheet) {
		style.styleSheet.cssText = replaceText(index, css);
	} else {
		var cssNode = document.createTextNode(css);
		var childNodes = style.childNodes;

		if (childNodes[index]) style.removeChild(childNodes[index]);

		if (childNodes.length) {
			style.insertBefore(cssNode, childNodes[index]);
		} else {
			style.appendChild(cssNode);
		}
	}
}

function applyToTag (style, obj) {
	var css = obj.css;
	var media = obj.media;

	if(media) {
		style.setAttribute("media", media)
	}

	if(style.styleSheet) {
		style.styleSheet.cssText = css;
	} else {
		while(style.firstChild) {
			style.removeChild(style.firstChild);
		}

		style.appendChild(document.createTextNode(css));
	}
}

function updateLink (link, options, obj) {
	var css = obj.css;
	var sourceMap = obj.sourceMap;

	/*
		If convertToAbsoluteUrls isn't defined, but sourcemaps are enabled
		and there is no publicPath defined then lets turn convertToAbsoluteUrls
		on by default.  Otherwise default to the convertToAbsoluteUrls option
		directly
	*/
	var autoFixUrls = options.convertToAbsoluteUrls === undefined && sourceMap;

	if (options.convertToAbsoluteUrls || autoFixUrls) {
		css = fixUrls(css);
	}

	if (sourceMap) {
		// http://stackoverflow.com/a/26603875
		css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */";
	}

	var blob = new Blob([css], { type: "text/css" });

	var oldSrc = link.href;

	link.href = URL.createObjectURL(blob);

	if(oldSrc) URL.revokeObjectURL(oldSrc);
}


/***/ })
],[6]);
//# sourceMappingURL=commons.js.map