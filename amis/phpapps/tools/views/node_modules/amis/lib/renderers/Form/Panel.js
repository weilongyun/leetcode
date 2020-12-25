"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.PanelRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var factory_1 = require("../../factory");
var Panel_1 = tslib_1.__importDefault(require("../Panel"));
var classnames_1 = tslib_1.__importDefault(require("classnames"));
var PanelRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(PanelRenderer, _super);
    function PanelRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    PanelRenderer.prototype.renderBody = function () {
        var _a = this.props, render = _a.render, renderFormItems = _a.renderFormItems, body = _a.body, bodyClassName = _a.bodyClassName, controls = _a.controls, tabs = _a.tabs, fieldSet = _a.fieldSet, mode = _a.mode, formMode = _a.formMode, horizontal = _a.horizontal, $path = _a.$path, ns = _a.classPrefix;
        if (!body && (controls || tabs || fieldSet)) {
            var props = {};
            mode && (props.mode = mode);
            horizontal && (props.horizontal = horizontal);
            return (react_1.default.createElement("div", { className: classnames_1.default(ns + "Form--" + (props.mode || formMode || 'normal'), bodyClassName) }, renderFormItems({
                controls: controls,
                tabs: tabs,
                fieldSet: fieldSet
            }, $path.replace(/^.*form\//, ''), props)));
        }
        return _super.prototype.renderBody.call(this);
    };
    PanelRenderer.propsList = ['onChange'];
    PanelRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)form(?:\/.+)?\/control\/(?:\d+\/)?panel$/,
            weight: -100,
            name: 'panel-control'
        })
    ], PanelRenderer);
    return PanelRenderer;
}(Panel_1.default));
exports.PanelRenderer = PanelRenderer;
//# sourceMappingURL=./renderers/Form/Panel.js.map
