<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="sliders">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Sliders</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new slider</v-btn>
                        </v-toolbar>
                    </v-card>
                </template>
                <template v-slot:item.status="{item}">
                    <div v-if="item.status == 0">
                        <v-icon color="red">mdi-checkbox-blank-circle</v-icon><strong>Ոչ ակտիվ</strong>
                    </div>
                    <div v-if="item.status == 1">
                        <v-icon color="green">mdi-checkbox-blank-circle</v-icon><strong>Ակտիվ</strong>
                    </div>
                </template>
                <template v-slot:item.image="{ item }">
                    <div class="p-2 ">
                        <img class="tbl-img"  v-if="item.image" :src="item.image" height="200px"></img>
                    </div>
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
                                <v-col cols="3">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="slider.rang"
                                            v-mask="'##'"
                                            label="rang"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                                <v-col cols="3">
                                    <v-file-input
                                        label="nkar"
                                        color="#347cbb"
                                        dense
                                        outlined
                                        @change="onFileSelected"
                                    ></v-file-input>
                                    <v-card tile flat outlined>
                                        <v-img v-if="slider.image" :src="slider.image" contain></v-img>
                                    </v-card>
                                </v-col>
                                <v-col cols="3">
                                    <v-checkbox
                                        v-model="slider.status"
                                        true-value="1"
                                        false-value="0"
                                        :label="`status: ${!!+slider.status}`"
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

    export default {
        name: "HomeSlider",
        data: () => ({
            headers: [
                { text: "Rang", value: "rang" },
                { text: "Image", value: "image", sortable: false },
                { text: "Status", value: "status", sortable: false },
                { text: "Action", value: "action", sortable: false },
            ],
            sliders: [],
            slider: {
                id: '',
                rang: '',
                image: '',
                status: 0,
                imageFile: null,
            },
            dialog: false,
            mode: 0,
            errorMessage: "",
            valid: false,
        }),
        computed: {
            title () {
                return this.mode === 1 ? "New Slider" : "Update Slider"
            },
        },
        methods: {
            getSliders () {
                axios.get(`/api/profile/sliders`)
                    .then(res => this.sliders = res.data)
                    .catch(err => console.error(err.response.data.message));
            },

            open(item, mode) {
                this.slider = {
                    id: item.id,
                    rang: item.rang,
                    image: item.image,
                    status: item.status,
                    imageFile: null,
                };
                this.mode = mode;
                this.dialog = true;
            },

            save() {
                const fd = new FormData();
                fd.append("rang", this.slider.rang);
                fd.append("status", this.slider.status);
                fd.append("image",this.slider.imageFile);

                if (this.mode === 1) {
                    axios.post(`/api/profile/slider/create`, fd)
                        .then(res => {
                            this.sliders.unshift(res.data);
                            this.slider = {
                                id: '',
                                rang: "",
                                image: "",
                                status: 0,
                                imageFile: null,
                            };
                            this.dialog = false;
                        })
                        .catch(err => this.errorMessage = err.response.data.message);
                } else {
                    fd.append("_method", 'PUT');
                    axios.post(`/api/profile/slider/update/${this.slider.id}`, fd)
                        .then(res => {
                            let index = this.sliders.findIndex(slider => slider.id === res.data.id);
                            this.sliders.splice(index, 1, res.data);
                            this.slider = {
                                rang: "",
                                image: "",
                                status: 0,
                                imageFile: null,
                            };
                            this.dialog = false;
                        })
                        .catch(err => this.errorMessage = err.response.data.message);
                }
            },

            remove (item) {
                confirm("Are you sure you want to delete this slider?") &&
                axios.delete(`/api/profile/slider/delete/${item.id}`)
                    .then(res => {
                        console.log(res.data);
                        let index = this.sliders.findIndex(slider => slider.id == res.data);
                        this.sliders.splice(index, 1);
                    })
                    .catch(err => console.error(err.response.data.message));
            },

            onFileSelected (event) {
                this.slider.imageFile = event;
                const reader = new FileReader();
                reader.readAsDataURL(this.slider.imageFile);
                reader.onload = e => this.slider.image = e.target.result;
            },
        },

        created () {
            this.getSliders();
        }
    }
</script>

<style scoped>

</style>
