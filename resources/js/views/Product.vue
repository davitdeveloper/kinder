<template>
    <section>
        <v-container>
            <v-row no-gutters justify="center">
                <v-col cols="9">
                    <v-row no-gutters justify="space-between" align="center">
                        <v-col cols="6" class="petlya">
                            <v-img src="/images/shape2.png" width="45" class="titer"></v-img>
                        </v-col>
                        <v-col cols="5" class="pl-10">
                            <div class="gic"></div>
                        </v-col>
                    </v-row>

                    <v-row no-gutters justify="center" class="mt-1">
                        <h1 class="title apranqiAnun">{{ product.title }}</h1>
                    </v-row>

                    <v-row no-gutters justify="space-between" class="mt-8">
                        <v-col cols="4" style="position: relative">
                            <template v-if="selectedProduct.id">
                                <v-img
                                    v-for="image in selectedProduct.images"
                                    :key="'image' + image.id"
                                    :src="image.image"
                                    alt=""
                                    class="mt-3"
                                    contain
                                ></v-img>

                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-img
                                            src="/images/swsh.png"
                                            :class="[ product.favorite ? 'favoriteSrtik' : 'srtik' ]"
                                            v-on="on"
                                            @click="product.favorite ? removeFromFavorites(product) : makeFavorite(product)"
                                        ></v-img>
                                    </template>

                                    <span>{{ product.favorite ? 'remove from favorites' : 'make favorite' }}</span>
                                </v-tooltip>
                            </template>

                            <template v-else>
                                <v-img :src="product.main_image" alt="" contain></v-img>

                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-img
                                            src="/images/swsh.png"
                                            :class="[ product.favorite ? 'favoriteSrtik' : 'srtik' ]"
                                            v-on="on"
                                            @click="product.favorite ? removeFromFavorites(product) : makeFavorite(product)"
                                        ></v-img>
                                    </template>

                                    <span>{{ product.favorite ? 'remove from favorites' : 'make favorite' }}</span>
                                </v-tooltip>
                            </template>
                        </v-col>

                        <v-col class="b_sticky" cols="7">
                            <v-toolbar-title class="gin">
                                <template v-if="selectedProduct.id">
                                    <span class="red--text mr-7">{{ selectedProduct.price }}֏</span>

                                    <template v-if="selectedProduct.old_price">
                                        <span class="grey--text">
                                            {{ selectedProduct.old_price }} ֏
                                        </span>
                                        <div class="jnjoxGic"></div>
                                    </template>
                                </template>

                                <template v-else>
                                    <span class="red--text mr-7">{{ product.price }}֏</span>

                                    <template v-if="product.old_price">
                                        <span class="grey--text">
                                            {{ product.old_price }} ֏
                                        </span>
                                        <div class="jnjoxGic"></div>
                                    </template>
                                </template>
                            </v-toolbar-title>

                            <div class="timer">
                                132 days 10hr 24min 03sec
                            </div>

                            <v-card-title v-if="selectedProduct.id" class="pa-0 mt-7 grey--text">REFERENCE: {{ selectedProduct.SCU }}</v-card-title>
                            <v-card-title v-else class="pa-0 mt-7 grey--text">REFERENCE: - </v-card-title>

                            <v-row v-if="colors.length" class="mt-8" no-gutters align="center">
                                <v-col cols="1" class="mr-3">
                                    <v-card-title class="grey--text pa-0">Color:</v-card-title>
                                </v-col>

                                <v-tooltip
                                    v-for="color in colors"
                                    :key="color.id"
                                    bottom
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-card
                                            tile
                                            outlined
                                            width="40"
                                            height="40"
                                            class="pointer mx-3"
                                            :class="{ b_active: color.active }"
                                            v-on="on"
                                            :ripple="false"
                                            @click="pickColor(color)"
                                        >
                                            <v-card
                                                :color="color.value"
                                                tile
                                                flat
                                                class="b_centeredColor"
                                                width="25"
                                                height="25"
                                                v-on="on"
                                            >
                                                <div class="guyn"></div>
                                            </v-card>
                                        </v-card>
                                    </template>

                                    <span>{{ color.name }}</span>
                                </v-tooltip>

                                <v-btn text color="#4dc0a6" @click="reset">reset</v-btn>
                            </v-row>

                            <v-row v-if="sizes.length" class="mt-8" no-gutters align="center">
                                <v-col cols="1" class="mr-3">
                                    <v-card-title class="grey--text pa-0">Size:</v-card-title>
                                </v-col>

                                <v-card
                                    v-for="size in sizes"
                                    :key="size.id"
                                    tile
                                    outlined
                                    width="40"
                                    height="40"
                                    class="pointer mx-3 b_centeredSize"
                                    :ripple="false"
                                    :class="{ b_active: size.active }"
                                    @click="pickSize(size)"
                                >
                                    {{ size.value }}
                                </v-card>
                            </v-row>

                            <v-row no-gutters class="mt-8">
                                <v-col cols="2">
                                    <v-row no-gutters justify="space-between">
                                        <v-col cols="3" class="mt-1">
                                            <v-btn icon color="#347cbb" :disabled="quantity === 1" @click="quantity--">
                                                <v-icon>mdi-minus</v-icon>
                                            </v-btn>
                                        </v-col>

                                        <v-col cols="5">
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="quantity"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                ></v-text-field>
                                            </v-card>
                                        </v-col>

                                        <v-col cols="3" class="mt-1">
                                            <v-btn icon color="#347cbb" @click="quantity++">
                                                <v-icon>mdi-plus</v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>

                            <v-alert v-if="inCard" type="info" dense>
                                This item is already in your card.
                                If you add it again the selected quantity will be added to the existing quantity.
                            </v-alert>

                            <div style="position: relative">
                                <v-btn color="#347cbb" text x-large height="60" width="250" class="mt-7" @click="addToCard">
                                    <div class="gic1"></div>
                                    <div class="gic2"></div>
                                    <v-img src="/images/bag_ins.png" width="25" contain class="cardImage"></v-img>
                                    add to card
                                </v-btn>
                                <v-btn v-if="product.offerable" color="red darken-2" class="mt-7" dark x-large @click="open()">make an offer</v-btn>
                            </div>

                            <v-expansion-panels class="mt-12">
                                <v-expansion-panel>
                                    <v-expansion-panel-header>
                                        <v-toolbar-title class="pa-0">
                                            <span class="b_primary">
                                                More Info
                                            </span>
                                        </v-toolbar-title>
                                    </v-expansion-panel-header>

                                    <v-expansion-panel-content>
                                        <v-card-text v-html="product.long_description"></v-card-text>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>
                                        <v-toolbar-title class="pa-0 blue--text">
                                            <span class="b_primary">
                                                Data Sheet
                                            </span>
                                        </v-toolbar-title>
                                    </v-expansion-panel-header>

                                    <v-expansion-panel-content>

                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

            <v-dialog v-model="dialog" max-width="50%" persistent>
                <v-card>
                    <v-card-title>
                        Your Offer
                    </v-card-title>

                    <v-form >
                        <v-container>
                            <v-row no-gutters justify="center">

                                <v-col cols="8">
                                    <v-card tile flat>
                                        <v-textarea
                                            v-model="offer.message"
                                            label="Նամակ"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-textarea>
                                    </v-card>
                                </v-col>

                            </v-row>
                            <v-row no-gutters justify="center">
                                <v-col cols="8">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="offer.price"
                                            label="Ձեր առաջարկվող գինը"
                                            v-mask="'######'"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                            </v-row>
                            <v-row no-gutters justify="center">
                                <v-col cols="4">
                                    <v-row align-items="center" justify="space-between">
                                        <v-col cols="3" class="text-center">
                                            <v-btn v-if="selectedProduct.min_offer_count" icon color="#347cbb" @click="selectedProduct.min_offer_count--">
                                                <v-icon>mdi-minus</v-icon>
                                            </v-btn>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="selectedProduct.min_offer_count"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                ></v-text-field>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="3" class="text-center">
                                            <v-btn icon color="#347cbb" @click="selectedProduct.min_offer_count++">
                                                <v-icon>mdi-plus</v-icon>
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="dialog = false">cancel</v-btn>
                        <v-btn color="#347cbb" dark width="150" @click="sendOffer()">Send Offer</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </section>
