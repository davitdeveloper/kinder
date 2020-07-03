<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="articles">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">Նոր հոդված</v-btn>
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
                <template v-slot:item.status="{ item }">
                    <div v-if="item.status == 0" style="text-align: center">
                        <v-icon color="red">mdi-checkbox-blank-circle</v-icon><strong>Չհաստատված</strong>
                    </div>
                    <div v-if="item.status == 1" style="text-align: center">
                        <v-icon color="green">mdi-checkbox-blank-circle</v-icon><strong>Հաստատված</strong>
                    </div>
                </template>
                <template v-slot:item.description="{ item }">
                    <v-card class="px-3 py-3" tile flat max-width="700" max-height="80" style="text-align: justify;overflow-y: auto">
<!--                        {{ item.description }}-->
                        <viewer :value="item.description"></viewer>
                    </v-card>
                </template>
            </v-data-table>

            <v-dialog v-model="dialog" max-width="50%" persistent>
                <v-card>
                    <v-card-title>
                        {{ title }}
                    </v-card-title>
                    <v-form>
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
                                            clearable
                                            open-on-clear
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
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around">

                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-autocomplete
                                            v-model="article.tags"
                                            :items="tags"
                                            item-text="name"
                                            item-key="id"
                                            :search-input.sync="searchTags"
                                            return-object
                                            label="թեգեր"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            prepend-inner-icon="mdi-database-search"
                                            chips
                                            small-chips
                                            multiple
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
                                        <v-file-input
                                            label="Գլխավոր նկար"
                                            color="#347cbb"
                                            dense
                                            outlined
                                            @change="onFileSelected"
                                        ></v-file-input>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row no-gutters justify="space-around">
<!--                                <v-col cols="5">-->
<!--                                    <v-card tile flat>-->
<!--                                        <v-textarea-->
<!--                                            v-model="article.description"-->
<!--                                            label="Նկարագրություն"-->
<!--                                            color="#347cbb"-->
<!--                                            outlined-->
<!--                                            dense-->
<!--                                            clearable-->
<!--                                        ></v-textarea>-->
<!--                                    </v-card>-->
<!--                                </v-col>-->

                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-img v-if="article.main_image" :src="article.main_image" contain></v-img>
                                    </v-card>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <editor v-model="article.description" :options="editorOptions"/>
                                </v-col>
                            </v-row>
                            <v-row no-gutters justify="center">
                                <v-col cols="10">
                                    <v-card tile flat>
                                        <v-file-input
                                            label="Նկարներ"
                                            color="#347cbb"
                                            multiple
                                            dense
                                            outlined
                                            @change="onFilesSelected"
                                        ></v-file-input>
                                    </v-card>
                                </v-col>

                            </v-row>
                            <v-row no-gutters justify="center">
                                <v-col cols="11">
                                    <v-card tile outlined>
                                        <v-row no-gutters justify="space-around">
                                            <v-col
                                                v-for="(image, i) in article.gallery"
                                                :key="i"
                                                cols="3"
                                            >
