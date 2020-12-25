"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.SpinnerRenderer = void 0;
var tslib_1 = require("tslib");
var Spinner_1 = tslib_1.__importDefault(require("../components/Spinner"));
var factory_1 = require("../factory");
var react_1 = tslib_1.__importDefault(require("react"));
var SpinnerRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(SpinnerRenderer, _super);
    function SpinnerRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    SpinnerRenderer.prototype.render = function () {
        return react_1.default.createElement(Spinner_1.default, tslib_1.__assign({}, this.props));
    };
    SpinnerRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)spinner$/,
            name: 'spinner'
        })
    ], SpinnerRenderer);
    return SpinnerRenderer;
}(react_1.default.Component));
exports.SpinnerRenderer = SpinnerRenderer;
//# sourceMappingURL=./renderers/Spinner.js.map
