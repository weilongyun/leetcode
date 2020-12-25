"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.FormulaControlRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var Item_1 = require("./Item");
var tpl_1 = require("../../utils/tpl");
var helper_1 = require("../../utils/helper");
var FormulaControl = /** @class */ (function (_super) {
    tslib_1.__extends(FormulaControl, _super);
    function FormulaControl() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    FormulaControl.prototype.componentDidMount = function () {
        var _a = this.props, formula = _a.formula, data = _a.data, setPrinstineValue = _a.setPrinstineValue, initSet = _a.initSet, condition = _a.condition;
        if (!formula || initSet === false) {
            return;
        }
        else if (condition &&
            !~condition.indexOf('$') &&
            !~condition.indexOf('<%') &&
            !tpl_1.evalJS(condition, data)) {
            return;
        }
        var result = tpl_1.evalJS(formula, data);
        result !== null && setPrinstineValue(result);
    };
    FormulaControl.prototype.componentWillReceiveProps = function (nextProps) {
        var _a = this.props, formula = _a.formula, data = _a.data, onChange = _a.onChange, autoSet = _a.autoSet, value = _a.value, condition = _a.condition;
        if (autoSet !== false &&
            formula &&
            nextProps.formula &&
            helper_1.isObjectShallowModified(data, nextProps.data, false) &&
            value === nextProps.value) {
            var nextResult = tpl_1.evalJS(nextProps.formula, nextProps.data);
            if (condition && nextProps.condition) {
                if (!!~condition.indexOf('$') || !!~condition.indexOf('<%')) {
                    // 使用${xxx}，来监听某个变量的变化
                    if (tpl_1.filter(condition, data) !==
                        tpl_1.filter(nextProps.condition, nextProps.data)) {
                        onChange(nextResult);
                    }
                }
                else if (tpl_1.evalJS(nextProps.condition, nextProps.data)) {
                    // 使用 data.xxx == 'a' 表达式形式来判断
                    onChange(nextResult);
                }
            }
            else {
                var prevResult = tpl_1.evalJS(formula, data);
                if (JSON.stringify(prevResult) !== JSON.stringify(nextResult)) {
                    onChange(nextResult || '');
                }
            }
        }
    };
    FormulaControl.prototype.doAction = function () {
        // 不细化具体是啥动作了，先重新计算，并把值运用上。
        var _a = this.props, formula = _a.formula, data = _a.data, onChange = _a.onChange, autoSet = _a.autoSet, value = _a.value;
        var result = tpl_1.evalJS(formula, data);
        onChange(result);
    };
    FormulaControl.prototype.render = function () {
        return null;
    };
    return FormulaControl;
}(react_1.default.Component));
exports.default = FormulaControl;
var FormulaControlRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(FormulaControlRenderer, _super);
    function FormulaControlRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    FormulaControlRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'formula',
            wrap: false,
            strictMode: false,
            sizeMutable: false
        })
    ], FormulaControlRenderer);
    return FormulaControlRenderer;
}(FormulaControl));
exports.FormulaControlRenderer = FormulaControlRenderer;
//# sourceMappingURL=./renderers/Form/Formula.js.map
