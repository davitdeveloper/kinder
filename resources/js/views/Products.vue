<template>
    <v-row no-gutters justify="center" class="px-3">
        <v-col cols="12" sm="12" md="12" lg="10" xl="9">
            <!-- breadcrumbs -->
            <v-col cols="10" class="mt-10">
                <v-btn
                    :disabled="$route.path === ('/products/' + $route.params.alias)"
                    color="#347cbb"
                    text
                    small
                    style="font-style: italic;"
                    @click="$router.push('/products/' + $route.params.alias)"
                >
                    <h4>{{ category.title }}</h4>
                </v-btn>

                <template v-if="$route.params.subAlias">
                    <span class="blue--text">/</span>

                    <v-btn
                        :disabled="$route.path === ('/products/' + $route.params.alias + '/' + $route.params.subAlias)"
                        color="#347cbb"
                        text
                        small
                        style="font-style: italic;"
                        @click="$router.push('/products/' + $route.params.alias + '/' + $route.params.subAlias)"
                    >
                        <h4>{{ subCategory.title }}</h4>
                    </v-btn>
                </template>

                <template v-if="$route.params.subSubAlias">
                    <span class="blue--text">/</span>

                    <v-btn
                        :disabled="$route.path === ('/products/' + $route.params.alias + '/' + $route.params.subAlias + '/' + $route.params.subSubAlias)"
                        color="#347cbb"
                        text
                        small
                        style="font-style: italic;"
                        @click="$router.push('/products/' + $route.params.alias + '/' + $route.params.subAlias + '/' + $route.params.subSubAlias)"
                    >
                        <h4>{{ subSubCategory.title }}</h4>
                    </v-btn>
                </template>
            </v-col>

            <v-divider></v-divider>

            <v-row no-gutters>
                <!-- filters -->
                <v-col v-if="$vuetify.breakpoint.mdAndUp" cols="5" sm="4" md="3" lg="3" xl="3" class="pa-0 pr-9 mt-5 b_sticky">
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

                    <template v-if="colors.length">
                        <h4 class="kapuyt mt-3">Ֆիլտրել ըստ գույնի</h4>

                        <v-row no-gutters justify="space-around" class="mt-2">
                            <v-col
                                v-for="color in colors"
                                :key="color.id"
                                :class="{ b_active: color.active }" 
                                class="mx-1 my-2 b_outlined py-2 pointer"
                                cols="2"
                                @click="pickColor(color)"
                            >
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-card
                                            :color="color.value"
                                            tile 
                                            flat 
                                            class="b_centered" 
                                            width="25" 
                                            height="25"
                                            v-on="on"
                                        >
                                            <div class="guyn"></div>
                                        </v-card>
                                    </template>

                                    <span>{{ color.name }}</span>
                                </v-tooltip>
                            </v-col>
                        </v-row>

                        <v-btn
                            small
                            color="#347cbb"
                            outlined
                            block
                            rounded
                            class="mt-3"
                            @click="allColors"
                        >Բոլոր գույները</v-btn>

                        <v-divider class="mt-5"></v-divider>
                    </template>

                    <template v-if="topSizes.length">
                        <h4 class="kapuyt mt-3">Ֆիլտրել ըստ չափի</h4>

                        <v-row no-gutters justify="space-around" class="mt-2">
                            <v-col
                                v-for="size in topSizes"
                                :key="size.id"
                                :class="{ b_active: size.active }" 
                                class="mx-1 my-2 b_outlined pa-1 pointer"
                                cols="2"
                                @click="pickSize(size, 'top')"
                            >
                                <v-card
                                    tile 
                                    flat 
                                    width="100%" 
                                >
                                    <v-card-text class="pa-0 text-center">
                                        {{ size.value }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>

                        <v-btn
                            small
                            color="#347cbb"
                            outlined
                            block
                            rounded
                            class="mt-3"
                            @click="allSizes('top')"
                        >Բոլոր չափերը</v-btn>

                        <v-divider class="mt-5"></v-divider>
                    </template>

                    <template v-if="pantsSizes.length">
                        <h4 class="kapuyt mt-3">Ֆիլտրել ըստ չափի</h4>

                        <v-row no-gutters justify="space-around" class="mt-2">
                            <v-col
                                v-for="size in pantsSizes"
                                :key="size.id"
                                :class="{ b_active: size.active }" 
                                class="mx-1 my-2 b_outlined pa-1 pointer"
                                cols="2"
                                @click="pickSize(size, 'pants')"
                            >
                                <v-card
                                    tile 
                                    flat 
                                    width="100%" 
                                >
                                    <v-card-text class="pa-0 text-center">
                                        {{ size.value }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>

                        <v-btn
                            small
                            color="#347cbb"
                            outlined
                            block
                            rounded
                            class="mt-3"
                            @click="allSizes('top')"
                        >Բոլոր չափերը</v-btn>

                        <v-divider class="mt-5"></v-divider>
                    </template>

                     <template v-if="shoeSizes.length">
                        <h4 class="kapuyt mt-3">Ֆիլտրել ըստ չափի</h4>

                        <v-row no-gutters justify="space-around" class="mt-2">
                            <v-col
                                v-for="size in shoeSizes"
                                :key="size.id"
                                :class="{ b_active: size.active }" 
                                class="mx-1 my-2 b_outlined pa-1 pointer"
                                cols="2"
                                @click="pickSize(size, 'shoe')"
                            >
                                <v-card
                                    tile 
                                    flat 
                                    width="100%" 
                                >
                                    <v-card-text class="pa-0 text-center">
                                        {{ size.value }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>

                        <v-btn
                            small
                            color="#347cbb"
                            outlined
                            block
                            rounded
                            class="mt-3"
                            @click="allSizes('top')"
                        >Բոլոր չափերը</v-btn>

                        <v-divider class="mt-5"></v-divider>
                    </template>

                    <template v-if="accessorySizes.length">
                        <h4 class="kapuyt mt-3">Ֆիլտրել ըստ չափի</h4>

                        <v-row no-gutters justify="space-around" class="mt-2">
                            <v-col
                                v-for="size in accessorySizes"
                                :key="size.id"
                                :class="{ b_active: size.active }" 
                                class="mx-1 my-2 b_outlined pa-1 pointer"
                                cols="2"
                                @click="pickSize(size, 'accessory')"
                            >
                                <v-card
                                    tile 
                                    flat 
                                    width="100%" 
                                >
                                    <v-card-text class="pa-0 text-center">
                                        {{ size.value }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>

                        <v-btn
                            small
                            color="#347cbb"
                            outlined
                            block
                            rounded
                            class="mt-3"
                            @click="allSizes('top')"
                        >Բոլոր չափերը</v-btn>

                        <v-divider class="mt-5"></v-divider>
                    </template>
                                    
                    <v-window v-model="step">
                        <v-window-item :value="1" style="overflow-y: auto; height: 550px;">
                            <v-list>
                                <v-list-item-group v-model="category" color="#347cbb">
                                    <v-list-item
                                        v-for="item in $store.state.upperMenu"
                                        :key="'category' + item.id"
                                        :value="item"
                                        @click="step++"
                                    >
                                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                                        <v-list-item-icon>
                                            <v-icon>mdi-chevron-right</v-icon>
                                        </v-list-item-icon>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-window-item>

                        <v-window-item :value="2" style="overflow-y: auto; height: 550px;">
                            <v-row no-gutters align="center">
                                <v-col cols="2">
                                    <v-btn icon class="mt-2" @click="step--">
                                        <v-icon>mdi-arrow-left</v-icon>
                                    </v-btn>
                                </v-col>

                                <v-col>
                                    <p class="ma-0 mt-2">{{ category.title }}</p>
                                </v-col>
                            </v-row>

                            <v-list dense>
                                <v-list-group
                                    v-for="subItem in category.children"
                                    :key="'subCategory' + subItem.id"
                                    @click="subCategory = subItem"
                                >
                                    <template v-slot:activator>
                                        <v-list-item-title class="pl-4">
                                            {{ subItem.title }}
                                        </v-list-item-title>
                                    </template>

                                    <v-list-item-group v-model="subSubCategory" color="#347cbb">
                                        <v-list-item
                                            v-for="subSubItem in subCategory.children"
                                            :key="'subSubItem' + subSubItem.id"
                                            :value="subSubItem"
                                            class="pa-0 pl-12"
                                        >
                                            <v-list-item-title v-text="subSubItem.title"></v-list-item-title>
                                        </v-list-item>
                                    </v-list-item-group>
                                </v-list-group>
                            </v-list>
                        </v-window-item>
                    </v-window>

                    <v-divider></v-divider>
                </v-col>

                <!-- products list -->
                <v-col cols="12" sm="12" md="9" lg="9" xl="9">
                    <v-row justify="space-around">
                        <v-col 
                            v-for="product in products" 
                            :key="`product-${product.id}`"
                            cols="10" sm="6"  md="4"
                            style="position: relative"
                        >
                            <v-skeleton-loader
                                v-if="skeleton"
                                class="mx-auto"
                                type="article, image@2"
                            ></v-skeleton-loader>

                            <v-hover
                                v-else
                                v-slot:default="{ hover }"
                            >
                                <v-card :elevation="hover ? 1 : 0" tile outlined @click="$router.push(`/product/${product.alias}`)">
                                    <v-card-title class="kapuyt" style="font-size: 15px">{{ product.title }}</v-card-title>

                                    <v-divider class="mb-3 mx-5"></v-divider>

                                    <v-img :src="product.main_image" height="300" width="450" contain></v-img>

                                    <v-divider class="mt-3 mx-5"></v-divider>

                                    <v-card-text v-text="hover ? product.short_description : product.short_descriptionShortened"></v-card-text>

                                    <v-divider class="mx-5"></v-divider>

                                    <v-card-title class="price">֏ 3500</v-card-title>
                                </v-card>
                            </v-hover>

                            <v-img src="/images/star-small.png" class="astx" contain></v-img>

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
        </v-col>
    </v-row>
</template>

<script>
import { mapMutations } from "vuex";

export default {
    name: "Products",
    data () {
        return {
            skeleton: false,
            products: [],
            category: {},
            subCategory: {},
            subSubCategory: {},
            minPrice: 0,
            maxPrice: 0,
            range: [],
            priceStart: 0,
            priceEnd: 0,
            colors: [],
            color: this.$route.query.color,
            topSizes: [],
            pantsSizes: [],
            shoeSizes: [],
            accessorySizes: [],
            size: this.$route.query.size,
            sizeType: this.$route.query.sizeType,
            step: 1,
            page: +this.$route.query.page,
            pagesLength: 0,
        }
    },

    computed: {
        params () {
            let params = "";
            if (this.$route.params.alias) params += this.$route.params.alias + "/";
            if (this.$route.params.subAlias) params += this.$route.params.subAlias + "/";
            if (this.$route.params.subSubAlias) params += this.$route.params.subSubAlias;

            return params;
        },

        queryString () {
            let obj = {
                page: this.page,
                minPrice: this.priceStart,
                maxPrice: this.priceEnd,
                color: this.color,
                size: this.size,
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

        favorites: {
            get() {
                return this.$store.state.favorites;
            },

            set(val) {
                this.updateFavorites(val);
            }
        },

        auth() { return this.$store.state.auth },
    },

    methods: {
        ...mapMutations(["updateFavorites"]),

        getProducts() {
            this.skeleton = true;

            axios.get(`/api/app/products/${this.params}${this.queryString}`)
                .then(res => {
                    this.products = res.data.products.data;
                    this.products = this.products.map(product => {
                        product.short_descriptionShortened = product.short_description.length > 90 ? product.short_description.slice(0, 87) + "..." : product.short_description;
                        product.favorite = false;
                        return product;
                    });

                    if (this.auth.check) {
                        this.auth.user.favorite_products.forEach(favorite => {
                            this.products.find(product => {
                                if (product.id === favorite.id) product.favorite = true;
                            });
                        })
                    } else {
                        let favorites = JSON.parse(localStorage.getItem("favorites"));
                        if (favorites) {
                            favorites.forEach(favorite => {
                                this.products.find(product => {
                                    if (product.id === favorite) product.favorite = true;
                                });
                            })
                        }
                    }
                    
                    if (res.data.alias) this.category = this.$store.state.upperMenu.find(item => item.id === res.data.alias.id);
                    if (res.data.subAlias) this.subCategory = this.category.children.find(item => item.id === res.data.subAlias.id);
                    if (res.data.subsubAlias) this.subSubCategory = this.subCategory.children.find(item => item.id === res.data.subsubAlias.id);

                    this.minPrice = res.data.minPrice;
                    this.maxPrice = res.data.maxPrice;

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

                    this.colors = res.data.colors.map(color => {
                        if (this.color === color.name) {
                            color.active = true;
                        } else {
                            color.active = false;
                        }
                        return color;
                    });

                    this.topSizes = res.data.sizes.filter(size => size.type === "Top");
                    this.topSizes.forEach(size => size.active = false);
                    this.pantsSizes = res.data.sizes.filter(size => size.type === "Pant");
                    this.pantsSizes.forEach(size => size.active = false);
                    this.shoeSizes = res.data.sizes.filter(size => size.type === "Shoe");
                    this.shoeSizes.forEach(size => size.active = false);
                    this.accessorySizes = res.data.sizes.filter(size => size.type === "Accessory");
                    this.accessorySizes.forEach(size => size.active = false);
                    this.pagesLength = Math.ceil(res.data.products.total / 15);
                    this.skeleton = false;
                })
                .catch(err => console.error(err.response.data.message));
        },

        filterPrice() {
            this.priceStart = this.range[0];
            this.priceEnd = this.range[1];
        },

        pickColor(color) {
            this.colors.forEach(color => color.active = false);
            color.active = true;
            this.color = color.name;
        },

        allColors() {
            this.colors.forEach(color => color.active = false);
            this.color = null;
        },

        pickSize(size, type) {
            this[type + 'Sizes'].forEach(size => size.active = false);
            size.active = true;
            this.size = size.id;
        },

        allSizes(type) {
            this[type + 'Sizes'].forEach(size => size.active = false);
            this.size = null;
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
    },

    watch: {
        queryString (val) {
            this.$router.push(`/products/${this.params}${val}`);
        },

        params (val) {
            if (!this.$route.query.page) this.$router.push({ query: Object.assign({}, { page: 1 }, this.$route.query) });
            this.getProducts();
        },

        category (newVal, oldVal) {
            if (!newVal) {
                this.category = oldVal;
            }
        },

        subSubCategory (newVal, oldVal) {
            if (newVal !== oldVal) {
                this.$router.push(`/products/${this.category.alias}/${this.subCategory.alias}/${newVal.alias}`);
            }
        },

        $route() {
            if (!this.$route.query.page) {
                this.$router.push({ query: Object.assign({}, { page: 1 }, this.$route.query) });
            }
        },
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
