/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/cart/NoodleCart.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/cart/NoodleCart.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;
var _NoodleNumberControl = _interopRequireDefault(__webpack_require__(/*! ../components/NoodleNumberControl.vue */ "./resources/apps/web/components/NoodleNumberControl.vue"));
var _CartService = _interopRequireDefault(__webpack_require__(/*! ../CartService */ "./resources/apps/web/CartService.js"));
function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }
var cart = new _CartService["default"]();
var _default = exports["default"] = {
  name: "NoodleCart",
  components: {
    NoodleNumberControl: _NoodleNumberControl["default"]
  },
  data: function data() {
    return {
      visible: false,
      cart_items: [],
      loading: false
    };
  },
  computed: {
    total: function total() {
      var total = 0;
      this.cart_items.forEach(function (item) {
        total += parseFloat(item.subtotal);
      });
      return total.toFixed(2);
    }
  },
  methods: {
    close: function close() {
      this.$emit('input', false);
    },
    removeItem: function removeItem(index) {
      this.cart_items.splice(index, 1);
      var cartItems = cart.getCartItems();
      cartItems.splice(index, 1);
      cart.saveItems(cartItems);
    },
    onQuantityChange: function onQuantityChange(index) {
      var item = this.cart_items[index];
      var cartItems = cart.getCartItems();
      cartItems[index].quantity = item.quantity;
      cart.saveItems(cartItems);
    },
    onCheckout: function onCheckout() {
      window.location.assign('/checkout');
    },
    metaValue: function metaValue(options) {
      return Object.values(options).join(',');
    }
  },
  mounted: function mounted() {
    this.cart_items = cart.getCartItems();
  }
};

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/components/NoodleNumberControl.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/components/NoodleNumberControl.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, exports) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;
var _default = exports["default"] = {
  name: "NoodleNumberControl",
  props: {
    value: {
      type: Number,
      "default": 1
    }
  },
  data: function data() {
    return {
      quantity: 1
    };
  },
  watch: {
    value: function value(val) {
      if (val !== this.quantity) {
        this.quantity = val;
      }
    },
    quantity: function quantity(val) {
      this.$emit('change', val);
    }
  },
  methods: {
    onInput: function onInput() {
      if (!/\d+/.test(this.quantity)) {
        this.quantity = 1;
      }
      if (this.quantity < 1) {
        this.quantity = 1;
      }
      this.$emit('input', this.quantity);
    },
    onDecrease: function onDecrease() {
      if (this.quantity > 1) {
        this.quantity--;
        this.onInput();
      }
    },
    onIncrease: function onIncrease() {
      this.quantity++;
      this.onInput();
    }
  },
  mounted: function mounted() {
    this.quantity = this.value || 1;
  }
};

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/cart/NoodleCart.vue?vue&type=template&id=601e4744&scoped=true":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/cart/NoodleCart.vue?vue&type=template&id=601e4744&scoped=true ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, exports) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports.staticRenderFns = exports.render = void 0;
var render = exports.render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "container"
  }, [!_vm.loading ? _c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-12 col-md-8"
  }, [_c("div", {
    staticClass: "cart-items"
  }, _vm._l(_vm.cart_items, function (item, index) {
    return _c("div", {
      key: index,
      staticClass: "cart-item"
    }, [_c("div", {
      staticClass: "cart-item__remove"
    }, [_c("i", {
      staticClass: "bi bi-x-circle",
      on: {
        click: function click($event) {
          return _vm.removeItem(index);
        }
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "cart-item__image"
    }, [_c("img", {
      attrs: {
        src: item.image,
        alt: ""
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "cart-item__main"
    }, [_c("div", {
      staticClass: "cart-item__title"
    }, [_c("div", {
      staticClass: "title"
    }, [_vm._v(_vm._s(item.title))]), _vm._v(" "), _c("div", {
      staticClass: "metas"
    }, [_vm._v("\n                                " + _vm._s(_vm.metaValue(item.options)) + "\n                            ")])]), _vm._v(" "), _c("div", {
      staticClass: "cart-item__price text-bull-cyan"
    }, [_vm._v("€" + _vm._s(item.price))]), _vm._v(" "), _c("div", {
      staticClass: "cart-item__qty"
    }, [_c("noodle-number-control", {
      on: {
        change: function change($event) {
          return _vm.onQuantityChange(index);
        }
      },
      model: {
        value: item.quantity,
        callback: function callback($$v) {
          _vm.$set(item, "quantity", $$v);
        },
        expression: "item.quantity"
      }
    })], 1)]), _vm._v(" "), _c("div", {
      staticClass: "cart-item__total text-bull-cyan"
    }, [_vm._v("€" + _vm._s(item.subtotal))])]);
  }), 0)]), _vm._v(" "), _c("div", {
    staticClass: "col-12 col-md-4"
  }, [_c("div", {
    staticClass: "cart-totals"
  }, [_c("div", {
    staticClass: "cart-total"
  }, [_c("div", {
    staticClass: "cart-total__label cart-total__total"
  }, [_vm._v("Cart Total")]), _vm._v(" "), _c("div", {
    staticClass: "cart-total__value"
  }, [_vm._v("€" + _vm._s(_vm.total))])])]), _vm._v(" "), _c("div", {
    staticClass: "cart-actions"
  }, [_c("div", {
    staticClass: "cart-action"
  }, [_c("button", {
    staticClass: "btn btn-danger btn-lg text-uppercase",
    on: {
      click: _vm.onCheckout
    }
  }, [_vm._v("Check Out")])])])])]) : _vm._e()]);
};
var staticRenderFns = exports.staticRenderFns = [];
render._withStripped = true;

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/components/NoodleNumberControl.vue?vue&type=template&id=6558ee7c&scoped=true":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/components/NoodleNumberControl.vue?vue&type=template&id=6558ee7c&scoped=true ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, exports) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports.staticRenderFns = exports.render = void 0;
var render = exports.render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c("div", {
    staticClass: "number-control"
  }, [_c("div", {
    staticClass: "number-control__btn",
    on: {
      click: _vm.onDecrease
    }
  }, [_vm._v("-")]), _vm._v(" "), _c("div", {
    staticClass: "number-control__input"
  }, [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.quantity,
      expression: "quantity"
    }],
    staticClass: "number-control__input__input",
    attrs: {
      type: "number",
      min: 1,
      max: 100
    },
    domProps: {
      value: _vm.quantity
    },
    on: {
      change: _vm.onInput,
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.quantity = $event.target.value;
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "number-control__btn",
    on: {
      click: _vm.onIncrease
    }
  }, [_vm._v("+")])]);
};
var staticRenderFns = exports.staticRenderFns = [];
render._withStripped = true;

