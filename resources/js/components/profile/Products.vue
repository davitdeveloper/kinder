<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="products">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Products</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new product</v-btn>
                        </v-toolbar>
                    </v-card>
                </template>

                <template v-slot:item.action="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon class="mr-2" color="yellow darken-3" v-on="on" @click="open(item, 2)">
                                mdi-pencil-outline
                            </v-icon>
                        </template>
                        <span>Update</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon color="red" v-on="on" @click="remove(item)">
                                mdi-delete-outline
                            </v-icon>
                        </template>
                        <span>Delete</span>
                    </v-tooltip>
                </template>
            </v-data-table>

            <v-dialog v-model="dialog" max-width="50%" persistent>
                <v-card>
                    <v-card-title>
                        {{ title }}
                    </v-card-title>

                    <v-form v-model="valid">
                        <v-container>
                            <v-row no-gutters justify="space-around">
                                <!-- product.model_id -->
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-autocomplete
                                            v-model="product.model_id"
                                            :items="productModels"
                                            return-object
                                            item-value="id"
                                            item-text="title"
                                            :search-input.sync="search"
                                            label="մոդել"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            prepend-inner-icon="mdi-database-search"
                                            hide-selected
                                            outlined
                                            dense
                                            clearable
                                            open-on-clear
                                        ></v-autocomplete>
                                    </v-card>
                                </v-col>
                                <!-- product.color_id -->
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-select
                                            v-model="product.color_id"
                                            :rules="nameRules"
                                            :items="colors"
                                            item-text="name"
                                            item-value="id"
                                            menu-props="offsetY"
                                            label="գույն"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                            open-on-clear
                                        >
                                            <template v-slot:item="{ item }">
                                                <v-row no-gutters justify="space-between">
                                                    <v-col cols="6">
                                                        {{ item.name }}
                                                    </v-col>
                                                    <v-col cols="3">
                                                        <v-card flat tile class="pa-3" width="100%" :color="item.value">
                                                        </v-card>
                                                    </v-col>
                                                </v-row>
                                            </template>
                                        </v-select>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="center">
                                <!-- model - selectedSizes -->
                                <!-- items - sizes -->
                                <v-col cols="11">
                                    <v-card tile flat>
                                        <v-select
                                            v-model="selectedSizes"
                                            :rules="nameRules"
                                            :items="sizes"
                                            item-text="size.value"
                                            return-object
                                            menu-props="offsetY"
                                            label="չափս"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            :multiple="mode === 1"
                                            outlined
                                            dense
                                            clearable
                                            open-on-clear
                                        ></v-select>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row justify="center">
                                <!-- selected sizes v-for -->
                                <v-col cols="11">
                                    <v-row
                                        v-for="(info, i) in productInfos"
                                        :key="i"
                                        no-gutters
                                        justify="space-between"
                                    >
                                        <v-col cols="1">
                                            {{ info.value }}
                                        </v-col>

                                        <v-col cols="2">
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="info.price"
                                                    :rules="nameRules"
                                                    label="գին"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                ></v-text-field>
                                            </v-card>
                                        </v-col>

                                        <v-col cols="2">
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="info.quantity"
                                                    :rules="nameRules"
                                                    label="քանակ"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                ></v-text-field>
                                            </v-card>
                                        </v-col>

                                        <v-col cols="2">
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="info.SCU"
                                                    :rules="nameRules"
                                                    label="SCU"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                ></v-text-field>
                                            </v-card>
                                        </v-col>

                                        <v-col v-if="offerable" cols="3">
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="info.min_offer_count"
                                                    :rules="nameRules"
                                                    label="Min Offer Count"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                ></v-text-field>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="center">
                                <!-- model - selectedDistributors -->
                                <!-- items - distributors -->
                                <v-col cols="11">
                                    <v-card tile flat>
                                        <v-select
                                            v-model="selectedDistributors"
                                            :rules="nameRules"
                                            :items="distributors"
                                            return-object
                                            menu-props="offsetY"
                                            label="մատակարար(ներ)"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            multiple
                                            outlined
                                            dense
                                            clearable
                                            open-on-clear
                                        ></v-select>
                                    </v-card>
                                </v-col>
                            </v-row>
                            <!-- v-for product.distributors  -->
                            <v-row
                                v-for="distributor in product.distributors"
                                :key="distributor.id"
                                no-gutters
                                justify="space-around"
                            >
                                <v-col cols="3">
                                    {{ distributor.text }}
                                </v-col>

                                <v-col cols="3">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="distributor.price"
                                            :rules="nameRules"
                                            label="գին"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>

                                <v-col cols="3">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="distributor.quantity"
                                            :rules="nameRules"
                                            label="քանակ"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <!-- images -->
                            <v-row no-gutters justify="center">
                                <v-col cols="11">
                                    <v-card tile flat>
                                        <v-file-input
                                            label="ապրանքի նկարներ"
                                            color="#347cbb"
                                            multiple
                                            dense
                                            outlined
                                            @change="onFilesSelected"
                                        ></v-file-input>
                                    </v-card>
                                </v-col>
                                <v-col cols="11">
                                    <v-card tile outlined>
                                        <v-row no-gutters justify="space-around">
                                            <v-col
                                                v-for="(image, i) in product.images"
                                                :key="i"
                                                cols="3"
                                            >
                                                <v-card tile outlined style="position: relative;">
                                                    <v-img :src="image" contain></v-img>
                                                    <v-btn icon color="red" class="deleteImage" @click="deleteImage(image)">
                                                        <v-icon>mdi-close</v-icon>
                                                    </v-btn>
                                                </v-card>
                                            </v-col>
                                        </v-row>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                    {{ errorMessage }}
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="dialog = false">cancel</v-btn>
                        <v-btn color="#347cbb" dark width="90" @click="save">save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card>
    </v-container>
