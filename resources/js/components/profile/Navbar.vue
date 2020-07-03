<template>
    <nav>
        <v-app-bar app flat>
            <v-progress-linear
                color="#347cbb"
                absolute top height="2"
                :active="loading"
                :indeterminate="loading"
            ></v-progress-linear>

            <v-btn icon color="#347cbb" @click="drawer = !drawer">
                <v-icon>mdi-menu</v-icon>
            </v-btn>

            <v-toolbar-title class="ml-10">
                <router-link to="/">
                    <v-img src="/images/logo.png" height="64" max-width="100"></v-img>
                </router-link>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <v-btn icon color="#347cbb" class="mr-1" to="/admin">
                        <v-icon v-on="on">mdi-account-outline</v-icon>
                    </v-btn>
                </template>

                <span>Account</span>
            </v-tooltip>
        </v-app-bar>

        <v-navigation-drawer v-model="drawer" app temporary width="268">
            <v-toolbar flat>
                <v-btn icon color="#347cbb" class="ml-1" @click="drawer = !drawer">
                    <v-icon>mdi-menu</v-icon>
                </v-btn>

                <v-toolbar-title class="ml-5">
                    <router-link to="/">
                        <v-img src="/images/logo.png" height="64" max-width="100"></v-img>
                    </router-link>
                </v-toolbar-title>
            </v-toolbar>

            <v-divider></v-divider>

            <v-list dense>
                <v-list-item-group v-model="item" color="#347cbb">
                    <v-list-item
                        v-for="(item, i) in items"
                        :key="i"
                        :to="item.to"
                    >
                        <v-list-item-icon>
                          <v-icon v-text="item.icon"></v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                          <v-list-item-title v-text="item.text"></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
    </nav>
</template>

<script>
export default {
    name: "Navbar",
    data: () => ({
        loading: false,
        drawer: false,
        item: null,
        items: [
            { text: "Users", icon: 'mdi-account-outline', to: "/profile/users", active: false },
            { text: "Contracts", icon: 'mdi-file-document-edit-outline', to: "/profile/contracts", active: false },
            { text: 'Manufacturers', icon: 'mdi-bank-outline', to: "/profile/manufacturers", active: false },
            { text: 'Global Sizes', icon: 'mdi-alpha-s-circle-outline', to: "/profile/globalSizes", active: false },
            { text: 'Manufacturer Sizes', icon: 'mdi-alpha-s-circle-outline', to: "/profile/sizes", active: false },
            { text: 'Colors', icon: 'mdi-palette-outline', to: "/profile/colors", active: false },
            { text: 'Product Models', icon: 'mdi-alpha-m-circle-outline', to: "/profile/productModels", active: false },
            { text: 'Products', icon: 'mdi-tshirt-crew-outline', to: "/profile/products", active: false },
            { text: 'Product Model Discount', icon: 'mdi-percent-outline', to: "/profile/modelDiscounts", active: false },
            { text: 'Product Discount', icon: 'mdi-percent-outline', to: "/profile/productDiscounts", active: false },
            { text: 'Tags', icon: 'mdi-bookmark-outline', to: "/profile/tags", active: false },
            { text: 'Article Categories', icon: 'mdi-shape-outline', to: "/profile/articleCategories", active: false },
            { text: 'Articles', icon: 'mdi-post-outline', to: "/profile/articles", active: false },
            { text: 'Company Info', icon: 'mdi-information-outline', to: "/profile/companyInfo", active: false },
            { text: 'Company Products', icon: 'mdi-alpha-p-circle-outline', to: "/profile/companyProducts", active: false },
            { text: 'Ads', icon: 'mdi-alpha-p-circle-outline', to: "/profile/ads", active: false },
            { text: 'HomePage Slider', icon: 'mdi-alpha-p-circle-outline', to: "/profile/sliders", active: false },
            { text: 'Orders', icon: 'mdi-account-cash-outline', to: "/profile/orders", active: false },
            { text: 'Opinions', icon: 'mdi-comment-quote-outline', to: "/profile/opinions", active: false },
        ],
    }),

    watch: {
        item(newVal, oldVal) {
            if (oldVal === -1) oldVal = null;
            if (oldVal || oldVal === 0) this.items[oldVal].icon = this.items[oldVal].icon + "-outline";
            if (~newVal) this.items[newVal].icon = this.items[newVal].icon.slice(0, -8);
        }
    },

    created () {
        this.item = this.items.findIndex(item => item.to === this.$route.path);
    }
}
</script>

<style scoped>
.border {
    border: 1px solid rgba(0, 0, 0, 0.12);
}
</style>
