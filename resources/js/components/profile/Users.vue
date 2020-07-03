<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="users">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Users</v-toolbar-title>
                        
                            <v-card tile flat width="400" class="ml-12">
                                <v-select
                                    v-model="selectedRole"
                                    :items="roles"
                                    menu-props="offsetY"
                                    label="դեր"
                                    color="#347cbb"
                                    item-color="#347cbb"
                                    outlined
                                    dense
                                    hide-details
                                    clearable
                                    open-on-clear
                                ></v-select>
                            </v-card>
                            <v-spacer></v-spacer>
                            <v-btn outlined color="#347cbb" class="mr-5" @click="open({}, 1)">new user</v-btn>
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
                                            v-model="user.name"
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
                                            v-model="user.email"
                                            :rules="emailRules"
                                            type="email"
                                            label="Էլ․ հասցե"
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
                                        <v-select
                                            v-model="user.role_id"
                                            :rules="nameRules"
                                            :items="roles"
                                            menu-props="offsetY"
                                            label="Դեր"
                                            color="#347cbb"
                                            item-color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                            open-on-clear
                                        ></v-select>
                                    </v-card>
                                </v-col>
                                <v-col cols="5">
                                    <v-btn
                                        v-if="mode === 2"
                                        color="#347cbb"
                                        text
                                        block
                                        @click="updatePassword = true"
                                    >update password</v-btn>
                                </v-col>
                            </v-row>

                            <v-row v-if="mode === 1" no-gutters justify="space-around">
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="user.password"
                                            :rules="nameRules"
                                            type="password"
                                            label="Գաղտնաբառ"
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
                                            v-model="user.password_confirmation"
                                            :rules="nameRules"
                                            type="password"
                                            label="Հաստատել գաղտնաբառը"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            clearable
                                        ></v-text-field>
                                    </v-card>
                                </v-col>
                            </v-row>

                            <v-row v-if="updatePassword" no-gutters justify="space-around">
                                <v-col cols="5">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="user.password"
                                            :rules="nameRules"
                                            type="password"
                                            label="Գաղտնաբառ"
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
                                            v-model="user.password_confirmation"
                                            :rules="nameRules"
                                            type="password"
                                            label="Հաստատել գաղտնաբառը"
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
                                    <v-checkbox
                                        v-model="user.status"
                                        true-value="1"
                                        false-value="0"
                                        :label="`status active: ${!!+user.status}`"
                                    ></v-checkbox>
                                </v-col>
                                <v-col cols="5"></v-col>
                            </v-row>

                            <template v-if="user.role_id === 3">
                                <v-card-title>Distributor options</v-card-title>
                                <v-row no-gutters justify="space-around">
                                    <v-col cols="5">
                                        <v-card tile flat>
                                            <v-text-field
                                                v-model="user.distributor.company"
                                                :rules="nameRules"
                                                label="Կազմակերպություն"
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
                                                v-model="user.distributor.director"
                                                :rules="nameRules"
                                                label="Տնօրեն"
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
                                            <v-text-field
                                                v-model="user.distributor.address"
                                                :rules="nameRules"
                                                label="Հասցե"
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
                                                v-model="user.distributor.phone"
                                                v-mask="'+(374)##-###-###'"
                                                :rules="nameRules"
                                                label="Հեռախոսահամար"
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
                                            <v-text-field
                                                v-model="user.distributor.tax_code"
                                                :rules="nameRules"
                                                label="Հարկային կոդ"
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
                                                v-model="user.distributor.bank_name"
                                                :rules="nameRules"
                                                label="Բանկի անուն"
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
                                            <v-text-field
                                                v-model="user.distributor.iban"
                                                :rules="nameRules"
                                                label="ԻԲԱՆ"
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
                                                v-model="user.distributor.website"
                                                :rules="nameRules"
                                                label="Կայք"
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
                                                v-model="user.distributor.description"
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
                                                label="Կազմակերպության լոգո"
                                                color="#347cbb"
                                                dense
                                                outlined
                                                @change="onFileSelected"
                                            ></v-file-input>
                                            <v-img v-if="user.distributor.logo" :src="user.distributor.logo" contain></v-img>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </template>
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
import User from "../../models/User";

