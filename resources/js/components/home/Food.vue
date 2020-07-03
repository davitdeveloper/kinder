<template>
    <v-row no-gutters align="center" class="mt-7">
        <v-col v-if="$vuetify.breakpoint.smAndUp" cols="5" sm="4" md="3" lg="3" xl="3">
            <v-row no-gutters justify="center">
                <v-col
                    v-for="image in images"
                    :key="image.id"
                    cols="6" md="5" lg="5" xl="4"
                    class="text-center"
                >
                    <v-img :src="image.src" width="75.5" :height="image.height" class="opacity" contain :class="{ active: image.active }" @click="makeActive(image)"></v-img>
                    <v-toolbar-title class="opacity" v-text="image.text" :style="{ marginTop: image.margin + 'px' }" :class="{ active: image.active }" @click="makeActive(image)"></v-toolbar-title>
                </v-col>
            </v-row>
        </v-col>

        <v-col cols="12" sm="8" md="9" lg="9" xl="9">
            <v-row no-gutters justify="space-between">
                <v-col v-if="$vuetify.breakpoint.mdAndUp" cols="4" md="3" lg="3" xl="4">
                    <div class="gic"></div>
                </v-col>

                <v-col cols="12" sm="12" md="4" lg="4" xl="3" style="position: relative;">
                    <v-toolbar-title
                        class="text-center" 
                        :class="{
                            b_title: $vuetify.breakpoint.smAndDown,
                            b_title_MdAndUp: $vuetify.breakpoint.mdAndUp, 
                        }"
                    >Սնունդ</v-toolbar-title>
                    <v-img src="/images/shape2.png" width="45" class="titer"></v-img>
                </v-col>

                <v-col cols="12" sm="12" md="5" lg="5" xl="5">
                    <v-row no-gutters align="center" justify="space-around">
                        <v-col v-if="$vuetify.breakpoint.mdAndUp" cols="6" md="4" lg="5" xl="6">
                            <div class="gic"></div>
                        </v-col>
                        <v-col cols="12" sm="12" md="8" lg="7" xl="6">
                            <v-toolbar-title
                                class="text-center"
                                :class="{
                                    b_subtitle: $vuetify.breakpoint.smAndDown,
                                    b_subtitle_MdAndUp: $vuetify.breakpoint.mdAndUp,
                                }"
                            >0+ տարեկան</v-toolbar-title>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>

        <v-row no-gutters class="mt-6">
            <v-col v-if="$vuetify.breakpoint.smAndUp" cols="5" sm="4" md="3" lg="3" xl="3" class="catHolder" id="style-5">
                <v-list v-if="items.length" class="pa-0">
                    <v-list-item-group>
                        <v-list-item
                            v-for="(item, i) in items"
                            :key="i"
                            :to="'/products/' + grandParent + '/' + parent + '/' + item.alias"
                            class="drawerLink"
                        >
                            <v-list-item-content>
                              <v-list-item-title v-text="item.title"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-col>

            <v-col cols="12" sm="8" md="9" lg="9" xl="9">
                <v-carousel hide-delimiters cycle show-arrows show-arrows-on-hover height="570">
                    <v-carousel-item
                      v-for="(arr, i) in products"
                      :key="'arr' + i"
                    >
                        <v-row no-gutters  justify="center">
                            <v-col cols="12">
                                <v-row no-gutters justify="space-around">
                                    <v-col
                                        v-for="product in arr"
                                        :key="`product-${product.id}`"
                                        cols="10" sm="9" md="5" lg="5" xl="4"
                                        style="position: relative"
                                        class="px-3"
                                    >
                                        <v-hover v-slot:default="{ hover }">
                                            <v-card :elevation="hover ? 1 : 0" tile outlined color="white" light @click="$router.push(`/product/${product.alias}`)">
                                                <v-card-title class="productTitle mx-1">{{ product.title }}</v-card-title>

                                                <v-divider class="mb-3 mx-5"></v-divider>

                                                <v-img :src="product.main_image" height="300" width="450" contain></v-img>

                                                <v-divider class="mt-3 mx-5"></v-divider>

                                                <v-card-text v-text="hover ? product.short_description : product.description_shortened"></v-card-text>

                                                <v-divider class="mx-5"></v-divider>

                                                <v-card-title class="price" v-text="product.price + ' դր․'"></v-card-title>
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
                            </v-col>
                        </v-row>
                    </v-carousel-item>
                </v-carousel>
            </v-col>
        </v-row>
    </v-row>
