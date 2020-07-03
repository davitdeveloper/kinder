<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="ads">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Ads</v-toolbar-title>
                        </v-toolbar>
                    </v-card>
                </template>

                <template v-slot:item.status="{item}">
                    <div v-if="item.status === 0">
                        <v-icon color="red">mdi-checkbox-blank-circle</v-icon><strong>Չհաստատված</strong>
                    </div>
                    <div v-if="item.status === 1">
                        <v-icon color="green">mdi-checkbox-blank-circle</v-icon><strong>Հաստատված</strong>
                    </div>
                </template>
                <template v-slot:item.description="{ item }">
                    <v-card class="px-3 py-3" tile flat max-width="700" max-height="80" style="text-align: justify;overflow-y: auto">
                        {{ item.description }}
                    </v-card>
                </template>
                <template v-slot:item.image="{ item }">
                    <div class="p-2 ">
                        <img class="tbl-img"  v-if="item.images.length" :src="item.images[0].image" height="100px"></img>
                    </div>
                </template>

                <template v-slot:item.action="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-icon class="mr-2" color="yellow darken-3" v-on="on" @click="open(item)">
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
                    <v-form >
                        <v-container>
                            <v-card-text>
                                <v-row no-gutters justify="space-between">
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="ad.city"
                                                label="տարածաշրջան"
                                                outlined
                                                dense
                                                disabled
                                            >
                                            </v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="ad.categories"
                                                label="տարածաշրջան"
                                                outlined
                                                dense
                                                disabled
                                            >
                                            </v-text-field>
                                        </v-card>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters justify="space-between">
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="ad.manufacturer"
                                                label="արտադրող"
                                                outlined
                                                dense
                                                disabled
                                                open-on-clear
                                            >
                                            </v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="ad.title"
                                                label="անուն"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                disabled
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters justify="space-between">
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="ad.condition"
                                                label="վիճակ"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                disabled
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="ad.price"
                                                v-mask="'######'"
                                                label="գին"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                disabled
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters justify="space-between">
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="ad.phone"
                                                v-mask="'+(374)##-###-###'"
                                                label="հեռախոսահամար"
                                                color="#347cbb"
                                                outlined
                                                dense
                                                disabled
                                            ></v-text-field>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-checkbox
                                                v-model="ad.status"
                                                :true-value="1"
                                                :false-value="0"
                                                :label="`status: ${!!+ad.status}`"
                                            ></v-checkbox>
                                        </v-card>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters justify="center">
                                    <v-col cols="12">
                                        <v-card tile flat>
                                            <v-textarea
                                                v-model="ad.description"
                                                solo
                                                dense
                                                name="description"
                                                label="նկարագրություն"
                                                disabled
                                            ></v-textarea>
                                        </v-card>
                                    </v-col>
                                </v-row>
                                <v-row  justify="center">
                                    <h4 class="mt-4 mb-4">Նկարներ</h4>
                                </v-row>
                                <v-row no-gutters>
                                    <v-col
                                        cols="2"
                                        v-for="(image,i) in ad.images"
                                        :key="i"
                                    >
                                        <v-img class="mt-2 mr-1" :src="image.image" contain max-height="100"></v-img>
                                    </v-col>
                                </v-row>
                            </v-card-text>
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
        name: "Ads",
        data: () => ({
            headers: [
                { text: "User Name", value: "owner.name", sortable: false },
                { text: "Title", value: "title", sortable: false },
                { text: "Description", value: "description", sortable: false },
                { text: "Image", value: "image", sortable: false },
                { text: "Status", value: "status"},
                { text: "Action", value: "action" },
            ],
            ads: [],
            ad : {
                id : '',
                name : '',
                title : '',
                price : '',
                description : '',
                city : '',
                phone : '',
                manufacturer : '',
                condition : '',
                status : '',
                images : '',
                categories : '',
            },
            dialog: false,
            errorMessage: "",
        }),

        computed: {
            title () {
                return "Update Ad"
            },
        },

        methods: {
            getAds () {
                axios.get(`/api/profile/ads`)
                    .then(res => this.ads = res.data)
                    .catch(err => console.error(err.response.data.message));
            },

            open(item) {
                let cat = '';
                item.categories.forEach((category, key) => {
                    cat = cat+category.title+',';
                });
                this.ad ={
                    id : item.id,
                    name : item.owner.name,
                    title : item.title,
                    price : item.price,
                    description : item.description,
                    city : item.city.name,
                    phone : item.phone,
                    manufacturer : item.manufacturer,
                    condition : item.condition,
                    status : item.status,
                    images : item.images,
                    categories : cat,
                };
                this.dialog = true;
            },
            save() {
                const fd = new FormData();

                fd.append('status', this.ad.status);
                fd.append("_method", 'PUT');
                axios.post(`/api/profile/ads/update/${this.ad.id}`, fd)
                    .then(res => {
                        let index = this.ads.findIndex(ad => ad.id === res.data.id);
                        this.ads.splice(index, 1, res.data);
                        this.ad ={
                            name : '',
                            title : '',
                            price : '',
                            description : '',
                            city : '',
                            phone : '',
                            manufacturer : '',
                            condition : '',
                            status : '',
                            images : '',
                            categories : '',
                        };
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data);
            },

            remove (item) {
                confirm("Are you sure you want to delete this article?") &&
                axios.delete(`/api/profile/ads/delete/${item.id}`)
                    .then(res => {
                        let index = this.ads.findIndex(ad => ad.id == res.data);
                        this.ads.splice(index, 1);
                    })
                    .catch(err => console.error(err.response.data.message));
            },
        },
        created () {
            this.getAds();
        }
    }
</script>

<style scoped>
    .border-bottom {
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    }
    .tbl-img{
        max-height: 50px;
    }
</style>
