(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Users.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/profile/Users.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _models_User__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../models/User */ "./resources/js/models/User.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
  name: "TextileTypes",
  data: function data() {
    return {
      headers: [{
        text: "Name",
        value: "name"
      }, {
        text: "Email",
        value: "email",
        sortable: false
      }, {
        text: "Password",
        value: "password",
        sortable: false
      }, {
        text: "Role",
        value: "role.name"
      }, {
        text: "Action",
        value: "action"
      }],
      users: [],
      user: new _models_User__WEBPACK_IMPORTED_MODULE_1__["default"](),
      roles: [{
        text: "Admin",
        value: 1
      }, {
        text: "Customer",
        value: 2
      }, {
        text: "Distributor",
        value: 3
      }],
      dialog: false,
      mode: 0,
      errorMessage: "",
      valid: false,
      nameRules: [function (v) {
        return !!v || "This field is required";
      }],
      emailRules: [function (v) {
        return !!v || "This field is required";
      }, function (v) {
        return /.+@.+/.test(v) || "E-mail must be valid";
      }]
    };
  },
  computed: {
    title: function title() {
      return this.mode === 1 ? "New User" : "Update User";
    }
  },
  methods: {
    getUsers: function getUsers() {
      var _this = this;

      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get("/api/profile/users").then(function (res) {
        return _this.users = res.data;
      })["catch"](function (err) {
        return console.error(err.response.data);
      });
    },
    open: function open(item, mode) {
      this.user = new _models_User__WEBPACK_IMPORTED_MODULE_1__["default"](item);
      this.mode = mode;
      this.dialog = true;
    },
    save: function save() {
      var _this2 = this;

      var fd = {};
      var dist = new FormData();
      fd.name = this.user.name;
      fd.email = this.user.email;
      fd.password = this.user.password;
      fd.password_confirmation = this.user.password_confirmation;
      fd.role_id = this.user.role_id;
      fd.status = this.user.status;
      dist.append("company", this.user.distributor.company);
      dist.append("director", this.user.distributor.director);
      dist.append("address", this.user.distributor.address);
      dist.append("phone", this.user.distributor.phone);
      dist.append("tax_code", this.user.distributor.tax_code);
      dist.append("bank_name", this.user.distributor.bank_name);
      dist.append("IBAN", this.user.distributor.IBAN);
      dist.append("website", this.user.distributor.website);
      dist.append("description", this.user.distributor.description);
      dist.append("image", this.user.distributor.imageFile);
      dist.append("user", []); // dist.user = fd;
      // console.log(dist);

      if (this.mode === 1) {
        axios__WEBPACK_IMPORTED_MODULE_0___default.a.post("/api/profile/users/create", dist).then(function (res) {
          _this2.users.push(res.data);

          _this2.user = new _models_User__WEBPACK_IMPORTED_MODULE_1__["default"]();
          _this2.dialog = false;
        })["catch"](function (err) {
          return _this2.errorMessage = err.response.data;
        });
      } else {
        axios__WEBPACK_IMPORTED_MODULE_0___default.a.put("url", fd).then(function (res) {
          var index = _this2.users.findIndex(function (user) {
            return user._id === res.data._id;
          });

          _this2.users.splice(index, 1, res.data);

          _this2.user = new _models_User__WEBPACK_IMPORTED_MODULE_1__["default"]();
          _this2.dialog = false;
        })["catch"](function (err) {
          return _this2.errorMessage = err.response.data;
        });
      }
    },
    remove: function remove(item) {
      var _this3 = this;

      confirm("Are you sure you want to delete this user?") && axios__WEBPACK_IMPORTED_MODULE_0___default.a["delete"]("url").then(function (res) {
        var index = _this3.users.findIndex(function (user) {
          return user._id === res.data._id;
        });

        _this3.users.splice(index, 1);
      })["catch"](function (err) {
        return console.error(err.response.data);
      });
    },
    onFileSelected: function onFileSelected(event) {
      var _this4 = this;

      this.user.distributor.imageFile = event;
      var reader = new FileReader();
      reader.readAsDataURL(this.user.distributor.imageFile);

      reader.onload = function (e) {
        return _this4.user.distributor.image = e.target.result;
      };
    }
  },
  created: function created() {
    this.getUsers();
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/profile/Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.border-bottom[data-v-22655672] {\r\n    border-bottom: 1px solid rgba(0, 0, 0, 0.12);\n}\r\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--6-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--6-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/profile/Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Users.vue?vue&type=template&id=22655672&scoped=true&":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/profile/Users.vue?vue&type=template&id=22655672&scoped=true& ***!
  \****************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-container",
    { staticClass: "px-0", attrs: { fluid: "" } },
    [
      _c(
        "v-card",
        { attrs: { tile: "", outlined: "" } },
        [
          _c("v-data-table", {
            attrs: { headers: _vm.headers, items: _vm.users },
            scopedSlots: _vm._u([
              {
                key: "top",
                fn: function() {
                  return [
                    _c(
                      "v-card",
                      {
                        staticClass: "border-bottom",
                        attrs: { tile: "", flat: "" }
                      },
                      [
                        _c(
                          "v-toolbar",
                          { attrs: { flat: "" } },
                          [
                            _c("v-toolbar-title", [_vm._v("Users")]),
                            _vm._v(" "),
                            _c("v-spacer"),
                            _vm._v(" "),
                            _c(
                              "v-btn",
                              {
                                staticClass: "mr-5",
                                attrs: { outlined: "", color: "#347cbb" },
                                on: {
                                  click: function($event) {
                                    return _vm.open({}, 1)
                                  }
                                }
                              },
                              [_vm._v("new user")]
                            )
                          ],
                          1
                        )
                      ],
                      1
                    )
                  ]
                },
                proxy: true
              },
              {
                key: "item.action",
                fn: function(ref) {
                  var item = ref.item
                  return [
                    _c(
                      "v-tooltip",
                      {
                        attrs: { bottom: "" },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "activator",
                              fn: function(ref) {
                                var on = ref.on
                                return [
                                  _c(
                                    "v-icon",
                                    _vm._g(
                                      {
                                        staticClass: "mr-2",
                                        attrs: { color: "yellow darken-3" },
                                        on: {
                                          click: function($event) {
                                            return _vm.open(item, 2)
                                          }
                                        }
                                      },
                                      on
                                    ),
                                    [
                                      _vm._v(
                                        "\n                            mdi-pencil-outline\n                        "
                                      )
                                    ]
                                  )
                                ]
                              }
                            }
                          ],
                          null,
                          true
                        )
                      },
                      [_vm._v(" "), _c("span", [_vm._v("Update")])]
                    ),
                    _vm._v(" "),
                    _c(
                      "v-tooltip",
                      {
                        attrs: { bottom: "" },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "activator",
                              fn: function(ref) {
                                var on = ref.on
                                return [
                                  _c(
                                    "v-icon",
                                    _vm._g(
                                      {
                                        attrs: { color: "red" },
                                        on: {
                                          click: function($event) {
                                            return _vm.remove(item)
                                          }
                                        }
                                      },
                                      on
                                    ),
                                    [
                                      _vm._v(
                                        "\n                            mdi-delete-outline\n                        "
                                      )
                                    ]
                                  )
                                ]
                              }
                            }
                          ],
                          null,
                          true
                        )
                      },
                      [_vm._v(" "), _c("span", [_vm._v("Delete")])]
                    )
                  ]
                }
              }
            ])
          }),
          _vm._v(" "),
          _c(
            "v-dialog",
            {
              attrs: { "max-width": "50%", persistent: "" },
              model: {
                value: _vm.dialog,
                callback: function($$v) {
                  _vm.dialog = $$v
                },
                expression: "dialog"
              }
            },
            [
              _c(
                "v-card",
                [
                  _c("v-card-title", [
                    _vm._v(
                      "\n                    " +
                        _vm._s(_vm.title) +
                        "\n                "
                    )
                  ]),
                  _vm._v(" "),
                  _c(
                    "v-form",
                    {
                      model: {
                        value: _vm.valid,
                        callback: function($$v) {
                          _vm.valid = $$v
                        },
                        expression: "valid"
                      }
                    },
                    [
                      _c(
                        "v-container",
                        [
                          _c(
                            "v-row",
                            {
                              attrs: {
                                "no-gutters": "",
                                justify: "space-around"
                              }
                            },
                            [
                              _c(
                                "v-col",
                                { attrs: { cols: "5" } },
                                [
                                  _c(
                                    "v-card",
                                    { attrs: { tile: "", flat: "" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          rules: _vm.nameRules,
                                          label: "Անուն",
                                          color: "#347cbb",
                                          outlined: "",
                                          dense: "",
                                          clearable: ""
                                        },
                                        model: {
                                          value: _vm.user.name,
                                          callback: function($$v) {
                                            _vm.$set(_vm.user, "name", $$v)
                                          },
                                          expression: "user.name"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-col",
                                { attrs: { cols: "5" } },
                                [
                                  _c(
                                    "v-card",
                                    { attrs: { tile: "", flat: "" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          rules: _vm.emailRules,
                                          type: "email",
                                          label: "Էլ․ հասցե",
                                          color: "#347cbb",
                                          outlined: "",
                                          dense: "",
                                          clearable: ""
                                        },
                                        model: {
                                          value: _vm.user.email,
                                          callback: function($$v) {
                                            _vm.$set(_vm.user, "email", $$v)
                                          },
                                          expression: "user.email"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-row",
                            {
                              attrs: {
                                "no-gutters": "",
                                justify: "space-around"
                              }
                            },
                            [
                              _c(
                                "v-col",
                                { attrs: { cols: "5" } },
                                [
                                  _c(
                                    "v-card",
                                    { attrs: { tile: "", flat: "" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          rules: _vm.nameRules,
                                          type: "password",
                                          label: "Գաղտնաբառ",
                                          color: "#347cbb",
                                          outlined: "",
                                          dense: "",
                                          clearable: ""
                                        },
                                        model: {
                                          value: _vm.user.password,
                                          callback: function($$v) {
                                            _vm.$set(_vm.user, "password", $$v)
                                          },
                                          expression: "user.password"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-col",
                                { attrs: { cols: "5" } },
                                [
                                  _c(
                                    "v-card",
                                    { attrs: { tile: "", flat: "" } },
                                    [
                                      _c("v-text-field", {
                                        attrs: {
                                          rules: _vm.nameRules,
                                          type: "password",
                                          label: "Հաստատել գաղտնաբառը",
                                          color: "#347cbb",
                                          outlined: "",
                                          dense: "",
                                          clearable: ""
                                        },
                                        model: {
                                          value: _vm.user.password_confirmation,
                                          callback: function($$v) {
                                            _vm.$set(
                                              _vm.user,
                                              "password_confirmation",
                                              $$v
                                            )
                                          },
                                          expression:
                                            "user.password_confirmation"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-row",
                            {
                              attrs: {
                                "no-gutters": "",
                                justify: "space-around"
                              }
                            },
                            [
                              _c(
                                "v-col",
                                { attrs: { cols: "5" } },
                                [
                                  _c(
                                    "v-card",
                                    { attrs: { tile: "", flat: "" } },
                                    [
                                      _c("v-select", {
                                        attrs: {
                                          rules: _vm.nameRules,
                                          items: _vm.roles,
                                          "menu-props": "offsetY",
                                          label: "Դեր",
                                          color: "#347cbb",
                                          "item-color": "#347cbb",
                                          outlined: "",
                                          dense: "",
                                          clearable: "",
                                          "open-on-clear": ""
                                        },
                                        model: {
                                          value: _vm.user.role_id,
                                          callback: function($$v) {
                                            _vm.$set(_vm.user, "role_id", $$v)
                                          },
                                          expression: "user.role_id"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("v-col", { attrs: { cols: "5" } })
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _vm.user.role_id === 3
                            ? [
                                _c("v-card-title", [
                                  _vm._v("Distributor options")
                                ]),
                                _vm._v(" "),
                                _c(
                                  "v-row",
                                  {
                                    attrs: {
                                      "no-gutters": "",
                                      justify: "space-around"
                                    }
                                  },
                                  [
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-text-field", {
                                              attrs: {
                                                rules: _vm.nameRules,
                                                label: "Կազմակերպություն",
                                                color: "#347cbb",
                                                outlined: "",
                                                dense: "",
                                                clearable: ""
                                              },
                                              model: {
                                                value:
                                                  _vm.user.distributor.company,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.user.distributor,
                                                    "company",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "user.distributor.company"
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-text-field", {
                                              attrs: {
                                                rules: _vm.nameRules,
                                                label: "Տնօրեն",
                                                color: "#347cbb",
                                                outlined: "",
                                                dense: "",
                                                clearable: ""
                                              },
                                              model: {
                                                value:
                                                  _vm.user.distributor.director,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.user.distributor,
                                                    "director",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "user.distributor.director"
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "v-row",
                                  {
                                    attrs: {
                                      "no-gutters": "",
                                      justify: "space-around"
                                    }
                                  },
                                  [
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-text-field", {
                                              attrs: {
                                                rules: _vm.nameRules,
                                                label: "Հասցե",
                                                color: "#347cbb",
                                                outlined: "",
                                                dense: "",
                                                clearable: ""
                                              },
                                              model: {
                                                value:
                                                  _vm.user.distributor.address,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.user.distributor,
                                                    "address",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "user.distributor.address"
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-text-field", {
                                              attrs: {
                                                rules: _vm.nameRules,
                                                label: "Հեռախոսահամար",
                                                color: "#347cbb",
                                                outlined: "",
                                                dense: "",
                                                clearable: ""
                                              },
                                              model: {
                                                value:
                                                  _vm.user.distributor.phone,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.user.distributor,
                                                    "phone",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "user.distributor.phone"
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "v-row",
                                  {
                                    attrs: {
                                      "no-gutters": "",
                                      justify: "space-around"
                                    }
                                  },
                                  [
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-text-field", {
                                              attrs: {
                                                rules: _vm.nameRules,
                                                label: "Հարկային կոդ",
                                                color: "#347cbb",
                                                outlined: "",
                                                dense: "",
                                                clearable: ""
                                              },
                                              model: {
                                                value:
                                                  _vm.user.distributor.tax_code,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.user.distributor,
                                                    "tax_code",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "user.distributor.tax_code"
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-text-field", {
                                              attrs: {
                                                rules: _vm.nameRules,
                                                label: "Բանկի անուն",
                                                color: "#347cbb",
                                                outlined: "",
                                                dense: "",
                                                clearable: ""
                                              },
                                              model: {
                                                value:
                                                  _vm.user.distributor
                                                    .bank_name,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.user.distributor,
                                                    "bank_name",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "user.distributor.bank_name"
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "v-row",
                                  {
                                    attrs: {
                                      "no-gutters": "",
                                      justify: "space-around"
                                    }
                                  },
                                  [
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-text-field", {
                                              attrs: {
                                                rules: _vm.nameRules,
                                                label: "ԻԲԱՆ",
                                                color: "#347cbb",
                                                outlined: "",
                                                dense: "",
                                                clearable: ""
                                              },
                                              model: {
                                                value:
                                                  _vm.user.distributor.IBAN,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.user.distributor,
                                                    "IBAN",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "user.distributor.IBAN"
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-text-field", {
                                              attrs: {
                                                rules: _vm.nameRules,
                                                label: "Կայք",
                                                color: "#347cbb",
                                                outlined: "",
                                                dense: "",
                                                clearable: ""
                                              },
                                              model: {
                                                value:
                                                  _vm.user.distributor.website,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.user.distributor,
                                                    "website",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "user.distributor.website"
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    )
                                  ],
                                  1
                                ),
                                _vm._v(" "),
                                _c(
                                  "v-row",
                                  {
                                    attrs: {
                                      "no-gutters": "",
                                      justify: "space-around"
                                    }
                                  },
                                  [
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-textarea", {
                                              attrs: {
                                                rules: _vm.nameRules,
                                                label: "Նկարագրություն",
                                                color: "#347cbb",
                                                outlined: "",
                                                dense: "",
                                                clearable: ""
                                              },
                                              model: {
                                                value:
                                                  _vm.user.distributor
                                                    .description,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.user.distributor,
                                                    "description",
                                                    $$v
                                                  )
                                                },
                                                expression:
                                                  "user.distributor.description"
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "v-col",
                                      { attrs: { cols: "5" } },
                                      [
                                        _c(
                                          "v-card",
                                          { attrs: { tile: "", flat: "" } },
                                          [
                                            _c("v-file-input", {
                                              attrs: {
                                                label: "Կազմակերպության լոգո",
                                                color: "#347cbb",
                                                dense: "",
                                                outlined: ""
                                              },
                                              on: { change: _vm.onFileSelected }
                                            }),
                                            _vm._v(" "),
                                            _vm.user.distributor.image
                                              ? _c("v-img", {
                                                  attrs: {
                                                    src:
                                                      _vm.user.distributor
                                                        .image,
                                                    contain: ""
                                                  }
                                                })
                                              : _vm._e()
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    )
                                  ],
                                  1
                                )
                              ]
                            : _vm._e()
                        ],
                        2
                      )
                    ],
                    1
                  ),
                  _vm._v(
                    "\n                " +
                      _vm._s(_vm.errorMessage) +
                      "\n                "
                  ),
                  _c("v-divider"),
                  _vm._v(" "),
                  _c(
                    "v-card-actions",
                    [
                      _c("v-spacer"),
                      _vm._v(" "),
                      _c(
                        "v-btn",
                        {
                          attrs: { text: "" },
                          on: {
                            click: function($event) {
                              _vm.dialog = false
                            }
                          }
                        },
                        [_vm._v("cancel")]
                      ),
                      _vm._v(" "),
                      _c(
                        "v-btn",
                        {
                          attrs: { color: "#347cbb", dark: "", width: "90" },
                          on: { click: _vm.save }
                        },
                        [_vm._v("save")]
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/profile/Users.vue":
/*!***************************************************!*\
  !*** ./resources/js/components/profile/Users.vue ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Users_vue_vue_type_template_id_22655672_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Users.vue?vue&type=template&id=22655672&scoped=true& */ "./resources/js/components/profile/Users.vue?vue&type=template&id=22655672&scoped=true&");
/* harmony import */ var _Users_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Users.vue?vue&type=script&lang=js& */ "./resources/js/components/profile/Users.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Users_vue_vue_type_style_index_0_id_22655672_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css& */ "./resources/js/components/profile/Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Users_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Users_vue_vue_type_template_id_22655672_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Users_vue_vue_type_template_id_22655672_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "22655672",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/profile/Users.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/profile/Users.vue?vue&type=script&lang=js&":
/*!****************************************************************************!*\
  !*** ./resources/js/components/profile/Users.vue?vue&type=script&lang=js& ***!
  \****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Users.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Users.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/profile/Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/profile/Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css& ***!
  \************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_style_index_0_id_22655672_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader??ref--6-1!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--6-2!../../../../node_modules/vue-loader/lib??vue-loader-options!./Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Users.vue?vue&type=style&index=0&id=22655672&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_style_index_0_id_22655672_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_style_index_0_id_22655672_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_style_index_0_id_22655672_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_style_index_0_id_22655672_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_6_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_6_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_style_index_0_id_22655672_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/profile/Users.vue?vue&type=template&id=22655672&scoped=true&":
/*!**********************************************************************************************!*\
  !*** ./resources/js/components/profile/Users.vue?vue&type=template&id=22655672&scoped=true& ***!
  \**********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_template_id_22655672_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Users.vue?vue&type=template&id=22655672&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/profile/Users.vue?vue&type=template&id=22655672&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_template_id_22655672_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Users_vue_vue_type_template_id_22655672_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/models/User.js":
/*!*************************************!*\
  !*** ./resources/js/models/User.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return User; });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var User = function User() {
  var user = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

  _classCallCheck(this, User);

  this.id = user.id || null;
  this.name = user.name || "";
  this.email = user.email || "";
  this.password = user.password || "";
  this.password_confirmation = user.password_confirmation || "";
  this.role_id = user.role || null;
  this.status = user.status || 1;
  this.distributor = user.distributor || {
    id: null,
    company: "",
    director: "",
    address: "",
    phone: "",
    tax_code: "",
    bank_name: "",
    IBAN: "",
    website: "",
    description: "",
    image: "",
    imageFile: null
  };
};



/***/ })

}]);