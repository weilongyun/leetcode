"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var tslib_1 = require("tslib");
var factory_1 = require("./factory");
var Checkbox_1 = require("./renderers/Form/Checkbox");
var index_1 = require("./renderers/Form/index");
var FieldSet_1 = require("./renderers/Form/FieldSet");
var Tabs_1 = require("./renderers/Form/Tabs");
var Card_1 = require("./renderers/Card");
var List_1 = require("./renderers/List");
var ButtonGroup_1 = require("./renderers/Form/ButtonGroup");
var helper_1 = require("./utils/helper");
var Service_1 = require("./renderers/Form/Service");
// 兼容老的用法，老用法 label 用在 checkbox 的右侧内容，新用法用 option 来代替。
factory_1.addSchemaFilter(function CheckboxPropsFilter(schema, renderer) {
    if (renderer.component !== Checkbox_1.CheckboxControlRenderer) {
        return schema;
    }
    if (schema.label && typeof schema.option === 'undefined') {
        schema = tslib_1.__assign({}, schema);
        schema.option = schema.label;
        delete schema.label;
    }
    return schema;
});
function convertFieldSetTabs2Controls(schema) {
    var toUpdate = {};
    var flag = false;
    toUpdate.controls = Array.isArray(schema.controls)
        ? schema.controls.concat()
        : [];
    toUpdate.controls = toUpdate.controls.map(function (control) {
        if (Array.isArray(control)) {
            var converted = convertFieldSetTabs2Controls({
                type: 'group',
                controls: control
            });
            if (converted !== control) {
                flag = true;
            }
            return converted;
        }
        return control;
    });
    schema.fieldSet &&
        (Array.isArray(schema.fieldSet)
            ? schema.fieldSet
            : [schema.fieldSet]).forEach(function (fieldSet) {
            flag = true;
            toUpdate.controls.push(tslib_1.__assign(tslib_1.__assign({}, convertFieldSetTabs2Controls(fieldSet)), { type: 'fieldSet', collapsable: schema.collapsable }));
        });
    schema.tabs &&
        (flag = true) &&
        toUpdate.controls.push({
            type: 'tabs',
            tabs: schema.tabs.map(function (tab) { return convertFieldSetTabs2Controls(tab); })
        });
    if (flag) {
        schema = tslib_1.__assign(tslib_1.__assign({}, schema), toUpdate);
        delete schema.fieldSet;
        delete schema.tabs;
    }
    return schema;
}
// Form 中，把 fieldSet 和 tabs 转成 {type: 'fieldSet', controls: []}
// 同时把数组用法转成 {type: 'group', controls: []}
factory_1.addSchemaFilter(function FormPropsFilter(schema, renderer) {
    if (renderer.component !== index_1.FormRenderer) {
        return schema;
    }
    if (schema.fieldSet || schema.tabs) {
        // console.warn('Form 下面直接用 fieldSet 或者 tabs 将不支持，请改成在 controls 数组中添加。');
        schema = convertFieldSetTabs2Controls(schema);
    }
    else if (Array.isArray(schema.controls)) {
        var flag_1 = false;
        var converted = schema.controls.map(function (control) {
            if (Array.isArray(control)) {
                var converted_1 = convertFieldSetTabs2Controls({
                    type: 'group',
                    controls: control
                });
                if (converted_1 !== control) {
                    flag_1 = true;
                }
                return converted_1;
            }
            return control;
        });
        if (flag_1) {
            schema = tslib_1.__assign(tslib_1.__assign({}, schema), { controls: converted });
        }
    }
    return schema;
});
// FieldSet 中把 controls 里面的数组用法转成 {type: 'group', controls: []}
factory_1.addSchemaFilter(function FormPropsFilter(schema, renderer) {
    if (renderer.component !== FieldSet_1.FieldSetRenderer) {
        return schema;
    }
    if (Array.isArray(schema.controls)) {
        var flag_2 = false;
        var converted = schema.controls.map(function (control) {
            if (Array.isArray(control)) {
                var converted_2 = convertFieldSetTabs2Controls({
                    type: 'group',
                    controls: control
                });
                if (converted_2 !== control) {
                    flag_2 = true;
                }
                return converted_2;
            }
            return control;
        });
        if (flag_2) {
            schema = tslib_1.__assign(tslib_1.__assign({}, schema), { controls: converted });
        }
    }
    return schema;
});
// Form 里面的 Tabs 中把 controls 里面的数组用法转成 {type: 'group', controls: []}
factory_1.addSchemaFilter(function FormPropsFilter(schema, renderer) {
    if (renderer.component !== Tabs_1.TabsRenderer) {
        return schema;
    }
    if (Array.isArray(schema.tabs)) {
        var flag_3 = false;
        var converted = schema.tabs.map(function (tab) {
            var flag2 = false;
            var converted = (tab.controls || []).map(function (control) {
                if (Array.isArray(control)) {
                    var converted_3 = convertFieldSetTabs2Controls({
                        type: 'group',
                        controls: control
                    });
                    if (converted_3 !== control) {
                        flag2 = true;
                    }
                    return converted_3;
                }
                return control;
            });
            if (flag2) {
                flag_3 = true;
                tab = tslib_1.__assign(tslib_1.__assign({}, tab), { controls: converted });
            }
            return tab;
        });
        if (flag_3) {
            schema = tslib_1.__assign(tslib_1.__assign({}, schema), { tabs: converted });
        }
    }
    return schema;
});
function convertArray2Hbox(arr) {
    var flag = false;
    var converted = arr.map(function (item) {
        if (Array.isArray(item)) {
            flag = true;
            return convertArray2Hbox(item);
        }
        return item;
    });
    if (!flag) {
        converted = arr;
    }
    return {
        type: 'hbox',
        columns: converted
    };
}
// CRUD/List  和 CRUD/Card 的 body 中的数组用法转成 hbox
factory_1.addSchemaFilter(function (schema, renderer) {
    if (renderer.component !== Card_1.CardRenderer &&
        renderer.component !== List_1.ListItemRenderer) {
        return schema;
    }
    if (Array.isArray(schema.body)) {
        var flag_4 = false;
        var converted = schema.body.map(function (item) {
            if (Array.isArray(item)) {
                flag_4 = true;
                return convertArray2Hbox(item);
            }
            return item;
        });
        if (flag_4) {
            schema = tslib_1.__assign(tslib_1.__assign({}, schema), { body: converted });
        }
    }
    return schema;
});
// button group 的 btnClassName 和 btnActiveClassName 改成 btnLevel 和 btnActiveLevel 了
factory_1.addSchemaFilter(function (scheam, renderer) {
    if (renderer.component !== ButtonGroup_1.ButtonGroupControlRenderer) {
        return scheam;
    }
    if (scheam.btnClassName || scheam.btnActiveClassName) {
        scheam = tslib_1.__assign(tslib_1.__assign({}, scheam), { btnLevel: helper_1.getLevelFromClassName(scheam.btnClassName), btnActiveLevel: helper_1.getLevelFromClassName(scheam.btnActiveClassName) });
        delete scheam.btnClassName;
        delete scheam.btnActiveClassName;
    }
    return scheam;
});
// FieldSet  className 定制样式方式改成 size 来配置
factory_1.addSchemaFilter(function (scheam, renderer) {
    if (renderer.component !== FieldSet_1.FieldSetRenderer) {
        return scheam;
    }
    if (scheam.className &&
        !scheam.size &&
        /\bfieldset(?:\-(xs|sm|md|lg))?\b/.test(scheam.className)) {
        scheam = tslib_1.__assign(tslib_1.__assign({}, scheam), { size: RegExp.$1 || 'base', className: scheam.className.replace(/\bfieldset(?:\-(xs|sm|md|lg))?\b/, '') });
        delete scheam.btnClassName;
        delete scheam.btnActiveClassName;
    }
    return scheam;
});
// FieldSet  className 定制样式方式改成 size 来配置
factory_1.addSchemaFilter(function (scheam, renderer) {
    if (renderer.component !== Service_1.ServiceRenderer) {
        return scheam;
    }
    if (scheam.body && scheam.body.controls) {
        scheam = tslib_1.__assign(tslib_1.__assign({}, scheam), { controls: scheam.body.controls });
        delete scheam.body;
    }
    return scheam;
});
//# sourceMappingURL=./compat.js.map
