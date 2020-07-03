<template>
    <v-container fluid class="px-0">
        <v-card flat tile>
            <v-card-title >
                <h4>My Company Info</h4>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on" @click="edit">
                            <v-icon>mdi-pencil-outline</v-icon>
                        </v-btn>
                    </template>

                    <span class="pa-3">Edit</span>
                </v-tooltip>
            </v-card-title>

            <v-card-text>
                    <h3>Company</h3>

                    <v-layout wrap class="justify-space-around">
                        <v-flex xs4>
                            <v-text-field
                                v-model="info.company"
                                label="Name"
                                :clearable="clearable"
                                :disabled="disabled"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs4>
                            <v-text-field
                                v-model="info.description"
                                label="Description"
                                :clearable="clearable"
                                :disabled="disabled"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>

                    <v-layout wrap class="justify-space-around">
                        <v-flex xs4>
                            <v-text-field
                                v-model="info.address"
                                label="Address"
                                :clearable="clearable"
                                :disabled="disabled"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs4>
                            <v-text-field
                                v-model="info.phone"
                                label="Phone"
                                :clearable="clearable"
                                :disabled="disabled"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>

                    <v-layout wrap class="justify-space-around">
                        <v-flex xs4>
                            <v-text-field
                                v-model="info.website"
                                label="Website"
                                :clearable="clearable"
                                :disabled="disabled"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs4>
                            <v-text-field
                                v-model="info.director"
                                label="Director"
                                :clearable="clearable"
                                :disabled="disabled"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>

                    <h3>Financial</h3>

                    <v-layout wrap class="justify-space-around">
                        <v-flex xs3>
                            <v-text-field
                                v-model="info.bank_name"
                                label="Bank"
                                :clearable="clearable"
                                :disabled="disabled"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs3>
                            <v-text-field
                                v-model="info.tax_code"
                                label="Tax Code"
                                :clearable="clearable"
                                :disabled="disabled"
                            ></v-text-field>
                        </v-flex>
                        <v-flex xs3>
                            <v-text-field
                                v-model="info.iban"
                                label="Iban"
                                :clearable="clearable"
                                :disabled="disabled"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-card-actions v-if="!disabled">
                        <v-spacer></v-spacer>
                        <v-btn text @click="cancel">cancel</v-btn>
                        <v-btn  color="#347cbb" dark width="90" @click="save">save</v-btn>
                    </v-card-actions>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        name: "CompanyInfo",
        data:() => ({
            info:[],
            disabled: true,
            clearable: false,
        }),

        methods:{
            edit () {
                this.disabled = false;
                this.clearable = true;
            },
            save () {
                axios.put(`/api/profile/update-distributor-info/${this.info.id}`,this.info)
                    .then(res =>  {
                        this.info = res.data;
                        this.disabled = true;
                        this.clearable = false;
                    })
                    .catch(err => {
                        this.errMessage = err.response.data;
                        setTimeout(() => {
                            this.errMessage = "";
                        }, 2000)
                    });
            },
            cancel () {
                this.disabled = true;
                this.clearable = false;
            },
        },
        created() {
            if(this.$store.state.auth.user){
                return axios.get(`/api/profile/get-distributor-info/${this.$store.state.auth.user.id}`)
                    .then(res =>  this.info = res.data )
                    .catch(err => {
                        this.errMessage = err.response.data;
                        setTimeout(() => {
                            this.errMessage = "";
                        }, 2000)
                    });
            }else{
                return alert('not loggin');
            }
        }
    }
</script>

<style scoped>

</style>
