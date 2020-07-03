<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="productModels">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Product Models</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new product model</v-btn>
                        </v-toolbar>
                    </v-card>
                </template>

                <template v-slot:item.short_description="{ item }">
                    <v-expansion-panels flat>
                        <v-expansion-panel>
                            <template v-if="item.short_description.length > 50">
                                <v-expansion-panel-header>
                                    {{ item.short_description.slice(0, 47) + '...' }}
                                </v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    {{ item.short_description }}
                                </v-expansion-panel-content>
                            </template>

                            <v-expansion-panel-header v-else>
                                {{ item.short_description }}
                            </v-expansion-panel-header>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </template>

                <template v-slot:item.long_description="{ item }">
                    <Viewer v-model="item.long_description"/>
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
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-select
                                            v-model="productModel.manufacturer_id"
                                            :rules="nameRules"
                                            :items="manufacturers"
                                            item-text = "name"
                                            item-value = "id"
                                            menu-props="offsetY"
                                            label="արտադրող"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                            open-on-clear
                                        ></v-select>
                                    </v-card>
                                </v-col>

                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-select
                                            v-model="productModel.type"
                                            :rules="nameRules"
                                            :items="['Top', 'Pant', 'Shoe', 'Accessory', 'Other']"
                                            item-text="title"
                                            item-value="id"
                                            menu-props="offsetY"
                                            label="տեսակ"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                            open-on-clear
                                        ></v-select>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row justify="space-around">
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-select
                                            v-model="productModel.gender"
                                            :rules="nameRules"
                                            :items="['Man', 'Women', 'Unisex']"
                                            item-text="title"
                                            menu-props="offsetY"
                                            label="սեռ"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                            open-on-clear
                                        ></v-select>
                                    </v-card>
                                </v-col>

                                <v-col cols="5">
                                    <v-file-input
                                        label="գլխավոր նկար"
                                        color="#347cbb"
                                        dense
                                        outlined
                                        @change="onFileSelected"
                                    ></v-file-input>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around">
                                <v-col cols="5">
                                    <v-window v-model="step">
                                        <v-window-item :value="1">
                                            <v-list>
                                                <v-list-item-group v-model="category" color="#347cbb">
                                                    <v-list-item
                                                        v-for="item in menu"
                                                        :key="'category' + item.id"
                                                        :value="item"
                                                        @click="step++"
                                                    >
                                                        <v-list-item-title v-text="item.title"></v-list-item-title>
                                                    </v-list-item>
                                                </v-list-item-group>
                                            </v-list>
                                        </v-window-item>

                                        <v-window-item :value="2">
                                            <v-row no-gutters align="center">
                                                <v-col cols="2">
                                                    <v-btn icon @click="goCategory">
                                                        <v-icon>mdi-arrow-left</v-icon>
                                                    </v-btn>
                                                </v-col>
                                                <v-col>
                                                    <p class="ma-0">{{ category.title }}</p>
                                                </v-col>
                                            </v-row>

                                            <v-list>
                                                <v-list-item-group v-model="subCategory" color="#347cbb">
                                                    <v-list-item
                                                        v-for="subItem in category.children"
                                                        :key="'subCategory' + subItem.id"
                                                        :value="subItem"
                                                        @click="step++"
                                                    >
                                                        <v-list-item-title v-text="subItem.title"></v-list-item-title>
                                                    </v-list-item>
                                                </v-list-item-group>
                                            </v-list>
                                        </v-window-item>

                                        <v-window-item :value="3">
                                            <v-row no-gutters align="center">
                                                <v-col cols="2">
                                                    <v-btn icon @click="goSubCategory">
                                                        <v-icon>mdi-arrow-left</v-icon>
                                                    </v-btn>
                                                </v-col>
                                                <v-col>
                                                    <p class="ma-0">{{ subCategory.title }}</p>
                                                </v-col>
                                            </v-row>

                                            <v-list>
                                                <v-list-item-group v-model="subSubCategory" color="#347cbb">
                                                    <v-list-item
                                                        v-for="subSubItem in subCategory.children"
                                                        :key="'subSubCategory' + subSubItem.id"
                                                        :value="subSubItem"
                                                    >
                                                        <v-list-item-title v-text="subSubItem.title"></v-list-item-title>
                                                    </v-list-item>
                                                </v-list-item-group>
                                            </v-list>
                                        </v-window-item>
                                    </v-window>
                                </v-col>

                                <v-col cols="5">
                                    <v-card tile flat outlined>
                                        <v-img v-if="productModel.main_image" :src="productModel.main_image" contain></v-img>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around" class="mt-7">
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="productModel.title"
                                            :rules="nameRules"
                                            label="վերնագիր"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>

                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="productModel.sub_title"
                                            :rules="nameRules"
                                            label="ենթավերնագիր"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>

                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-text-field
                                            type="number"
                                            v-model="productModel.price"
                                            :rules="nameRules"
                                            label="գին"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>

                                <v-col cols="5"></v-col>
                            </v-row>

                            <v-row no-gutters justify="center">
                                <v-col cols="11">
                                    <v-card tile flat>
                                        <v-textarea
                                            v-model="productModel.short_description"
                                            :rules="nameRules"
                                            label="կարճ նկարագրություն"
                                            color="#347cbb"
                                            auto-grow
                                            outlined
                                            dense
                                            clearable
                                            rows="6"
                                            counter="77"
                                        ></v-textarea>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row justify="center">
                                <v-col cols="11">
                                    <Editor v-model="productModel.long_description"/>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around">
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-text-field
                                            type="number"
                                            v-model="productModel.bulk_quantity"
                                            :rules="nameRules"
                                            label="մեծածախի քանակ"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>

                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-text-field
                                            type="number"
                                            v-model="productModel.bulk_percent"
                                            :rules="nameRules"
                                            label="մեծածախի զեղչի տոկոս"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around" class="ml-5">
                                <v-col cols="3">
                                    <v-checkbox
                                        v-model="productModel.offerable"
                                        true-value="1"
                                        false-value="0"
                                        :label="`offerable: ${!!+productModel.offerable}`"
                                    ></v-checkbox>
                                </v-col>

                                <v-col cols="3">
                                    <v-checkbox
                                        v-model="productModel.watermarked"
                                        true-value="1"
                                        false-value="0"
                                        :label="`watermarked: ${!!+productModel.watermarked}`"
                                    ></v-checkbox>
                                </v-col>

                                <v-col cols="3">
                                    <v-checkbox
                                        v-model="productModel.top_status"
                                        true-value="1"
                                        false-value="0"
                                        :label="`top status: ${!!+productModel.top_status}`"
                                    ></v-checkbox>
                                </v-col>

                                <v-col cols="3">
                                    <v-checkbox
                                        v-model="productModel.hot_status"
                                        true-value="1"
                                        false-value="0"
                                        :label="`hot status: ${!!+productModel.hot_status}`"
                                    ></v-checkbox>
                                </v-col>

                                <v-col cols="3">
                                    <v-checkbox
                                        v-model="productModel.new_status"
                                        true-value="1"
                                        false-value="0"
                                        :label="`new status: ${!!+productModel.new_status}`"
                                    ></v-checkbox>
                                </v-col>

                                <v-col cols="3">
                                    <v-checkbox
                                        v-model="productModel.status"
                                        true-value="1"
                                        false-value="0"
                                        :label="`status: ${!!+productModel.status}`"
                                    ></v-checkbox>
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
import ProductModel from "../../models/ProductModel";
import { Editor, Viewer } from '@toast-ui/vue-editor';


