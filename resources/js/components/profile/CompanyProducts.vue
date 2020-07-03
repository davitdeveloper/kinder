<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="products">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Products</v-toolbar-title>
                        </v-toolbar>
                    </v-card>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
    import Product from "../../models/Product";
    import axios from "axios";

    export default {
        name: "CompanyProducts",
        data: () => ({
            headers: [
                { text: "Product Model", value: "model.title" },
                { text: "Description", value: "model.short_description" },
                { text: "Size", value: "size.value", sortable: false },
                { text: "Color", value: "color.name", sortable: false },
            ],
            products: [],
            product: [],
            errorMessage: "",
        }),
        methods: {
            getProducts () {
                if(this.$store.state.auth.user){
                    return axios.get(`/api/profile/get-distributor-products/${this.$store.state.auth.user.id}`)
                        .then(res => {
                            this.products = res.data;
                            // console.log(res.data);
                        })
                        .catch(err => console.error(err.response.data.message));
                }else{
                    return alert('not loggin');
                }
            },
        },

        created () {
            this.getProducts();
        }
    }
</script>

<style scoped>

</style>
