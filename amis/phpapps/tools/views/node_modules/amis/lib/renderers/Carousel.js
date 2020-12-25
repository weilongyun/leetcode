"use strict";
var _a;
Object.defineProperty(exports, "__esModule", { value: true });
exports.CarouselRenderer = exports.Carousel = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var Transition_1 = tslib_1.__importStar(require("react-transition-group/Transition"));
var factory_1 = require("../factory");
var tpl_builtin_1 = require("../utils/tpl-builtin");
var helper_1 = require("../utils/helper");
var icons_1 = require("../components/icons");
var animationStyles = (_a = {},
    _a[Transition_1.ENTERING] = 'in',
    _a[Transition_1.ENTERED] = 'in',
    _a[Transition_1.EXITING] = 'out',
    _a);
var defaultSchema = {
    type: 'tpl',
    tpl: "\n    <% if (data.hasOwnProperty('image')) { %>\n        <div style=\"background-image: url('<%= data.image %>'); background-size: contain; background-repeat: no-repeat; background-position: center center;\" class=\"image <%= data.imageClassName %>\"></div>\n        <% if (data.hasOwnProperty('title')) { %>\n            <div class=\"title <%= data.titleClassName %>\"><%= data.title %></div>\n        <% } if (data.hasOwnProperty('description')) { %> \n            <div class=\"description <%= data.descriptionClassName %>\"><%= data.description %></div> \n        <% } %>\n    <% } else if (data.hasOwnProperty('html')) { %>\n        <%= data.html %>\"\n    <% } else if (data.hasOwnProperty('image')) { %>\n        <div style=\"background-image: url('<%= data.image %>')\" class=\"image <%= data.imageClassName %>\"></div>\n        <% if (data.title) { %>\n            <div class=\"title <%= data.titleClassName %>\"><%= data.title %></div>\n        <% } if (data.description) { %> \n            <div class=\"description <%= data.descriptionClassName %>\"><%= data.description %></div> \n        <% } %>\n    <% } else if (data.hasOwnProperty('html')) { %>\n        <%= data.html %>\n    <% } else if (data.hasOwnProperty('item')) { %>\n        <%= data.item %>\n    <% } else { %>\n        <%= '\u672A\u627E\u5230\u6E32\u67D3\u6570\u636E' %>\n    <% } %>\n    "
};
var Carousel = /** @class */ (function (_super) {
    tslib_1.__extends(Carousel, _super);
    function Carousel() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.wrapperRef = react_1.default.createRef();
        _this.state = {
            current: 0,
            options: _this.props.value ||
                _this.props.options ||
                tpl_builtin_1.resolveVariable(_this.props.name, _this.props.data) ||
                [],
            showArrows: false,
            nextAnimation: ''
        };
        return _this;
    }
    Carousel.prototype.componentWillReceiveProps = function (nextProps) {
        var currentOptions = this.state.options;
        var nextOptions = nextProps.value ||
            nextProps.options ||
            tpl_builtin_1.resolveVariable(nextProps.name, nextProps.data) ||
            [];
        if (helper_1.isArrayChildrenModified(currentOptions, nextOptions)) {
            this.setState({
                options: nextOptions
            });
        }
    };
    Carousel.prototype.componentDidMount = function () {
        this.prepareAutoSlide();
    };
    Carousel.prototype.componentWillUnmount = function () {
        this.clearAutoTimeout();
    };
    Carousel.prototype.prepareAutoSlide = function () {
        if (this.state.options.length < 2) {
            return;
        }
        this.clearAutoTimeout();
        if (this.props.auto) {
            this.intervalTimeout = setTimeout(this.autoSlide, this.props.interval);
        }
    };
    Carousel.prototype.autoSlide = function (rel) {
        this.clearAutoTimeout();
        var animation = this.props.animation;
        var nextAnimation = this.state.nextAnimation;
        switch (rel) {
            case 'prev':
                animation === 'slide'
                    ? (nextAnimation = 'slideRight')
                    : (nextAnimation = '');
                this.transitFramesTowards('right', nextAnimation);
                break;
            case 'next':
            default:
                nextAnimation = '';
                this.transitFramesTowards('left', nextAnimation);
                break;
        }
        this.durationTimeout = setTimeout(this.prepareAutoSlide, this.props.duration);
    };
    Carousel.prototype.transitFramesTowards = function (direction, nextAnimation) {
        var current = this.state.current;
        switch (direction) {
            case 'left':
                current = this.getFrameId('next');
                break;
            case 'right':
                current = this.getFrameId('prev');
                break;
        }
        this.setState({
            current: current,
            nextAnimation: nextAnimation
        });
    };
    Carousel.prototype.getFrameId = function (pos) {
        var _a = this.state, options = _a.options, current = _a.current;
        var total = options.length;
        switch (pos) {
            case 'prev':
                return (current - 1 + total) % total;
            case 'next':
                return (current + 1) % total;
            default:
                return current;
        }
    };
    Carousel.prototype.next = function () {
        this.autoSlide('next');
    };
    Carousel.prototype.prev = function () {
        this.autoSlide('prev');
    };
    Carousel.prototype.clearAutoTimeout = function () {
        clearTimeout(this.intervalTimeout);
        clearTimeout(this.durationTimeout);
    };
    Carousel.prototype.renderDots = function () {
        var cx = this.props.classnames;
        var _a = this.state, current = _a.current, options = _a.options;
        return (react_1.default.createElement("div", { className: cx('Carousel-dotsControl'), onMouseEnter: this.handleMouseEnter, onMouseLeave: this.handleMouseLeave }, Array.from({ length: options.length }).map(function (_, i) { return (react_1.default.createElement("span", { key: i, className: cx('Carousel-dot', current === i ? 'is-active' : '') })); })));
    };
    Carousel.prototype.renderArrows = function () {
        var cx = this.props.classnames;
        return (react_1.default.createElement("div", { className: cx('Carousel-arrowsControl'), onMouseEnter: this.handleMouseEnter, onMouseLeave: this.handleMouseLeave },
            react_1.default.createElement("div", { className: cx('Carousel-leftArrow'), onClick: this.prev },
                react_1.default.createElement(icons_1.Icon, { icon: "left-arrow", className: "icon" })),
            react_1.default.createElement("div", { className: cx('Carousel-rightArrow'), onClick: this.next },
                react_1.default.createElement(icons_1.Icon, { icon: "right-arrow", className: "icon" }))));
    };
    Carousel.prototype.handleMouseEnter = function () {
        this.setState({
            showArrows: true
        });
        this.clearAutoTimeout();
    };
    Carousel.prototype.handleMouseLeave = function () {
        this.setState({
            showArrows: false
        });
        this.prepareAutoSlide();
    };
    Carousel.prototype.render = function () {
        var _this = this;
        var _a = this.props, render = _a.render, className = _a.className, cx = _a.classnames, itemSchema = _a.itemSchema, animation = _a.animation, width = _a.width, height = _a.height, controls = _a.controls, controlsTheme = _a.controlsTheme, placeholder = _a.placeholder, data = _a.data, name = _a.name;
        var _b = this.state, options = _b.options, showArrows = _b.showArrows, current = _b.current, nextAnimation = _b.nextAnimation;
        var body = null;
        var carouselStyles = {};
        width ? (carouselStyles.width = width + 'px') : '';
        height ? (carouselStyles.height = height + 'px') : '';
        var _c = [
            controls.indexOf('dots') > -1,
            controls.indexOf('arrows') > -1
        ], dots = _c[0], arrows = _c[1];
        var animationName = nextAnimation || animation;
        if (Array.isArray(options) && options.length) {
            body = (react_1.default.createElement("div", { ref: this.wrapperRef, className: cx('Carousel-container'), onMouseEnter: this.handleMouseEnter, onMouseLeave: this.handleMouseLeave },
                options.map(function (option, key) { return (react_1.default.createElement(Transition_1.default, { mountOnEnter: true, unmountOnExit: true, in: key === current, timeout: 500, key: key }, function (status) {
                    var _a;
                    if (status === Transition_1.ENTERING) {
                        _this.wrapperRef.current &&
                            _this.wrapperRef.current.childNodes.forEach(function (item) { return item.offsetHeight; });
                    }
                    return (react_1.default.createElement("div", { className: cx('Carousel-item', animationName, animationStyles[status]) }, render(current + "/body", itemSchema ? itemSchema : defaultSchema, {
                        data: helper_1.createObject(data, helper_1.isObject(option)
                            ? option
                            : (_a = { item: option }, _a[name] = option, _a))
                    })));
                })); }),
                dots ? this.renderDots() : null,
                arrows && showArrows ? this.renderArrows() : null));
        }
        return (react_1.default.createElement("div", { className: cx("Carousel Carousel--" + controlsTheme, className), style: carouselStyles }, body ? body : placeholder));
    };
    Carousel.defaultProps = {
        auto: true,
        interval: 5000,
        duration: 500,
        controlsTheme: 'light',
        animation: 'fade',
        controls: ['dots', 'arrows'],
        placeholder: '-'
    };
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", []),
        tslib_1.__metadata("design:returntype", void 0)
    ], Carousel.prototype, "prepareAutoSlide", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [String]),
        tslib_1.__metadata("design:returntype", void 0)
    ], Carousel.prototype, "autoSlide", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [String, String]),
        tslib_1.__metadata("design:returntype", void 0)
    ], Carousel.prototype, "transitFramesTowards", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [String]),
        tslib_1.__metadata("design:returntype", void 0)
    ], Carousel.prototype, "getFrameId", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", []),
        tslib_1.__metadata("design:returntype", void 0)
    ], Carousel.prototype, "next", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", []),
        tslib_1.__metadata("design:returntype", void 0)
    ], Carousel.prototype, "prev", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", []),
        tslib_1.__metadata("design:returntype", void 0)
    ], Carousel.prototype, "clearAutoTimeout", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", []),
        tslib_1.__metadata("design:returntype", void 0)
    ], Carousel.prototype, "handleMouseEnter", null);
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", []),
        tslib_1.__metadata("design:returntype", void 0)
    ], Carousel.prototype, "handleMouseLeave", null);
    return Carousel;
}(react_1.default.Component));
exports.Carousel = Carousel;
var CarouselRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(CarouselRenderer, _super);
    function CarouselRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    CarouselRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)carousel/,
            name: 'carousel'
        })
    ], CarouselRenderer);
    return CarouselRenderer;
}(Carousel));
exports.CarouselRenderer = CarouselRenderer;
//# sourceMappingURL=./renderers/Carousel.js.map