/***/ }),

/***/ "./resources/apps/web/CartService.js":
/*!*******************************************!*\
  !*** ./resources/apps/web/CartService.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, exports) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
var CartService = exports["default"] = /*#__PURE__*/function () {
  function CartService() {
    _classCallCheck(this, CartService);
    this.cartItems = this.getCartItems();
  }
  _createClass(CartService, [{
    key: "addToCart",
    value: function addToCart(product, price, quantity) {
      var options = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : {};
      var addtional_options = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : [];
      this.cartItems.push({
        product_id: product.id,
        title: product.title,
        image: product.image,
        price: price,
        quantity: quantity,
        options: options,
        addtional_options: addtional_options
      });
      this.updateStorage();
    }
  }, {
    key: "removeFromCart",
    value: function removeFromCart(id) {
      this.cartItems = this.cartItems.filter(function (item) {
        return item.product_id !== id;
      });
      this.updateStorage();
    }
  }, {
    key: "getCartItems",
    value: function getCartItems() {
      try {
        var cartItems = JSON.parse(localStorage.getItem('cartItems'));
        if (Array.isArray(cartItems)) {
          cartItems.forEach(function (item) {
            Object.defineProperty(item, 'subtotal', {
              get: function get() {
                return (Number(this.price) * Number(this.quantity)).toFixed(2);
              }
            });
          });
          return cartItems;
        }
      } catch (e) {
        return [];
      }
    }
  }, {
    key: "saveItems",
    value: function saveItems(items) {
      this.cartItems = items;
      this.updateStorage();
    }
  }, {
    key: "clearCart",
    value: function clearCart() {
      this.cartItems = [];
      this.updateStorage();
    }
  }, {
    key: "updateStorage",
    value: function updateStorage() {
      localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
    }
  }]);
  return CartService;
}();

/***/ }),

/***/ "./resources/apps/web/cart/NoodleCart.vue":
/*!************************************************!*\
  !*** ./resources/apps/web/cart/NoodleCart.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   __esModule: () => (/* reexport safe */ _NoodleCart_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.__esModule),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _NoodleCart_vue_vue_type_template_id_601e4744_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NoodleCart.vue?vue&type=template&id=601e4744&scoped=true */ "./resources/apps/web/cart/NoodleCart.vue?vue&type=template&id=601e4744&scoped=true");
