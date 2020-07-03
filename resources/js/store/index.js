import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        auth: {
            check: false,
            user: null,
        },
        upperMenu: [],
        menu: [],
        categories: {},
        cardProducts: [],
        favorites: [],
        slider: [],
        homeProducts: [],
    },

    mutations: {
        initAuth(state, auth) {
            state.auth = auth;
        },

        updateUpperMenu(state, menu) {
            state.upperMenu = menu;
        },

        updateMenu(state, menu) {
            state.menu = menu;
        },

        updateCategories(state, cat) {
            state.categories = cat;
        },

        updateCardProducts(state, cardProducts) {
            if (state.auth.check) {
                if (cardProducts.id) {
                    let cardProduct = state.auth.user.shop_products.find(prod => prod.id === cardProducts.id);
                    if (cardProduct) {
                        cardProduct.quantity += cardProducts.quantity;
                    } else {
                        state.auth.user.shop_products.push(cardProducts);
                    }
                } else {
                    state.auth.user.shop_products = cardProducts;
                    localStorage.removeItem("cardProducts");
                }
            } else {
                state.cardProducts = cardProducts;
            }
        },

        updateFavorites(state, favorites) {
            if (state.auth.check) {
                if (typeof favorites === "number") {
                    let index = state.auth.user.favorite_products.findIndex(fav => fav === favorites);
                    if (index) {
                        state.auth.user.favorite_products.splice(index, 1);
                    } else {
                        state.auth.user.favorite_products.push(favorites);
                    }
                } else {
                    state.auth.user.favorite_products = favorites;
                    localStorage.removeItem("favorites");
                }
            } else {
                state.favorites = favorites;
            }
        },

        updateSlider(state, sliderItems) {
            state.slider = sliderItems;
        },

        updateHomeProducts(state, homeProducts) {
            state.homeProducts = homeProducts;
        },
    },

    actions: {},

    modules: {}
});

export default store;

export const auth = store.state.auth;