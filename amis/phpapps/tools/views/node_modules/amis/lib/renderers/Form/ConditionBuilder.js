"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ConditionBuilderRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var Item_1 = require("./Item");
var index_1 = tslib_1.__importDefault(require("../../components/condition-builder/index"));
var ConditionBuilderControl = /** @class */ (function (_super) {
    tslib_1.__extends(ConditionBuilderControl, _super);
    function ConditionBuilderControl() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ConditionBuilderControl.prototype.render = function () {
        var _a = this.props, className = _a.className, cx = _a.classnames, rest = tslib_1.__rest(_a, ["className", "classnames"]);
        return (react_1.default.createElement("div", { className: cx("ConditionBuilderControl", className) },
            react_1.default.createElement(index_1.default, tslib_1.__assign({}, rest))));
    };
    return ConditionBuilderControl;
}(react_1.default.PureComponent));
exports.default = ConditionBuilderControl;
var ConditionBuilderRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ConditionBuilderRenderer, _super);
    function ConditionBuilderRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ConditionBuilderRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'condition-builder'
        })
    ], ConditionBuilderRenderer);
    return ConditionBuilderRenderer;
}(ConditionBuilderControl));
exports.ConditionBuilderRenderer = ConditionBuilderRenderer;
//# sourceMappingURL=./renderers/Form/ConditionBuilder.js.map
