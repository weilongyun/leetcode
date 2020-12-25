"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ImagesFieldRenderer = exports.ImagesField = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var factory_1 = require("../factory");
var tpl_1 = require("../utils/tpl");
var tpl_builtin_1 = require("../utils/tpl-builtin");
var Image_1 = tslib_1.__importStar(require("./Image"));
var helper_1 = require("../utils/helper");
var ImagesField = /** @class */ (function (_super) {
    tslib_1.__extends(ImagesField, _super);
    function ImagesField() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.list = [];
        return _this;
    }
    ImagesField.prototype.handleEnlarge = function (info) {
        var _a = this.props, onImageEnlarge = _a.onImageEnlarge, src = _a.src, originalSrc = _a.originalSrc;
        onImageEnlarge &&
            onImageEnlarge(tslib_1.__assign(tslib_1.__assign({}, info), { originalSrc: info.originalSrc || info.src, list: this.list.map(function (item) { return ({
                    src: src
                        ? tpl_1.filter(src, item, '| raw')
                        : (item && item.image) || item,
                    originalSrc: originalSrc
                        ? tpl_1.filter(originalSrc, item, '| raw')
                        : (item && item.src) || item,
                    title: item && (item.enlargeTitle || item.title),
                    caption: item && (item.enlargeCaption || item.description || item.caption)
                }); }) }), this.props);
    };
    ImagesField.prototype.render = function () {
        var _this = this;
        var _a = this.props, className = _a.className, defaultImage = _a.defaultImage, thumbMode = _a.thumbMode, thumbRatio = _a.thumbRatio, data = _a.data, name = _a.name, value = _a.value, placeholder = _a.placeholder, cx = _a.classnames, source = _a.source, delimiter = _a.delimiter, enlargeAble = _a.enlargeAble, src = _a.src, originalSrc = _a.originalSrc, listClassName = _a.listClassName;
        var list;
        if (typeof source === 'string' && tpl_builtin_1.isPureVariable(source)) {
            list = tpl_builtin_1.resolveVariableAndFilter(source, data, '| raw') || undefined;
        }
        else if (Array.isArray(value)) {
            list = value;
        }
        else if (name && data[name]) {
            list = data[name];
        }
        if (typeof list === 'string') {
            list = list.split(delimiter);
        }
        else if (list && !Array.isArray(list)) {
            list = [list];
        }
        this.list = list;
        return (react_1.default.createElement("div", { className: cx('ImagesField', className) }, Array.isArray(list) ? (react_1.default.createElement("div", { className: cx('Images', listClassName) }, list.map(function (item, index) { return (react_1.default.createElement(Image_1.default, { index: index, className: cx('Images-item'), key: index, src: (src ? tpl_1.filter(src, item, '| raw') : item && item.image) ||
                item, originalSrc: (originalSrc
                ? tpl_1.filter(originalSrc, item, '| raw')
                : item && item.src) || item, title: item && item.title, caption: item && (item.description || item.caption), thumbMode: thumbMode, thumbRatio: thumbRatio, enlargeAble: enlargeAble, onEnlarge: _this.handleEnlarge })); }))) : defaultImage ? (react_1.default.createElement("div", { className: cx('Images', listClassName) },
            react_1.default.createElement(Image_1.default, { className: cx('Images-item'), src: defaultImage, thumbMode: thumbMode, thumbRatio: thumbRatio }))) : (placeholder)));
    };
    var _a;
    ImagesField.defaultProps = {
        className: '',
        delimiter: ',',
        defaultImage: Image_1.imagePlaceholder,
        placehoder: '-',
        thumbMode: 'contain',
        thumbRatio: '1:1'
    };
    tslib_1.__decorate([
        helper_1.autobind,
        tslib_1.__metadata("design:type", Function),
        tslib_1.__metadata("design:paramtypes", [typeof (_a = typeof Image_1.ImageThumbProps !== "undefined" && Image_1.ImageThumbProps) === "function" ? _a : Object]),
        tslib_1.__metadata("design:returntype", void 0)
    ], ImagesField.prototype, "handleEnlarge", null);
    return ImagesField;
}(react_1.default.Component));
exports.ImagesField = ImagesField;
var ImagesFieldRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ImagesFieldRenderer, _super);
    function ImagesFieldRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ImagesFieldRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)images$/,
            name: 'images'
        })
    ], ImagesFieldRenderer);
    return ImagesFieldRenderer;
}(ImagesField));
exports.ImagesFieldRenderer = ImagesFieldRenderer;
//# sourceMappingURL=./renderers/Images.js.map
