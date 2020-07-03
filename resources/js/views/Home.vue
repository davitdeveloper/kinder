<template>
    <v-row no-gutters justify="center" class="px-5">
        <v-col cols="12" sm="12" md="12" lg="10" xl="9">
            <v-row no-gutters justify="center" class="mt-7">
                <v-col v-if="$vuetify.breakpoint.mdAndUp" cols="1">
                    <v-card tile flat color="red darken-2" class="araqumDzax"></v-card>
                </v-col>

                <v-col cols="12" sm="12" md="10" class="px-0">
                    <v-row no-gutters>
                        <v-col v-if="!$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm" cols="2" class="px-0">
                            <v-alert dense tile color="red darken-2" dark class="text-center">
                                <v-icon color="yellow darken-2" class="py-1">
                                    mdi-star
                                </v-icon>
                                <v-icon color="yellow darken-2">
                                    mdi-star
                                </v-icon>
                                <v-icon color="yellow darken-2">
                                    mdi-star
                                </v-icon>
                            </v-alert>
                        </v-col>

                        <v-col cols="12" sm="12" md="8">
                            <v-alert tile color="red darken-2" dark class="text-center pa-1">
                                <v-icon x-large class="mr-3">mdi-truck</v-icon>
                                ԱՆՎՃԱՐ ԱՌԱՔՈՒՄ 10․000֏+ ՊԱՏՎԵՐԻ ԴԵՊՔՈՒՄ
                            </v-alert>
                        </v-col>

                        <v-col v-if="!$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm" cols="2" class="px-0">
                            <v-alert dense tile color="red darken-2" dark class="text-center">
                                <v-icon color="yellow darken-2" class="py-1">
                                    mdi-star
                                </v-icon>
                                <v-icon color="yellow darken-2">
                                    mdi-star
                                </v-icon>
                                <v-icon color="yellow darken-2">
                                    mdi-star
                                </v-icon>
                            </v-alert>
                        </v-col>
                    </v-row>
                </v-col>

                <v-col v-if="$vuetify.breakpoint.mdAndUp" cols="1">
                    <v-card tile flat color="red darken-2" class="araqumAj"></v-card>
                </v-col>
            </v-row>

            <v-row no-gutters>
                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-img src="images/banner.png" contain></v-img>
                </v-col>

                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-img src="images/banner.png" contain></v-img>
                </v-col>
            </v-row>

            <router-view name="section1"></router-view>

            <v-row no-gutters class="mt-7">
                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-img src="images/banner.png" contain></v-img>
                </v-col>

                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-img src="images/banner.png" contain></v-img>
                </v-col>
            </v-row>

            <router-view name="section2"></router-view>
        </v-col>

        <v-img src="/images/middle_banner.jpg" class="mt-3"></v-img>

        <v-col cols="12" sm="12" md="12" lg="10" xl="9">
            <router-view name="section3"></router-view>

            <v-row>
                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-img src="images/banner.png" contain></v-img>
                </v-col>

                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-img src="images/banner.png" contain></v-img>
                </v-col>
            </v-row>

            <router-view name="section4"></router-view>

            <v-row no-gutters>
                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-img src="images/banner.png" contain></v-img>
                </v-col>

                <v-col cols="12" sm="12" md="6" lg="6" xl="6">
                    <v-img src="images/banner.png" contain></v-img>
                </v-col>
            </v-row>

            <router-view name="section5"></router-view>
        </v-col>

        <v-container fluid class="pa-0">
            <v-card tile flat style="position: relative">
                <v-img src="/images/footer_middle_bg.jpg"></v-img>
                <v-img
                    v-for="(logo, i) in logos"
                    :key="i"
                    :src="logo.src"
                    :class="logo.class"
                ></v-img>
            </v-card>
        </v-container>


        <v-row no-gutters justify="space-between" style="background-color: #f0fbfb;" class="mt-12">
            <v-col cols="2">
                <v-img src="/images/happyLeft1.png" contain></v-img>
            </v-col>

            <v-col cols="7" align-self="center">
                <v-toolbar-title class="happy-clients">HAPPY CLIENTS</v-toolbar-title>
                <v-carousel
                    :show-arrows="false"
                    hide-delimiter-background
                    cycle
                    light
                    height="370"
                >
                    <v-carousel-item v-for="(slide, i) in slides" :key="i">
                        <v-row no-gutters align="center" justify="center">
                            <v-col
                                v-for="n in 3"
                                :key="n"
                                cols="12" sm="12" md="6" lg="5" xl="4"
                                class="pa-5"
                            >
                                <v-card flat color="#f0e68c">
                                    <v-card-text>
                                        Aenean massa. Cum sociis sem Theme natoque penatibus et magnis dis et magnis dis amet parturient montes natoque.
                                        Aenean massa. Cum sociis sem Theme natoque penatibus et magnis dis et magnis dis amet parturient montes natoque.
                                    </v-card-text>
                                </v-card>
                                <v-row class="mt-8" no-gutters align="center">
                                    <v-col cols="2">
                                        <v-avatar>
                                            <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" width="50">
                                        </v-avatar>
                                    </v-col>

                                    <v-col cols="6">
                                        <v-card-title class="pa-0">Russel Grey</v-card-title>
                                    </v-col>

                                    <v-col cols="4">
                                        <v-card-text class="pa-0">
                                            Dad of yours girl
                                        </v-card-text>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-carousel-item>
                </v-carousel>
            </v-col>

            <v-col cols="2">
                <v-img src="/images/happyRight1.png" contain></v-img>
            </v-col>
        </v-row>
    </v-row>

            <!-- <v-img src="/images/blog_layer1.png" class="shortik"></v-img>
            <v-img src="/images/blog_layer2.png" class="naski"></v-img>
            <v-img src="/images/blog_layer3.png" class="mayka"></v-img>
            <v-img src="/images/blog_layer4.png" width="100"></v-img>
            <v-row justify="center">
                <v-col cols="9">
                    <v-row justify="center">
                        <v-col cols="12" class="mt-8">
                            <h1 class="title blog">BLOG</h1>
                            <v-toolbar-title class="text-center mt-5">LATEST DISCUSSIONS</v-toolbar-title>
                        </v-col>

                        <v-col cols="5" class="my-8">
                            <v-row no-gutters justify="space-between" align="center">
                                <v-col cols="6">
                                    <div class="dottedGreen">
                                        <v-avatar size="300" class="blogPic">
                                            <img src="/images/preview1.jpg" alt="John">
                                        </v-avatar>
                                    </div>
                                </v-col>
                                <v-col cols="5">
                                    <h4>IT IS A LONG ESTABLISHED FACT THAT A READER WILL</h4>
                                    <p class="mt-3">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                        Aenean commodo ligula eget dolor. Aenean massa.
                                        Cum sociis natoque penatibus et magnis dis parturient
                                    </p>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="5" class="my-8">
                            <v-row no-gutters justify="space-between" align="center">
                                <v-col cols="6">
                                    <div class="dottedBlue">
                                        <v-avatar size="300" class="blogPic">
                                            <img src="/images/preview2.jpg" alt="John">
                                        </v-avatar>
                                    </div>
                                </v-col>
                                <v-col cols="5">
                                    <h4>IT IS A LONG ESTABLISHED FACT THAT A READER WILL</h4>
                                    <p class="mt-3">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                        Aenean commodo ligula eget dolor. Aenean massa.
                                        Cum sociis natoque penatibus et magnis dis parturient
                                    </p>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12" class="text-center my-8">
                            <v-btn color="#347cbb" x-large outlined rounded width="200">view all</v-btn>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row style="background-color: #4dc0a6; height: 100px;" justify="center">
                <v-col cols="6" style="position: relative">
                    <v-img src="/images/subscribe_bg.png" height="130" width="700" class="navak" contain></v-img>
                    <v-row justify="center" align="center" no-gutters>
                        <v-col cols="7" class="ml-12">
                            <v-text-field label="Email" class="ml-7"></v-text-field>
                        </v-col>
                        <v-col cols="4" class="text-right">
                            <v-btn class="subscribe" text x-large>subscribe</v-btn>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row> -->