</template>

<script>
export default {
    name: "Food",
    data: () => ({
        skeleton: false,
        images: [
            { id: 1, src: "/images/boys_3.png", text: "Հեղուկ", height: 80, margin: 10, active: true },
            { id: 2, src: "/images/girls_3.png", text: "Պինդ", height: 90, margin: 1, active: false },
        ],
        item: 0,
    }),

    computed: {
        grandParent () {
            return this.$store.state.upperMenu.find(category => category.alias === "snund").alias;
        },

        parent () {
            return this.$store.state.upperMenu.find(category => category.alias === "snund").children[this.item].alias;
        },

        items () {
            return this.$store.state.upperMenu.find(category => category.alias === "snund").children[this.item].children;
        },

        products () {
            return this.$store.state.homeProducts.food;
        }
    },

    methods: {
        makeActive (image) {
            this.images.forEach(image => image.active = false);
            image.active = true;
            if(image.text === "Հեղուկ") {
                this.item = 0;
            } else {
                this.item = 1;
            }
        },

        makeFavorite(product) {
            product.favorite = true;
            this.$forceUpdate();

            if (!this.$store.state.auth.check) {
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
            } else {
                this.$http.post(`/shopping-cart/${this.$store.state.auth.user.id}`)
                    .then(res => this.$store.commit("updateFavorites", product.id))
                    .catch(err => console.error(err.response.data.message));

            }
        },

        removeFromFavorites(product) {
            product.favorite = false;
            this.$forceUpdate();

            if (!this.$store.state.auth.check) {
                let favorites = JSON.parse(localStorage.getItem("favorites"));

                let index = favorites.findIndex(favorite => favorite === product.id);
                favorites.splice(index, 1);
                localStorage.setItem("favorites", JSON.stringify(favorites));
                this.$store.commit("updateFavorites", favorites);
            } else {
                this.$http.post(`/favorites/${product.id}/${this.$store.state.auth.user.id}`)
                    .then(res => this.$store.commit("updateFavorites", res.data.id))
                    .catch(err => console.error(err));

            }
        },
    },
}
</script>

<style scoped>
.border {
    border: 1px solid black;
}

.opacity {
    cursor: pointer;
    opacity: 0.5;
    color: #347cbb;
    margin: 0 auto;
}

.active {
    opacity: 1;
}

.b_title {
    color: #4dc0a6;
    font-size: 30px;
}

.b_title_MdAndUp {
    color: #4dc0a6;
    font-size: 50px !important;
}

.b_subtitle {
    color: #347cbb;
    font-size: 17px;
}

.b_subtitle_MdAndUp {
    color: #347cbb;
    font-size: 25px;
    margin-top: 12px;
}

.titer {
    position: absolute;
    right: 0;
    top: -15px;
}

.gic {
    height: 2px;
    margin-top: 60px;
    background: url(/images/shape3.png);
    background-size: contain;
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
    top: 112px;
    left: 20px;
}

.srtik {
    cursor: pointer;
    opacity: 0.3;
    filter: grayscale(100%);
    width: 40px;
    position: absolute;
    top: 112px;
    right: 20px;
}

.favoriteSrtik {
    cursor: pointer;
    width: 40px;
    position: absolute;
    top: 112px;
    right: 20px;
}

.srtik:hover {
    opacity: 1;
    filter: none;
}

.productTitle {
    color: #4dc0a6;
    height: 96px;
    font-size: 15px;
}

.catHolder {
    overflow-y: scroll;
    max-height: 490px;
}

#style-5::-webkit-scrollbar-track {
    box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}

#style-5::-webkit-scrollbar {
	width: 10px;
	background-color: #F5F5F5;
}

#style-5::-webkit-scrollbar-thumb {
	background-color: #0ae;
	background-image: -webkit-gradient(linear, 0 0, 0 100%,
	                   color-stop(.5, rgba(255, 255, 255, .2)),
					   color-stop(.5, transparent), to(transparent));
}
</style>