export default {
    name: "ProductModels",
    components: {
        "Editor": Editor,
        "Viewer": Viewer,
    },
    data: () => ({
        editorOptions : {
            minHeight: '200px',
            language: 'en_US',
            useCommandShortcut: true,
            useDefaultHTMLSanitizer: true,
            usageStatistics: true,
            hideModeSwitch: false,
            toolbarItems: [
                'heading',
                'bold',
                'italic',
                'strike',
                'divider',
                'hr',
                'quote',
                'divider',
                'ul',
                'ol',
                'task',
                'table',
                'link',
            ]
        },
        headers: [
            { text: "Title", value: "title" },
            { text: "Short Description", value: "short_description", sortable: false },
            { text: "Long Description", value: "long_description", sortable: false },
            { text: "Type", value: "type", sortable: false },
            { text: "Price", value: "price", sortable: false },
            { text: "Image", value: "main_image", sortable: false },
            { text: "Action", value: "action", sortable: false },
        ],
        productModels: [],
        productModel: new ProductModel(),
        manufacturers: [],
        dialog: false,
        mode: 0,
        errorMessage: "",
        valid: false,
        nameRules: [
            v => !!v || "This field is required",
        ],
        step: 1,
        category: {},
        subCategory: {},
        subSubCategory: {},
    }),

    computed: {
        title () {
            return this.mode === 1 ? "New Product Model" : "Update Product Model"
        },

        menu () {
            return this.$store.state.upperMenu;
        }
    },

    methods: {
        getProductModels () {
            axios.get(`/api/profile/product-models`)
                .then(res => this.productModels = res.data)
                .catch(err => console.error(err.response.data.message));
        },

        getManufacturers () {
            axios.get(`/api/profile/manufacturers`)
                .then(res => this.manufacturers = res.data)
                .catch(err => console.error(err.response.data.message));
        },

        open(item, mode) {
            console.log(item);
            this.mode = mode;
            this.step = 1;
            if (item.id) {
                item.manufacturer_id = +item.manufacturer_id;
                this.category = this.menu.find(menuItem => menuItem.id === item.category_ids[0]);
                this.subCategory = this.category.children.find(menuItem => menuItem.id === item.category_ids[1]);
                this.subSubCategory = this.subCategory.children.find(menuItem => menuItem.id === item.category_ids[2]);
                this.step = 3;
            }

            this.productModel = new ProductModel(item);
            this.dialog = true;
        },

        save() {
            const fd = new FormData();

            fd.append("manufacturer_id", this.productModel.manufacturer_id);
            fd.append("category_ids", []);

            this.productModel.category_ids.forEach((model, i) => {
                fd.append(`category_ids[${i}]`, model)
            });

            fd.append("type", this.productModel.type);
            fd.append("gender", this.productModel.gender);
            fd.append("title", this.productModel.title);
            fd.append("sub_title", this.productModel.sub_title);
            fd.append("short_description", this.productModel.short_description);
            fd.append("long_description", this.productModel.long_description);
            fd.append("price", this.productModel.price);
            fd.append("old_price", this.productModel.old_price);
            fd.append("bulk_quantity", this.productModel.bulk_quantity);
            fd.append("bulk_percent", this.productModel.bulk_percent);
            fd.append("offerable", this.productModel.offerable);
            fd.append("watermarked", this.productModel.watermarked);
            fd.append("top_status", this.productModel.top_status);
            fd.append("hot_status", this.productModel.hot_status);
            fd.append("new_status", this.productModel.new_status);
            fd.append("status", this.productModel.status);
            fd.append("watermark", this.productModel.watermark);
            fd.append("main_image", this.productModel.main_imageFile);

            if (this.mode === 1) {
                axios.post(`/api/profile/product-model/create`, fd)
                    .then(res => {
                        this.productModels.unshift(res.data);
                        this.productModel = new ProductModel();
                        this.step = 1;
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            } else {
                fd.append("_method", "PUT");
                axios.post(`/api/profile/product-model/update/${this.productModel.id}`, fd)
                    .then(res => {
                        let index = this.productModels.findIndex(productModel => productModel.id === res.data.id);
                        this.productModels.splice(index, 1, res.data);
                        this.productModel = new ProductModel();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            }
        },

        remove (item) {
            confirm("Are you sure you want to delete this product model?") &&
            axios.delete(`/api/profile/product-model/${item.id}`)
                .then(res => {
                    let index = this.productModels.findIndex(productModel => productModel.id == res.data);
                    this.productModels.splice(index, 1);
                })
                .catch(err => console.error(err.response.data.message));
        },

        onFileSelected (event) {
            this.productModel.main_imageFile = event;
            const reader = new FileReader();
            reader.readAsDataURL(this.productModel.main_imageFile);
            reader.onload = e => this.productModel.main_image = e.target.result;
        },

        goCategory() {
            this.category = {};
            this.step--;
        },

        goSubCategory() {
            this.subCategory = {};
            this.step--;
        },
    },

    watch: {
        subSubCategory(val) {
            if (val) {
                if (val.id) {
                    this.productModel.category_ids = [];
                    this.productModel.category_ids.push(this.category.id);
                    this.productModel.category_ids.push(this.subCategory.id);
                    this.productModel.category_ids.push(val.id);
                }
            } else {
                this.productModel.category_ids = [];
            }
        },
    },

    created () {
        this.getProductModels();
        this.getManufacturers();
    }
}
</script>

<style scoped>
.border {
    border: 1px solid black;
}
.view_desc {
    height: 80px;
}
</style>
