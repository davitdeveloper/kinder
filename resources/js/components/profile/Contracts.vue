<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="contracts">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Contracts</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new contract</v-btn>
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
                                        <v-autocomplete
                                            v-model="contract.user_id"
                                            :items="distributors"
                                            item-value="user_id"
                                            item-text="company"
                                            :search-input.sync="search"
                                            label="distributor"
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
                                            v-model="contract.name"
                                            :rules="nameRules"
                                            label="name"
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
                                        <v-file-input
                                            label="պայմանագրի փաստաթուղթ"
                                            color="#347cbb"
                                            dense
                                            outlined
                                            @change="onFileSelected"
                                        ></v-file-input>
                                    </v-card>
                                </v-col>

                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-menu
                                            v-model="periodMenu"
                                            :close-on-content-click="false"
                                            nudge-bottom="40"
                                        >
                                            <template v-slot:activator="{ on }">
                                                <v-card id="periodDiv" tile flat>
                                                    <v-text-field
                                                        v-model="period"
                                                        placeholder="Period"
                                                        color="#347cbb"
                                                        prepend-inner-icon="mdi-calendar-search"
                                                        dense
                                                        outlined
                                                        v-on="on"
                                                        @click="calculatePeriodWidth"
                                                    ></v-text-field>
                                                </v-card>
                                            </template>

                                            <v-card tile flat>
                                                <v-date-picker
                                                    v-model="period"
                                                    :width="periodWidth"
                                                    color="#347cbb"
                                                    range
                                                    no-title
                                                    scrollable
                                                ></v-date-picker>
                                            </v-card>
                                        </v-menu>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row no-gutters>
                                <v-col cols="3" class="ml-10">
                                    <v-checkbox
                                        v-model="contract.status"
                                        true-value="1"
                                        false-value="0"
                                        :label="`status active: ${!!+contract.status}`"
                                        class="mt-0"
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
import Contract from "../../models/Contract";

export default {
    name: "Contracts",
    data: () => ({
        periodMenu: false,
        period: [],
        periodWidth: null,
        headers: [
            { text: "Distributor", value: "user.distributor.company" },
            { text: "Name", value: "name" },
            { text: "Date Start", value: "date_start" },
            { text: "Date End", value: "date_end" },
            { text: "Status", value: "status" },
            { text: "Action", value: "action", sortable: false },
        ],
        contracts: [],
        contract: new Contract(),
        distributors: [],
        dialog: false,
        mode: 0,
        errorMessage: "",
        valid: false,
        nameRules: [
            v => !!v || "This field is required",
        ],
        search: "",
    }),

    computed: {
        title () {
            return this.mode === 1 ? "New Contract" : "Update Contract"
        },
    },

    methods: {
        calculatePeriodWidth () {
            this.periodWidth = document.getElementById("periodDiv").offsetWidth;
        },

        getContracts () {
            axios.get(`/api/profile/contracts`)
                .then(res => this.contracts = res.data)
                .catch(err => console.error(err.response.data));
        },

        open(item, mode) {

            if(mode === 2){
                this.period.splice(0, 1, item.date_start);
                this.period.splice(1, 1, item.date_end);
            }
            console.log(this.period);
            this.contract = new Contract(item);
            if (this.contract.id) this.distributors = [this.contract.user.distributor];
            this.mode = mode;
            this.dialog = true;
        },

        save() {
            const fd = new FormData();

            fd.append("user_id", this.contract.user_id);
            fd.append("name", this.contract.name);
            fd.append("document", this.contract.document);
            fd.append("date_start", this.contract.date_start);
            fd.append("date_end", this.contract.date_end);
            fd.append("status", this.contract.status);

            if (this.mode === 1) {
                axios.post(`/api/profile/contract/create`, fd)
                    .then(res => {
                        this.contracts.push(res.data);
                        this.contract = new Contract();
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            } else {
                fd.append("_method", 'PUT');
                axios.post(`/api/profile/contract/update/${this.contract.id}`, fd)
                    .then(res => {
                        let index = this.contracts.findIndex(contract => contract.id === res.data.id);
                        this.contracts.splice(index, 1, res.data);
                        this.contract = new Contract();
                        this.period = [];
                        this.dialog = false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            }
        },

        remove (item) {
            confirm("Are you sure you want to delete this contract?") &&
            axios.delete(`/api/profile/contract/delete/${item.id}`)
                .then(res => {
                    let index = this.contracts.findIndex(contract => contract.id == res.data);
                    this.contracts.splice(index, 1);
                })
                .catch(err => console.error(err.response.data.message));
        },

        onFileSelected (event) {
            this.contract.document = event;
        },
    },

    watch: {
        search (val) {
            if (val) {
                axios.get(`/api/profile/contract/search-dist?search=${val}`)
                    .then(res => this.distributors = res.data)
                    .catch(err => console.error(err.response.data));
            }
        },

        period (val) {
            if (val.length > 1) {
                if (val[0] > val[1]) {
                    const holder = val[0];
                    val[0] = val[1];
                    val[1] = holder;
                }
            }

            this.contract.date_start = val[0];
            this.contract.date_end = val[1];
        }
    },

    created () {
        this.getContracts();
    }
}
</script>

<style scoped>
.border-bottom {
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}
</style>
