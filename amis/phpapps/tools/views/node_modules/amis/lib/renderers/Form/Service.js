"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ServiceRenderer = void 0;
var tslib_1 = require("tslib");
var react_1 = tslib_1.__importDefault(require("react"));
var factory_1 = require("../../factory");
var Service_1 = tslib_1.__importDefault(require("../Service"));
var Scoped_1 = require("../../Scoped");
var service_1 = require("../../store/service");
var helper_1 = require("../../utils/helper");
var ServiceRenderer = /** @class */ (function (_super) {
    tslib_1.__extends(ServiceRenderer, _super);
    function ServiceRenderer() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    ServiceRenderer.prototype.componentWillMount = function () {
        var scoped = this.context;
        scoped.registerComponent(this);
    };
    ServiceRenderer.prototype.componentDidMount = function () {
        var _a = this.props, formInited = _a.formInited, addHook = _a.addHook;
        this.mounted = true;
        // form层级下的所有service应该都会走这里
        // 但是传入props有可能是undefined，所以做个处理
        if (formInited !== false) {
            _super.prototype.componentDidMount.call(this);
        }
        else {
            addHook && addHook(this.initFetch, 'init');
        }
    };
    ServiceRenderer.prototype.componentDidUpdate = function (prevProps) {
        var formInited = this.props.formInited;
        if (formInited !== false) {
            _super.prototype.componentDidUpdate.call(this, prevProps);
        }
    };
    ServiceRenderer.prototype.componentWillUnmount = function () {
        var scoped = this.context;
        scoped.unRegisterComponent(this);
        var removeHook = this.props.removeHook;
        removeHook && removeHook(this.initFetch, 'init');
        _super.prototype.componentWillUnmount.call(this);
    };
    ServiceRenderer.prototype.afterDataFetch = function (payload) {
        var formStore = this.props.formStore;
        var onChange = this.props.onChange;
        // 有可能有很多层 serivce，这里需要注意。
        if (formStore && this.isFormMode()) {
            var keys = helper_1.isObject(payload === null || payload === void 0 ? void 0 : payload.data) ? Object.keys(payload.data) : [];
            if (keys.length) {
                formStore.setValues(payload.data);
                onChange(payload.data[keys[0]], keys[0]);
            }
        }
        return _super.prototype.afterDataFetch.call(this, payload);
    };
    // schema 接口可能会返回数据，需要把它同步到表单上，否则会没用。
    ServiceRenderer.prototype.afterSchemaFetch = function (schema) {
        var formStore = this.props.formStore;
        var onChange = this.props.onChange;
        // 有可能有很多层 serivce，这里需要注意。
        if (formStore && this.isFormMode()) {
            var keys = helper_1.isObject(schema === null || schema === void 0 ? void 0 : schema.data) ? Object.keys(schema.data) : [];
            if (keys.length) {
                formStore.setValues(schema.data);
                onChange(schema.data[keys[0]], keys[0]);
            }
        }
        return _super.prototype.afterSchemaFetch.call(this, schema);
    };
    ServiceRenderer.prototype.isFormMode = function () {
        var _a = this.props, store = _a.store, schema = _a.body, controls = _a.controls, tabs = _a.tabs, feildSet = _a.feildSet, renderFormItems = _a.renderFormItems, cx = _a.classnames;
        var finnalSchema = store.schema ||
            schema || {
            controls: controls,
            tabs: tabs,
            feildSet: feildSet
        };
        return (finnalSchema &&
            !finnalSchema.type &&
            (finnalSchema.controls || finnalSchema.tabs || finnalSchema.feildSet) &&
            renderFormItems);
    };
    ServiceRenderer.prototype.renderBody = function () {
        var _a = this.props, render = _a.render, store = _a.store, schema = _a.body, controls = _a.controls, tabs = _a.tabs, feildSet = _a.feildSet, renderFormItems = _a.renderFormItems, formMode = _a.formMode, cx = _a.classnames;
        if (this.isFormMode()) {
            var finnalSchema = store.schema ||
                schema || {
                controls: controls,
                tabs: tabs,
                feildSet: feildSet
            };
            return (react_1.default.createElement("div", { key: store.schemaKey || 'forms', className: cx("Form--" + (formMode || 'normal')) }, renderFormItems(finnalSchema, 'controls', {
                store: store,
                data: store.data,
                render: render
            })));
        }
        return _super.prototype.renderBody.call(this);
    };
    ServiceRenderer.propsList = ['onChange'];
    ServiceRenderer.contextType = Scoped_1.ScopedContext;
    ServiceRenderer = tslib_1.__decorate([
        factory_1.Renderer({
            test: /(^|\/)form\/(.*)\/service$/,
            weight: -100,
            storeType: service_1.ServiceStore.name,
            storeExtendsData: false,
            name: 'service-control'
        })
    ], ServiceRenderer);
    return ServiceRenderer;
}(Service_1.default));
exports.ServiceRenderer = ServiceRenderer;
//# sourceMappingURL=./renderers/Form/Service.js.map
