webpackJsonp([2],{

/***/ 4:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 5:
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

/***/ })

},[6]);
//# sourceMappingURL=commons.js.map