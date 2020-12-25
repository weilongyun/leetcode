"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ButtonToolbarRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var factory_1 = require("../factory");
var ButtonToolbar = /** @class */ (function (_super) {
    tslib_1.__extends(ButtonToolbar, _super);
    function ButtonToolbar() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ButtonToolbar.prototype.render = function () {
        var _a = this.props, buttons = _a.buttons, className = _a.className, cx = _a.classnames, render = _a.render;
        return (react_1.default.createElement("div", { className: cx('ButtonToolbar', className) }, Array.isArray(buttons)
            ? buttons.map(function (button, key) {
                return render("" + key, button, {
                    key: key
                });
            })
            : null));
    };
    ButtonToolbar.propsList = ['buttons', 'className'];
    return ButtonToolbar;
}(react_1.default.Component));
exports.default = ButtonToolbar;
var ButtonToolbarRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ButtonToolbarRenderer, _super);
    function ButtonToolbarRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ButtonToolbarRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)button-toolbar$/,
            name: 'button-toolbar'
        })
    ], ButtonToolbarRenderer);
    return ButtonToolbarRenderer;
}(ButtonToolbar));
exports.ButtonToolbarRenderer = ButtonToolbarRenderer;
//# sourceMappingURL=./renderers/ButtonToolbar.js.map
