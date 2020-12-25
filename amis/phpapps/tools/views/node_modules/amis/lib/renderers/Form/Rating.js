"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.RatingControlRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var Item_1 = require("./Item");
var Rating_1 = tslib_1.__importDefault(require("../../components/Rating"));
var RatingControl = /** @class */ (function (_super) {
    tslib_1.__extends(RatingControl, _super);
    function RatingControl() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    RatingControl.prototype.render = function () {
        var _a = this.props, className = _a.className, value = _a.value, count = _a.count, half = _a.half, readOnly = _a.readOnly, onChange = _a.onChange, size = _a.size, cx = _a.classnames;
        return (react_1.default.createElement("div", { className: cx('RatingControl', className) },
            react_1.default.createElement(Rating_1.default, { classnames: cx, value: value, count: count, half: half, readOnly: readOnly, onChange: function (value) { return onChange(value); } })));
    };
    RatingControl.defaultProps = {
        value: 0,
        count: 5,
        half: false,
        readOnly: false
    };
    return RatingControl;
}(react_1.default.Component));
exports.default = RatingControl;
var RatingControlRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(RatingControlRenderer, _super);
    function RatingControlRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    RatingControlRenderer = tslib_1.__decorate([
        Item_1.FormItem({
            type: 'rating',
            sizeMutable: false
        })
    ], RatingControlRenderer);
    return RatingControlRenderer;
}(RatingControl));
exports.RatingControlRenderer = RatingControlRenderer;
//# sourceMappingURL=./renderers/Form/Rating.js.map