</template>

<script>
import axios from "axios";
import Product from "../../models/Product";
import Distributor from "../../models/Distributor";
import ProductInfo from "../../models/ProductInfo";

export default {
    name: "Products",
    data: () => ({
        headers: [
            { text: "Product Model", value: "model.title" },
            { text: "Size", value: "size.value", sortable: false },
            { text: "Color", value: "color.name", sortable: false },
            { text: "SCU", value: "SCU", sortable: false },
            { text: "Price", value: "price" },
            { text: "Old Price", value: "old_price", sortable: false },
            { text: "Quantity", value: "quantity" },
            { text: "Distributor Quantity", value: "distributors.length" },
            { text: "Action", value: "action", sortable: false },
        ],
        products: [],
        product: new Product(),
        productModels: [],
        search: "",
        sizes: [],
        selectedSizes: [],
        productInfos: [],
        colors: [],
        distributors: [],
        selectedDistributors: [],
        dialog: false,
        mode: 0,
        errorMessage: "",
        valid: false,
        nameRules: [
            // v => !!v || "This field is required",
        ],
        offerable: false,
    }),

    computed: {
        title () {
            return this.mode === 1 ? "New Product" : "Update Product"
        },
    },

    methods: {
        getProducts () {
            axios.get(`/api/profile/products`)
                .then(res => {
                    this.products = res.data.map(data => {
                        data.info = {
                            SCU: data.SCU,
                            price: data.price,
                            quantity: data.quantity,
                            min_offer_count: data.min_offer_count,
                        };
                        data.images = data.images.map(image => {
                            image = image.image;
                            return image;
                        })
                        return data;
                    });
                })
                .catch(err => console.error(err.response.data.message));
        },

        getDistributors () {
            axios.get(`/api/profile/distributors`)
                .then(res => {
                    this.distributors = res.data.map(user => {
                        user.text = user.name + " \"" + user.distributor.company + "\" ";
                        return user;
                    });
                })
                .catch(err => console.error(err.response.data.message));
        },

        open(item, mode) {
            this.product = new Product(item);
            if (this.product.id) {
                this.productModels = [item.model];
                this.product.model_id = item.model;
                this.product.color_id = +this.product.color_id;
                this.product.distributors = this.product.distributors.map(dist => {
                    dist = new Distributor({
                        id: dist.id,
                        text: dist.name + " \"" + dist.distributor.company + "\" ",
                        price: dist.pivot.price,
                        quantity: dist.pivot.quantity,
                    })
                    return dist;
                });
                this.product.distributors.forEach(dist => this.selectedDistributors.push(new Distributor(dist)));
            }
            this.mode = mode;
            this.dialog = true;
        },

        save() {
            const fd = new FormData();
            fd.append(`products`, []);
            fd.append(`distributors`, []);
            this.product.distributors.forEach((dist, di) => {
                fd.append(`distributors[${di}][id]`, dist.id);
                fd.append(`distributors[${di}][price]`, dist.price);
                fd.append(`distributors[${di}][quantity]`, dist.quantity);
            });

            fd.append("images", []);
            this.product.imageFiles.forEach((image, i) => {
                fd.append(`images[${i}]`, image);
            });

            if (this.selectedSizes.length) {
                this.selectedSizes.forEach((selectedSize, i) => {
                    fd.append(`products[${i}]`, {});
                    fd.append(`products[${i}][model_id]`, this.product.model_id.id);
                    fd.append(`products[${i}][size_id]`, selectedSize.size.id);
                    fd.append(`products[${i}][color_id]`, this.product.color_id);
                });
            } else {
                fd.append(`products[0]`, {});
                fd.append(`products[0][model_id]`, this.product.model_id.id);
                fd.append(`products[0][size_id]`, '');
                fd.append(`products[0][color_id]`, this.product.color_id);
            }

            this.productInfos.forEach((productInfo, i) => {
                fd.append(`products[${i}][info]`, {});
                fd.append(`products[${i}][info][price]`, productInfo.price);
                fd.append(`products[${i}][info][quantity]`, productInfo.quantity);
                fd.append(`products[${i}][info][SCU]`, productInfo.SCU);
                fd.append(`products[${i}][info][min_offer_count]`, productInfo.min_offer_count);
            });

            if (this.mode === 1) {
                axios.post(`/api/profile/product/create`, fd)
                    .then(res => {
                        res.data.forEach((product) => {
                            this.products.unshift(product);
                        });
                        this.product = new Product();
                        this.selectedDistributors = [];
                        this.selectedSizes = [];
                        this.errorMessage = "";
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            } else {
                fd.append("_method", "PUT");
                axios.post(`/api/profile/product/update/${this.product.id}`, fd)
                    .then(res => {
                        let index = this.products.findIndex(product => product.id === res.data.id);
                        this.products.splice(index, 1, res.data);
                        this.product = new Product();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            }
        },

        remove (item) {
            confirm("Are you sure you want to delete this product?") &&
            axios.delete(`/api/profile/product/${item.id}`)
                .then(res => {
                    let index = this.products.findIndex(product => product.id == res.data);
                    this.products.splice(index, 1);
                })
                .catch(err => console.error(err.response.data.message));
        },

        onFilesSelected (event) {
            this.product.imageFiles = event;
            this.product.imageFiles.forEach(imageFile => {
                const reader = new FileReader();
                reader.readAsDataURL(imageFile);
                reader.onload = (e) => {
                    this.product.images.push(e.target.result);
                    imageFile.dataUrl = e.target.result;
                }
            });
        },

        deleteImage (image) {
            let exo = confirm("Are you sure you want to delete this image?");
            if (exo) {
                if (image[0] === "/") {
                    axios.delete(`/api/profile/product/del-img?image=${image}`)
                        .then(res => console.log(res.data))
                        .catch(err => console.error(err.response.data.message));
                } else {
                    let index = this.product.imageFiles.findIndex(imageFile => imageFile.dataUrl === image);
                    this.product.imageFiles.splice(index, 1);
                    index = this.product.images.findIndex(img => img === image);
                    this.product.images.splice(index, 1);
                }
            }
        }
    },

    watch: {
        search (val) {
            if (val) {
                axios.get(`/api/profile/product/search-model?search=${val}`)
                    .then(res => this.productModels = res.data)
                    .catch(err => console.error(err.response.data.message));
            }
        },

        ["product.model_id"] (val) {
            if (val) {
                this.offerable = this.product.model_id.offerable;
                axios.get(`/api/profile/product/colors`)
                    .then(res => this.colors = res.data.colors)
                    .catch(err => console.error(err.response.data.message));
            } else {
                this.colors = [];
            }
        },

        ["product.color_id"] (val) {
            if (val) {
                if(this.product.model_id.type === 'Other'){
                    let color = this.colors.find(color => color.id === val);
                    this.productInfos.push(new ProductInfo({ value: color.name }))
                }
                axios.get(`/api/profile/product/sizes/${this.product.model_id.id}/${val}`)
                    .then(res => {
                        this.sizes = res.data.sizes;
                        if (this.product.id) {
                            axios.get(`/api/profile/product/sizes/get-product/` +
                                       `${this.product.model_id.manufacturer_id}/${this.product.size_id}/` +
                                       `${this.product.model_id.type}`
                                    ).then(res => {
                                        this.sizes.unshift(res.data);
                                        this.selectedSizes = res.data;
                                    }).catch(err => console.error(err.response.data.message));
                        }
                    })
                    .catch(err => console.error(err.response.data.message));
            } else {
                this.sizes = [];
            }
        },

        selectedSizes(val) {
            this.productInfos = [];
            if (val.length) {
                val.forEach(size => this.productInfos.push(new ProductInfo({ value: size.size.value})));
            } else {
                if (val.size) {
                    this.productInfos.push(new ProductInfo({
                        value: val.size.value,
                        SCU: this.product.info.SCU,
                        price: this.product.info.price,
                        quantity: this.product.info.quantity,
                        min_offer_count: this.product.info.min_offer_count,
                    }));
                }
            }
        },

        selectedDistributors(val) {
            this.product.distributors = [];
            val.forEach(dist => this.product.distributors.push(new Distributor(dist)));
        },

        dialog(val) {
            if (!val) {
                this.productInfos = [];
                this.selectedSizes = [];
                this.selectedDistributors = [];
                this.product = new Product();
            }
        }
    },

    created () {
        this.getProducts();
        this.getDistributors();
    }
}
</script>

<style scoped>
.border-bottom {
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}

.deleteImage {
    position: absolute;
    top: 0;
    right: 0;
}
</style>
