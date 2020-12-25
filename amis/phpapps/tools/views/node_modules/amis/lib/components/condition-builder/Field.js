"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ConditionField = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var PopOverContainer_1 = tslib_1.__importDefault(require("../PopOverContainer"));
var ListRadios_1 = tslib_1.__importDefault(require("../ListRadios"));
var ResultBox_1 = tslib_1.__importDefault(require("../ResultBox"));
var theme_1 = require("../../theme");
var icons_1 = require("../icons");
var helper_1 = require("../../utils/helper");
var option2value = function (item) { return item.name; };
function ConditionField(_a) {
    var options = _a.options, onChange = _a.onChange, value = _a.value, cx = _a.classnames;
    return (react_1.default.createElement(PopOverContainer_1.default, { popOverRender: function (_a) {
            var onClose = _a.onClose;
            return (react_1.default.createElement(ListRadios_1.default, { onClick: onClose, showRadio: false, options: options, value: value, option2value: option2value, onChange: onChange }));
        } }, function (_a) {
        var _b;
        var onClick = _a.onClick, ref = _a.ref, isOpened = _a.isOpened;
        return (react_1.default.createElement("div", { className: cx('CBGroup-field') },
            react_1.default.createElement(ResultBox_1.default, { className: cx('CBGroup-fieldInput', isOpened ? 'is-active' : ''), ref: ref, allowInput: false, result: value ? (_b = helper_1.findTree(options, function (item) { return item.name === value; })) === null || _b === void 0 ? void 0 : _b.label : '', onResultChange: helper_1.noop, onResultClick: onClick, placeholder: "\u8BF7\u9009\u62E9\u5B57\u6BB5" },
                react_1.default.createElement("span", { className: cx('CBGroup-fieldCaret') },
                    react_1.default.createElement(icons_1.Icon, { icon: "caret", className: "icon" })))));
    }));
}
exports.ConditionField = ConditionField;
exports.default = theme_1.themeable(ConditionField);
//# sourceMappingURL=./components/condition-builder/Field.js.map
