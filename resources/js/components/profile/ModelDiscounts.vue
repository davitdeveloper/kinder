<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="discounts">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Model Discounts</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new discount</v-btn>
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
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-autocomplete
                                            v-model="discount.model_id"
                                            :items="models"
                                            item-text="text"
                                            item-value="id"
                                            :search-input.sync="search"
                                            label="ապրանքի մոդել"
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

                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-menu
                                            v-model="periodMenu"
                                            :close-on-content-click="false"
                                            nudge-bottom="40"
                                        >
                                            <template v-slot:activator="{ on }">
                                                <v-card id="periodDiv" tile flat>
                                                    <v-text-field
                                                        v-model="period"
                                                        placeholder="Period"
                                                        color="#347cbb"
                                                        prepend-inner-icon="mdi-calendar-search"
                                                        dense
                                                        outlined
                                                        v-on="on"
                                                        @click="calculatePeriodWidth"
                                                    ></v-text-field>
                                                </v-card>
                                            </template>

                                            <v-card tile flat>
                                                <v-date-picker
                                                    v-model="period"
                                                    :width="periodWidth"
                                                    color="#347cbb"
                                                    range
                                                    no-title
                                                    scrollable
                                                ></v-date-picker>
                                            </v-card>
                                        </v-menu>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around">
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-text-field
                                            type="number"
                                            v-model="discount.percent"
                                            :rules="percentRules"
                                            label="տոկոս"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                                <v-col cols="5">

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
    import ModelDiscount from "../../models/ModelDiscount";

    export default {
        name: "ModelDiscount",
        data: () => ({
            periodMenu: false,
            period: [],
            periodWidth: null,
            headers: [
                { text: "Model Title", value: "model.title" },
                { text: "Date Start", value: "start"},
                { text: "Date End", value: "end"},
                { text: "Percent", value: "percent"},
                { text: "Action", value: "action" },
            ],
            discounts: [],
            discount: new ModelDiscount(),
            models: [],
            // tags:[],
            dialog: false,
            mode: 0,
            search: "",
            // searchTags: "",
            errorMessage: "",
            valid: false,
            percentRules: [
                v => !!v || "This field is required",
                // v => Number.isInteger(v) || "This field is be integer",
                v => v < 100 || "This field is be small 100",
            ],
        }),

        computed: {
            title () {
                return this.mode === 1 ? "New Discount" : "Update Discount"
            },
        },

        methods: {
            calculatePeriodWidth () {
                this.periodWidth = document.getElementById("periodDiv").offsetWidth;
            },
            getDiscounts () {
                axios.get(`/api/profile/model-discounts`)
                    .then(res => this.discounts = res.data,  )
                    .catch(err => console.error(err.response.data.message));
            },

            open(item, mode) {
                this.discount = new ModelDiscount(item);
                if (this.discount.id) this.models = [item.model];
                this.mode = mode;
                this.dialog = true;
            },

            save() {
                if (this.mode === 1) {
                    axios.post(`/api/profile/model-discount/create`, this.discount)
                        .then(res => {
                            this.discounts.push(res.data);
                            this.discount = new ModelDiscount();
                            this.dialog = false;
                        })
                        .catch(err => this.errorMessage = err.response.data.message);
                } else {
                    axios.put(`/api/profile/model-discount/update/${this.discount.id}`,this.discount)
                        .then(res => {
                            let index = this.discounts.findIndex(discount => discount.id === res.data.id);
                            this.discounts.splice(index, 1, res.data);
                            this.discount = new ModelDiscount();
                            this.dialog = false;
                        })
                        .catch(err => this.errorMessage = err.response.data.message);
                }
            },

            remove (item) {
                confirm("Are you sure you want to delete this article?") &&
                axios.delete(`/api/profile/model-discount/delete/${item.id}`)
                    .then(res => {
                        let index = this.discounts.findIndex(discount => discount.id === res.data.id);
                        this.discounts.splice(index, 1);
                    })
                    .catch(err => console.error(err.response.data.message));
            },
        },
        watch: {
            search (val) {
                if (val) {
                    axios.get(`/api/profile/model-discount/search-model?search=${val}`)
                        .then(res => {
                            this.models = res.data;
                        })
                        .catch(err => console.error(err.response.data.message));
                }
            },
            period (val) {
                if (val.length > 1) {
                    if (val[0] > val[1]) {
                        const holder = val[0];
                        val[0] = val[1];
                        val[1] = holder;
                    }
                }

                this.discount.start = val[0];
                this.discount.end = val[1];
            }
        },

        created () {
            this.getDiscounts();
        }
    }
</script>

<style scoped>
    .border-bottom {
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    }
</style>
