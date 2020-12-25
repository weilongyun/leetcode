"use strict";
/**
 * @file Overlay
 * @description
 * @author fex
 */
Object.defineProperty(exports, "__esModule", { value: true });
var tslib_1 = require("tslib");
var react_overlays_1 = require("react-overlays");
var react_dom_1 = require("react-dom");
var react_1 = tslib_1.__importDefault(require("react"));
var dom_1 = require("../utils/dom");
var helper_1 = require("../utils/helper");
var resize_sensor_1 = require("../utils/resize-sensor");
// @ts-ignore
react_overlays_1.Position.propTypes.placement = function () { return null; };
// @ts-ignore
var Position = /** @class */ (function (_super) {
    tslib_1.__extends(Position, _super);
    function Position() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    Position.prototype.updatePosition = function (target) {
        var _this = this;
        var _a;
        this._lastTarget = target;
        if (!target) {
            return this.setState({
                positionLeft: 0,
                positionTop: 0,
                arrowOffsetLeft: null,
                arrowOffsetTop: null
            });
        }
        var watchTargetSizeChange = this.props.watchTargetSizeChange;
        var overlay = react_dom_1.findDOMNode(this);
        var container = dom_1.getContainer(this.props.container, dom_1.ownerDocument(this).body);
        if ((!this.watchedTarget || this.watchedTarget !== target) &&
            resize_sensor_1.getComputedStyle(target, 'position') !== 'static') {
            (_a = this.resizeDispose) === null || _a === void 0 ? void 0 : _a.forEach(function (fn) { return fn(); });
            this.watchedTarget = target;
            this.resizeDispose = [
                watchTargetSizeChange !== false
                    ? resize_sensor_1.resizeSensor(target, function () { return _this.updatePosition(target); })
                    : helper_1.noop,
                resize_sensor_1.resizeSensor(overlay, function () { return _this.updatePosition(target); })
            ];
        }
        this.setState(dom_1.calculatePosition(this.props.placement, overlay, target, container, this.props.containerPadding));
    };
    Position.prototype.componentWillUnmount = function () {
        var _a;
        (_a = this.resizeDispose) === null || _a === void 0 ? void 0 : _a.forEach(function (fn) { return fn(); });
    };
    return Position;
}(react_overlays_1.Position));
var Overlay = /** @class */ (function (_super) {
    tslib_1.__extends(Overlay, _super);
    function Overlay(props) {
        var _this = _super.call(this, props) || this;
        _this.state = {
            exited: !props.show
        };
        return _this;
    }
    Overlay.prototype.componentWillReceiveProps = function (nextProps) {
        if (nextProps.show) {
            this.setState({ exited: false });
        }
        else if (!nextProps.transition) {
            // Otherwise let handleHidden take care of marking exited.
            this.setState({ exited: true });
        }
    };
    Overlay.prototype.onHiddenListener = function (node) {
        this.setState({ exited: true });
        if (this.props.onExited) {
            this.props.onExited(node);
        }
    };
    Overlay.prototype.render = function () {
        var _a = this.props, container = _a.container, containerPadding = _a.containerPadding, target = _a.target, placement = _a.placement, shouldUpdatePosition = _a.shouldUpdatePosition, rootClose = _a.rootClose, children = _a.children, watchTargetSizeChange = _a.watchTargetSizeChange, Transition = _a.transition, props = tslib_1.__rest(_a, ["container", "containerPadding", "target", "placement", "shouldUpdatePosition", "rootClose", "children", "watchTargetSizeChange", "transition"]);
        var mountOverlay = props.show || (Transition && !this.state.exited);
        if (!mountOverlay) {
            // Don't bother showing anything if we don't have to.
            return null;
        }
        var child = children;
        // Position is be inner-most because it adds inline styles into the child,
        // which the other wrappers don't forward correctly.
        child = (
        // @ts-ignore
        react_1.default.createElement(Position, tslib_1.__assign({}, {
            container: container,
            containerPadding: containerPadding,
            target: target,
            placement: placement,
            shouldUpdatePosition: shouldUpdatePosition
        }), child));
        if (Transition) {
            var onExit = props.onExit, onExiting = props.onExiting, onEnter = props.onEnter, onEntering = props.onEntering, onEntered = props.onEntered;
            // This animates the child node by injecting props, so it must precede
            // anything that adds a wrapping div.
            child = (react_1.default.createElement(Transition, { in: props.show, appear: true, onExit: onExit, onExiting: onExiting, onExited: this.onHiddenListener, onEnter: onEnter, onEntering: onEntering, onEntered: onEntered }, child));
        }
        // This goes after everything else because it adds a wrapping div.
        if (rootClose) {
            child = (
            // @ts-ignore
            react_1.default.createElement(react_overlays_1.RootCloseWrapper, { onRootClose: props.onHide }, child));
        }
        // @ts-ignore
        return react_1.default.createElement(react_overlays_1.Portal, { container: container }, child);
    };
    var _a;
    Overlay.defaultProps = {
        placement: 'auto'
    };
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [typeof (_a = typeof HTMLElement !== "undefined" && HTMLElement) === "function" ? _a : Object]),
        tslib_1.__metadata("design:returntype", void 0)
    ], Overlay.prototype, "onHiddenListener", null);
    return Overlay;
}(react_1.default.Component));
exports.default = Overlay;
//# sourceMappingURL=./components/Overlay.js.map
