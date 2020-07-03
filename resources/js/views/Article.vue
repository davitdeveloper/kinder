<template>
    <section class="marginHeader">
        <v-container>
            <v-row>
                <v-col cols="12" >
                    <template v-if="$vuetify.breakpoint.xs || $vuetify.breakpoint.sm">
                        <v-row>
                            <v-col cols="1" class="ml-5">
                                <v-btn icon color="#347cbb" @click="drawer = !drawer">
                                    <v-img src="/images/filter.png" width="50"></v-img>
                                </v-btn>
                            </v-col>
                            <v-col cols="10" >
                                <v-text-field
                                    v-model="filters.search"
                                    @keyup.13="searchTitle"
                                    label="search"
                                    color="#347cbb"
                                    prepend-inner-icon="mdi-magnify"
                                    rounded
                                    outlined
                                    dense
                                    hide-details
                                    single-line
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" v-if="drawer">
                                <v-col class="mb-4">
                                    <h1>Recent Posts</h1>
                                </v-col>

                                <v-col v-for="item in recentBlog" :key="`recent-article-${item.id}`" cols="12">
                                    <v-card
                                        :href="'/article/'+ item.id"
                                        class="CurosorPointer"
                                        color="#952175"
                                        dark
                                    >
                                        <div class="d-flex flex-no-wrap justify-space-between">
                                            <div>
                                                <v-card-title class="headline" v-text="item.title"></v-card-title>

                                                <v-card-subtitle v-text="item.created_at"></v-card-subtitle>
                                            </div>

                                            <v-avatar class="ma-3" size="125" tile>
                                                <v-img :src="item.main_image"></v-img>
                                            </v-avatar>
                                        </div>
                                    </v-card>
                                </v-col>

                                <v-col class="mb-4">
                                    <h1>Archives</h1>
                                </v-col>

                                <v-col>
                                    <v-card class="mx-auto">
                                        <v-list shaped>
                                            <v-list-item-group v-model="filters.dates" multiple>
                                                <v-list-item v-for="item in archive" :key="`date-${item.month} ${item.year}`" :value="`${item.month} ${item.year}`">
                                                    <v-list-item-content>
                                                        <v-list-item-title v-text="item.month + '  ' + item.year"></v-list-item-title>
                                                    </v-list-item-content>
                                                    <v-list-item-action>{{ item.number }}</v-list-item-action>
                                                </v-list-item>
                                            </v-list-item-group>
                                        </v-list>
                                    </v-card>
                                </v-col>

                                <v-col class="mb-4">
                                    <h1>Categories</h1>
                                </v-col>

                                <v-col cols="12">
                                    <v-select
                                        v-model="filters.category"
                                        :items="categories"
                                        item-text="name"
                                        item-value="alias"
                                        clearable
                                        outlined
                                    ></v-select>
                                </v-col>

                                <v-col class="mb-4">
                                    <h1>Tags</h1>
                                    <v-sheet elevation="10" class="pa-4">
                                        <v-chip-group
                                            v-model="filters.tag" column>
                                            <v-chip v-for="tag in tags" :key="tag.name" :value="tag.name" filter>
                                                {{ tag.name }}
                                            </v-chip>
                                        </v-chip-group>
                                    </v-sheet>
                                </v-col>


                            </v-col>
                        </v-row>
                    </template>
                </v-col>


                <v-col cols="12" xs="12" sm="12" md="8" lg="8" xl="8" class="mt-1">
                    <h2 class="mb-2">{{article.title}}</h2>
                    <v-img height="200" contain :src="article.main_image"></v-img>
                    <p class="mt-2" >
                        <viewer :value="article.description"></viewer>
                    </p>



                    <hr>
                    <ul  class="my-8">
                        <li v-for="item in article.tags"
                            :key="`Tags For Product-${item.id}`"
                            class="py-3  mr-1"
                        >
                            <a href="#" class="py-3" >{{item.name}}</a>
                        </li>

                    </ul>
                        <!--/*For Comment Form */-->
                        <!--                    <h2>Leave a Reply</h2>-->
                        <!--                    <span>Your email address will not be published. Required fields are marked *</span>-->

                        <!--                    <v-form-->
                        <!--                        ref="form"-->
                        <!--                        v-model="valid"-->
                        <!--                        :lazy-validation="lazy"-->
                        <!--                    >-->

                        <!--                        <v-text-field-->
                        <!--                            color="pink lighten-1"-->
                        <!--                            v-model="comment"-->
                        <!--                            label="Comment"-->
                        <!--                            :rules="nameRules"-->
                        <!--                            required-->
                        <!--                        ></v-text-field>-->
                        <!--                        <v-text-field-->
                        <!--                            color="pink lighten-1"-->
                        <!--                            v-model="name"-->
                        <!--                            label="Name"-->
                        <!--                            :rules="nameRules"-->
                        <!--                            required-->
                        <!--                        ></v-text-field>-->
                        <!--                        <v-text-field-->
                        <!--                            color="pink lighten-1"-->
                        <!--                            v-model="email"-->
                        <!--                            label="Email"-->
                        <!--                            :rules="emailRules"-->
                        <!--                            required-->
                        <!--                        ></v-text-field>-->

                        <!--                        <v-btn color="error" dark large :disabled="!valid">-->
                        <!--                            Post Comment-->
                        <!--                        </v-btn>-->
                        <!--                    </v-form>-->
                        <v-card class="mt-4">
                            <v-col cols="12">
                                <v-row style="max-height: 800px;overflowY:auto">
                                    <v-col cols="12">
                                        <v-card v-for="comment in this.article.comments" :key="comment.id"  flat tile>
                                            <v-card-title style="display:flex;justify-content: space-between">
                                                <div>
                                                    <v-avatar>
                                                        <v-img :src="comment.user.image"></v-img>
                                                    </v-avatar>
                                                    <strong>{{ comment.user.name }}</strong>
                                                </div>
                                                {{ comment.created_at }}
                                            </v-card-title>
                                            <v-card-text v-text="comment.text"></v-card-text>
                                            <v-card-actions>
                                                <v-btn text color="blue" @click="displayReplies(comment)">
                                                    View replies
                                                </v-btn>
                                                <strong>{{ comment.replies.length }}</strong>
                                            </v-card-actions>
                                            <v-row v-if="comment.replyDisplay" style="max-height: 400px;overflowY:auto">
                                                <v-col cols="12">
                                                    <v-card class="ml-8"  v-for="reply in comment.replies" :key="reply.id" flat tile>
                                                        <v-card-title style="display:flex;justify-content: space-between">
                                                            <div>
                                                                <v-avatar>
                                                                    <v-img :src="comment.user.image"></v-img>
                                                                </v-avatar>
                                                                <strong>{{ reply.user.name }}</strong>
                                                            </div>
                                                            {{ reply.created_at }}
                                                        </v-card-title>
                                                        <v-card-text v-text="reply.text">

                                                        </v-card-text>
                                                    </v-card>
                                                </v-col>
                                                <v-row no-gutters justify="center">
                                                    <v-col cols="10">
                                                        <v-form>
                                                            <v-textarea
                                                                color="pink lighten-1"
                                                                v-model="reply"
                                                                label="Reply"
                                                                required
                                                            ></v-textarea>

                                                            <v-btn text color="blue" @click="createReply(comment.id)">
                                                                Reply
                                                            </v-btn>
                                                        </v-form>
                                                    </v-col>
                                                </v-row>

                                            </v-row>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-card>
                    <v-form>
                        <v-textarea
                            color="pink lighten-1"
                            v-model="comment"
                            label="Comment"
                            required
                        ></v-textarea>

                        <v-btn text color="blue" @click="createComment()">
                            Comment
                        </v-btn>
                    </v-form>
                </v-col>
                <v-col cols="4" md="4" lg="4" xl="4" class="mt-2" v-if="$vuetify.breakpoint.md || $vuetify.breakpoint.lg || $vuetify.breakpoint.xl">
                    <v-col cols="12">
                        <v-text-field
                            v-model="filters.search"
                            @keyup.13="searchTitle"
                            label="search"
                            color="#347cbb"
                            prepend-inner-icon="mdi-magnify"
                            rounded
                            outlined
                            dense
                            hide-details
                            single-line
                        ></v-text-field>
                    </v-col>

                    <v-col class="mb-4">
                        <h1>Recent Posts</h1>
                    </v-col>

                    <v-col v-for="item in recentBlog" :key="`recent-article-${item.id}`" cols="12">
                        <v-card
                            :href="'/article/'+ item.id"
                            class="CurosorPointer"
                            color="#952175"
                            dark
                        >
                            <div class="d-flex flex-no-wrap justify-space-between">
                                <div>
                                    <v-card-title class="headline" v-text="item.title"></v-card-title>

                                    <v-card-subtitle v-text="item.created_at"></v-card-subtitle>
                                </div>

                                <v-avatar class="ma-3" size="125" tile>
                                    <v-img :src="item.main_image"></v-img>
                                </v-avatar>
                            </div>
                        </v-card>
                    </v-col>

                    <v-col class="mb-4">
                        <h1>Archives</h1>
                    </v-col>

                    <v-col>
                        <v-card class="mx-auto">
                            <v-list shaped>
                                <v-list-item-group v-model="filters.dates" multiple>
                                    <v-list-item v-for="item in archive" :key="`date-${item.month} ${item.year}`" :value="`${item.month} ${item.year}`">
                                        <v-list-item-content>
                                            <v-list-item-title v-text="item.monthHY + '  ' + item.year"></v-list-item-title>
                                        </v-list-item-content>
                                        <v-list-item-action>{{ item.number }}</v-list-item-action>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-card>
                    </v-col>

                    <v-col class="mb-4">
                        <h1>Categories</h1>
                    </v-col>

                    <v-col cols="12">
                        <v-select
                            v-model="filters.category"
                            :items="categories"
                            item-text="name"
                            item-value="alias"
                            clearable
                            outlined
                        ></v-select>
                    </v-col>

                    <v-col class="mb-4">
                        <h1>Tags</h1>
                        <v-sheet elevation="10" class="pa-4">
                            <v-chip-group
                                v-model="filters.tag" column>
                                <v-chip v-for="tag in tags" :key="tag.name" :value="tag.name" filter>
                                    {{ tag.name }}
                                </v-chip>
                            </v-chip-group>
                        </v-sheet>
                    </v-col>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<script>
    import axios from "axios";
    import { pickBy } from "lodash";
    import { Viewer } from '@toast-ui/vue-editor';

    const compact = (value, key) => {
        if (Array.isArray(value)) return !!(value.length);

        if (key === 'total') return false;

        if (value) return true;
    };

    export default {
        name: "Article",
        components: {
            'viewer': Viewer,
        },
        data: () => ({
            comment:'',
            reply:'',
            name:'',
            email:'',
            valid: false,
            lazy: false,
            article:[],
            recentBlog:[],
            tags:[],
            archive: [],
            articles: [],
            categories:[],
            filters: {
                search:'',
                page: 1,
                perpage: 10,
                dates: [],
                tag: null,
                category: null,
            },
            total: null,
            drawer:false


        }),
        watch: {
            filters: {
                handler: function (filters) {
                    let params = pickBy(filters, compact);

                    this.$router.replace({name: 'blog', query: params});

                    this.getArticles(params);
                },
                deep: true
            }
        },
        methods:{
            createComment(){
                axios.post(`/api/app/article/comment/${this.article.id}`, {
                    comment : this.comment,
                    user_id : this.$store.state.auth.user.id,
                })
                    .then(res => {
                        this.comment = '';
                        this.getArticle();
                    })
                    .catch(err => console.error(err.response.data.message));
            },
            createReply(id){
                axios.post(`/api/app/article/comment/reply/${id}`, {
                    reply : this.reply,
                    article_id : this.article.id,
                    user_id : this.$store.state.auth.user.id,
                })
                    .then(res => {
                        this.reply = '';
                        this.getArticle();
                    })
                    .catch(err => console.error(err.response.data.message));
            },
            displayReplies(comment){
              comment.replyDisplay = !comment.replyDisplay;
              this.reply = '';
            },
            getArticle(){
                axios.get(`/api/app/article/` + this.$route.params.id)
                    .then(res => {
                        res.data.comments.forEach(comment => {
                            comment.replyDisplay = false;
                        });
                        this.article = res.data;
                    })
                    .catch(err => console.error(err.response.data.message));
            },
            searchTitle(){
                this.$router.push('/blog?search=' + this.search);
                axios.get(`/api/app/articles?search=` + this.search)
                    .then(res => {
                        this.blog = res.data;
                    })
                    .catch(err => console.error(err.response.data.message));
            },
            getArticles(params = {}) {
                axios.get(`/api/app/articles`, {params})
                    .then(res => {
                        this.articles = res.data.data;
                        this.total = res.data.total;
                    })
                    .catch(err => console.error(err.response.data.message));
            },
            getRecentPost(){
                axios.get(`/api/app/article/latest`)
                    .then(res => {
                        this.recentBlog = res.data;
                    })
                    .catch(err => console.error(err.response.data.message));
            },
            getArchive(){
                axios.get(`/api/app/article/get-archives`)
                    .then(res => this.archive = res.data)
                    .catch(err => console.error(err.response.data.message));
            },
            getCategories(){
                axios.get(`/api/app/article/categories`)
                    .then(res => this.categories = res.data)
                    .catch(err => console.error(err.response.data.message));
            },
            getTags(){
                axios.get(`/api/app/article/get-articles-tags`)
                    .then(res => this.tags = res.data)
                    .catch(err => console.error(err.response.data.message));
            },
            recentTwoBlog(item){
                this.filter = !this.filter
                if(this.filter){
                    this.$router.push('/blog?month=' + item.month +'&year=' + item.year);
                    axios.get(`/api/app/articles?month=` + item.month +'&year='+ item.year)
                        .then(res => {
                            this.blog = res.data.data;

                        })
                        .catch(err => console.error(err.response.data.message));
                }else this.getBlog();
            },
        },
        created() {
            this.getArticle();
            this.getArticles(this.$route.query);
            this.getRecentPost();
            this.getArchive();
            this.getCategories();
            this.getTags();
        }
    }
</script>

<style scoped>
    .marginHeader{
        margin-top: 100px;
    }
    li{
        float: left;
    }
    li a {
        font-size: .75rem !important;
        background: #e94d65;
        color: #fff;
        text-align: center;
        padding: 16px;
        text-decoration: none;
        text-transform: uppercase;
    }
    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }





</style>
