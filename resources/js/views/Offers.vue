<template>
        <v-data-table :items-per-page="5" :headers="headers" :items="offers">
            <template v-slot:item.image="{ item }">
                <div class="p-2 tbl-img">
                    <v-img :src="item.product.model.main_image"></v-img>
                </div>
            </template>
        </v-data-table>
</template>

<script>
    export default {
        name: "Offers",
        data:() => ({
            headers: [
                { text: "Title", value: "product.model.title" },
                { text: "Description", value: "product.model.short_description", sortable: false },
                { text: "Image", value: "image", sortable: false },
                { text: "Quantity", value: "quantity", sortable: false },
                { text: "Price", value: "price", sortable: false  },
            ],
            pagination: {
                itemsPerPage: 5,
            },
           offers: [],
        }),

        methods:{

        },
        created() {
            if(this.$store.state.auth.user){
                return axios.get(`/api/app/user/offers/${this.$store.state.auth.user.id}`)
                    .then(res =>  this.offers = res.data )
                    .catch(err => {
                        this.errMessage = err.response.data.message;
                        setTimeout(() => {
                            this.errMessage = "";
                        }, 2000)
                    });
            }else{
                window.location.href = '/';
            }


        }
    }
</script>

<style scoped>
    .petlya {
        height: 100px;
        background: url(/images/shape1.png) no-repeat;
        background-size: contain;
        position: relative;
    }
    .titer {
        position: absolute;
        right: -50px;
        top: -5px;
    }
    .gic {
        height: 2px;
        margin-top: 60px;
        background: url(/images/shape3.png);
        background-size: contain;
    }
    .myInfo {
        color: #4dc0a6;
        font-size: 3vw !important;
        position: absolute;
        top: 190px;
        left: 38%;
    }
    .tbl-img{
        max-width: 50px;
        max-height: 150px;
    }
</style>
