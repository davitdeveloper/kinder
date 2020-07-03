<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="sizes" item-key="type + id">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Sizes</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new size</v-btn>
                        </v-toolbar>
                    </v-card>
                </template>

                <template v-slot:item.chest="{ item }">
                    <div v-if="item.chest">
                        {{ item.chest + ' սմ' }}
                    </div>
                    <div v-else class="ml-3" style="border: 1px solid grey; width: 12px"></div>
                </template>

                <template v-slot:item.waist="{ item }">
                    <div v-if="item.waist">
                        {{ item.waist + ' սմ' }}
                    </div>
                    <div v-else class="ml-3" style="border: 1px solid grey; width: 12px"></div>
                </template>

                <template v-slot:item.height="{ item }">
                    <div v-if="item.height">
                        {{ item.height + ' սմ' }}
                    </div>
                    <div v-else class="ml-3" style="border: 1px solid grey; width: 12px"></div>
                </template>

                <template v-slot:item.hip="{ item }">
                    <div v-if="item.hip">
                        {{ item.hip + ' սմ' }}
                    </div>
                    <div v-else class="ml-3" style="border: 1px solid grey; width: 12px"></div>
                </template>

                <template v-slot:item.weight="{ item }">
                    <div v-if="item.weight">
                        {{ item.weight + ' կգ' }}
                    </div>
                    <div v-else class="ml-3" style="border: 1px solid grey; width: 12px"></div>
                </template>

                <template v-slot:item.length="{ item }">
                    <div v-if="item.length">
                        {{ item.length + ' սմ' }}
                    </div>
                    <div v-else class="ml-3" style="border: 1px solid grey; width: 12px"></div>
                </template>

                <template v-slot:item.foot_length="{ item }">
                    <div v-if="item.foot_length">
                        {{ item.foot_length + ' սմ' }}
                    </div>
                    <div v-else class="ml-3" style="border: 1px solid grey; width: 12px"></div>
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
                                            v-model="size.manufacturer_id"
                                            :rules="nameRules"
                                            :items="manufacturers"
                                            :disabled="mode !== 1"
                                            item-text="name"
                                            item-value="id"
                                            menu-props="offsetY"
                                            label="Արտադրող"
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
                                            v-model="size.size.type"
                                            :rules="nameRules"
                                            :items="['Top', 'Pant', 'Shoe', 'Accessory']"
                                            :disabled="mode !== 1"
                                            menu-props="offsetY"
                                            label="Տեսակ"
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

                            <v-row v-if="mode === 1" no-gutters justify="space-around">
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-select
                                            v-model="selectedSizes"
                                            :rules="nameRules"
                                            :items="globalSizes"
                                            item-text="value"
                                            return-object
                                            multiple
                                            menu-props="offsetY"
                                            label="Հնարավոր արժեքներ"
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
                                </v-col>
                            </v-row>

                            <template v-if="size.size.type === 'Top'">
                                <v-row
                                    v-for="size in reqSizes"
                                    :key="size.size.id"
                                    justify="space-around"
                                    align="center"
                                >
                                    <v-col cols="1" class="text-right">
                                        {{ size.size.value }}
                                    </v-col>
                                    <v-icon>mdi-arrow-right</v-icon>
                                    <v-col cols="2">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="size.chest"
                                                :rules="nameRules"
                                                label="chest"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                clearable
                                                hide-details
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="2">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="size.waist"
                                                :rules="nameRules"
                                                label="waist"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                clearable
                                                hide-details
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="2">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="size.height"
                                                :rules="nameRules"
                                                label="height"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                clearable
                                                hide-details
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="2">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="size.weight"
                                                :rules="nameRules"
                                                label="weight"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                clearable
                                                hide-details
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </template>

                            <template v-else-if="size.size.type === 'Pant'">
                                <v-row
                                    v-for="size in reqSizes"
                                    :key="size.size.id"
                                    justify="space-around"
                                    align="center"
                                >
                                    <v-col cols="1" class="text-right">
                                        {{ size.size.value }}
                                    </v-col>
                                    <v-icon>mdi-arrow-right</v-icon>
                                    <v-col cols="2">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="size.waist"
                                                :rules="nameRules"
                                                label="waist"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                clearable
                                                hide-details
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="2">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="size.height"
                                                :rules="nameRules"
                                                label="height"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                clearable
                                                hide-details
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="2">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="size.weight"
                                                :rules="nameRules"
                                                label="weight"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                clearable
                                                hide-details
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="3">
                                    </v-col>
                                </v-row>
                            </template>

                            <template v-else-if="size.size.type === 'Shoe'">
                                <v-row
                                    v-for="size in reqSizes"
                                    :key="size.size.id"
                                    justify="space-around"
                                    align="center"
                                >
                                    <v-col cols="1" class="text-right">
                                        {{ size.size.value }}
                                    </v-col>
                                    <v-icon>mdi-arrow-right</v-icon>
                                    <v-col cols="2">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="size.foot_length"
                                                :rules="nameRules"
                                                label="foot length"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                clearable
                                                hide-details
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="2">
                                    </v-col>
                                    <v-col cols="3">
                                    </v-col>
                                    <v-col cols="2">
                                    </v-col>
                                </v-row>
                            </template>
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
import Size from "../../models/Size";

