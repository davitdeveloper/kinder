<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="dataTag">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Tags</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new tag</v-btn>
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
                            <v-icon color="red" v-on="on" @click="remove(item.id)">
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
                                <v-col cols="9">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="tag.name"
                                            :rules="nameRules"
                                            :items="tags"
                                            label="Text"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                                <v-col cols="2">
                                    <v-icon v-if="tag.name"
                                            color="#347cbb" dark x-large
                                            @click="add(tag.name)"
                                            :disabled="update == true"
                                    >
                                        mdi-plus-circle
                                    </v-icon>
                                </v-col>
                            </v-row>
                            <v-row v-for="(t,i) in tags" :key="i" no-gutters justify="space-around">
                                <v-col cols="9">
                                    <v-card tile flat>
                                        <v-text-field
                                            :value="t.name"
                                            label="Text"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            disabled
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                                <v-col cols="2">
                                    <v-icon color="red" dark x-large @click="delTag(i)">
                                        mdi-delete-outline
                                    </v-icon>

                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
<!--                    {{ errorMessage }}-->
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn text @click="dialog = false">cancel</v-btn>
                        <v-btn   color="#347cbb" dark width="90" @click="save">save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card>
    </v-container>
</template>

<script>
    import axios from "axios";
    import Tag from "../../models/Tag";

    export default {
        name: "Tags",
        data: () => ({
            headers: [
                { text: "Name", value: "name" },
                { text: "Action", value: "action" },
            ],
            dataTag: [],
            tags:[],
            tag: new Tag(),
            updateData:[],
            dialog: false,
            mode: 0,
            errorMessage: "",
            valid: false,
            update:false,
            nameRules: [
                // v => !!v || "This field is required",
            ],
        }),

        computed: {
            title () {
                return this.mode === 1 ? "New Tag" : "Update Tag"
            },
        },

        methods: {
            add(tag){
                this.tags.push({name:tag});
                this.tag.name = '';
            },
            delTag(i){
                this.tags.splice(i,1);
            },
            getTags () {
                axios.get(`/api/profile/tags`)
                    .then(res => this.dataTag = res.data,  )
                    .catch(err => console.error(err.response.data.message));
            },

            open(item, mode) {
                if(mode == 2){
                    this.update = true;
                }
                this.updateData = item
                this.tag = new Tag(item);
                this.mode = mode;
                this.dialog = true;
            },

            save(item) {
                if (this.mode === 1) {
                    axios.post(`/api/profile/tag/create`, this.tags)
                        .then(res => {
                            for(var i = 0; i<res.data.length;i++){
                                this.dataTag.push(res.data[i]);
                            }
                            this.tag = new Tag();
                            this.tags = [];
                            this.dialog = false;
                        })
                        .catch(err => this.errorMessage = err.response.data.message);
                } else {
                    if(this.updateData.name !== this.tag.name){
                        this.updateData.name = this.tag.name;
                    }
                    axios.put(`/api/profile/tag/update/${this.updateData.id}`, this.updateData)
                        .then(res => {
                            let index = this.tags.findIndex(tag => tag.id == res.data.id);
                            this.tags.splice(index, 1, res.data);
                            this.tag = new Tag();
                            this.dialog = false;
                            this.tags = [];
                        })
                        .catch(err => this.errorMessage = err.response.data.message);
                }
            },

            remove (id) {
                confirm("Are you sure you want to delete this article?") &&
                axios.delete(`/api/profile/tag/${id}`)
                    .then(res => {
                        let index = this.dataTag.findIndex(dt => dt.id == res.data);
                        this.dataTag.splice(index, 1);
                    })
                    .catch(err => console.error(err.response.data.message));
            },

            onFileSelected (event) {
                this.article.main_imageFile = event;
                const reader = new FileReader();
                reader.readAsDataURL(this.article.main_imageFile);
                reader.onload = e => this.article.main_image = e.target.result;
            },

            onFilesSelected (event) {
                this.article.galleryFiles = event;
                this.article.galleryFiles.forEach(galleryFile => {
                    const reader = new FileReader();
                    reader.readAsDataURL(galleryFile);
                    reader.onload = e => this.article.gallery.push(e.target.result);
                });
            },
        },

        created () {
            this.getTags();
        }
    }
</script>

<style scoped>
    .border-bottom {
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
    }
</style>
