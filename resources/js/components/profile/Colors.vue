<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="colors">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Colors</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new color</v-btn>
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
                                        <v-text-field
                                            v-model="color.name"
                                            :rules="nameRules"
                                            label="անուն"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                                <v-col cols="5">
                                    <v-menu :close-on-content-click="false" nudge-bottom="40">
                                        <template v-slot:activator="{ on }">
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="color.value"
                                                    :rules="nameRules"
                                                    label="գույն"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    v-on="on"
                                                ></v-text-field>
                                            </v-card>
                                        </template>

                                        <v-card>
                                            <v-card-title>Pick a color</v-card-title>
                                            <v-row justify="center">
                                                <v-color-picker v-model="color.value" flat></v-color-picker>
                                            </v-row>
                                        </v-card>
                                    </v-menu>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around">
                                <v-col cols="5" class="border">
                                    <v-card tile flat>
                                        <v-select
                                            v-model="color.tint"
                                            :rules="nameRules"
                                            :items="['light', 'dark']"
                                            menu-props="offsetY"
                                            label="երանգ"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                            open-on-clear
                                        ></v-select>
                                    </v-card>
                                </v-col>
                                <v-col cols="5" class="border">
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
import Color from "../../models/Color";

export default {
    name: "Colors",
    data: () => ({
        headers: [
            { text: "Name", value: "name" },
            { text: "Value", value: "value", sortable: false },
            { text: "Tint", value: "tint", sortable: false },
            { text: "Action", value: "action", sortable: false },
        ],
        colors: [],
        color: new Color(),
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
            return this.mode === 1 ? "New Color" : "Update Color"
        },
    },

    methods: {
        getColors () {
            axios.get(`/api/profile/colors`)
                .then(res => this.colors = res.data)
                .catch(err => console.error(err.response.data.message));
        },

        open(item, mode) {
            this.color = new Color(item);
            this.mode = mode;
            this.dialog = true;
        },

        save() {
            if (this.mode === 1) {
                axios.post(`/api/profile/color/create`, {
                    name: this.color.name,
                    value: this.color.value,
                    tint: this.color.tint,
                })
                    .then(res => {
                        this.colors.push(res.data);
                        this.color = new Color();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            } else {
                axios.post(`/api/profile/color/update/${this.color.id}`, {
                    _method: "PUT",
                    name: this.color.name,
                    value: this.color.value,
                    tint: this.color.tint,
                })
                    .then(res => {
                        let index = this.colors.findIndex(color => color.id === res.data.id);
                        this.colors.splice(index, 1, res.data);
                        this.color = new Color();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            }
        },

        remove (item) {
            confirm("Are you sure you want to delete this color?") &&
            axios.delete(`/api/profile/color/${item.id}`)
                .then(res => {
                    let index = this.colors.findIndex(color => color.id === res.data.id);
                    this.colors.splice(index, 1);
                })
                .catch(err => console.error(err.response.data.message));
        },
    },

    created () {
        this.getColors();
    }
}
</script>

<style scoped>
.border-bottom {
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}
</style>
