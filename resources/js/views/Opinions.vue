<template>
    <section>
        <v-container>
            <v-row justify="center" align="center">
                <v-col cols="9">
                    <v-row justify="space-between" align="center">
                        <v-col cols="5">
                            <div class="gic"></div>
                        </v-col>
                        <v-col cols="2" >
                            <h1 class="display-1 blue--text text-center" >Կարծիքներ</h1>
                        </v-col>
                        <v-col cols="5" class="pl-10">
                            <div class="gic"></div>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>


            <v-row   v-for="opinion in opinions" :key="opinion.id" justify="center" >
                <v-col cols="9">
                    <v-card flat>
                        <p style="padding: 10px">{{ opinion.text }}</p>
                        <v-avatar style="margin: 10px">
                            <img :src="opinion.user.image"width="50">
                        </v-avatar>
                        <span style="font-size: 25px;margin: 10px">{{ opinion.user.name }}</span>
                    </v-card>
                    <v-divider></v-divider>
                </v-col>
            </v-row>


            <v-row no-gutters justify="center">
                <v-col cols="9">
                    <v-form>
                        <v-textarea
                            color="pink lighten-1"
                            v-model="text"
                            label="Կարծիք"
                            required
                        ></v-textarea>

                        <v-btn text color="blue" @click="createOpinion()">
                            Ուղարկել
                        </v-btn>
                    </v-form>
                </v-col>
            </v-row>
        </v-container>
    </section>
</template>

<script>
    import axios from "axios";

    export default {
        name: "Opinions",
        data: () => ({
           opinions: [],
           text: '',
        }),
        methods:{
            getOpinions() {
                axios.get(`/api/opinions`)
                    .then(res => {
                        this.opinions = res.data;
                        console.log(this.opinions);
                    })
                    .catch(err => console.error(err.response.data.message));
            },
            createOpinion() {
                axios.post(`/api/opinions/` + this.$store.state.auth.user.id, {
                    text: this.text
                }).then(res => { this.text = '' })
                    .catch(err => console.error(err.response.data.message));
            },
        },
        created() {
            this.getOpinions();
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
</style>
