<template>
    <section class="marginHeader">
        <v-container>
            <v-row>
                <v-col cols="12" >
                    <template v-if="$vuetify.breakpoint.xs || $vuetify.breakpoint.sm">
                        <v-row>
                            <v-col cols="1" class="ml-6">
                                <v-btn icon color="#347cbb" @click="drawer = !drawer">
                                   <v-img src="/images/filter.png" width="50"></v-img>
                                </v-btn>
                            </v-col>
                            <v-col cols="10" >
                                <v-text-field
                                    v-model="filters.search"
                                    prepend-inner-icon="mdi-magnify"
                                    label="search"
                                    color="#347cbb"
                                    hide-details
                                    single-line
                                    outlined
                                    rounded
                                    dense
                                />
                            </v-col>
                        </v-row>

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

                    </template>
                </v-col>
                <v-col cols="12" xs="12" sm="12" md="8" lg="8" xl="8">
                    <v-col cols="12" class="mb-4">
                        <v-col cols="12" v-for="item in articles" :key="`article-${item.id}`">
                            <v-card
                                class="mx-auto backColor" :href="'/article/'+ item.id">
                                <v-img :src="item.main_image"
                                       :to="'/article'+ item.id" contain>
                                </v-img>

                                <v-card-title to="/article">{{item.title}}</v-card-title>


                                <v-card-text class="text--primary">
                                    <div>
<!--                                        {{item.description}}-->
                                        <viewer :value="item.description"></viewer>
                                    </div>
                                </v-card-text>

                                <v-col class="text-start" cols="4">
                                    Created : {{item.created_at}}
                                </v-col>

                                <v-col class="text-end" >
                                    <v-btn color="error" dark large :to="'/article/'+ item.id">
                                        Continue Reading
                                    </v-btn>
                                </v-col>
                            </v-card>

                            <v-spacer/>

                            <v-divider class="mx-4"/>

                            <v-spacer/>
                        </v-col>
                    </v-col>

                    <v-pagination
                        v-model="filters.page"
                        :value="filters.page"
                        :total-visible="10"
                        :length="Math.ceil(total / filters.perpage)"
                        color="error"
                        class="mt-5"
                        circle
                    />
                </v-col>

                <v-col cols="4" md="4" lg="4" xl="4" class="mt-2" v-if="$vuetify.breakpoint.md || $vuetify.breakpoint.lg || $vuetify.breakpoint.xl">
                    <v-col cols="12">
                        <v-text-field
                            v-model="filters.search"
                            prepend-inner-icon="mdi-magnify"
                            label="search"
                            color="#347cbb"
                            hide-details
                            single-line
                            outlined
                            rounded
                            dense
                        />
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
    import axios from 'axios';
    import { pickBy } from 'lodash';
    import { Viewer } from '@toast-ui/vue-editor';

    const compact = (value, key) => {
        if (Array.isArray(value)) return !!(value.length);

        if (key === 'total') return false;

        if (value) return true;
    };

    export default {
        name: "Blog",
        components: {
            'viewer': Viewer,
        },
        data: () => ({
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
            getArticles(params = {}) {
                this.filters.search = params.search,
                this.filters.category = params.category,
                this.filters.tag = params.tag,
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
            this.getArticles(this.$route.query);
            this.getRecentPost();
            this.getArchive();
            this.getCategories();
            this.getTags();

        }
    }
</script>

<style scoped>
    .CurosorPointer{
        cursor:pointer;
    }
    .backColor:hover{
        background-color: white;
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
    a:hover {
        text-decoration: none;
        background-color: #c2185b;
    }
    .marginHeader{
        margin-top: 100px;
    }
</style>
