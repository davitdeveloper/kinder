<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="articles">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Articles</v-toolbar-title>
                        </v-toolbar>
                    </v-card>
                </template>

                <template v-slot:item.status="{item}">
                    <div v-if="item.status == 0">
                        <v-icon color="red">mdi-checkbox-blank-circle</v-icon><strong>Չհաստատված</strong>
                    </div>
                    <div v-if="item.status == 1">
                        <v-icon color="green">mdi-checkbox-blank-circle</v-icon><strong>Հաստատված</strong>
                    </div>
                </template>
                <template v-slot:item.description="{ item }">
                    <v-card class="px-3 py-3" tile flat max-width="700" max-height="80" style="text-align: justify;overflow-y: auto">
                        {{ item.description }}
                    </v-card>
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
                    <v-form v-model="valid">
                        <v-container>
                            <v-row no-gutters justify="space-around">
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-autocomplete
                                            v-model="article.article_category_id"
                                            :items="articleCategories"
                                            item-value="id"
                                            item-text="name"
                                            :search-input.sync="search"
                                            return-object
                                            label="բաժին"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            prepend-inner-icon="mdi-database-search"
                                            hide-selected
                                            outlined
                                            dense
                                            disabled
                                        ></v-autocomplete>
                                    </v-card>
                                </v-col>

                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="article.title"
                                            label="Վերնագիր"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            disabled
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around">
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <h4 class="mb-4">Գլխավոր նկար</h4>
                                        <v-img v-if="article.main_image" :src="article.main_image" contain></v-img>
                                    </v-card>
                                </v-col>
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-textarea
                                            v-model="article.description"
                                            label="Նկարագրություն"
                                            color="#347cbb"
                                            outlined
                                            dense
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
                                    v-for="(image,i) in article.gallery[0]"
                                    :key="i"
                                >
                                    <v-img class="mt-2 mr-1" :src="image.image" contain></v-img>
                                </v-col>
                            </v-row>
                            <v-row no-gutters justify="center">
                                <v-col cols="2">
                                    <v-checkbox
                                        v-model="status"
                                        :true-value="1"
                                        :false-value="0"
                                        :label="`status: ${!!+article.status}`"
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
import Article from "../../models/Article";

export default {
    name: "Articles",
    data: () => ({
        headers: [
            { text: "User Name", value: "user.name" },
            { text: "Title", value: "title" },
            { text: "Description", value: "description", sortable: false },
            { text: "Category", value: "category.name", sortable: false },
            { text: "Status", value: "status"},
            { text: "Action", value: "action" },
        ],
        articles: [],
        article: new Article(),
        articleCategories: [],
        tags:[],
        dialog: false,
        search: "",
        searchTags: "",
        errorMessage: "",
        valid: false,
        status: null,
    }),

    computed: {
        title () {
            return "Update Article"
        },
    },

    methods: {
        getArticles () {
            axios.get(`/api/profile/articles`)
                .then(res => this.articles = res.data)
                .catch(err => console.error(err.response.data.message));
        },

        open(item) {
            item.name = '';
            this.article = new Article(item);
            this.status = item.status;
            if (this.article.id) {
                this.tags = [item.tags[0]];
                this.articleCategories = [item.category];

                this.article.gallery = [item.images];
            }
            this.dialog = true;
        },
        save() {
            const fd = new FormData();

            fd.append('status', this.status);
            fd.append("_method", 'PUT');
                axios.post(`/api/profile/article/update/${this.article.id}`, fd)
                    .then(res => {
                        let index = this.articles.findIndex(article => article.id === res.data.id);
                        this.articles.splice(index, 1, res.data);
                        this.article = new Article();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data);
        },

        remove (item) {
            confirm("Are you sure you want to delete this article?") &&
            axios.delete(`/api/profile/article/delete/${item.id}`)
                .then(res => {
                    let index = this.articles.findIndex(article => article.id == res.data);
                    this.articles.splice(index, 1);
                })
                .catch(err => console.error(err.response.data.message));
        },
    },
    created () {
        this.getArticles();
    }
}
</script>

<style scoped>
.border-bottom {
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}
</style>
