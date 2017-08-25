webpackJsonp([0],[
/* 0 */
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
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var TimeHelper = function () {
    function TimeHelper(userTimezone) {
        _classCallCheck(this, TimeHelper);

        this.userTimezone = userTimezone;
        this.dateTimeFormat = 'YYYY-MM-DD hh:mm a';
    }

    _createClass(TimeHelper, [{
        key: 'getUserUtcOffset',
        value: function getUserUtcOffset() {
            var baseOffset = moment().utcOffset();
            if (this.userTimezone) {
                baseOffset = parseInt(this.userTimezone) * 60;
            }

            return baseOffset;
        }
    }, {
        key: 'convertUtcToUserTime',
        value: function convertUtcToUserTime(utcdateTime, parseFormat) {
            utcdateTime = moment.utc(utcdateTime, parseFormat).utcOffset(this.getUserUtcOffset());
            return utcdateTime;
        }
    }, {
        key: 'timestampToLocal',
        value: function timestampToLocal(timestamp) {
            return this.convertUtcToUserTime('' + timestamp, 'X').format(this.dateTimeFormat);
        }
    }, {
        key: 'userTime',
        value: function userTime() {
            return moment.utc().utcOffset(this.getUserUtcOffset());
        }
    }, {
        key: 'utcTime',
        value: function utcTime() {
            return moment.utc();
        }
    }, {
        key: 'convertLocalToUtc',
        value: function convertLocalToUtc(localdateTime, parseFormat) {
            localdateTime = moment(localdateTime, parseFormat);
            var detectedOffset = localdateTime.utcOffset();
            var userOffset = this.getUserUtcOffset();
            localdateTime = localdateTime.subtract(userOffset - detectedOffset, 'minutes').utcOffset(this.getUserUtcOffset()).utcOffset(0);
            return localdateTime;
        }

        /**
         * Jquery dependant
         */

    }, {
        key: 'updateTimes',


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
                    timeToSet = self.utcTime();
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
        key: 'setUserTimeToUtc',


        /**
         * Jquery dependant
         */
        value: function setUserTimeToUtc(elem) {
            var self = this;
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
                self.setTimeData(formattedTime, attrib, target);
            }

            var utcTime = this.convertLocalToUtc(value, parsePattern);
            setInTarget(utcTime, elem, parent);
            if (linked) {
                setInTarget(utcTime, linked, parent);
            }
        }
    }], [{
        key: 'setTimeData',
        value: function setTimeData(formattedTime, attrib, elem) {
            if (attrib != null && attrib != null && attrib.length > 0) {
                if (attrib == 'value') {
                    rrr = elem;
                    elem.val(formattedTime);
                } else elem.attr(attrib, formattedTime);
            } else {
                elem.text(formattedTime);
            }
        }
    }, {
        key: 'getParsePattern',
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
        key: 'getParent',
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


module.exports = TimeHelper;

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Created by talha on 4/5/2017.
 */
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
        key: 'setForm',
        value: function setForm(jForm) {
            this.form = jForm;
        }
    }, {
        key: 'addError',
        value: function addError(field, message) {
            if (!this.clientValidationErrors[field]) this.clientValidationErrors[field] = [];

            this.clientValidationErrors[field].push(message);
        }
    }, {
        key: 'validate',
        value: function validate() {
            this.clientValidationErrors = {};
            return true;
        }
    }, {
        key: 'getData',
        value: function getData() {
            if (this.getMethod() == 'get') {
                return null;
            } else {
                return new FormData(this.form[0]);
            }
        }
    }, {
        key: 'getMethod',
        value: function getMethod() {
            return this.form.attr('method');
        }
    }, {
        key: 'getUrl',
        value: function getUrl() {
            var method = this.getMethod();
            var url = this.form.attr('action');
            if (method == 'get') {
                return url + '?' + this.form.serialize();
            } else {
                return url;
            }
        }
    }, {
        key: 'processSuccessResponse',
        value: function processSuccessResponse(data, callback) {
            this.processResponseData(data);
            var event = $.Event('formSubmitted:' + this.type);
            event.cusData = {
                data: data,
                submitter: this
            };

            $(document).trigger(event);
            this.form.trigger(event);
        }
    }, {
        key: 'processResponseData',
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
                alert(data.Message);
            }
        }
    }, {
        key: 'showErrors',
        value: function showErrors(errors) {
            var self = this;

            for (var field in errors) {
                var container = self.getElement('[' + this.errorAttr + '=\'' + field + '\']');
                if (errors[field].length > 0) {
                    container.removeClass("field-validation-valid").addClass("field-validation-error");
                    container.html(errors[field][0]);
                }
            }
        }
    }, {
        key: 'getElement',
        value: function getElement(selector) {
            var pref1 = this.form.find(selector);
            var pref2 = this.form.parents('.js-form').find(selector);
            return pref1.length > 0 ? pref1 : pref2;
        }
    }, {
        key: 'resetFormErrors',
        value: function resetFormErrors() {
            this.getElement('[' + this.errorAttr + ']').addClass("field-validation-valid").removeClass("field-validation-error");
            this.getElement('[' + this.errorAttr + ']').text('');
        }
    }, {
        key: 'submit',
        value: function submit() {
            this.clientValidationErrors = {};
            this.resetFormErrors();
            var self = this;

            $.siteAjax({
                url: this.getUrl(),
                method: this.getMethod(),
                success: function success(data) {
                    if (typeof data == 'string') data = JSON.parse(data);
                    self.processSuccessResponse(data);
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


module.exports = FormSubmitter;

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }(); //Requirement. Creation model and override open modal. addViewForData, removeViewForData.   'js-crudable-item' class. Add event for form submition of modal


var _FormSubmitter = __webpack_require__(2);

var _FormSubmitter2 = _interopRequireDefault(_FormSubmitter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

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
        key: 'init',
        value: function init() {
            this.helperData.listingElem = this.containers.listing.find(this.helperData.listClass);
        }
    }, {
        key: 'refreshData',
        value: function refreshData(callback) {}
        //Calls addData

    }, {
        key: 'setData',
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
        key: 'addData',
        value: function addData(data) {
            var self = this;
            self.addReplaceViewForData(data);
            self.data[data[this.getIdPropertyName()]] = data;
        }
    }, {
        key: 'getIdPropertyName',
        value: function getIdPropertyName() {
            return 'id';
        }
        //Calls removeViewForData

    }, {
        key: 'removeData',
        value: function removeData(data) {
            var self = this;
            self.removeViewForData(data);
            delete self.data[data.id];
        }
    }, {
        key: 'clearListingView',
        value: function clearListingView() {
            this.helperData.listingElem.html('');
        }
    }, {
        key: 'addReplaceViewForData',
        value: function addReplaceViewForData(data) {
            var view = this.getViewToAddReplace(data);
            var existing = this.helperData.listingElem.find('.js-crudable-item[data-id=\'' + data[this.getIdPropertyName()] + '\']');
            if (existing.length > 0) {
                existing.replaceWith(view);
            } else {
                this.helperData.listingElem.append(view);
            }
        }
    }, {
        key: 'getViewToAddReplace',
        value: function getViewToAddReplace(data) {}
    }, {
        key: 'removeViewForData',
        value: function removeViewForData(data) {
            this.containers.listing.find('[data-id=\'' + data[this.getIdPropertyName()] + '\']').remove();
        }
    }, {
        key: 'openModal',
        value: function openModal(data) {}
    }, {
        key: 'getDataByID',
        value: function getDataByID(id) {
            return this.data[id];
        }
    }, {
        key: 'getDeletionUrl',
        value: function getDeletionUrl(id) {
            return this.helperData.deletionUrl;
        }
    }, {
        key: 'getSelectedID',
        value: function getSelectedID(clickedElem) {
            return clickedElem.parents('.js-crudable-item').attr('data-id');
        }
    }, {
        key: 'handleDeletion',
        value: function handleDeletion(clickedElement) {
            var self = this;
            var submitter = new _FormSubmitter2.default();
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
        key: 'hookEvents',
        value: function hookEvents() {
            var self = this;
            if (this.containers.edit) {
                this.containers.edit.on('click', self.helperData.editClass, function (e) {
                    var id = self.getSelectedID($(this));
                    var d = self.getDataByID(id);
                    self.openModal(d);
                });
            }

            if (this.containers.delete) {
                this.containers.delete.on('click', self.helperData.deleteClass, function (e) {
                    self.handleDeletion($(this));
                });
            }

            if (this.containers.create) {
                this.containers.create.on('click', self.helperData.creationClass, function () {
                    self.openModal();
                });
            }
        }
    }]);

    return CrudHelper;
}();

exports.default = CrudHelper;


module.exports = CrudHelper;

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var BaseModalHandler = function () {
    function BaseModalHandler(container) {
        _classCallCheck(this, BaseModalHandler);

        this.container = container;
        this.editableData = null;
        this.name = "BaseModelHandler";
    }

    _createClass(BaseModalHandler, [{
        key: 'initView',
        value: function initView(data, callback) {
            var self = this;
            var form = self.container.find('form');
            this.setEditableData(data);

            if (callback) callback();
        }
    }, {
        key: 'setEditableData',
        value: function setEditableData(data) {
            this.editableData = data;
        }
    }, {
        key: 'hookEvents',
        value: function hookEvents() {
            var self = this;

            self.container.on('click', '.js-submit-form', function () {
                self.submit(self.container.find('form'));
            });
        }
    }, {
        key: 'fillViewFromData',
        value: function fillViewFromData() {
            var self = this;
        }
    }, {
        key: 'submit',
        value: function submit(form) {
            form.trigger('submit');
        }
    }]);

    return BaseModalHandler;
}();

exports.default = BaseModalHandler;


module.exports = BaseModalHandler;

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
var userInfo = exports.userInfo = {};
var ajaxUrls = exports.ajaxUrls = {};
var timeHelper = exports.timeHelper = null;

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.default = submitFormUsingAjax;

var _FormSubmitter = __webpack_require__(2);

var _FormSubmitter2 = _interopRequireDefault(_FormSubmitter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * Jquery Dependant
 */

var formSubmittersMap = {};
$(document).ready(function () {
    $.siteAjax = function (options) {
        if (!options.headers) {
            options.headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }

        return $.ajax(options);
    };

    var formSubmitters = [function () {
        return new _FormSubmitter2.default();
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

module.exports = submitFormUsingAjax;

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _time = __webpack_require__(1);

var _time2 = _interopRequireDefault(_time);

var _globals = __webpack_require__(5);

var global = _interopRequireWildcard(_globals);

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

$(document).ready(function () {
    global.userInfo = $("#user-info").data();
    global.ajaxUrls = $("#ajax-urls").data();
    global.timeHelper = new _time2.default();

    $(document).on('click', '[data-click]', function () {
        $($(this).attr('data-click')).trigger('click');
    });

    $(document).on('change', '[data-change-converted-time]', function () {
        timeHelper.setUserTimeToUtc($(this));
    });

    $('[data-convert-time]').each(function () {
        timeHelper.updateTimes($(this));
    });
});

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["BaseModalHandler"] = __webpack_require__(4);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["CrudHelper"] = __webpack_require__(3);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["FormSubmitter"] = __webpack_require__(2);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["Globals"] = __webpack_require__(5);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["TimeHelper"] = __webpack_require__(1);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ }),
/* 13 */,
/* 14 */,
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _time = __webpack_require__(1);

var _time2 = _interopRequireDefault(_time);

__webpack_require__(7);

__webpack_require__(6);

var _CrudHelper = __webpack_require__(3);

var _CrudHelper2 = _interopRequireDefault(_CrudHelper);

var _BaseModalHandler = __webpack_require__(4);

var _BaseModalHandler2 = _interopRequireDefault(_BaseModalHandler);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

__webpack_require__(11);
__webpack_require__(12);
__webpack_require__(10);
__webpack_require__(8);
__webpack_require__(9);

/***/ })
],[15]);
//# sourceMappingURL=commons.js.map