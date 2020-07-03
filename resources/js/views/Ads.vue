<template>
    <section>
        <v-container>
            <v-row no-gutters justify="center">
                <v-col cols="9">
<!--                    <v-row no-gutters class="mt-12">-->
<!--                        <v-col cols="10">-->
<!--                            <v-btn-->
<!--                                :disabled="$route.path === ('/ads/' + $route.params.alias)"-->
<!--                                color="#347cbb"-->
<!--                                text-->
<!--                                small-->
<!--                                style="font-style: italic;"-->
<!--                                @click="$router.push('/ads/' + $route.params.alias)"-->
<!--                            >-->
<!--                                <h4>{{ category.title }}</h4>-->
<!--                            </v-btn>-->

<!--                            <span v-if="$route.params.subAlias" class="blue&#45;&#45;text">/</span>-->

<!--                            <v-btn-->
<!--                                v-if="$route.params.subAlias"-->
<!--                                :disabled="$route.path === ('/ads/' + $route.params.alias + '/' + $route.params.subAlias)"-->
<!--                                color="#347cbb"-->
<!--                                text-->
<!--                                small-->
<!--                                style="font-style: italic;"-->
<!--                                @click="$router.push('/ads/' + $route.params.alias + '/' + $route.params.subAlias)"-->
<!--                            >-->
<!--                                <h4>{{ subCategory.title }}</h4>-->
<!--                            </v-btn>-->

<!--                            <span v-if="$route.params.subSubAlias" class="blue&#45;&#45;text">/</span>-->

