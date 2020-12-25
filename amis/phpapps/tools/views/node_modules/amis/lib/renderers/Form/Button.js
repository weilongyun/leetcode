"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ResetControlRenderer = exports.SubmitControlRenderer = exports.ButtonControlRenderer = exports.ButtonControl = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var Item_1 = require("./Item");
var ButtonControl = /** @class */ (function (_super) {
    tslib_1.__extends(ButtonControl, _super);
    function ButtonControl() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ButtonControl.prototype.render = function () {
        var _a = this.props, render = _a.render, type = _a.type, children = _a.children, data = _a.data, rest = tslib_1.__rest(_a, ["render", "type", "children", "data"]);
        return render('action', tslib_1.__assign(tslib_1.__assign({}, rest), { type: type }));
    };
    ButtonControl.defaultProps = {};
    return ButtonControl;
}(react_1.default.Component));
exports.ButtonControl = ButtonControl;
var ButtonControlRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ButtonControlRenderer, _super);
    function ButtonControlRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ButtonControlRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'button',
            renderLabel: false,
            strictMode: false,
            sizeMutable: false
        })
    ], ButtonControlRenderer);
    return ButtonControlRenderer;
}(ButtonControl));
exports.ButtonControlRenderer = ButtonControlRenderer;
var SubmitControlRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(SubmitControlRenderer, _super);
    function SubmitControlRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    SubmitControlRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'submit',
            renderLabel: false,
            sizeMutable: false,
            strictMode: false
        })
    ], SubmitControlRenderer);
    return SubmitControlRenderer;
}(ButtonControl));
exports.SubmitControlRenderer = SubmitControlRenderer;
var ResetControlRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ResetControlRenderer, _super);
    function ResetControlRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ResetControlRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'reset',
            renderLabel: false,
            strictMode: false,
            sizeMutable: false
        })
    ], ResetControlRenderer);
    return ResetControlRenderer;
}(ButtonControl));
exports.ResetControlRenderer = ResetControlRenderer;
//# sourceMappingURL=./renderers/Form/Button.js.map
