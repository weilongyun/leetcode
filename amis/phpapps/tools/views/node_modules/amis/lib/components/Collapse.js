"use strict";
/**
 * @file Collapse
 * @description
 * @author fex
 */
var _a;
Object.defineProperty(exports, "__esModule", { value: true });
exports.Collapse = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var index_1 = tslib_1.__importDefault(require("dom-helpers/style/index"));
var theme_1 = require("../theme");
var Transition_1 = tslib_1.__importStar(require("react-transition-group/Transition"));
var helper_1 = require("../utils/helper");
var collapseStyles = (_a = {},
    _a[Transition_1.EXITED] = 'out',
    _a[Transition_1.EXITING] = 'out',
    _a[Transition_1.ENTERING] = 'in',
    _a);
var Collapse = /** @class */ (function (_super) {
    tslib_1.__extends(Collapse, _super);
    function Collapse() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.contentRef = function (ref) { return (_this.contentDom = ref); };
        return _this;
    }
    Collapse.prototype.handleEnter = function (elem) {
        elem.style['height'] = '';
    };
    Collapse.prototype.handleEntering = function (elem) {
        elem.style['height'] = elem['scrollHeight'] + "px";
    };
    Collapse.prototype.handleEntered = function (elem) {
        elem.style['height'] = '';
    };
    Collapse.prototype.handleExit = function (elem) {
        var offsetHeight = elem['offsetHeight'];
        var height = offsetHeight +
            parseInt(index_1.default(elem, 'marginTop'), 10) +
            parseInt(index_1.default(elem, 'marginBottom'), 10);
        elem.style['height'] = height + "px";
        // trigger browser reflow
        elem.offsetHeight;
    };
    Collapse.prototype.handleExiting = function (elem) {
        elem.style['height'] = '';
    };
    Collapse.prototype.render = function () {
        var _this = this;
        var _a = this.props, show = _a.show, children = _a.children, cx = _a.classnames, mountOnEnter = _a.mountOnEnter, unmountOnExit = _a.unmountOnExit;
        return (react_1.default.createElement(Transition_1.default, { mountOnEnter: mountOnEnter, unmountOnExit: unmountOnExit, in: show, timeout: 300, onEnter: this.handleEnter, onEntering: this.handleEntering, onEntered: this.handleEntered, onExit: this.handleExit, onExiting: this.handleExiting }, function (status) {
            if (status === Transition_1.ENTERING) {
                _this.contentDom.offsetWidth;
            }
            return react_1.default.cloneElement(children, tslib_1.__assign(tslib_1.__assign({}, children.props), { ref: _this.contentRef, className: cx('Collapse-content', children.props.className, collapseStyles[status]) }));
        }));
    };
    var _b, _c, _d, _e, _f;
    Collapse.defaultProps = {
        show: false,
        mountOnEnter: false,
        unmountOnExit: false
    };
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [typeof (_b = typeof HTMLElement !== "undefined" && HTMLElement) === "function" ? _b : Object]),
        tslib_1.__metadata("design:returntype", void 0)
    ], Collapse.prototype, "handleEnter", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [typeof (_c = typeof HTMLElement !== "undefined" && HTMLElement) === "function" ? _c : Object]),
        tslib_1.__metadata("design:returntype", void 0)
    ], Collapse.prototype, "handleEntering", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [typeof (_d = typeof HTMLElement !== "undefined" && HTMLElement) === "function" ? _d : Object]),
        tslib_1.__metadata("design:returntype", void 0)
    ], Collapse.prototype, "handleEntered", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [typeof (_e = typeof HTMLElement !== "undefined" && HTMLElement) === "function" ? _e : Object]),
        tslib_1.__metadata("design:returntype", void 0)
    ], Collapse.prototype, "handleExit", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [typeof (_f = typeof HTMLElement !== "undefined" && HTMLElement) === "function" ? _f : Object]),
        tslib_1.__metadata("design:returntype", void 0)
    ], Collapse.prototype, "handleExiting", null);
    return Collapse;
}(react_1.default.Component));
exports.Collapse = Collapse;
exports.default = theme_1.themeable(Collapse);
//# sourceMappingURL=./components/Collapse.js.map