</template>

<script>
import axios from "axios";
import Manufacturer from "../models/Manufacturer";

export default {
    name: "Product",
    data: () => ({
        inCard: false,
        product: {},
        selectedProduct: {},
        colors: [],
        color: null,
        sizes: [],
        size: null,
        quantity: 1,
        dialog: false,
        offer: {
            price: '',
            message: '',
        }
    }),

    computed: {
        auth() {
            return this.$store.state.auth;
        },

        alias () {
            return this.$route.params.alias;
        },
    },

    methods: {
        getProduct() {
            axios.get(`/api/app/product/${this.alias}`)
                .then(res => {
                    this.product = res.data.product;
                    if (this.auth.check) {
                        this.product.favorite = !!this.auth.user.favorite_products.find(fav => fav === this.product.id);
                    } else {
                        this.product.favorite = !!this.$store.state.favorites.find(fav => fav === this.product.id);
                    }

                    if (this.product.products.length < 2) {
                        this.selectedProduct = this.product.products[0];
                    }

                    this.product.products.forEach(product => {
                        if (product.color) {
                            if (!this.colors.find(color => color.name === product.color.name)) {
                                product.color.active = false;
                                this.colors.push(product.color);
                            }
                        }

                        if (product.size) {
                            if (!this.sizes.find(size => size.id === product.size.id)) {
                                product.size.active = false;
                                this.sizes.push(product.size);
                            }
                        }
                    });
                })
                .catch(err => console.error(err.response.data.message));
        },

        pickColor(color) {
            this.colors.forEach(color => color.active = false);
            color.active = true;
            this.color = color;
            this.sizes = [];
            this.product.products.forEach(product => {
                if (product.color.name === color.name) {
                    product.size.active = false;
                    this.sizes.push(product.size)
                };
            });
            if (this.size) {
                this.size = this.sizes.find(item => item.id === this.size.id);
                this.size.active = true;
                this.selectedProduct = this.product.products.find(prod => prod.color.id === this.color.id && prod.size.id === this.size.id);
            }
        },

        pickSize(size) {
            this.sizes.forEach(size => size.active = false);
            size.active = true;
            this.size = size;
            this.colors = [];
            this.product.products.forEach(product => {
                if (product.size.id === size.id) {
                    product.color.active = false;
                    this.colors.push(product.color);
                }
            });
            if (this.color) {
                this.color = this.colors.find(item => item.id === this.color.id);
                this.color.active = true;
                this.selectedProduct = this.product.products.find(prod => prod.color.id === this.color.id && prod.size.id === this.size.id);
            }
        },

        reset() {
            this.colors = [];
            this.sizes = [];

            this.product.products.forEach(product => {
                if (product.color) {
                    if (!this.colors.find(color => color.name === product.color.name)) {
                        product.color.active = false;
                        this.colors.push(product.color);
                    }
                }

                if (product.size) {
                    if (!this.sizes.find(size => size.id === product.size.id)) {
                        product.size.active = false;
                        this.sizes.push(product.size);
                    }
                }
            });
            this.color = null;
            this.size = null;
            this.selectedProduct = {};
        },

        makeFavorite(product) {
            product.favorite = true;
            this.$forceUpdate();

            if (this.auth.check) {
                axios.post(`/api/favorites/create/${this.auth.user.id}`,{
                    id: product.id
                })
                    .then(res => {
                        this.$store.commit("updateFavorites", res.data);
                    })
                    .catch(err => console.error(err.response.data.message));
            } else {
                let favorites = JSON.parse(localStorage.getItem("favorites"));

                if (!favorites) {
                    favorites = [product.id];
                    localStorage.setItem("favorites", JSON.stringify(favorites));
                    this.$store.commit("updateFavorites", favorites);
                } else {
                    favorites.push(product.id);
                    localStorage.setItem("favorites", JSON.stringify(favorites));
                    this.$store.commit("updateFavorites", favorites);
                }
            }
        },

        removeFromFavorites(product) {
            product.favorite = false;
            this.$forceUpdate();

            if (this.auth.check) {
                axios.delete(`/api/favorites/${product.id}/${this.$store.state.auth.user.id}`)
                    .then(res => {
                        this.$store.commit("updateFavorites")
                    })
                    .catch(err => console.error(err));
            } else {
                let favorites = JSON.parse(localStorage.getItem("favorites"));

                let index = favorites.findIndex(favorite => favorite === product.id);
                favorites.splice(index, 1);
                localStorage.setItem("favorites", JSON.stringify(favorites));
                this.$store.commit("updateFavorites", favorites);
            }
        },

        addToCard() {
            if (this.selectedProduct.id) {
                if (this.auth.check) {
                    axios.post(`/shopping-cart/${this.auth.user.id}`, { 
                        id: this.selectedProduct.id,
                        quantity: this.quantity,
                    })
                        .then(res => this.$store.commit("updateCardProducts"))
                        .catch(err => console.error(err.response.data.message));
                } else {
                    let cardProducts = JSON.parse(localStorage.getItem("cardProducts"));

                    if (!cardProducts) {
                        cardProducts = [{ id: this.selectedProduct.id, quantity: this.quantity }];
                        localStorage.setItem("cardProducts", JSON.stringify(cardProducts));
                        this.$store.commit("updateCardProducts", cardProducts);
                    } else {
                        const cardProduct = cardProducts.find(cardProd => cardProd.id === this.selectedProduct.id);

                        if (cardProduct) {
                            cardProduct.quantity += this.quantity;
                            localStorage.setItem("cardProducts", JSON.stringify(cardProducts));
                            this.$store.commit("updateCardProducts", cardProducts);
                        } else {
                            cardProducts.push({ id: this.selectedProduct.id, quantity: this.quantity });
                            localStorage.setItem("cardProducts", JSON.stringify(cardProducts));
                            this.$store.commit("updateCardProducts", cardProducts);
                        }
                    }

                    this.checkInCard();
                }
            }
        },

        checkInCard() {
            if (this.selectedProduct.id) {
                if (this.auth.check) {
                    this.inCard = !!this.auth.user.shop_products.find(shopProd => shopProd.id === this.selectedProduct.id);
                } else {
                    let cardProducts = JSON.parse(localStorage.getItem("cardProducts"));

                    if (cardProducts) {
                        this.inCard = !!cardProducts.find(cardProd => cardProd.id === this.selectedProduct.id);
                    } else {
                        this.inCard = false;
                    }
                }
            }
        },

        open() {
            this.dialog = true;
        },

        sendOffer(){
            axios.post(`/api/app/offer/create/${this.$store.state.auth.user.id}`,{
                quantity :  this.selectedProduct.min_offer_count,
                price:  this.offer.price,
                message: this.offer.message,
                product_id: this.selectedProduct.id,
            }).then(res => this.$store.commit("updateFavorites", this.selectedProduct.id))
                .catch(err => console.error(err.response.data.message));
        }
    },

    watch: {
        selectedProduct() {
            this.checkInCard();
        }
    },

    created () {
        this.getProduct();
        this.checkInCard();
    }
}
</script>

