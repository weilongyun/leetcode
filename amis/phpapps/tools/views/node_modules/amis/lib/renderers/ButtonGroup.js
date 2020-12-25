"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ButtonGroupRenderer = void 0;
var tslib_1 = require("tslib");
var ButtonGroup_1 = tslib_1.__importDefault(require("./Form/ButtonGroup"));
var factory_1 = require("../factory");
exports.default = ButtonGroup_1.default;
var ButtonGroupRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ButtonGroupRenderer, _super);
    function ButtonGroupRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ButtonGroupRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)(?:button|action)\-group$/,
            name: 'button-group'
        })
    ], ButtonGroupRenderer);
    return ButtonGroupRenderer;
}(ButtonGroup_1.default));
exports.ButtonGroupRenderer = ButtonGroupRenderer;
//# sourceMappingURL=./renderers/ButtonGroup.js.map
