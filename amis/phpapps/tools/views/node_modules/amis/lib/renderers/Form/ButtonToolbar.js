"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ButtonToolbarRenderer = exports.ButtonToolbarControl = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var Item_1 = require("./Item");
var classnames_1 = tslib_1.__importDefault(require("classnames"));
var ButtonToolbarControl = /** @class */ (function (_super) {
    tslib_1.__extends(ButtonToolbarControl, _super);
    function ButtonToolbarControl() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ButtonToolbarControl.prototype.renderButtons = function () {
        var _a = this.props, render = _a.render, ns = _a.classPrefix, buttons = _a.buttons;
        return Array.isArray(buttons)
            ? buttons.map(function (button, key) {
                return render("button/" + key, button, {
                    key: key
                });
            })
            : null;
    };
    ButtonToolbarControl.prototype.render = function () {
        var _a = this.props, render = _a.render, className = _a.className, ns = _a.classPrefix, buttons = _a.buttons;
        return (react_1.default.createElement("div", { className: classnames_1.default(ns + "ButtonToolbar", className) }, this.renderButtons()));
    };
    ButtonToolbarControl.defaultProps = {};
    return ButtonToolbarControl;
}(react_1.default.Component));
exports.ButtonToolbarControl = ButtonToolbarControl;
var ButtonToolbarRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ButtonToolbarRenderer, _super);
    function ButtonToolbarRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ButtonToolbarRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'button-toolbar',
            sizeMutable: false,
            strictMode: false // data 变化也更新
        })
    ], ButtonToolbarRenderer);
    return ButtonToolbarRenderer;
}(ButtonToolbarControl));
exports.ButtonToolbarRenderer = ButtonToolbarRenderer;
//# sourceMappingURL=./renderers/Form/ButtonToolbar.js.map