<style scoped>
.border {
    border: 1px solid black;
}

.petlya {
    position: relative;
    height: 100px;
    background: url(/images/shape1.png) no-repeat;
    background-size: contain;
}

.titer {
    position: absolute;
    right: -50px;
    top: -5px;
}

.apranqiAnun {
    color: #4dc0a6;
    font-size: 2vw !important;
}

.gic {
    height: 2px;
    margin-top: 60px;
    background: url(/images/shape3.png);
    background-size: contain;
}

.b_sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 30px;
    max-height: 800px;
}

.gin {
    position: relative;
    font-size: 55px;
}

.jnjoxGic {
    border: 1px solid grey;
    width: 135px;
    position: absolute;
    top: 40px;
    left: 145px;
    transform: rotate(5deg);
}

.timer {
    border: 3px dotted red;
    max-width: 300px;
    font-size: 20px;
    color: grey;
    margin-top: 10px;
    padding: 20px 0;
    text-align: center;
}

.pointer {
    cursor: pointer;
}

.b_centeredColor {
    margin: auto;
    margin-top: 6px;
}

.b_centeredSize {
    text-align: center;
    font-size: 17px;
    padding-top: 6px;
}

.b_active {
    border: 2px solid goldenrod !important;
}

.gic1 {
    border: 1px solid #347cbb;
    width: 60px;
    transform: rotate(92deg);
    position: absolute;
    top: 10px;
    left: 0;
}

.gic2 {
    border: 1px solid #347cbb;
    width: 210px;
    position: absolute;
    transform: rotate(-2deg);
    bottom: -10px;
    left: -17px;
}

.cardImage {
    position: absolute;
    top: -7px;
    left: -7px;
}

.b_primary {
    color: #347cbb;
}

.srtik {
    cursor: pointer;
    opacity: 0.3;
    filter: grayscale(100%);
    width: 40px;
    position: absolute;
    top: 40px;
    right: 20px;
}

.favoriteSrtik {
    cursor: pointer;
    width: 40px;
    position: absolute;
    top: 40px;
    right: 20px;
}

.srtik:hover {
    opacity: 1;
    filter: none;
}
</style>
