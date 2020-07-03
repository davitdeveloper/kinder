<template>
    <v-container fluid class="px-0">
        <v-card tile outlined>
            <v-data-table :headers="headers" :items="opinions">
                <template v-slot:top>
                    <v-card tile flat class="border-bottom">
                        <v-toolbar flat>
                            <v-toolbar-title>Opinions</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                    </v-card>
                </template>
                <template v-slot:item.text="{item}">
                   <p >{{ item.text }}</p>
                </template>
                <template v-slot:item.status="{item}">
                    <div style="display: flex" v-if="item.status == 0">
                        <v-icon color="red">mdi-checkbox-blank-circle</v-icon><strong>Չհաստատված</strong>
                    </div>
                    <div style="display: flex" v-if="item.status == 1">
                        <v-icon color="green">mdi-checkbox-blank-circle</v-icon><strong>Հաստատված</strong>
                    </div>
                </template>

                <template v-slot:item.action="{ item }">
                    <div style="display: flex">
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
                    </div>
                </template>
            </v-data-table>

            <v-dialog v-model="dialog" max-width="50%" persistent>
                <v-card>
                    <v-card-title>
                       Կարծիք
                    </v-card-title>
                    <v-form>
                        <v-container>
                            <v-row no-gutters justify="space-around">
                                <v-col cols="10">
                                    <v-card tile flat>
                                        <v-text-field
                                            v-model="opinion.name"
                                            label="Գրողի Անուն"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            disabled
                                        ></v-text-field>
                                    </v-card>

                                    <v-card tile flat>
                                        <v-textarea
                                            v-model="opinion.text"
                                            label="Կարծիք"
                                            color="#347cbb"
                                            outlined
                                            dense
                                            readonly
                                        ></v-textarea>
                                    </v-card>
                                </v-col>
                            </v-row>
                            <v-row no-gutters justify="center">
                                <v-col cols="2">
                                    <v-checkbox
                                        v-model="opinion.status"
                                        true-value="1"
                                        false-value="0"
                                        :label="`status: ${!!+opinion.status}`"
                                    ></v-checkbox>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
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
    export default {
        name: "Opinions",
        data: () => ({
            headers: [
                { text: "Name", value: "user.name" },
                { text: "Text", value: "text", sortable: false },
                { text: "Status", value: "status", sortable: false },
                { text: "Action", value: "action", sortable: false },
            ],
            opinions: [],
            opinion: {
                id: '',
                name: '',
                text: '',
                status: '',
            },
            dialog: false,
        }),

        methods: {
            getOpinions () {
                axios.get(`/api/profile/opinions`)
                    .then(res => this.opinions = res.data)
                    .catch(err => console.error(err.response.data.message));
            },

            open(item) {
                this.opinion.id = item.id;
                this.opinion.name = item.user.name;
                this.opinion.text = item.text;
                this.opinion.status = item.status;
                this.dialog = true;
            },

            save() {
                axios.post(`/api/profile/opinions/update/${this.opinion.id}`, {
                    _method: 'put',
                    status: this.opinion.status
                }).then(res => {
                    let index = this.opinions.findIndex(opinion => opinion.id === res.data.id);
                    this.opinions.splice(index, 1, res.data);
                    this.opinion.id = '';
                    this.opinion.name = '';
                    this.opinion.text = '';
                    this.opinion.status = '';
                    this.dialog = false;
                 }).catch(err => err.response.data.message);
            },

            remove (item) {
                confirm("Are you sure you want to delete this manufacturer?") &&
                axios.delete(`/api/profile/opinions/delete/${item.id}`)
                    .then(res => {
                        let index = this.opinions.findIndex(opinion => opinion.id === res.data);
                        this.opinions.splice(index, 1);
                    })
                    .catch(err => console.error(err.response.data.message));
            },
        },

        created () {
            this.getOpinions();
        }
    }
</script>

<style scoped>

</style>
