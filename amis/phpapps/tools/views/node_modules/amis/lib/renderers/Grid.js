"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.GridRenderer = exports.ColProps = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var factory_1 = require("../factory");
var pick_1 = tslib_1.__importDefault(require("lodash/pick"));
exports.ColProps = ['lg', 'md', 'sm', 'xs'];
function fromBsClass(cn) {
    if (typeof cn === 'string' && cn) {
        return cn.replace(/\bcol-(xs|sm|md|lg)-(\d+)\b/g, function (_, bp, size) { return "Grid-col--" + bp + size; });
    }
    return cn;
}
function copProps2Class(props) {
    var cns = [];
    var modifiers = exports.ColProps;
    modifiers.forEach(function (modifier) {
        return props &&
            props[modifier] &&
            cns.push("Grid-col--" + modifier + props[modifier]);
    });
    cns.length || cns.push('Grid-col--sm');
    return cns.join(' ');
}
var Grid = /** @class */ (function (_super) {
    tslib_1.__extends(Grid, _super);
    function Grid() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    Grid.prototype.renderChild = function (region, node, key, length) {
        var _a = this.props, render = _a.render, itemRender = _a.itemRender;
        return itemRender
            ? itemRender(node, key, length, this.props)
            : render(region, node);
    };
    Grid.prototype.renderColumn = function (column, key, length) {
        var _this = this;
        var colProps = pick_1.default(column, exports.ColProps);
        colProps = tslib_1.__assign({}, colProps);
        var cx = this.props.classnames;
        return (react_1.default.createElement("div", { key: key, className: cx(copProps2Class(colProps), fromBsClass(column.columnClassName)) }, Array.isArray(column) ? (react_1.default.createElement("div", { className: cx('Grid') }, column.map(function (column, key) {
            return _this.renderColumn(column, key, column.length);
        }))) : (this.renderChild("column/" + key, column, key, length))));
    };
    Grid.prototype.renderColumns = function (columns) {
        var _this = this;
        return columns.map(function (column, key) {
            return _this.renderColumn(column, key, columns.length);
        });
    };
    Grid.prototype.render = function () {
        var _a = this.props, className = _a.className, cx = _a.classnames;
        return (react_1.default.createElement("div", { className: cx('Grid', className) }, this.renderColumns(this.props.columns)));
    };
    Grid.propsList = ['columns'];
    Grid.defaultProps = {};
    return Grid;
}(react_1.default.Component));
exports.default = Grid;
var GridRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(GridRenderer, _super);
    function GridRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    GridRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)grid$/,
            name: 'grid'
        })
    ], GridRenderer);
    return GridRenderer;
}(Grid));
exports.GridRenderer = GridRenderer;
//# sourceMappingURL=./renderers/Grid.js.map
