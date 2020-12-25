"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ColorControlRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var Item_1 = require("./Item");
var classnames_1 = tslib_1.__importDefault(require("classnames"));
var ColorPicker_1 = tslib_1.__importDefault(require("../../components/ColorPicker"));
var ColorControl = /** @class */ (function (_super) {
    tslib_1.__extends(ColorControl, _super);
    function ColorControl() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.state = {
            open: false
        };
        return _this;
    }
    ColorControl.prototype.render = function () {
        var _a = this.props, className = _a.className, ns = _a.classPrefix, rest = tslib_1.__rest(_a, ["className", "classPrefix"]);
        return (react_1.default.createElement("div", { className: classnames_1.default(ns + "ColorControl", className) },
            react_1.default.createElement(ColorPicker_1.default, tslib_1.__assign({ classPrefix: ns }, rest))));
    };
    ColorControl.defaultProps = {
        format: 'hex',
        clearable: true
    };
    return ColorControl;
}(react_1.default.PureComponent));
exports.default = ColorControl;
var ColorControlRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ColorControlRenderer, _super);
    function ColorControlRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ColorControlRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'color'
        })
    ], ColorControlRenderer);
    return ColorControlRenderer;
}(ColorControl));
exports.ColorControlRenderer = ColorControlRenderer;
//# sourceMappingURL=./renderers/Form/Color.js.map
