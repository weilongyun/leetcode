"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.EachRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var factory_1 = require("../factory");
var tpl_builtin_1 = require("../utils/tpl-builtin");
var helper_1 = require("../utils/helper");
var Each = /** @class */ (function (_super) {
    tslib_1.__extends(Each, _super);
    function Each() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    Each.prototype.render = function () {
        var _a = this.props, data = _a.data, name = _a.name, className = _a.className, render = _a.render, value = _a.value, items = _a.items, placeholder = _a.placeholder, cx = _a.classnames, __ = _a.translate;
        var arr = typeof value !== 'undefined'
            ? helper_1.isObject(value)
                ? Object.keys(value).map(function (key) { return ({
                    key: key,
                    value: value[key]
                }); })
                : Array.isArray(value)
                    ? value
                    : []
            : tpl_builtin_1.resolveVariable(name, data);
        return (react_1.default.createElement("div", { className: cx('Each', className) }, Array.isArray(arr) && items ? (arr.map(function (item, index) {
            var _a;
            return render("item/" + index, items, {
                data: helper_1.createObject(data, helper_1.isObject(item)
                    ? tslib_1.__assign({ index: index }, item) : (_a = {}, _a[name] = item, _a.item = item, _a.index = index, _a)),
                key: index
            });
        })) : (react_1.default.createElement("div", { className: cx('Each-placeholder') }, render('placeholder', __(placeholder))))));
    };
    Each.propsList = ['name', 'items', 'value'];
    Each.defaultProps = {
        className: '',
        placeholder: '暂无内容'
    };
    return Each;
}(react_1.default.Component));
exports.default = Each;
var EachRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(EachRenderer, _super);
    function EachRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    EachRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)(?:repeat|each)$/,
            name: 'each'
        })
    ], EachRenderer);
    return EachRenderer;
}(Each));
exports.EachRenderer = EachRenderer;
//# sourceMappingURL=./renderers/Each.js.map