</template>

<script>
import axios from "axios";

export default {
    name: "Home",
    data: () => ({
        logos: [
            { id: 1, src: "/images/logo1.jpg", class: "logo1" },
            { id: 2, src: "/images/logo2.jpg", class: "logo2" },
            { id: 3, src: "/images/logo3.jpg", class: "logo3" },
            { id: 4, src: "/images/logo4.jpg", class: "logo4" },
            { id: 5, src: "/images/logo5.jpg", class: "logo5" },
        ],
        colors: [
          'indigo',
          'warning',
          'pink darken-2',
        ],
        slides: [
          'First',
          'Second',
          'Third',
        ],
    }),
}
</script>

<style scoped>
.border {
    border: 1px solid black;
}

.borderTop {
    border-top: 2px solid #4dc0a6;
}

.araqumDzax {
    position: relative;
    padding: 24px 0;
}

.araqumDzax::after {
    content: " ";
    position: absolute;
    top: 0;
    left: 0;
    margin-left: -5px;
    border-width: 24px 34px;
    border-style: solid;
    border-color: #d32f2f #d32f2f #d32f2f transparent;
    background-color: white;
    z-index: 555;
}

.araqumAj {
    position: relative;
    padding: 24px 0;
}

.araqumAj::after {
    content: " ";
    position: absolute;
    top: 0;
    right: 0;
    margin-left: -5px;
    border-width: 24px 34px;
    border-style: solid;
    border-color: #d32f2f transparent #d32f2f #d32f2f;
    background-color: white;
    z-index: 555;
}

.logo1 {
    width: 9%;
    position: absolute;
    top: 45%;
    left: 13%;
}

.logo2 {
    width: 9%;
    position: absolute;
    top: 70%;
    left: 26%;
}

.logo3 {
    width: 9%;
    position: absolute;
    top: 44%;
    left: 41.5%;
}

.logo4 {
    width: 8%;
    position: absolute;
    top: 63%;
    right: 35.5%;
}

.logo5 {
    width: 9%;
    position: absolute;
    top: 50%;
    right: 19.5%;
}

.happy-clients {
    color: #4dc0a6;
    font-size: 50px !important;
    text-align: center;
    margin-bottom: 7%;
}

.blog {
    color: #4dc0a6;
    font-size: 57.27px !important;
    text-align: center;
}

.shortik {
    width: 105px;
    position: absolute;
    top: -31px;
    left: 270px;
}

.naski {
    width: 50px;
    position: absolute;
    top: -31px;
    right: 270px;
}

.mayka {
    width: 105px;
    position: absolute;
    top: -31px;
    right: 70px;
}

.dottedGreen {
    border: 3px dotted #4dc0a6;
    position: relative;
    height: 280px;
}

.dottedBlue {
    border: 3px dotted #347cbb;
    position: relative;
    height: 280px;
}

.blogPic {
    position: absolute;
    top: 2%;
    left: 2%;
}

.navak {
    position: absolute;
    top: -20px;
    left: 0;
}

.subscribe {
    font-size: 30px;
    color: #347cbb;
}
</style>