export default {
    name: "TextileTypes",
    data: () => ({
        headers: [
            { text: "Manufacturer", value: "manufacturer.name" },
            { text: "Type", value: "size.type", sortable: false },
            { text: "Value", value: "size.value", sortable: false },
            { text: "Chest", value: "chest", sortable: false },
            { text: "Waist", value: "waist", sortable: false },
            { text: "Height", value: "height", sortable: false },
            { text: "Weight", value: "weight", sortable: false },
            { text: "Hip", value: "hip", sortable: false },
            { text: "Foot length", value: "foot_length", sortable: false },
            { text: "Action", value: "action", sortable: false },
        ],
        sizes: [],
        size: new Size(),
        manufacturers: [],
        globalSizes: [],
        selectedSizes: [],
        reqSizes: [],
        dialog: false,
        mode: 0,
        errorMessage: "",
        valid: false,
        nameRules: [
            v => !!v || "This field is required",
        ],
    }),

    computed: {
        title () {
            return this.mode === 1 ? "New Size" : "Update Size"
        },
    },

    methods: {
        getSizes () {
            axios.get(`/api/profile/manufacturers/sizes`)
                .then(res => this.sizes = res.data)
                .catch(err => console.error(err.response.data.message));
        },

        getManufacturers () {
            axios.get(`/api/profile/manufacturers`)
                .then(res => this.manufacturers = res.data)
                .catch(err => console.error(err.response.data.message));
        },

        getGlobalSizes () {
            if (this.size.manufacturer_id && this.size.size.type) {
                axios.get(`/api/profile/sizes/${this.size.size.type}/${this.size.manufacturer_id}`)
                    .then(res => this.globalSizes = res.data)
                    .catch(err => console.error(err.response.data.message));
            }
        },

        open(item, mode) {
            this.mode = mode;
            if (item.id) {
                item.manufacturer_id = +item.manufacturer_id;
                this.size = new Size(item);
                this.reqSizes = [];
                this.reqSizes.push(this.size);
            } else {
                this.size = new Size(item);
            }
            this.dialog = true;
        },

        save() {
            this.reqSizes = this.reqSizes.map(reqSize => {
                if (reqSize.size.id) reqSize.size_id = reqSize.size.id;
                reqSize.type = reqSize.size.type;
                reqSize = this.$pickBy(reqSize);
                return reqSize;
            });

            if (this.mode === 1) {
                axios.post(`/api/profile/size/create`, this.reqSizes)
                    .then(res => {
                        this.sizes = res.data.concat(this.sizes);
                        this.size = new Size();
                        this.topSizes = [];
                        this.selectedSizes = [];
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            } else {
                this.size.size_id = this.size.size_id.id;
                axios.put(`/api/profile/size/update/${this.size.id}`, this.reqSizes[0])
                    .then(res => {
                        let index = this.sizes.findIndex(size => size.id == res.data.id);
                        this.sizes.splice(index, 1, res.data);
                        this.size = new Size();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            }
        },

        remove (item) {
            confirm("Are you sure you want to delete this size?") &&
            axios.delete(`/api/profile/size/${item.id}/${item.size.type}`)
                .then(res => {
                    let index = this.sizes.findIndex(size => size.id === res.data.id);
                    this.sizes.splice(index, 1);
                })
                .catch(err => console.error(err.response.data.message));
        },
    },

    watch: {
        ["size.manufacturer_id"] (val) {
            if (val) {
                this.getGlobalSizes();
            } else {
                this.globalSizes = [];
                this.selectedSizes = [];
            }
        },

        ["size.size.type"] (val) {
            if (val) {
                this.getGlobalSizes();
            } else {
                this.globalSizes = [];
                this.selectedSizes = [];
            }
        },

        selectedSizes (val) {
            this.reqSizes = val.map(selectedSize => {
                selectedSize = new Size(Object.assign({}, this.size, { size: selectedSize }));
                return selectedSize;
            });
        }
    },

    created () {
        this.getManufacturers();
        this.getSizes();
    }
}
</script>

<style scoped>
.border {
    border: 1px solid black;
}

.border-bottom {
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}
</style>
