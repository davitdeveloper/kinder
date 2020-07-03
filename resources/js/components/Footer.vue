<template>
    <v-row no-gutters justify="center" class="px-5">
        <v-col cols="12" sm="12" md="12" lg="11" xl="9">
            <v-row no-gutters justify="center" align="center">
                <v-col cols="12" sm="7" md="5" lg="5" style="position: relative">
                    <v-img src="/images/footer_icon.png"></v-img>
                    <v-img src="/images/logo.png" class="footerImage"></v-img>
                </v-col>

                <v-col cols="12" sm="12" md="12" lg="7" class="pa-3">
                    <v-row no-gutters>
                        <v-col cols="6" sm="4" md="4" lg="4" xl="4">
                            <v-list :dense="$vuetify.breakpoint.smAndDown">
                                <v-list-item-group v-model="usefulLink" color="#347cbb">
                                    <v-list-item dense class="mb-5" disabled>
                                        <v-toolbar-title class="b_blue" :class="{ fz: $vuetify.breakpoint.smAndDown }">Useful Links</v-toolbar-title>
                                    </v-list-item>
                                    <v-list-item
                                        v-for="link in usefulLinks"
                                        :key="link.id"
                                    >
                                        <v-list-item-title v-text="link.text"></v-list-item-title>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-col>

                        <v-col cols="6" sm="4" md="4" lg="4" xl="4">
                            <v-list :dense="$vuetify.breakpoint.smAndDown">
                                <v-list-item-group v-model="accountLink" color="#347cbb">
                                    <v-list-item dense class="mb-5" disabled>
                                        <v-toolbar-title class="b_blue" :class="{ fz: $vuetify.breakpoint.smAndDown }">My Account</v-toolbar-title>
                                    </v-list-item>

                                    <v-list-item
                                        v-for="link in accountLinks"
                                        :key="link.id"
                                    >
                                        <v-list-item-title v-text="link.text"></v-list-item-title>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-col>

                        <v-col cols="8" sm="4" md="4" lg="4" xl="4">
                            <v-list :dense="$vuetify.breakpoint.smAndDown">
                                <v-list-item-group v-model="customerServiceLink" color="#347cbb">
                                    <v-list-item dense class="mb-5" disabled>
                                        <v-toolbar-title class="b_blue" :class="{ fz: $vuetify.breakpoint.smAndDown }">Customer Service</v-toolbar-title>
                                    </v-list-item>
                                    
                                    <v-list-item
                                        v-for="link in customerServiceLinks"
                                        :key="link.id"
                                    >
                                        <v-list-item-title v-text="link.text"></v-list-item-title>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-col>
                    </v-row>

                    <v-row no-gutters>
                        <v-col class="borderGreen"></v-col>
                    </v-row>

                    <v-row no-gutters>
                        <v-col cols="12" lg="4" xl="4" class="text-center mt-3">
                            <v-btn icon :large="$vuetify.breakpoint.mdAndUp" color="#347cbb" class="mr-1">
                                <v-icon>mdi-facebook</v-icon>
                            </v-btn>
                            <v-btn icon :large="$vuetify.breakpoint.mdAndUp" color="#347cbb" class="mr-1">
                                <v-icon>mdi-instagram</v-icon>
                            </v-btn>
                            <v-btn icon :large="$vuetify.breakpoint.mdAndUp" color="#347cbb" class="mr-1">
                                <v-icon>mdi-twitter</v-icon>
                            </v-btn>
                            <v-btn icon :large="$vuetify.breakpoint.mdAndUp" color="#347cbb" class="mr-1">
                                <v-icon>mdi-pinterest</v-icon>
                            </v-btn>
                        </v-col>
                        <v-col cols="12" lg="8" xl="8" class="text-center mt-3">
                            <div>
                                {{ new Date().getFullYear() }} — <strong>kinder.am</strong>
                            </div>
                            Design & Development by 
                            <a href="https://gdesign.am/" target="blank">
                                G Design group
                            </a> 
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "Footer",
    data: () => ({
        usefulLinks: [
            { id: 1, text: "How it works" },
            { id: 2, text: "About us" },
            { id: 3, text: "Babysitters" },
            { id: 4, text: "Contact us" },
        ],
        usefulLink: undefined,
        accountLinks: [
            { id: 1, text: "Track my order" },
            { id: 2, text: "Terms of use" },
            { id: 3, text: "Wishlist" },
            { id: 4, text: "Submit Your feedback" },
        ],
        accountLink: undefined,
        customerServiceLinks: [
            { id: 1, text: "Help & Contact Us" },
            { id: 2, text: "Returns & Refunds" },
            { id: 3, text: "Online Stores" },
            { id: 4, text: "Terms & Condition" },
        ],
        customerServiceLink: undefined,
    }),
}
</script>

<style scoped>
.border {
    border: 1px solid black;
}

.borderGreen {
    border: 1px solid #4dc0a6;
}

.footerImage {
    width: 27%;
    position: absolute;
    top: 39%;
    left: 31%;
}

.b_blue {
    color: #347cbb;
}

.fz {
    font-size: 17px;
}
</style>