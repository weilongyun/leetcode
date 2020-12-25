"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.HBoxRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var factory_1 = require("../factory");
var classnames_1 = tslib_1.__importDefault(require("classnames"));
var helper_1 = require("../utils/helper");
var HBox = /** @class */ (function (_super) {
    tslib_1.__extends(HBox, _super);
    function HBox() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    HBox.prototype.renderChild = function (region, node) {
        var render = this.props.render;
        return render(region, node);
    };
    HBox.prototype.renderColumn = function (column, key, length) {
        var _a = this.props, itemRender = _a.itemRender, data = _a.data, ns = _a.classPrefix;
        if (!helper_1.isVisible(column, data)) {
            return null;
        }
        var style = tslib_1.__assign({ width: column.width, height: column.height }, column.style);
        return (react_1.default.createElement("div", { key: key, className: classnames_1.default(ns + "Hbox-col", column.columnClassName), style: style }, itemRender
            ? itemRender(column, key, length, this.props)
            : this.renderChild("column/" + key, column)));
    };
    HBox.prototype.renderColumns = function () {
        var _this = this;
        var columns = this.props.columns;
        return columns.map(function (column, key) {
            return _this.renderColumn(column, key, columns.length);
        });
    };
    HBox.prototype.render = function () {
        var _a = this.props, className = _a.className, cx = _a.classnames;
        return react_1.default.createElement("div", { className: cx("Hbox", className) }, this.renderColumns());
    };
    HBox.propsList = ['columns'];
    HBox.defaultProps = {};
    return HBox;
}(react_1.default.Component));
exports.default = HBox;
var HBoxRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(HBoxRenderer, _super);
    function HBoxRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    HBoxRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)hbox$/,
            name: 'hbox'
        })
    ], HBoxRenderer);
    return HBoxRenderer;
}(HBox));
exports.HBoxRenderer = HBoxRenderer;
//# sourceMappingURL=./renderers/HBox.js.map
