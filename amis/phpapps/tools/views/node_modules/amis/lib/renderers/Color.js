"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ColorFieldRenderer = exports.ColorField = void 0;
var tslib_1 = require("tslib");
/**
 * @file 用来展示颜色块。
 */
var react_1 = tslib_1.__importDefault(require("react"));
var factory_1 = require("../factory");
var tpl_builtin_1 = require("../utils/tpl-builtin");
var ColorField = /** @class */ (function (_super) {
    tslib_1.__extends(ColorField, _super);
    function ColorField() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ColorField.prototype.render = function () {
        var _a = this.props, className = _a.className, data = _a.data, cx = _a.classnames, name = _a.name, value = _a.value, defaultColor = _a.defaultColor, showValue = _a.showValue;
        var color = value || (name ? tpl_builtin_1.resolveVariableAndFilter(name, data, '| raw') : null);
        return (react_1.default.createElement("div", { className: cx('ColorField', className) },
            react_1.default.createElement("i", { className: cx('ColorField-previewIcon'), style: { backgroundColor: color || defaultColor } }),
            showValue ? (react_1.default.createElement("span", { className: cx('ColorField-value') }, color)) : null));
    };
    ColorField.defaultProps = {
        className: '',
        defaultColor: '#ccc',
        showValue: true
    };
    return ColorField;
}(react_1.default.Component));
exports.ColorField = ColorField;
var ColorFieldRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ColorFieldRenderer, _super);
    function ColorFieldRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ColorFieldRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)color$/,
            name: 'color'
        })
    ], ColorFieldRenderer);
    return ColorFieldRenderer;
}(ColorField));
exports.ColorFieldRenderer = ColorFieldRenderer;
//# sourceMappingURL=./renderers/Color.js.map
