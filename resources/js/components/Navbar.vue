<template>
    <v-row no-gutters justify="center">
        <v-col cols="12" sm="12" md="12" lg="10" xl="9" class="pa-0" style="position: relative;">
            <v-row no-gutters align="center">
                <v-col cols="12">
                    <v-toolbar v-if="$vuetify.breakpoint.xs" flat>
                        <v-menu offset-y>
                            <template v-slot:activator="{ on }">
                                <v-btn x-small text color="#347cbb" height="48" v-on="on">
                                    <span class="navbar-btn">Կապնվեք մեզ հետ</span>
                                    <v-icon>mdi-menu-down</v-icon>
                                </v-btn>
                            </template>

                            <v-list>
                                <v-list-item
                                    v-for="contact in contacts"
                                    :key="contact.icon"
                                >
                                    <v-btn text :color="contact.color" class="px-0">
                                        <v-icon class="mr-4" :color="contact.color" v-text="contact.icon"></v-icon>
                                        {{ contact.text }}
                                    </v-btn>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                        <v-btn text x-small color="#347cbb" height="48">
                            <v-icon>mdi-phone</v-icon>
                            093 45 45 45
                        </v-btn>

                        <v-spacer></v-spacer>

                        <v-btn icon color="#347cbb" @click="drawer = true">
                            <v-icon>mdi-menu</v-icon>
                        </v-btn>
                    </v-toolbar>

                    <v-toolbar v-else-if="$vuetify.breakpoint.sm" flat>
                        <v-menu offset-y>
                            <template v-slot:activator="{ on }">
                                <v-btn text color="#347cbb" height="48" v-on="on">
                                    <span class="navbar-btn">Կապնվեք մեզ հետ</span>
                                    <v-icon>mdi-menu-down</v-icon>
                                </v-btn>
                            </template>

                            <v-list>
                                <v-list-item
                                    v-for="contact in contacts"
                                    :key="contact.icon"
                                >
                                    <v-btn text :color="contact.color" class="px-0">
                                        <v-icon class="mr-4" :color="contact.color" v-text="contact.icon"></v-icon>
                                        {{ contact.text }}
                                    </v-btn>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                        <v-btn text color="#347cbb" height="48">
                            24/7 -
                            <v-icon>mdi-phone</v-icon>
                            093 45 45 45
                        </v-btn>

                        <v-btn v-if="$vuetify.breakpoint.md" text color="#347cbb" height="48" class="navbar-btn">
                            Միացեք մեզ & շահեք բոնուսներ
                        </v-btn>

                        <v-spacer></v-spacer>

                        <v-btn icon color="#347cbb" @click="drawer = true">
                            <v-icon>mdi-menu</v-icon>
                        </v-btn>
                    </v-toolbar>

                    <template v-else-if="$vuetify.breakpoint.md">
                        <v-menu offset-y>
                            <template v-slot:activator="{ on }">
                                <v-btn text color="#347cbb" height="48" class="bx ml-3" v-on="on">
                                    <span class="navbar-btn">Կապնվեք մեզ հետ</span>
                                    <v-icon>mdi-menu-down</v-icon>
                                </v-btn>
                            </template>

                            <v-list>
                                <v-list-item
                                    v-for="contact in contacts"
                                    :key="contact.icon"
                                >
                                    <v-btn text :color="contact.color" class="px-0">
                                        <v-icon class="mr-4" :color="contact.color" v-text="contact.icon"></v-icon>
                                        {{ contact.text }}
                                    </v-btn>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                        <v-btn text color="#347cbb" height="48" class="br">
                            24/7 -
                            <v-icon>mdi-phone</v-icon>
                            093 45 45 45
                        </v-btn>

                        <v-btn text color="#347cbb" height="48" class="navbar-btn">
                            Միացեք մեզ & շահեք բոնուսներ
                        </v-btn>

                        <div class="lenta mr-3">
                            <div class="lentaMenu py-2" @click="drawer = true">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>

                            <div class="lentaCart" @click="$router.push('/cart')">
                                <div>
                                    <span>
                                        {{ this.$store.state.auth.check ?
                                           this.$store.state.auth.user.shop_products.length : this.$store.state.cardProducts.length }}
                                    </span>
                                </div>
                            </div>

                            <div class="lentaWish" @click="$router.push('/wish')">
                                <div>
                                    <span>
                                        {{ this.$store.state.auth.check ?
                                           this.$store.state.auth.user.favorite_products.length : this.$store.state.favorites.length }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <v-menu offset-y>
                            <template v-slot:activator="{ on }">
                                <v-btn text color="#347cbb" height="48" class="bx ml-3" v-on="on">
                                    <span class="navbar-btn">Կապնվեք մեզ հետ նաև</span>
                                    <v-icon>mdi-menu-down</v-icon>
                                </v-btn>
                            </template>

                            <v-list>
                                <v-list-item
                                    v-for="contact in contacts"
                                    :key="contact.icon"
                                >
                                    <v-btn text :color="contact.color" class="px-0">
                                        <v-icon class="mr-4" :color="contact.color" v-text="contact.icon"></v-icon>
                                        {{ contact.text }}
                                    </v-btn>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                        <v-btn href="tel:+093 45 45 45" text color="#347cbb" height="48" class="navbar-btn br">
                            Հասանելի 24/7 -
                            <v-icon>mdi-phone</v-icon>
                            093 45 45 45
                        </v-btn>

                        <v-btn text color="#347cbb" height="48" class="navbar-btn">
                            Միացեք մեզ & շահեք բոնուսներ
                        </v-btn>

                        <div class="lenta mr-3">
                            <div class="lentaMenu py-2" @click="drawer = true">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>

                            <div class="lentaCart" @click="$router.push('/cart')">
                                <div>
                                    <span>
                                        {{ this.$store.state.auth.check ?
                                           this.$store.state.auth.user.shop_products.length : this.$store.state.cardProducts.length }}
                                    </span>
                                </div>
                            </div>

                            <div class="lentaWish" @click="$router.push('/wish')">
                                <div>
                                    <span>
                                        {{ this.$store.state.auth.check ?
                                           this.$store.state.auth.user.favorite_products.length : this.$store.state.favorites.length }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>
                </v-col>
            </v-row>
        </v-col>


        <v-navigation-drawer
            v-model="drawer"
            color="#347cbb"
            app
            right
            temporary
            style="z-index: 556"
        >
            <v-toolbar flat color="#347cbb" dense>
                <v-btn icon x-large dark>
                    <v-icon @click="drawer = false">mdi-close</v-icon>
                </v-btn>

                <v-card-title>
                    <span class="white--text">Close</span>
                </v-card-title>
            </v-toolbar>

            <v-row justify="center">
                <v-col cols="9">
                    <v-list color="#347cbb" dark>
                        <v-list-item-group v-model="item">

                            <v-list-item
                                v-if="!this.$store.state.auth.check"
                                class="drawerLink"
                                to="/register"
                            >
                                <v-list-item-content class="text-center">
                                    <v-list-item-title>Register</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-if="!this.$store.state.auth.check"
                                class="drawerLink"
                                to="/login"
                            >
                                <v-list-item-content class="text-center">
                                    <v-list-item-title>Login</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                class="drawerLink"
                                to="/blog"
                            >
                                <v-list-item-content class="text-center">
                                    <v-list-item-title>Blog</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-if="this.$store.state.auth.check && this.$store.state.auth.user.role_id !== 2"
                                class="drawerLink"
                                to="/profile"
                            >
                                <v-list-item-content class="text-center">
                                    <v-list-item-title>Dashboard</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-if="this.$store.state.auth.check"
                                class="drawerLink"
                                to="/prof"
                            >
                                <v-list-item-content class="text-center">
                                    <v-list-item-title>Profile</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                class="drawerLink"
                                to="/opinions"
                            >
                                <v-list-item-content class="text-center">
                                    <v-list-item-title>Կարծիքներ</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-if="this.$store.state.auth.check"
                                class="drawerLink"
                            >
                                <v-list-item-content class="text-center">
                                    <form action="/logout" method="post">
                                        <input :value="$csrf" name="_token" type="hidden" />
                                        <button type="submit">
                                            Logout
                                        </button>
                                    </form>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </v-col>
            </v-row>
        </v-navigation-drawer>
    </v-row>
</template>

<script>
export default {
    name: 'Navbar',
    data: () => ({
        drawer: false,
        item: null,
        items: [
            { text: "Register", to: "/register" },
            { text: "Login", to: "/login" },
            { text: "Dashboard", to: "/profile" },
            { text: "Cart", to: "/cart" },
            { text: "WishList", to: "/wish" },
            { text: "Prof", to: "/prof" },
        ],
        contacts: [
            { icon: "mdi-whatsapp", text: "+374 91-07-88-00", color: "green" },
            { icon: "mdi-phone-in-talk", text: "+374 91-07-88-00", color: "purple" },
            { icon: "mdi-skype", text: "+374 91-07-88-00", color: "blue" },
        ]
    }),
};
</script>

<style scoped>
.border {
    border: 1px solid black;
}

.bx {
    border-left: 1px solid rgba(0, 0, 0, 0.12);
    border-right: 1px solid rgba(0, 0, 0, 0.12);
}

.br {
    border-right: 1px solid rgba(0, 0, 0, 0.12);
}

.navbar-btn {
    text-transform: none;
    font-weight: 550;
}

.lenta {
    height: 320px;
    width: 116px;
    position: absolute;
    top: 0;
    right: -3px;
    background: url('/images/right_pls.png') no-repeat;
    z-index: 555;
}

.lentaMenu {
    cursor: pointer;
    width: 44%;
    margin: 0 auto;
    margin-bottom: 50px;
}

.lentaMenu div {
    height: 4px;
    background-color: white;
    margin: 0 auto;
    margin-top: 6px;
    margin-bottom: 6px;
}

.lentaCart {
    cursor: pointer;
    width: 40%;
    margin: 0 auto;
    margin-bottom: 50px;
}

.lentaCart div {
    height: 50px;
    background: url('/images/bag_icon.png') no-repeat;
    position: relative;
}

.lentaCart span {
    position: absolute;
    top: 14px;
    right: 0;
    padding: 3px 6px;
    font-size: 14px;
    color: white;
}

.lentaWish {
    cursor: pointer;
    width: 44%;
    margin: 0 auto;
}

.lentaWish div {
    height: 50px;
    background: url('/images/wish_icon.png') no-repeat;
    position: relative;
}

.lentaWish span {
    position: absolute;
    top: 9px;
    right: 0;
    padding: 3px 5px;
    font-size: 14px;
    color: white;
}

.drawerLink {
    border-bottom: 2px solid #4dc0a6;
}
</style>
