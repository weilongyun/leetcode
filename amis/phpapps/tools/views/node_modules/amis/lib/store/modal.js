"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.ModalStore = void 0;
var service_1 = require("./service");
var mobx_state_tree_1 = require("mobx-state-tree");
var helper_1 = require("../utils/helper");
exports.ModalStore = service_1.ServiceStore.named('ModalStore')
    .props({
    form: mobx_state_tree_1.types.frozen()
})
    .views(function (self) {
    return {
        get formData() {
            return helper_1.createObject(self.data, self.form);
        }
    };
})
    .actions(function (self) {
    return {
        setFormData: function (obj) {
            self.form = obj;
        }
    };
});
//# sourceMappingURL=./store/modal.js.map
