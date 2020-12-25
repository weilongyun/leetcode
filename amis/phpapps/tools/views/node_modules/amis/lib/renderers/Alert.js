"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.TplRenderer = void 0;
var tslib_1 = require("tslib");
var factory_1 = require("../factory");
var react_1 = tslib_1.__importDefault(require("react"));
var Alert2_1 = tslib_1.__importDefault(require("../components/Alert2"));
var TplRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(TplRenderer, _super);
    function TplRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    TplRenderer.prototype.render = function () {
        var _a = this.props, render = _a.render, body = _a.body, rest = tslib_1.__rest(_a, ["render", "body"]);
        return react_1.default.createElement(Alert2_1.default, tslib_1.__assign({}, rest), render('body', body));
    };
    TplRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)alert$/,
            name: 'alert'
        })
    ], TplRenderer);
    return TplRenderer;
}(react_1.default.Component));
exports.TplRenderer = TplRenderer;
//# sourceMappingURL=./renderers/Alert.js.map
