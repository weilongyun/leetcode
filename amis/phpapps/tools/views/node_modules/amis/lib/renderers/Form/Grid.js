"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.GridRenderer = void 0;
var tslib_1 = require("tslib");
var Grid_1 = tslib_1.__importDefault(require("../Grid"));
var Item_1 = require("./Item");
var react_1 = tslib_1.__importDefault(require("react"));
var defaultHorizontal = {
    left: 'col-sm-4',
    right: 'col-sm-8',
    offset: 'col-sm-offset-4'
};
var GridRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(GridRenderer, _super);
    function GridRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    GridRenderer.prototype.renderChild = function (region, node, key, length) {
        var _a = this.props, render = _a.render, renderFormItems = _a.renderFormItems, cx = _a.classnames, $path = _a.$path, itemRender = _a.itemRender, store = _a.store;
        if (node && !node.type && (node.controls || node.tabs || node.feildSet)) {
            return (react_1.default.createElement("div", { className: cx("Grid-form Form--" + (node.mode || 'normal')) }, renderFormItems(node, $path.replace(/^.*form\//, ''), {
                mode: node.mode || 'normal',
                horizontal: node.horizontal || defaultHorizontal,
                store: store,
                data: store.data,
                render: render
            })));
        }
        return itemRender
            ? itemRender(node, key, length, this.props)
            : render(region, node.body || node);
    };
    GridRenderer.propsList = ['columns', 'onChange'];
    GridRenderer.defaultProps = {};
    GridRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'grid',
            strictMode: false,
            sizeMutable: false
        })
    ], GridRenderer);
    return GridRenderer;
}(Grid_1.default));
exports.GridRenderer = GridRenderer;
//# sourceMappingURL=./renderers/Form/Grid.js.map
