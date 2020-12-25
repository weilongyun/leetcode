"use strict";
/**
 * @file Rating
 * @description
 * @author fex
 */
Object.defineProperty(exports, "__esModule", { value: true });
exports.Rating = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var classnames_1 = tslib_1.__importDefault(require("classnames"));
var theme_1 = require("../theme");
var Rating = /** @class */ (function (_super) {
    tslib_1.__extends(Rating, _super);
    function Rating(props) {
        var _this = _super.call(this, props) || this;
        _this.state = {
            value: props.value || 0,
            stars: [],
            halfStar: {
                at: Math.floor(props.value),
                hidden: props.half && props.value % 1 < 0.5
            }
        };
        _this.getRate = _this.getRate.bind(_this);
        _this.getStars = _this.getStars.bind(_this);
        _this.moreThanHalf = _this.moreThanHalf.bind(_this);
        _this.mouseOver = _this.mouseOver.bind(_this);
        _this.mouseLeave = _this.mouseLeave.bind(_this);
        _this.handleClick = _this.handleClick.bind(_this);
        return _this;
    }
    Rating.prototype.componentDidMount = function () {
        var value = this.state.value;
        this.setState({
            stars: this.getStars(value)
        });
    };
    Rating.prototype.componentWillReceiveProps = function (props) {
        this.setState({
            stars: this.getStars(props.value),
            value: props.value,
            halfStar: {
                at: Math.floor(props.value),
                hidden: props.half && props.value % 1 < 0.5
            }
        });
    };
    Rating.prototype.getRate = function () {
        var stars;
        var value = this.state.value;
        var half = this.props.half;
        if (half) {
            stars = Math.floor(value);
        }
        else {
            stars = Math.round(value);
        }
        return stars;
    };
    Rating.prototype.getStars = function (activeCount) {
        if (typeof activeCount === 'undefined') {
            activeCount = this.getRate();
        }
        var stars = [];
        var count = this.props.count;
        for (var i = 0; i < count; i++) {
            stars.push({
                active: i <= activeCount - 1
            });
        }
        return stars;
    };
    Rating.prototype.mouseOver = function (event) {
        var _a = this.props, readOnly = _a.readOnly, size = _a.size, half = _a.half;
        if (readOnly)
            return;
        var index = Number(event.target.getAttribute('data-index'));
        if (half) {
            var isAtHalf = this.moreThanHalf(event, size);
            if (isAtHalf)
                index = index + 1;
            this.setState({
                halfStar: {
                    at: index,
                    hidden: isAtHalf
                }
            });
        }
        else {
            index = index + 1;
        }
        this.setState({
            stars: this.getStars(index)
        });
    };
    Rating.prototype.moreThanHalf = function (event, size) {
        var target = event.target;
        var mouseAt = event.clientX - target.getBoundingClientRect().left;
        mouseAt = Math.round(Math.abs(mouseAt));
        return mouseAt > size / 2;
    };
    Rating.prototype.mouseLeave = function () {
        var value = this.state.value;
        var _a = this.props, half = _a.half, readOnly = _a.readOnly;
        if (readOnly)
            return;
        if (half) {
            this.setState({
                halfStar: {
                    at: Math.floor(value),
                    hidden: value % 1 === 0 // check value is decimal or not
                }
            });
        }
        this.setState({
            stars: this.getStars()
        });
    };
    Rating.prototype.handleClick = function (event) {
        var _a = this.props, half = _a.half, readOnly = _a.readOnly, onChange = _a.onChange, size = _a.size;
        if (readOnly)
            return;
        var index = Number(event.target.getAttribute('data-index'));
        var value;
        if (half) {
            var isAtHalf = this.moreThanHalf(event, size);
            if (isAtHalf)
                index = index + 1;
            value = isAtHalf ? index : index + 0.5;
            this.setState({
                halfStar: {
                    at: index,
                    hidden: isAtHalf
                }
            });
        }
        else {
            value = index = index + 1;
        }
        this.setState({
            value: value,
            stars: this.getStars(index)
        });
        onChange && onChange(value);
    };
    Rating.prototype.renderStars = function () {
        var _this = this;
        var _a = this.state, halfStar = _a.halfStar, stars = _a.stars;
        var _b = this.props, char = _b.char, half = _b.half, readOnly = _b.readOnly, cx = _b.classnames;
        return stars.map(function (star, i) {
            var className = cx('Rating', {
                'Rating-half': half && !halfStar.hidden && halfStar.at === i,
                'is-active': star.active,
                'is-disabled': readOnly
            });
            return (react_1.default.createElement("span", { className: className, key: i, "data-index": i, "data-forhalf": char, onMouseOver: _this.mouseOver, onMouseMove: _this.mouseOver, onMouseLeave: _this.mouseLeave, onClick: _this.handleClick }, char));
        });
    };
    Rating.prototype.render = function () {
        var className = this.props.className;
        return (react_1.default.createElement("div", { className: classnames_1.default(className ? className : '') }, this.renderStars()));
    };
    Rating.defaultProps = {
        containerClass: 'rating',
        readOnly: false,
        half: true,
        value: 0,
        count: 5,
        char: '★',
        size: 24
    };
    return Rating;
}(react_1.default.Component));
exports.Rating = Rating;
exports.default = theme_1.themeable(Rating);
//# sourceMappingURL=./components/Rating.js.map
