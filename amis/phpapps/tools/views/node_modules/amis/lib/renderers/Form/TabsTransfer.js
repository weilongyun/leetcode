"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.TabsTransferRenderer = void 0;
var tslib_1 = require("tslib");
var Options_1 = require("./Options");
var react_1 = tslib_1.__importDefault(require("react"));
var Spinner_1 = tslib_1.__importDefault(require("../../components/Spinner"));
var Transfer_1 = require("./Transfer");
var TabsTransfer_1 = tslib_1.__importDefault(require("../../components/TabsTransfer"));
var TabsTransferRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(TabsTransferRenderer, _super);
    function TabsTransferRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    TabsTransferRenderer.prototype.render = function () {
        var _a = this.props, className = _a.className, cx = _a.classnames, options = _a.options, selectedOptions = _a.selectedOptions, sortable = _a.sortable, loading = _a.loading, searchable = _a.searchable, searchResultMode = _a.searchResultMode, showArrow = _a.showArrow, deferLoad = _a.deferLoad, disabled = _a.disabled;
        return (react_1.default.createElement("div", { className: cx('TabsTransferControl', className) },
            react_1.default.createElement(TabsTransfer_1.default, { value: selectedOptions, disabled: disabled, options: options, onChange: this.handleChange, option2value: this.option2value, sortable: sortable, searchResultMode: searchResultMode, onSearch: searchable ? this.handleSearch : undefined, showArrow: showArrow, onDeferLoad: deferLoad }),
            react_1.default.createElement(Spinner_1.default, { overlay: true, key: "info", show: loading })));
    };
    TabsTransferRenderer = tslib_1.__decorate([
        Options_1.OptionsControl({
            type: 'tabs-transfer'
        })
    ], TabsTransferRenderer);
    return TabsTransferRenderer;
}(Transfer_1.BaseTransferRenderer));
exports.TabsTransferRenderer = TabsTransferRenderer;
//# sourceMappingURL=./renderers/Form/TabsTransfer.js.map
