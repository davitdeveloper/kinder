<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="orders">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Orders</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                    </v-card>
                </template>
                <template v-slot:item.status="{ item }">
                    <div v-if="item.status == 0">
                        <v-icon color="red">mdi-checkbox-blank-circle</v-icon><strong>Չհաստատված</strong>
                    </div>
                    <div v-if="item.status == 1">
                        <v-icon color="green">mdi-checkbox-blank-circle</v-icon><strong>Հաստատված</strong>
                    </div>
                </template>

                <template v-slot:item.action="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon class="mr-2" color="blue darken-3" v-on="on" @click="open(item)">
                                mdi-eye-outline
                            </v-icon>
                        </template>
                        <span>View Order Products</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon class="mr-2" color="blue darken-3" v-on="on" @click="completeOrder(item)">
                                mdi-bookmark-check
                            </v-icon>
                        </template>
                        <span>Complete Order</span>
                    </v-tooltip>
                </template>
            </v-data-table>

            <v-dialog v-model="dialog" max-width="70%" persistent>
                <v-card>
                    <v-card-title>
                        Order Products
                    </v-card-title>
                    <v-data-table :headers="productsHeaders" :items="products">
                        <template v-slot:item.product.model.main_image="{ item }">
                            <v-img :src="item.product.model.main_image" width="100"/>
                        </template>
                        <template v-slot:item.product.size.value="{ item }">
                            <span v-if="!item.product.size"> --- </span>
                            <span v-if="item.product.size"> {{ item.product.size.value }}</span>
                        </template>
                    </v-data-table>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="dialog = false">cancel</v-btn>
                        <v-btn color="#347cbb" dark width="90" @click="">save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card>
    </v-container>
</template>

<script>
    import axios from "axios";

    export default {
        name: "Orders",
        data: () => ({
            headers: [
                { text: "Order Id", value: "id", sortable: false },
                { text: "User Name", value: "user.name", sortable: false },
                { text: "Price/դր", value: "price", sortable: false },
                { text: "Address", value: "address", sortable: false },
                { text: "Phone", value: "phone", sortable: false },
                { text: "Status", value: "status", sortable: true },
                { text: "Order Date", value: "created_at", sortable: false },
                { text: "Action", value: "action", sortable: false },
            ],
            productsHeaders: [
                { text: "Title", value: "product.model.title", sortable: false },
                { text: "Manufacturer", value: "product.model.manufacturer.name", sortable: false },
                { text: "Color", value: "product.color.name", sortable: false },
                { text: "Size", value: "product.size.value", sortable: false },
                { text: "Quantity", value: "quantity", sortable: false },
                { text: "Image", value: "product.model.main_image", sortable: false },
                { text: "Single Price", value: "product.price", sortable: false },
                { text: "Price", value: "price", sortable: false }
            ],
            orders: [],
            products: [],
            dialog: false,
            errorMessage: "",
            valid: false,
            nameRules: [
                v => !!v || "This field is required",
            ],
        }),

        methods: {
            getOrders () {
                axios.get(`/api/profile/orders`)
                    .then(res => {
                        this.orders = res.data;
                    })
                    .catch(err => console.error(err.response.data.message));
            },

            open(item) {
                this.products = item.products;
                this.dialog = true;
            },

            completeOrder(item) {
                axios.get(`/api/profile/order/complete/${item.id}`)
                    .then(res => {
                        let index = this.orders.findIndex(order => order.id == res.data.id);
                        this.orders.splice(index, 1, res.data);
                    })
                    .catch(err => console.error(err.response.data.message));
            }


        },

        created () {
            this.getOrders();
        }
    }
</script>

<style scoped>
    .border-bottom {
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    }
</style>