<!--                                                <v-img :src="image.image"></v-img>-->
                                                <v-card tile flat>
                                                    <v-img v-if="typeof(image) === 'string'" :src="image" contain max-height="150px">
                                                        <div style="display:flex;justify-content:flex-end">

                                                            <v-tooltip bottom>
                                                                <template v-slot:activator="{ on }">
                                                                    <v-btn icon v-on="on"  @click="delImg(i,image.id)">
                                                                        <v-icon style="color:red">mdi-window-close</v-icon>
                                                                    </v-btn>
                                                                </template>

                                                                <span class="pa-3">Delete Image</span>
                                                            </v-tooltip>
                                                        </div>
                                                    </v-img>
                                                    <v-img v-if="typeof (image) === 'object'" :src="image.image" contain max-height="150px">
                                                        <div style="display:flex;justify-content:flex-end">

                                                            <v-tooltip bottom>
                                                                <template v-slot:activator="{ on }">
                                                                    <v-btn icon v-on="on"  @click="delImg(i,image.id)">
                                                                        <v-icon style="color:red">mdi-window-close</v-icon>
                                                                    </v-btn>
                                                                </template>

                                                                <span class="pa-3">Delete Image</span>
                                                            </v-tooltip>
                                                        </div>
                                                    </v-img>
                                                </v-card>
                                            </v-col>
                                        </v-row>
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
    import Article from "../models/Article";
    import { Editor, Viewer } from '@toast-ui/vue-editor';

    export default {
        name: "MyArticles",
        components: {
            'editor': Editor,
            'viewer': Viewer,
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
                { text: "Վերնագիր", value: "title", sortable: false  },
                { text: "Նկարագրություն", value: "description", sortable: false },
                { text: "Բաժին", value: "category.name", sortable: false },
                { text: "Ստատուս", value: "status", sortable: false  },
                { text: "Գործողություններ", value: "action" , sortable: false },
            ],
            articles: [],
            article: new Article(),
            articleCategories: [],
            articleCategoriesCheck: [],
            tags:[],
            dialog: false,
            mode: 0,
            search: "",
            searchTags: "",
            errorMessage: "",
        }),

        computed: {
            title () {
                return this.mode === 1 ? "New Article" : "Update Article"
            },
        },

        methods: {
            getArticles () {
                axios.get(`/api/app/my-articles/${this.$store.state.auth.user.id}`)
                    .then(res => {
                        this.articles =  res.data;
                    })
                    .catch(err => console.error(err.response.data.message));
            },
            delImg (index,id) {
                if(id){
                    axios.delete(`/api/app/my-articles/image/${id}`)
                        .then(res =>  {
                            this.article.gallery.splice(index, 1);
                        })
                        .catch();
                }else{
                    this.article.gallery.splice(index, 1);
                }
            },
            open(item, mode) {
                item.name = '';
                this.article = new Article(item);
                this.article.gallery = item.images
                if (this.article.id) {
                    this.tags = [item.tags[0]];
                    this.articleCategories = [item.category];
                    this.articleCategoriesCheck =  this.articleCategories;
                    // this.article.gallery = [item.gallery];
                }
                this.mode = mode;
                this.dialog = true;
            },
            save() {
                const fd = new FormData();
                if (this.mode === 1) {
                    fd.append('article_category_id', this.article.article_category_id.id);
                } else if(this.articleCategories[0].name == this.articleCategoriesCheck[0].name ){
                    alert('chpoxvac category');
                    fd.append('article_category_id', this.article.article_category_id);
                }else if(this.articleCategories[0].name !== this.articleCategoriesCheck[0].name){
                    alert('Poxvac ');
                    fd.append('article_category_id', this.article.article_category_id.id);
                }

                fd.append('title', this.article.title);
                fd.append('user_id', this.$store.state.auth.user.id);
                fd.append('description', this.article.description);
                fd.append('main_image', this.article.main_imageFile);
                fd.append("tags", []);

                this.article.tags.forEach((tag, i) => {
                    fd.append(`tags[${i}]`, tag.id);
                });

                fd.append("gallery", []);
                this.article.galleryFiles.forEach((image, i) => {
                    fd.append(`gallery[${i}]`, image);
                });
                if (this.mode === 1) {
                    axios.post(`/api/app/my-article/create`, fd)
                        .then(res => {
                            this.articles.push(res.data);
                            this.article = new Article();
                            this.dialog = false;
                        })
                        .catch(err => this.errorMessage = err.response.data);
                } else {

                    fd.append("_method", 'PUT');
                    axios.post(`/api/app/my-article/update/${this.article.id}`, fd)
                        .then(res => {
                            let index = this.articles.findIndex(article => article.id === res.data.id);
                            this.articles.splice(index, 1, res.data);
                            this.article = new Article();
                            this.dialog = false;
                        })
                        .catch(err => this.errorMessage = err.response.data);
                }
            },

            remove (item) {
                confirm("Are you sure you want to delete this article?") &&
                axios.delete(`/api/app/my-article/delete/${item.id}`)
                    .then(res => {
                        let index = this.articles.findIndex(article => article.id === res.data);
                        this.articles.splice(index, 1);
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
        watch: {
            search (val) {
                if (val) {
                    axios.get(`/api/app/my-articles/search-category?search=${val}`)
                        .then(res => {
                            this.articleCategories = res.data;
                        })
                        .catch(err => console.error(err.response.data.message));
                }
            },
            searchTags (val) {
                if (val) {
                    axios.get(`/api/app/my-articles/search-tags?search=${val}`)
                        .then(res => {
                            this.tags = res.data;
                        })
                        .catch(err => console.error(err.response.data.message));
                }
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
