<template>
    <section style="margin: 0 16.57%;">
        <v-container>
            <template>
                <v-row justify="space-between" align="center">
                    <v-col cols="5" class="petlya">
                        <v-img src="/images/shape2.png" width="45" class="titer"></v-img>
                    </v-col>
                    <v-col cols="3" style="position:relative">
                        <h1 class="myInfo  text-center">Անձնական Էջ</h1>
                    </v-col>
                    <v-col cols="4" class="pl-10">
                        <div class="gic"></div>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row>
                        <v-tabs>
                            <v-tab style="display: flex;justify-content: start">
                                <v-icon left>mdi-account-badge-horizontal-outline</v-icon>
                                Տվյալներ
                            </v-tab>
                            <v-tab style="display: flex;justify-content: start">
                                <v-icon left>mdi-offer</v-icon>
                                Առաջարկներ
                            </v-tab>
                            <v-tab style="display: flex;justify-content: start">
                                <v-icon left>mdi-alpha-p-box-outline</v-icon>
                                Ապրանքներ
                            </v-tab>
                            <v-tab style="display: flex;justify-content: start">
                                <v-icon left>mdi-blogger</v-icon>
                                Հոդվածներ
                            </v-tab>
                            <v-tab style="display: flex;justify-content: start">
                                <v-icon left>mdi-blogger</v-icon>
                                Ռեզյումե
                            </v-tab>
                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text>
                                        <my-info></my-info>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text>
                                        <Offers></Offers>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text>
                                        <my-products></my-products>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text>
                                        <my-articles></my-articles>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text>
                                        <cv></cv>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                        </v-tabs>
                </v-row>
            </template>
        </v-container>
    </section>
</template>

<script>
    import Offers from "./Offers";
    import MyInfo from "./MyInfo";
    import MyProducts from "./MyProducts";
    import MyArticles from "./MyArticles";
    import Cv from "./Cv";
    export default {
        name: "Prof",
        components: {MyInfo, Offers, MyProducts, MyArticles,Cv},
        data () {
            return {
                mini: false,
                user: {},
            }
        },
    }
</script>

<style scoped>
    .petlya {
        height: 100px;
        background: url(/images/shape1.png) no-repeat;
        background-size: contain;
        position: relative;
    }
    .titer {
        position: absolute;
        right: -50px;
        top: -5px;
    }
    .gic {
        height: 2px;
        margin-top: 60px;
        background: url(/images/shape3.png);
        background-size: contain;
    }
    .myInfo {
        color: #4dc0a6;
        font-size: 3vw !important;
        position: absolute;
        top: -25px;
        left: -36%;
    }
</style>
