"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.SearchBoxRenderer = void 0;
var tslib_1 = require("tslib");
var factory_1 = require("../factory");
var react_1 = tslib_1.__importDefault(require("react"));
var SearchBox_1 = tslib_1.__importDefault(require("../components/SearchBox"));
var helper_1 = require("../utils/helper");
var SearchBoxRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(SearchBoxRenderer, _super);
    function SearchBoxRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    SearchBoxRenderer.prototype.handleCancel = function () {
        var name = this.props.name;
        var onQuery = this.props.onQuery;
        var data = {};
        helper_1.setVariable(data, name, '');
        onQuery === null || onQuery === void 0 ? void 0 : onQuery(data);
    };
    SearchBoxRenderer.prototype.handleSearch = function (text) {
        var _a = this.props, name = _a.name, onQuery = _a.onQuery;
        var data = {};
        helper_1.setVariable(data, name, text);
        onQuery === null || onQuery === void 0 ? void 0 : onQuery(data);
    };
    SearchBoxRenderer.prototype.render = function () {
        var _a = this.props, data = _a.data, name = _a.name, onQuery = _a.onQuery, mini = _a.mini, searchImediately = _a.searchImediately;
        var value = helper_1.getVariable(data, name);
        return (react_1.default.createElement(SearchBox_1.default, { name: name, disabled: !onQuery, defaultActive: !!value, defaultValue: value, mini: mini, searchImediately: searchImediately, onSearch: this.handleSearch, onCancel: this.handleCancel }));
    };
    SearchBoxRenderer.defaultProps = {
        name: 'keywords',
        mini: false,
        searchImediately: false
    };
    SearchBoxRenderer.propsList = ['mini', 'searchImediately'];
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", []),
        tslib_1.__metadata("design:returntype", void 0)
    ], SearchBoxRenderer.prototype, "handleCancel", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [String]),
        tslib_1.__metadata("design:returntype", void 0)
    ], SearchBoxRenderer.prototype, "handleSearch", null);
    SearchBoxRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)search\-box$/,
            name: 'search'
        })
    ], SearchBoxRenderer);
    return SearchBoxRenderer;
}(react_1.default.Component));
exports.SearchBoxRenderer = SearchBoxRenderer;
//# sourceMappingURL=./renderers/SearchBox.js.map