<!--                            <v-btn-->
<!--                                v-if="$route.params.subSubAlias"-->
<!--                                :disabled="$route.path === ('/ads/' + $route.params.alias + '/' + $route.params.subAlias + '/' + $route.params.subSubAlias)"-->
<!--                                color="#347cbb"-->
<!--                                text-->
<!--                                small-->
<!--                                style="font-style: italic;"-->
<!--                                @click="$router.push('/ads/' + $route.params.alias + '/' + $route.params.subAlias + '/' + $route.params.subSubAlias)"-->
<!--                            >-->
<!--                                <h4>{{ subSubCategory.title }}</h4>-->
<!--                            </v-btn>-->
<!--                        </v-col>-->
<!--                    </v-row>-->

                    <v-divider></v-divider>

                    <v-row no-gutters>
                        <v-container>
                            <v-row justify="space-between">
                                <v-col cols="3" class="pa-0 pr-9 mt-5 b_sticky">
                                    <template v-if="minPrice !== maxPrice">
                                        <h4 class="kapuyt mt-3">Ֆիլտրել ըստ գնի</h4>

                                        <v-range-slider
                                            v-model="range"
                                            :min="minPrice"
                                            :max="maxPrice"
                                            color="#347cbb"
                                            class="mt-3"
                                            hide-details
                                        ></v-range-slider>

                                        <span class="gin">Գին։ {{ range[0] }}֏ - {{ range[1] }}֏</span>

                                        <v-btn
                                            small
                                            color="#347cbb"
                                            outlined
                                            block
                                            rounded
                                            class="mt-2"
                                            @click="filterPrice"
                                        >Ֆիլտրել</v-btn>

                                        <v-divider class="mt-5"></v-divider>
                                    </template>
                                    <template>
                                        <h4 class="kapuyt mt-3">Ֆիլտրել ըստ վիճակի</h4>
                                        <v-radio-group v-model="condition">
                                            <v-radio label="Նոր" value="Նոր"></v-radio>
                                            <v-radio label="Օգտագործված" value="Օգտագործված"></v-radio>
                                        </v-radio-group>
                                        <v-divider class="mt-5"></v-divider>
                                    </template>
                                    <template>
                                        <h4 class="kapuyt mt-3">Ֆիլտրել ըստ տարածաշրջանի</h4>
                                        <v-list>
                                            <v-list-group
                                                v-for="item in cit"
                                                :key="item.id"
                                            >
                                                <template v-slot:activator>
                                                    <v-list-item-content>
                                                        <v-list-item-title v-text="item.name"></v-list-item-title>
                                                    </v-list-item-content>
                                                </template>
                                                <v-list-item
                                                    v-for="subItem in item.children"
                                                    :key="subItem.name"
                                                >
                                                    <v-checkbox v-model="city" :label="subItem.name" :value="subItem.id"></v-checkbox>
                                                </v-list-item>
                                            </v-list-group>
                                        </v-list>
                                        <v-divider class="mt-5"></v-divider>
                                    </template>



                                    <v-window v-model="step">
                                        <v-window-item :value="1">
                                            <v-list>
                                                <v-list-item-group color="#347cbb">
                                                    <v-list-item
                                                        v-for="category in $store.state.upperMenu"
                                                        :key="category.id"
                                                        @click="pickCategory(category)"
                                                    >
                                                        <v-list-item-title>{{ category.title }}</v-list-item-title>

                                                        <v-list-item-icon>
                                                            <v-icon>mdi-chevron-right</v-icon>
                                                        </v-list-item-icon>
                                                    </v-list-item>
                                                </v-list-item-group>
                                            </v-list>
                                        </v-window-item>

                                        <v-window-item :value="2">
                                            <v-btn icon class="mt-2" @click="step--">
                                                <v-icon>mdi-arrow-left</v-icon>
                                            </v-btn>

                                            <v-list dense>
                                                <v-list-group
                                                    v-for="category in selectedCategory.children"
                                                    :key="category.id"
                                                >
                                                    <template v-slot:activator>
                                                        <v-list-item-title class="pl-4" @click="$router.push(`/ads/${selectedCategory.alias}/${category.alias}`)">
                                                            {{ category.title }}
                                                        </v-list-item-title>
                                                    </template>

                                                    <v-list-item
                                                        v-for="subCategory in category.children"
                                                        :key="subCategory.id"
                                                        link
                                                        class="pa-0 pl-12"
                                                        @click="$router.push(`/ads/${selectedCategory.alias}/${category.alias}/${subCategory.alias}`)"
                                                    >
                                                        <v-list-item-title v-text="subCategory.title"></v-list-item-title>
                                                    </v-list-item>
                                                </v-list-group>
                                            </v-list>
                                        </v-window-item>
                                    </v-window>

                                    <v-divider></v-divider>
                                </v-col>

                                <v-col cols="9" class="px-0">
                                    <v-row no-gitters justify="center">
                                        <v-col cols="9">
                                            <v-text-field
                                                v-model="searchData"
                                                label="Փնտրել հայտարարություններ"
                                                color="#347cbb"
                                                prepend-inner-icon="mdi-magnify"
                                                rounded
                                                outlined
                                                dense
                                                hide-details
                                                single-line
                                                v-on:keyup.enter.prevent="filterSearch"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row
                                        v-for="product in products"
                                        :key="`product-${product.id}`"
                                    >
                                        <v-col cols="12">
                                                <v-card tile outlined @click="$router.push(`/ad/${product.alias}`)">
                                                    <v-row no-gutters justify="space-around" align="center">
                                                        <v-col cols="2">
                                                            <v-img v-if="product.images.length" :src="product.images[0].image" height="100" contain></v-img>
                                                        </v-col>
                                                        <v-col cols="6">
                                                            <p  class="kapuyt" style="font-size: 15px;line-height: 1.3">{{ product.title }}</p>
                                                        </v-col>
                                                        <v-col cols="2">
                                                            <v-card-title class="price">{{ product.price }} ֏</v-card-title>
                                                        </v-col>
                                                    </v-row>
                                                </v-card>

<!--                                            <v-img src="/images/star-small.png" class="astx" contain></v-img>-->

<!--                                            <v-tooltip bottom>-->
<!--                                                <template v-slot:activator="{ on }">-->
<!--                                                    <v-img-->
<!--                                                        src="/images/swsh.png"-->
<!--                                                        :class="[ product.favorite ? 'favoriteSrtik' : 'srtik' ]"-->
<!--                                                        v-on="on"-->
<!--                                                        @click="product.favorite ? removeFromFavorites(product) : makeFavorite(product)"-->
<!--                                                    ></v-img>-->
<!--                                                </template>-->

