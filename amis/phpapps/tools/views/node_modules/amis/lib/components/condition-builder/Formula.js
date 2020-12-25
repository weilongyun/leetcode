"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Formula = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var theme_1 = require("../../theme");
var InputBox_1 = tslib_1.__importDefault(require("../InputBox"));
var Formula = /** @class */ (function (_super) {
    tslib_1.__extends(Formula, _super);
    function Formula() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    Formula.prototype.render = function () {
        var _a = this.props, cx = _a.classnames, value = _a.value, onChange = _a.onChange;
        return (react_1.default.createElement("div", { className: cx('CBFormula') },
            react_1.default.createElement(InputBox_1.default, { value: value, onChange: onChange, placeholder: "\u8BF7\u8F93\u5165\u516C\u5F0F", prefix: react_1.default.createElement("span", { className: cx('CBFormula-label') }, "\u8868\u8FBE\u5F0F") })));
    };
    return Formula;
}(react_1.default.Component));
exports.Formula = Formula;
exports.default = theme_1.themeable(Formula);
//# sourceMappingURL=./components/condition-builder/Formula.js.map