export default {
    name: "TextileTypes",
    data: () => ({
        headers: [
            { text: "Name", value: "name" },
            { text: "Email", value: "email", sortable: false },
            { text: "Role", value: "role.name", sortable: false },
            { text: "Action", value: "action", sortable: false },
        ],
        users: [],
        user: new User(),
        roles: [
            { text: "Admin", value: 1 },
            { text: "Customer", value: 2 },
            { text: "Distributor", value: 3 },
            { text: "Copywriter", value: 4 },
        ],
        dialog: false,
        mode: 0,
        errorMessage: "",
        valid: false,
        nameRules: [
            v => !!v || "This field is required",
        ],
        emailRules: [
            v => !!v || "This field is required",
            v => /.+@.+/.test(v) || "E-mail must be valid",
        ],
        updatePassword: false,
        selectedRole: null,
    }),

    computed: {
        title () {
            return this.mode === 1 ? "New User" : "Update User"
        },
    },

    methods: {
        getUsers () {
            axios.get(`/api/profile/users`)
                .then(res => this.users = res.data)
                .catch(err => console.error(err.response.data.message));
        },

        open(item, mode) {
            this.user = new User(item);
            if (this.user.id) this.user.role_id = this.user.role_id.id;
            this.mode = mode;
            this.dialog = true;
        },

        save() {
            const fd = new FormData();

            fd.append("text", this.user.name + " " + this.user.email);
            fd.append("name", this.user.name);
            fd.append("email", this.user.email);
            fd.append("password", this.user.password);
            fd.append("password_confirmation", this.user.password_confirmation);
            fd.append("role_id", this.user.role_id);
            fd.append("status", this.user.status);

            fd.append("distributor[company]", this.user.distributor.company);
            fd.append("distributor[director]", this.user.distributor.director);
            fd.append("distributor[address]", this.user.distributor.address);
            fd.append("distributor[phone]", this.user.distributor.phone);
            fd.append("distributor[tax_code]", this.user.distributor.tax_code);
            fd.append("distributor[bank_name]", this.user.distributor.bank_name);
            fd.append("distributor[iban]", this.user.distributor.iban);
            fd.append("distributor[website]", this.user.distributor.website);
            fd.append("distributor[description]", this.user.distributor.description);
            fd.append("distributor[logo]", this.user.distributor.logoFile);

            if (this.mode === 1) {
                axios.post(`/api/profile/user/create`, fd)
                    .then(res => {
                        this.users.push(res.data);
                        this.user = new User();
                        this.dialog = false;
                        valid: false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            } else {
                fd.append("_method", "PUT");
                axios.post(`/api/profile/user/update/${this.user.id}`, fd)
                    .then(res => {
                        let index = this.users.findIndex(user => user.id === res.data.id);
                        this.users.splice(index, 1, res.data);
                        this.user = new User();
                        this.dialog = false;
                        valid: false;
                    })
                    .catch(err => this.errorMessage = err.response.data.message);
            }
        },

        remove (item) {
            confirm("Are you sure you want to delete this user?") &&
            axios.delete(`/api/profile/user/delete/${item.id}`)
                .then(res => {
                    let index = this.users.findIndex(user => user.id == res.data);
                    this.users.splice(index, 1);
                })
                .catch(err => console.error(err.response.data.message));
        },

        onFileSelected (event) {
            this.user.distributor.logoFile = event;
            const reader = new FileReader();
            reader.readAsDataURL(this.user.distributor.logoFile);
            reader.onload = e => this.user.distributor.logo = e.target.result;
        },
    },

    watch: {
        dialog (val) {
            if (!val) this.updatePassword = false;
        },
        selectedRole(val){
            axios.get(`/api/profile/users/${val}`)
                .then(res => this.users = res.data)
                .catch(err => console.error(err.response.data.message));
        }
    },

    created () {
        this.getUsers();
    }
}
</script>

<style scoped>
.border-bottom {
    border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}
</style>