/* harmony import */ var _NoodleCart_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NoodleCart.vue?vue&type=script&lang=js */ "./resources/apps/web/cart/NoodleCart.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _NoodleCart_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _NoodleCart_vue_vue_type_template_id_601e4744_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _NoodleCart_vue_vue_type_template_id_601e4744_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "601e4744",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/apps/web/cart/NoodleCart.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/apps/web/components/NoodleNumberControl.vue":
/*!***************************************************************!*\
  !*** ./resources/apps/web/components/NoodleNumberControl.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   __esModule: () => (/* reexport safe */ _NoodleNumberControl_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.__esModule),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _NoodleNumberControl_vue_vue_type_template_id_6558ee7c_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NoodleNumberControl.vue?vue&type=template&id=6558ee7c&scoped=true */ "./resources/apps/web/components/NoodleNumberControl.vue?vue&type=template&id=6558ee7c&scoped=true");
/* harmony import */ var _NoodleNumberControl_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NoodleNumberControl.vue?vue&type=script&lang=js */ "./resources/apps/web/components/NoodleNumberControl.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _NoodleNumberControl_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _NoodleNumberControl_vue_vue_type_template_id_6558ee7c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _NoodleNumberControl_vue_vue_type_template_id_6558ee7c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "6558ee7c",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/apps/web/components/NoodleNumberControl.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/apps/web/cart/NoodleCart.vue?vue&type=script&lang=js":
/*!************************************************************************!*\
  !*** ./resources/apps/web/cart/NoodleCart.vue?vue&type=script&lang=js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   __esModule: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleCart_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__.__esModule),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleCart_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./NoodleCart.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/cart/NoodleCart.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleCart_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/apps/web/components/NoodleNumberControl.vue?vue&type=script&lang=js":
/*!***************************************************************************************!*\
  !*** ./resources/apps/web/components/NoodleNumberControl.vue?vue&type=script&lang=js ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   __esModule: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleNumberControl_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__.__esModule),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleNumberControl_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./NoodleNumberControl.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/components/NoodleNumberControl.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleNumberControl_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/apps/web/cart/NoodleCart.vue?vue&type=template&id=601e4744&scoped=true":
/*!******************************************************************************************!*\
  !*** ./resources/apps/web/cart/NoodleCart.vue?vue&type=template&id=601e4744&scoped=true ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   __esModule: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleCart_vue_vue_type_template_id_601e4744_scoped_true__WEBPACK_IMPORTED_MODULE_0__.__esModule),
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleCart_vue_vue_type_template_id_601e4744_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleCart_vue_vue_type_template_id_601e4744_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleCart_vue_vue_type_template_id_601e4744_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./NoodleCart.vue?vue&type=template&id=601e4744&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/cart/NoodleCart.vue?vue&type=template&id=601e4744&scoped=true");


/***/ }),

/***/ "./resources/apps/web/components/NoodleNumberControl.vue?vue&type=template&id=6558ee7c&scoped=true":
/*!*********************************************************************************************************!*\
  !*** ./resources/apps/web/components/NoodleNumberControl.vue?vue&type=template&id=6558ee7c&scoped=true ***!
  \*********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   __esModule: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleNumberControl_vue_vue_type_template_id_6558ee7c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.__esModule),
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleNumberControl_vue_vue_type_template_id_6558ee7c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleNumberControl_vue_vue_type_template_id_6558ee7c_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_NoodleNumberControl_vue_vue_type_template_id_6558ee7c_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./NoodleNumberControl.vue?vue&type=template&id=6558ee7c&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/apps/web/components/NoodleNumberControl.vue?vue&type=template&id=6558ee7c&scoped=true");


/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ normalizeComponent)
/* harmony export */ });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent(
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */,
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options =
    typeof scriptExports === 'function' ? scriptExports.options : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) {
    // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
          injectStyles.call(
            this,
            (options.functional ? this.parent : this).$root.$options.shadowRoot
          )
        }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection(h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing ? [].concat(existing, hook) : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!************************************!*\
  !*** ./resources/apps/web/cart.js ***!
  \************************************/


var _NoodleCart = _interopRequireDefault(__webpack_require__(/*! ./cart/NoodleCart.vue */ "./resources/apps/web/cart/NoodleCart.vue"));
function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }
new Vue({
  el: '#cartApp',
  render: function render(h) {
    return h(_NoodleCart["default"]);
  }
});
})();

/******/ })()
;