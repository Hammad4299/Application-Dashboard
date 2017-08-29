webpackJsonp([2],{

/***/ 18:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(6);

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

/***/ 6:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var common_1 = __webpack_require__(3);
$(document).on('click', '.js-transaction-accept,.js-transaction-reject', function () {
    var url = $('#ajax-urls').data('transaction-status-url');
    var button = $(this);
    url = common_1.default.replaceUrlParams(url, button, 'trans-id');
    var status = button.data('status');
    var fD = new FormData();
    fD.append('status', status);
    $.siteAjax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        data: fD,
        success: function success(data) {
            if (typeof data == 'string') data = JSON.parse(data);
            var td = button.parent();
            td.html('<span class="text-center status-text" >Accepted</span>');
            if (status === 3) {
                td.find('span').text('Rejected');
            }
        }
    });
});

/***/ })

},[18]);
//# sourceMappingURL=transaction.js.map