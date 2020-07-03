<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="articleCategories">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Article Categories</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new article category</v-btn>
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
                                            v-model="articleCategory.name"
                                            :rules="nameRules"
                                            label="Անուն"
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
                                            v-model="articleCategory.alias"
                                            :rules="nameRules"
                                            label="Alias"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around">
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-textarea
                                                v-model="articleCategory.description"
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
                                        <v-card tile flat>
                                            <v-file-input
                                                label="Նկար"
                                                color="#347cbb"
                                                dense
                                                outlined
                                                @change="onFileSelected"
                                            ></v-file-input>
                                            <v-img v-if="articleCategory.image" :src="articleCategory.image" contain></v-img>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            <v-row no-gutters justify="space-around">
                                <v-col cols="5">
                                    <v-checkbox
                                        v-model="articleCategory.status"
                                        true-value="1"
                                        false-value="0"
                                        :label="`status: ${!!+articleCategory.status}`"
                                    ></v-checkbox>
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
import ArticleCategory from "../../models/ArticleCategory";

export default {
    name: "ArticleCategory",
    data: () => ({
        headers: [
            { text: "Name", value: "name" },
            { text: "Alias", value: "alias", sortable: false },
            { text: "Description", value: "description", sortable: false },
            { text: "Image", value: "image", sortable: false },
            { text: "Action", value: "action", sortable: false },
        ],
        articleCategories: [],
        articleCategory: new ArticleCategory(),
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
            return this.mode === 1 ? "New Article Category" : "Update Article Category"
        },
    },

    methods: {
        getArticleCategories () {
            axios.get(`/api/profile/article-categories`)
                .then(res => this.articleCategories = res.data,  )
                .catch(err => console.error(err.response.data));
        },

        open(item, mode) {
            this.articleCategory = new ArticleCategory(item);
            this.mode = mode;
            this.dialog = true;
        },

        save() {
            const fd = new FormData();
            fd.append("name", this.articleCategory.name);
            fd.append("description", this.articleCategory.description);
            fd.append("status", this.articleCategory.status);
            fd.append("alias", this.articleCategory.alias);
            fd.append("image",this.articleCategory.imageFile);
            if (this.mode === 1) {
                axios.post(`/api/profile/article-category/create`, fd)
                    .then(res => {
                        this.articleCategories.push(res.data);
                        this.articleCategory = new ArticleCategory();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            } else {
                fd.append("_method", 'PUT');
                axios.post(`/api/profile/article-category/update/${this.articleCategory.id}`, fd)
                    .then(res => {
                        let index = this.articleCategories.findIndex(cat => cat.id === res.data.id);
                        this.articleCategories.splice(index, 1, res.data);
                        this.articleCategory = new ArticleCategory();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            }
        },

        remove (item) {
            confirm("Are you sure you want to delete this article category?") &&
            axios.delete(`/api/profile/article-category/delete/${item.id}`)
                .then(res => {
                    let index = this.articleCategories.findIndex(cat => cat.id == res.data);
                    this.articleCategories.splice(index, 1);
                })
                .catch(err => console.error(err.response.data.message));
        },

        onFileSelected (event) {
            this.articleCategory.imageFile = event;
            const reader = new FileReader();
            reader.readAsDataURL(this.articleCategory.imageFile);
            reader.onload = e => this.articleCategory.image = e.target.result;
        },
    },

    created () {
        this.getArticleCategories();
    }
}
</script>

<style scoped>
.border-bottom {
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}
</style>
