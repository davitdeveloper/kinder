require('./bootstrap');

import Vue from 'vue';
import vuetify from './plugins/vuetify';
import router from './router';
import store from './store';
import App from './App.vue';
import VueMask from 'v-mask';
import 'tui-editor/dist/tui-editor.css';
import 'tui-editor/dist/tui-editor-contents.css';
import 'codemirror/lib/codemirror.css';
import 'highlight.js/styles/github.css';
import Editor from '@toast-ui/vue-editor/src/Editor.vue';
import Viewer from '@toast-ui/vue-editor/src/Viewer.vue';

import { cloneDeep, pickBy } from 'lodash';

Vue.prototype.$cloneDeep = cloneDeep;
Vue.prototype.$pickBy = pickBy;
Vue.use(VueMask);

const csrf = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
Vue.prototype.$csrf = csrf;

const el = document.getElementById('app');

new Vue({
    components: {
        'editor': Editor,
        'viewer': Viewer,
    },
    props: ["initialAuth", "upMenu", "siMenu", "products", "sliders"],
    propsData: {
        initialAuth: JSON.parse(el.dataset.initialAuth),
        upMenu: JSON.parse(el.dataset.upMenu),
        products: JSON.parse(el.dataset.products),
        sliders: JSON.parse(el.dataset.sliders),
    },
    vuetify,
    router,
    store,
    render: h => h(App),
    computed: {
        auth: {
            get() {
                return this.$store.state.auth;
            },

            set(val) {
                this.$store.commit("initAuth", val);
            }
        },
        upperMenu: {
            get() {
                return this.$store.state.upperMenu;
            },

            set(val) {
                this.$store.commit("updateUpperMenu", val);
            }
        },
        menu: {
            get() {
                return this.$store.state.menu;
            },

            set(val) {
                this.$store.commit("updateMenu", val);
            }
        },
        slider: {
            get() {
                return this.$store.state.slider;
            },
            set(val) {
                this.$store.commit("updateSlider", val);
            }
        },
        homeProducts: {
            get() {
                return this.$store.state.homeProducts;
            },

            set(val) {
                this.$store.commit("updateHomeProducts", val);
            }
        }
    },
    methods: {
        createUpperMenu(categories) {
            let upperCategories = categories.filter(cat => !cat.parent_ids.length);
            upperCategories = this.createTree(upperCategories, categories, "down");
            return upperCategories;
        },

        createSideMenu(categories) {
            let sideCategories = categories.filter(cat => !cat.child_ids.length);
            sideCategories = this.createTree(sideCategories, categories);
            return sideCategories;
        },

        createTree(categories, globals, mode) {
            if (mode === "down") {
                categories.forEach(category => {
                    category.children = category.child_ids.map(child => {
                        child = globals.find(global => global.id === child);
                        return child;
                    });

                    if (category.children.length) category.children = this.$cloneDeep(this.createTree(category.children, globals, "down"));
                });

                return categories;
            } else {
                categories.forEach(category => {
                    category.children = category.parent_ids.map(parent => {
                        parent = globals.find(global => global.id === parent);
                        return parent;
                    });

                    if (category.children.length) category.children = this.createTree(category.children, globals);

                });

                return categories;
            }
        }
    },
    created() {
        this.slider = this.sliders;
        console.log(this.slider);
        this.homeProducts = this.products;
        this.auth = this.initialAuth;

        if (this.auth.check) {
            const cardProducts = JSON.parse(localStorage.getItem("cardProducts"));
            if (cardProducts) {
                axios.post(`/api/shopping-cart/add-many/${this.$store.state.auth.user.id}`, cardProducts)
                    .then(res => this.$store.commit("updateCardProducts", cardProducts))
                    .catch(err => console.error(err.response.data));
            }

            const favorites = JSON.parse(localStorage.getItem("favorites"));
            if (favorites) {
                axios.post(`/api/favorites/create/${this.auth.user.id}`, favorites)
                    .then(res => {
                        this.$store.commit("updateFavorites", res.data)
                    })
                    .catch(err => console.error(err.response.data));

            };
        } else {
            const cardProducts = JSON.parse(localStorage.getItem("cardProducts"));
            if (cardProducts) this.$store.commit("updateCardProducts", cardProducts);

            const favorites = JSON.parse(localStorage.getItem("favorites"));
            if (favorites) this.$store.commit("updateFavorites", favorites);
        }

        this.upperMenu = this.createUpperMenu(this.upMenu);

        this.menu = this.$cloneDeep(this.upperMenu);
        this.menu.forEach(menu => {
            menu.children.forEach(child => {
                let arr = [];
                let arr2 = [];
                let arr3 = [];
                child.children.forEach((subChild, i) => {
                    if (i < 10) {
                        arr.push(subChild);
                    } else if (i < 20) {
                        arr2.push(subChild);
                    } else {
                        arr3.push(subChild);
                    }
                });
                child.children = [];
                if (arr.length) child.children.push(arr);
                if (arr2.length) child.children.push(arr2);
                if (arr3.length) child.children.push(arr3);
            })
        });
    },
}).$mount("#app");