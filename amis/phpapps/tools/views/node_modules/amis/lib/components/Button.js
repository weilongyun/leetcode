"use strict";
/**
 * @file Button
 * @author fex
 */
Object.defineProperty(exports, "__esModule", { value: true });
exports.Button = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var TooltipWrapper_1 = tslib_1.__importDefault(require("./TooltipWrapper"));
var helper_1 = require("../utils/helper");
var theme_1 = require("../theme");
var Button = /** @class */ (function (_super) {
    tslib_1.__extends(Button, _super);
    function Button() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    Button.prototype.renderButton = function () {
        var _a;
        var _b = this.props, level = _b.level, size = _b.size, disabled = _b.disabled, className = _b.className, Comp = _b.componentClass, cx = _b.classnames, children = _b.children, disabledTip = _b.disabledTip, block = _b.block, type = _b.type, active = _b.active, iconOnly = _b.iconOnly, href = _b.href, rest = tslib_1.__rest(_b, ["level", "size", "disabled", "className", "componentClass", "classnames", "children", "disabledTip", "block", "type", "active", "iconOnly", "href"]);
        if (href) {
            Comp = 'a';
        }
        return (react_1.default.createElement(Comp, tslib_1.__assign({ type: Comp === 'a' ? undefined : type }, helper_1.pickEventsProps(rest), { href: href, className: cx("Button", (_a = {},
                _a["Button--" + level] = level,
                _a["Button--" + size] = size,
                _a["Button--block"] = block,
                _a["Button--iconOnly"] = iconOnly,
                _a['is-disabled'] = disabled,
                _a['is-active'] = active,
                _a), className), disabled: disabled }), children));
    };
    Button.prototype.render = function () {
        var _a = this.props, tooltip = _a.tooltip, placement = _a.placement, tooltipContainer = _a.tooltipContainer, tooltipTrigger = _a.tooltipTrigger, tooltipRootClose = _a.tooltipRootClose, disabled = _a.disabled, disabledTip = _a.disabledTip, classPrefix = _a.classPrefix, cx = _a.classnames;
        return (react_1.default.createElement(TooltipWrapper_1.default, { placement: placement, tooltip: disabled ? disabledTip : tooltip, container: tooltipContainer, trigger: tooltipTrigger, rootClose: tooltipRootClose }, disabled && disabledTip ? (react_1.default.createElement("div", { className: cx('Button--disabled-wrap') }, this.renderButton())) : (this.renderButton())));
    };
    Button.defaultProps = {
        componentClass: 'button',
        level: 'default',
        type: 'button',
        placement: 'top',
        tooltipTrigger: ['hover', 'focus'],
        tooltipRootClose: false
    };
    return Button;
}(react_1.default.Component));
exports.Button = Button;
exports.default = theme_1.themeable(Button);
//# sourceMappingURL=./components/Button.js.map
