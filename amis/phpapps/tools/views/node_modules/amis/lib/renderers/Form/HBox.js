"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.HBoxRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var Item_1 = require("./Item");
var classnames_1 = tslib_1.__importDefault(require("classnames"));
var helper_1 = require("../../utils/helper");
var HBoxRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(HBoxRenderer, _super);
    function HBoxRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    HBoxRenderer.prototype.renderColumn = function (column, key, length) {
        var _a = this.props, itemRender = _a.itemRender, data = _a.data, ns = _a.classPrefix;
        if (!helper_1.isVisible(column, data)) {
            return null;
        }
        var style = tslib_1.__assign({ width: column.width, height: column.height }, column.style);
        return (react_1.default.createElement("div", { key: key, style: style, className: classnames_1.default(ns + "Hbox-col", ns + "Form--" + (column.mode || 'normal'), column.columnClassName) }, itemRender
            ? itemRender(column, key, length, this.props)
            : this.renderChild("column/" + key, column, key)));
    };
    HBoxRenderer.prototype.renderChild = function (region, node, index) {
        var _a = this.props, render = _a.render, renderFormItems = _a.renderFormItems, formMode = _a.formMode, store = _a.store, $path = _a.$path;
        if (node && !node.type && (node.controls || node.tabs || node.feildSet)) {
            return renderFormItems(node, $path.replace(/^.*form\//, ''), {
                mode: node.mode || 'normal',
                horizontal: node.horizontal || {
                    left: 4,
                    right: 8,
                    offset: 4
                },
                store: store,
                data: store.data,
                render: render
            });
        }
        return render(region, node.body || node);
    };
    HBoxRenderer.prototype.renderColumns = function () {
        var _this = this;
        var columns = this.props.columns;
        return columns.map(function (column, key) {
            return _this.renderColumn(column, key, columns.length);
        });
    };
    HBoxRenderer.prototype.render = function () {
        var _a = this.props, className = _a.className, columns = _a.columns, gap = _a.gap, ns = _a.classPrefix;
        return (react_1.default.createElement("div", { className: classnames_1.default(ns + "FormHbox", gap ? ns + "Hbox--" + gap : '', className) },
            react_1.default.createElement("div", { className: ns + "Hbox" }, this.renderColumns())));
    };
    HBoxRenderer.propsList = ['columns', 'onChange'];
    HBoxRenderer.defaultProps = {};
    HBoxRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'hbox',
            strictMode: false,
            sizeMutable: false
        })
    ], HBoxRenderer);
    return HBoxRenderer;
}(react_1.default.Component));
exports.HBoxRenderer = HBoxRenderer;
//# sourceMappingURL=./renderers/Form/HBox.js.map
