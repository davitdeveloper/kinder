<template>
    <v-row no-gutters justify="center">
        <v-col cols="12" sm="12" md="12" lg="10" xl="9">
            <v-row no-gutters align="center" justify="space-between" class="px-3 my-3">
                <template v-if="$vuetify.breakpoint.xs">
                    <v-col cols="5" sm="3" class="b_pointer" @click="$router.push('/')">
                        <v-img src="/images/logo.png" contain width="80%" style="margin: auto;"></v-img>
                    </v-col>

                    <v-col cols="7" sm="8" class="text-right">
                        <v-btn icon color="#347cbb" class="mr-1">
                            <v-icon>mdi-facebook</v-icon>
                        </v-btn>
                        <v-btn icon color="#347cbb" class="mr-1">
                            <v-icon>mdi-instagram</v-icon>
                        </v-btn>
                        <v-btn icon color="#347cbb" class="mr-1">
                            <v-icon>mdi-twitter</v-icon>
                        </v-btn>
                        <v-btn icon color="#347cbb" class="mr-1">
                            <a style="text-decoration: none" href="/sign-in/pinterest"><v-icon>mdi-pinterest</v-icon></a>
                        </v-btn>
                    </v-col>

                    <v-col cols="12" sm="12" class="px-3 my-5">
                        <v-text-field
                            label="search"
                            color="#347cbb"
                            prepend-inner-icon="mdi-magnify"
                            rounded
                            outlined
                            dense
                            hide-details
                            single-line
                        ></v-text-field>
                    </v-col>
                </template>

                <template v-else-if="$vuetify.breakpoint.sm">
                    <v-col cols="5" sm="3" class="b_pointer" @click="$router.push('/')">
                        <v-img src="/images/logo.png" contain width="80%" style="margin: auto;"></v-img>
                    </v-col>

                    <v-col cols="7" sm="8" class="text-right">
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <v-icon>mdi-facebook</v-icon>
                        </v-btn>
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <v-icon>mdi-instagram</v-icon>
                        </v-btn>
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <v-icon>mdi-twitter</v-icon>
                        </v-btn>
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <a style="text-decoration: none" href="/sign-in/pinterest"><v-icon>mdi-pinterest</v-icon></a>
                        </v-btn>
                    </v-col>

                    <v-col cols="12" sm="12" class="px-3 my-5">
                        <v-text-field
                            label="search"
                            color="#347cbb"
                            prepend-inner-icon="mdi-magnify"
                            rounded
                            outlined
                            dense
                            hide-details
                            single-line
                        ></v-text-field>
                    </v-col>
                </template>

                <template v-else-if="$vuetify.breakpoint.md">
                    <v-col cols="2">
                        <v-img src="/images/logo.png" class="b_pointer ml-3" contain width="180" @click="$router.push('/')"></v-img>
                    </v-col>

                    <v-col cols="5" class="pl-3">
                        <v-text-field
                            label="search"
                            color="#347cbb"
                            prepend-inner-icon="mdi-magnify"
                            rounded
                            outlined
                            dense
                            hide-details
                            single-line
                        ></v-text-field>
                    </v-col>

                    <v-col cols="4">
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <v-icon>mdi-facebook</v-icon>
                        </v-btn>
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <v-icon>mdi-instagram</v-icon>
                        </v-btn>
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <v-icon>mdi-twitter</v-icon>
                        </v-btn>
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <a style="text-decoration: none" href="/sign-in/pinterest"><v-icon>mdi-pinterest</v-icon></a>
                        </v-btn>
                    </v-col>
                </template>

                <template v-else>
                    <v-col cols="2" class="b_pointer" @click="$router.push('/')">
                        <v-img src="/images/logo.png" contain width="80%" style="margin: auto;"></v-img>
                    </v-col>

                    <v-col cols="5">
                        <v-text-field
                            label="search"
                            color="#347cbb"
                            prepend-inner-icon="mdi-magnify"
                            rounded
                            outlined
                            dense
                            hide-details
                            single-line
                        ></v-text-field>
                    </v-col>

                    <v-col cols="4">
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <v-icon>mdi-facebook</v-icon>
                        </v-btn>
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <v-icon>mdi-instagram</v-icon>
                        </v-btn>
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <v-icon>mdi-twitter</v-icon>
                        </v-btn>
                        <v-btn icon large color="#347cbb" class="mr-1">
                            <a style="text-decoration: none" href="/sign-in/pinterest"><v-icon>mdi-pinterest</v-icon></a>
                        </v-btn>
                    </v-col>
                </template>
            </v-row>

            <v-col v-if="$vuetify.breakpoint.mdAndUp" sm="12" md="10" lg="10" xl="11" class="mt-3 py-0">
                <v-tabs v-model="tab" color="#347cbb" show-arrows center-active>
                    <v-tab>
                        <h4>Գլխավոր</h4>
                    </v-tab>
                    <v-tab v-for="item in items" :key="item.id">
                        <h4>{{ item.title }}</h4>
                    </v-tab>
                </v-tabs>
            </v-col>

            <v-tabs-items v-if="$vuetify.breakpoint.mdAndUp" v-model="tab" class="mx-3">
                <v-tab-item :value="0">
                    <v-row no-gutters>
                        <v-col cols="10">
                            <v-carousel v-model="carousel" :show-arrows="false" hide-delimiters cycle>
                                <v-carousel-item
                                  v-for="item in $store.state.slider"
                                  :key="'image' + item.id"
                                  :src="item.image"
                                ></v-carousel-item>
                            </v-carousel>
                        </v-col>

                        <v-col cols="2" class="pa-0" style="position: relative">
                            <div class="slideKid"></div>

                            <v-btn icon class="b_font" color="green" large style="position: absolute; bottom: 235px; right: 55px;" @click="carousel = 0">
                                1
                            </v-btn>
                            <v-btn icon class="b_font" color="green" large style="position: absolute; bottom: 195px; right: 55px;" @click="carousel = 1">
                                2
                            </v-btn>
                            <v-btn icon class="b_font" color="green" large style="position: absolute; bottom: 155px; right: 55px;" @click="carousel = 2">
                                3
                            </v-btn>
                            <v-btn icon class="b_font" color="green" large style="position: absolute; bottom: 115px; right: 55px;" @click="carousel = 3">
                                4
                            </v-btn>
                            <v-btn icon class="b_font" color="green" large style="position: absolute; bottom: 75px; right: 55px;" @click="carousel = 4">
                                5
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-tab-item>

                <v-tab-item v-for="item in items" :key="item.id" style="height: 500px;">
                    <v-row>
                        <v-col cols="6" v-for="subItem in item.children" :key="subItem.id">
                            <v-btn text color="#347cbb" @click="$router.push(`/products/${item.alias}/${subItem.alias}`)">
                                <h4>{{ subItem.title }}</h4>
                            </v-btn>

                            <v-list dense>
                                <v-list-item-group color="#347cbb">
                                    <v-row>
                                        <v-col
                                            v-for="(subArray, i) in subItem.children"
                                            :key="i"
                                            cols="4"
                                        >
                                            <v-list-item
                                                v-for="subsubItem in subArray"
                                                :key="subsubItem.id"
                                                @click="goTo(item.alias, subItem.alias, subsubItem.alias)"
                                            >
                                                <v-list-item-content>
                                                    <v-list-item-title v-text="subsubItem.title"></v-list-item-title>
                                                </v-list-item-content>
                                            </v-list-item>
                                        </v-col>
                                    </v-row>
                                </v-list-item-group>
                            </v-list>
                        </v-col>
                    </v-row>
                </v-tab-item>
            </v-tabs-items>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "Header",

    data: () => ({
        tab: 0,
        carousel: 0,
        items: [],
    }),

    computed: {
        menu () {
            return this.$store.state.menu;
        },
    },

    methods: {
        goTo(alias, subAlias, subSubAlias) {
            this.$router.push(`/products/${alias}/${subAlias}/${subSubAlias}`);
        },
    },

    created () {
        this.items = this.menu;
    }
}
</script>

<style scoped>
.border {
    border: 1px solid black;
}

.b_pointer {
    cursor: pointer;
}

.b_font {
    font-family: 'Amatic SC', cursive;
    font-size: 20px;
}

.slideKid {
    background: url("/images/slide_nav.png") no-repeat;
    width: 120px;
    height: 269px;
    position: absolute;
    right: 0;
    bottom: 0;
    border-bottom: 2px solid #347cbb;
}
</style>
