webpackJsonp([1],{

/***/ 19:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(7);

/***/ }),

/***/ 3:
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
            var appSlug = $('#appSlug').val();
            url = url.replace('####', appSlug);
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

/***/ 7:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var common_1 = __webpack_require__(3);
$(document).on('click', '.js-user-block,.js-user-unblock', function () {
    var url = $('#ajax-urls').data('user-state-url');
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
    var url = $('#ajax-urls').data('user-delete-url');
    var button = $(this);
    debugger;
    url = common_1.default.replaceUrlParams(url, button, 'user-id');
    $.siteAjax({
        url: url,
        method: 'delete',
        contentType: false,
        success: function success(data) {
            debugger;
            if (typeof data == 'string') data = JSON.parse(data);
            button.parents('tr').remove();
        }
    });
});

/***/ })

},[19]);
//# sourceMappingURL=user.js.map