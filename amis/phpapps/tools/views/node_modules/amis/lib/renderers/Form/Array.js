"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ArrayControlRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var Item_1 = require("./Item");
var combo_1 = require("../../store/combo");
var Combo_1 = tslib_1.__importDefault(require("./Combo"));
var ArrayControl = /** @class */ (function (_super) {
    tslib_1.__extends(ArrayControl, _super);
    function ArrayControl(props) {
        var _this = _super.call(this, props) || this;
        _this.comboRef = _this.comboRef.bind(_this);
        return _this;
    }
    ArrayControl.prototype.comboRef = function (ref) {
        this.comboInstance = ref;
    };
    ArrayControl.prototype.validate = function (args) {
        var _a;
        return this.comboInstance ? (_a = this.comboInstance).validate.apply(_a, args) : null;
    };
    ArrayControl.prototype.render = function () {
        var _a = this.props, items = _a.items, rest = tslib_1.__rest(_a, ["items"]);
        return (react_1.default.createElement(Combo_1.default, tslib_1.__assign({}, rest, { controls: [items], flat: true, multiple: true, multiLine: false, ref: this.comboRef })));
    };
    return ArrayControl;
}(react_1.default.Component));
exports.default = ArrayControl;
var ArrayControlRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ArrayControlRenderer, _super);
    function ArrayControlRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ArrayControlRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'array',
            storeType: combo_1.ComboStore.name
        })
    ], ArrayControlRenderer);
    return ArrayControlRenderer;
}(ArrayControl));
exports.ArrayControlRenderer = ArrayControlRenderer;
//# sourceMappingURL=./renderers/Form/Array.js.map
