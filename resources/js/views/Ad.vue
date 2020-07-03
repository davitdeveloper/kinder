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
                        <h1 class="mb-3 apranqiAnun">{{ this.product.title }}</h1>
                    </v-row>

                    <v-row justify="space-between">
                        <v-col cols="9">
                            <v-card>
                                <v-row justify="space-between" align="center">
                                    <v-col cols="5">
                                        <v-icon>mdi-map-marker-check</v-icon>
                                        <span>{{ this.product.city.name }}</span>
                                    </v-col>
                                    <v-col cols="4">
                                        <span>{{ this.product.created_at }}</span>
                                    </v-col>
                                    <v-col cols="2">
                                        <span style="color: #4dc0a6;font-size: 22px">{{ this.product.price }}դր․</span>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-card>
                                            <v-carousel hide-delimiters>
                                                <v-carousel-item
                                                    v-for="(image, i) in product.images"
                                                    :key="i"
                                                    :src="image.image"
                                                ></v-carousel-item>
                                            </v-carousel>
                                        </v-card>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="11">
                                        <strong class="ml-6">Վիճակ:</strong> <span class="ml-6">{{ this.product.condition }}</span>
                                    </v-col>
                                </v-row>
                                <v-row v-if="product.manufacturer">
                                    <v-col cols="11">
                                        <strong class="ml-6">Արտադրող:</strong> <span class="ml-6">{{ this.product.manufacturer }}</span>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="11">
                                        <h4 class="ml-6">Նկարագրություն</h4>
                                        <p class="ml-6">{{ this.product.description }}</p>
                                    </v-col>
                                </v-row>
                            </v-card>

                        </v-col>
                        <v-col cols="3">
                            <v-card>
                                <v-row justify="center">
                                    <h3>{{ product.owner.name }}</h3>
                                </v-row>
                                <v-divider class="mt-3 mb-3"></v-divider>
                                <v-row justify="center">
                                    <v-btn class="mb-3" large dark :href="'tel:+' + product.phone" color="#4dc0a6">
                                        <v-icon>mdi-phone</v-icon>{{ product.phone }}
                                    </v-btn>
                                </v-row>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<script>
    import axios from "axios";

    export default {
        name: "Ad",
        data: () => ({
            product: {},
        }),

        computed: {
            alias () {
                return this.$route.params.alias;
            },
        },

        methods: {
            getProduct() {
                axios.get(`/api/app/own-product/show/${this.alias}`)
                    .then(res => {
                        this.product = res.data.product;
                    })
                    .catch(err => console.error(err.response.data.message));
            },
        },

        created () {
            this.getProduct();
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
