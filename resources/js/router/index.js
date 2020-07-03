import Vue from "vue";
import VueRouter from "vue-router";
// import { auth } from "../store";
import NotFound from "../views/NotFound";
import Home from "../views/Home";
import Register from "../views/Register";
import Login from "../views/Login";
import Profile from "../views/Profile";
import Products from "../views/Products";
import Product from "../views/Product";
import Cart from "../views/Cart";
import Wish from "../views/Wish";
import Offers from "../views/Offers";
import MyProducts from "../views/MyProducts";
import Prof from "../views/Prof";
import MyInfo from "../views/MyInfo";
import Blog from "../views/Blog";
import Article from "../views/Article";
import Ads from "../views/Ads";
import Ad from "../views/Ad";
import Opinions from "../views/Opinions";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [{
            path: "/",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/home/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Home,
            },
            children: [{
                path: "/",
                components: {
                    section1: () =>
                        import ("../components/home/Clothes0-3"),
                    section2: () =>
                        import ("../components/home/Clothes3+"),
                    section3: () =>
                        import ("../components/home/Food"),
                    section4: () =>
                        import ("../components/home/BabyCare"),
                    section5: () =>
                        import ("../components/home/Accessories"),
                }
            }],
            // beforeEnter: (to, from, next) => {
            //     console.log(auth);
            //     next();
            // }
        },
        {
            path: "/register",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Register,
            }
        },
        {
            path: "/login",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Login,
            }
        },
        {
            path: "/profile",
            components: {
                navbar: () =>
                    import ("../components/profile/Navbar"),
                default: Profile,
            },
            children: [{
                    path: "users",
                    component: () =>
                        import ("../components/profile/Users"),
                },
                {
                    path: "contracts",
                    component: () =>
                        import ("../components/profile/Contracts"),
                },
                {
                    path: "manufacturers",
                    component: () =>
                        import ("../components/profile/Manufacturers"),
                },
                {
                    path: "globalSizes",
                    component: () =>
                        import ("../components/profile/GlobalSizes"),
                },
                {
                    path: "sizes",
                    component: () =>
                        import ("../components/profile/Sizes"),
                },
                {
                    path: "colors",
                    component: () =>
                        import ("../components/profile/Colors"),
                },
                {
                    path: "productModels",
                    component: () =>
                        import ("../components/profile/ProductModels"),
                },
                {
                    path: "products",
                    component: () =>
                        import ("../components/profile/Products"),
                },
                {
                    path: "modelDiscounts",
                    component: () =>
                        import ("../components/profile/ModelDiscounts"),
                },
                {
                    path: "productDiscounts",
                    component: () =>
                        import ("../components/profile/ProductDiscounts"),
                },
                {
                    path: "tags",
                    component: () =>
                        import ("../components/profile/Tags"),
                },
                {
                    path: "articleCategories",
                    component: () =>
                        import ("../components/profile/ArticleCategories"),
                },
                {
                    path: "articles",
                    component: () =>
                        import ("../components/profile/Articles"),
                },
                {
                    path: "companyInfo",
                    component: () =>
                        import ("../components/profile/CompanyInfo"),
                },
                {
                    path: "companyProducts",
                    component: () =>
                        import ("../components/profile/CompanyProducts"),
                },
                {
                    path: "ads",
                    component: () =>
                        import ("../components/profile/Ads"),
                },
                {
                    path: "sliders",
                    component: () =>
                        import ("../components/profile/HomeSlider"),
                },
                {
                    path: "orders",
                    component: () =>
                        import ("../components/profile/Orders"),
                },
                {
                    path: "opinions",
                    component: () =>
                        import ("../components/profile/Opinions"),
                },
            ]
        },
        {
            path: "/products",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Products,
            }
        },
        {
            path: "/products/:alias",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Products,
            }
        },
        {
            path: "/products/:alias/:subAlias",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Products,
            }
        },
        {
            path: "/products/:alias/:subAlias/:subSubAlias",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Products,
            }
        },
        {
            path: "/product/:alias",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Product,
            }
        },
        {
            path: "/cart",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Cart,
            }
        },
        {
            path: "/wish",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Wish,
            }
        },
        {

            path: "/offers",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Offers,
            }
        },
        {
            path: "/myProducts",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: MyProducts,
            }
        },
        {
            path: "/prof",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Prof,
            }
        },
        {
            path: "/myInfo",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: MyInfo,
            }
        },
        {
            name: 'blog',
            path: "/blog",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Blog,
            }
        },
        {
            path: "/article/:id",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Article,
            }
        },
        {
            path: "/ads",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                default: Ads,

            }
        },
        {
            path: "/ads/:alias",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                default: Ads,

            }
        },
        {
            path: "/ads/:alias/:subAlias",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                default: Ads,

            }
        },
        {
            path: "/ads/:alias/:subAlias/:subSubAlias",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                default: Ads,

            }
        },
        {
            path: "/ad/:alias",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                default: Ad,
            }
        },
        {
            path: "/opinions",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: Opinions,
            }
        },
        {
            path: "*",
            components: {
                navbar: () =>
                    import ("../components/Navbar"),
                header: () =>
                    import ("../components/home/Header"),
                footer: () =>
                    import ("../components/footer"),
                default: NotFound,
            }
        },

    ]
});
