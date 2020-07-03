<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="manufacturers">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Manufacturers</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new manufacturer</v-btn>
                        </v-toolbar>
                    </v-card>
                </template>
                <template v-slot:item.description="{ item }">
                    <v-card tile flat width="700">
                        <v-card-text>
                            {{ item.description }}
                        </v-card-text>
                    </v-card>
                </template>

                <template v-slot:item.logo="{ item }">
                    <v-img :src="item.logo" width="200" height="120.41" contain></v-img>
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
                                        <v-text-field
                                            v-model="manufacturer.name"
                                            :rules="nameRules"
                                            label="Անուն"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>

                                    <v-card tile flat>
                                        <v-textarea
                                            v-model="manufacturer.description"
                                            :rules="nameRules"
                                            label="Նկարագրություն"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-textarea>
                                    </v-card>
                                </v-col>
                                <v-col cols="5">
                                    <v-file-input
                                        label="Արտադրողի լոգո"
                                        color="#347cbb"
                                        dense
                                        outlined
                                        @change="onFileSelected"
                                    ></v-file-input>
                                    <v-card tile flat outlined>
                                        <v-img v-if="manufacturer.logo" :src="manufacturer.logo" contain></v-img>
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
import Manufacturer from "../../models/Manufacturer";

export default {
    name: "Manufacturers",
    data: () => ({
        headers: [
            { text: "Name", value: "name" },
            { text: "Description", value: "description", sortable: false },
            { text: "Logo", value: "logo", sortable: false },
            { text: "Action", value: "action", sortable: false },
        ],
        manufacturers: [],
        manufacturer: new Manufacturer(),
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
            return this.mode === 1 ? "New Manufacturer" : "Update Manufacturer"
        },
    },

    methods: {
        getManufacturers () {
            axios.get(`/api/profile/manufacturers`)
                .then(res => this.manufacturers = res.data)
                .catch(err => console.error(err.response.data.message));
        },

        open(item, mode) {
            this.manufacturer = new Manufacturer(item);
            this.mode = mode;
            this.dialog = true;
        },

        save() {
            const fd = new FormData();
            fd.append("name", this.manufacturer.name);
            fd.append("description", this.manufacturer.description);
            fd.append("logo",this.manufacturer.logoFile);

            if (this.mode === 1) {
                axios.post(`/api/profile/manufacturer/create`, fd)
                    .then(res => {
                        this.manufacturers.unshift(res.data);
                        this.manufacturer = new Manufacturer();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            } else {
                fd.append("_method", 'PUT');
                axios.post(`/api/profile/manufacturer/update/${this.manufacturer.id}`, fd)
                    .then(res => {
                        let index = this.manufacturers.findIndex(manufacturer => manufacturer.id === res.data.id);
                        this.manufacturers.splice(index, 1, res.data);
                        this.manufacturer = new Manufacturer();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            }
        },

        remove (item) {
            confirm("Are you sure you want to delete this manufacturer?") &&
            axios.delete(`/api/profile/manufacturer/${item.id}`)
                .then(res => {
                    let index = this.manufacturers.findIndex(manufacturer => manufacturer.id == res.data);
                    this.manufacturers.splice(index, 1);
                })
                .catch(err => console.error(err.response.data.message));
        },

        onFileSelected (event) {
            this.manufacturer.logoFile = event;
            const reader = new FileReader();
            reader.readAsDataURL(this.manufacturer.logoFile);
            reader.onload = e => this.manufacturer.logo = e.target.result;
        },
    },

    created () {
        this.getManufacturers();
    }
}
</script>

<style scoped>
.border-bottom {
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}
</style>
