"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ContainerControlRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var classnames_1 = tslib_1.__importDefault(require("classnames"));
var Container_1 = tslib_1.__importDefault(require("../Container"));
var Item_1 = tslib_1.__importDefault(require("./Item"));
var ContainerControlRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ContainerControlRenderer, _super);
    function ContainerControlRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ContainerControlRenderer.prototype.renderBody = function () {
        var _a = this.props, renderFormItems = _a.renderFormItems, body = _a.body, bodyClassName = _a.bodyClassName, controls = _a.controls, tabs = _a.tabs, fieldSet = _a.fieldSet, mode = _a.mode, formMode = _a.formMode, horizontal = _a.horizontal, $path = _a.$path, ns = _a.classPrefix, store = _a.store, render = _a.render;
        if (!body && (controls || tabs || fieldSet)) {
            var props = {
                store: store,
                data: store.data,
                render: render
            };
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
    ContainerControlRenderer.propsList = ['onChange'];
    ContainerControlRenderer = tslib_1.__decorate([
        Item_1.default({
            type: 'container',
            strictMode: false,
            sizeMutable: false
        })
    ], ContainerControlRenderer);
    return ContainerControlRenderer;
}(Container_1.default));
exports.ContainerControlRenderer = ContainerControlRenderer;
//# sourceMappingURL=./renderers/Form/Container.js.map