<!--                                                <span>{{ product.favorite ? 'remove from favorites' : 'make favorite' }}</span>-->
<!--                                            </v-tooltip>-->
                                        </v-col>
                                    </v-row>
                                    <v-pagination
                                        v-model="page"
                                        circle
                                        :length="pagesLength"
                                        :page="page"
                                        :total-visible="10"
                                        class="mt-5"
                                    ></v-pagination>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<script>
    import { mapMutations } from "vuex";

    export default {
        name: "Ads",
        data () {
            return {
                skeleton: false,
                products: [],
                category: {},
                subCategory: {},
                subSubCategory: {},
                minPrice: 0,
                maxPrice: 0,
                search: this.$route.query.search,
                searchData: this.$route.query.search,
                condition: this.$route.query.condition,
                range: [],
                priceStart: 0,
                priceEnd: 0,
                step: 1,
                selectedCategory: [],
                cit: [],
                city: this.$route.query.city,
                page: +this.$route.query.page,
                pagesLength: 0,
            }
        },

        computed: {
            alias () {
                return this.$route.params.alias;
            },

            subAlias () {
                return this.$route.params.subAlias;
            },

            subSubAlias () {
                return this.$route.params.subSubAlias;
            },

            queryString () {
                let obj = {
                    page: this.page,
                    minPrice: this.priceStart,
                    maxPrice: this.priceEnd,
                    search: this.search,
                    condition: this.condition,
                    city: this.city,
                };

                for (let key in obj) {
                    if (!obj[key]) delete obj[key];
                }

                let string = "?";

                for (let key in obj) {
                    string += key + "=" + obj[key] + "&";
                }

                return string;
            },

            // cardProducts: {
            //     get() {
            //         return this.$store.state.cardProducts;
            //     },
            //
            //     set(val) {
            //         this.updateCardProducts(val);
            //     }
            // },
            //
            // favorites: {
            //     get() {
            //         return this.$store.state.favorites;
            //     },
            //
            //     set(val) {
            //         this.updateFavorites(val);
            //     }
            // }
        },

        methods: {
            // ...mapMutations(["updateCardProducts", "updateFavorites"]),

            createCitiesMenu(cities) {
                let cityMenu = cities.filter(cit => cit.region_id === null);
                cityMenu = this.createTree(cityMenu, cities);
                this.cit = cityMenu;

            },
            createTree(qaxaqner, globals) {
                qaxaqner.forEach(city => {
                    city.children = globals.filter(global => global.region_id === city.id);
                });
                return qaxaqner;
            },

            getProducts() {
                this.skeleton = true;

                let params = "";
                if (this.alias) params += this.alias + "/";
                if (this.subAlias) params += this.subAlias + "/";
                if (this.subSubAlias) params += this.subSubAlias;
                axios.get(`/api/app/own-products/${params}${this.queryString}`)
                    .then(res => {
                        this.products = res.data.products.data;
                        this.createCitiesMenu(res.data.cities);
                        this.products = this.products.map(product => {
                            product.descriptionShortened = product.description.length > 90 ? product.description.slice(0, 87) + "..." : product.description;
                            product.favorite = false;
                            return product;
                        });
                        // let favorites = JSON.parse(localStorage.getItem("favorites"));
                        // if (favorites) {
                        //     favorites.forEach(favorite => {
                        //         this.products.find(product => {
                        //             if (product.id === favorite) product.favorite = true;
                        //         });
                        //     })
                        // } else if (this.$store.state.auth.check) {
                        //     this.$store.state.auth.user.favorites.forEach(favorite => {
                        //         this.products.find(product => {
                        //             if (product.id === favorite) product.favorite = true;
                        //         });
                        //     })
                        // }

                        this.category = res.data.alias;
                        this.subCategory = res.data.subAlias;
                        this.subSubCategory = res.data.subsubAlias;

                        this.minPrice = res.data.minPrice;
                        this.maxPrice = res.data.maxPrice;
                        this.search = res.data.search;
                        this.condition = res.data.condition;
                        this.city = res.data.city;
                        this.range = [];

                        if (this.$route.query.minPrice) {
                            this.range.push(this.$route.query.minPrice);
                        } else {
                            this.range.push(this.minPrice);
                        }

                        if (this.$route.query.maxPrice) {
                            this.range.push(this.$route.query.maxPrice);
                        } else {
                            this.range.push(this.maxPrice);
                        }

                        this.pagesLength = Math.ceil(res.data.products.total / 15);
                        this.skeleton = false;
                    })
                    .catch(err => console.error(err.response.data.message));
            },

            filterPrice() {
                this.priceStart = this.range[0];
                this.priceEnd = this.range[1];
            },
            filterSearch() {
                this.search = this.searchData;
            },
            pickCategory (category) {
                this.$router.push("/ads/" + category.alias);
                this.selectedCategory = category;
                this.step++;
            },

            // makeFavorite(product) {
            //     product.favorite = true;
            //     this.$forceUpdate();
            //
            //     if (!this.$store.state.auth.check) {
            //         let favorites = JSON.parse(localStorage.getItem("favorites"));
            //
            //         if (!favorites) {
            //             favorites = [product.id];
            //             localStorage.setItem("favorites", JSON.stringify(favorites));
            //             this.$store.commit("updateFavorites", favorites);
            //         } else {
            //             favorites.push(product.id);
            //             localStorage.setItem("favorites", JSON.stringify(favorites));
            //             this.$store.commit("updateFavorites", favorites);
            //         }
            //     } else {
            //         this.$store.commit("updateFavorites", product.id);
            //     }
            // },
            //
            // removeFromFavorites(product) {
            //     product.favorite = false;
            //     this.$forceUpdate();
            //
            //     if (!this.$store.state.auth.check) {
            //         let favorites = JSON.parse(localStorage.getItem("favorites"));
            //
            //         let index = favorites.findIndex(favorite => favorite === product.id);
            //         favorites.splice(index, 1);
            //         localStorage.setItem("favorites", JSON.stringify(favorites));
            //         this.$store.commit("updateFavorites", favorites);
            //     } else {
            //         this.$store.commit("updateFavorites", product.id);
            //     }
            // }
        },

        watch: {
            queryString (val) {
                let params = "";
                if (this.alias) params += this.alias + "/";
                if (this.subAlias) params += this.subAlias + "/";
                if (this.subSubAlias) params += this.subSubAlias;
                this.$router.push(`/ads/${params}${val}`);
            },

            $route () {
                this.getProducts();
            }
        },

        beforeCreate () {
            if (!this.$route.query.page) {
                this.$router.push({ query: Object.assign({}, { page: 1 }, this.$route.query) });
            }
        },

        created () {
            this.getProducts();
        }
    }
</script>

<style scoped>
    .border {
        border: 1px solid black;
    }

    .gin {
        color: #347cbb;
        font-size: 14px;
        margin-left: 2px;
    }

    .kapuyt {
        color: #4dc0a6;
    }

    .pointer {
        cursor: pointer;
    }

    .b_outlined {
        border: 1px solid rgba(0, 0, 0, 0.12);
    }

    .b_active {
        border: 2px solid goldenrod;
    }

    .b_centered {
        margin: auto;
    }

    .b_sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 30px;
        max-height: 800px;
    }

    .price {
        display: block;
        color: #4dc0a6;
        text-align: center !important;
        padding: 0;
    }

    .astx {
        width: 50px;
        position: absolute;
        top: 80px;
        left: 10px;
    }

    .srtik {
        cursor: pointer;
        opacity: 0.3;
        filter: grayscale(100%);
        width: 40px;
        position: absolute;
        top: 80px;
        right: 20px;
    }

    .favoriteSrtik {
        cursor: pointer;
        width: 40px;
        position: absolute;
        top: 80px;
        right: 20px;
    }

    .srtik:hover {
        opacity: 1;
        filter: none;
    }
</style>
