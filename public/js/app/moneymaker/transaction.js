webpackJsonp([3],{

/***/ 20:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


__webpack_require__(21);

/***/ }),

/***/ 21:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", { value: true });
var globals_1 = __webpack_require__(0);
var common_1 = __webpack_require__(5);
$(document).on('click', '.js-transaction-accept,.js-transaction-reject', function () {
    var url = globals_1.default.ajaxUrls.moneymakerTransactionStatusUrl;
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

},[20]);
//# sourceMappingURL=transaction.js.map