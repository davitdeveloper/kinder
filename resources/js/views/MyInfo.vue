<template>
    <section>
        <v-container>
            <template>
                <v-card flat tile>
                    <v-card-title >
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
                        <v-form>
                            <v-row no-gutters justify="space-between" align="center">
                                <v-col cols="5">
                                    <v-text-field
                                        v-model="info.name"
                                        label="Name"
                                        rounded
                                        outlined
                                        dense
                                        :clearable="clearable"
                                        :disabled="disabled"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="5">
                                    <v-text-field
                                        v-model="info.email"
                                        rounded
                                        outlined
                                        dense
                                        label="Email"
                                        :rules = "emailRules"
                                        :clearable="clearable"
                                        :disabled="disabled"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row justify="space-between">
                                <v-col cols="3">
                                    <v-btn
                                        color="#347cbb"
                                        text
                                        block
                                        :disabled="disabled"
                                        @click="updatePassword = !updatePassword"
                                    >update password</v-btn>
                                </v-col>
                                <v-col cols="3">
                                    <v-btn
                                        color="#347cbb"
                                        text
                                        block
                                        :disabled="disabled"
                                        @click="updateAvatar = !updateAvatar"
                                    >update avatar</v-btn>
                                </v-col>
                                <v-col cols="3">
                                    <v-btn
                                        color="#347cbb"
                                        text
                                        block
                                        :disabled="disabled"
                                        @click="childBirthday = !childBirthday"
                                    >add children birthday</v-btn>
                                </v-col>
                                <v-col cols="3">
                                    <v-btn
                                        color="#347cbb"
                                        text
                                        block
                                        :disabled="disabled"
                                        @click="cv = !cv"
                                    >baby sitter cv</v-btn>
                                </v-col>
                            </v-row>
                            <v-row  no-gutters justify="center">
                                <v-col cols="7" v-if="updatePassword">
                                    <v-row justify="center">
                                        <v-col cols="4">
                                            <h2 >Update Password</h2>
                                        </v-col>
                                    </v-row>
                                    <v-text-field
                                        v-model="info.password"
                                        :rules="nameRules"
                                        rounded
                                        outlined
                                        dense
                                        type="password"
                                        label="Գաղտնաբառ"
                                        color="#347cbb"
                                        clearable
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="info.password_confirmation"
                                        :rules="nameRules"
                                        rounded
                                        outlined
                                        dense
                                        type="password"
                                        label="Հաստատել գաղտնաբառը"
                                        color="#347cbb"
                                        clearable
                                    ></v-text-field>
                                </v-col>
                                <v-col v-if="updateAvatar" cols="7">
                                    <v-row justify="center">
                                        <v-col cols="3">
                                            <h2 >Update Avatar</h2>
                                        </v-col>
                                    </v-row>
                                    <v-file-input
                                        label="նկար"
                                        color="#347cbb"
                                        dense
                                        outlined
                                        @change="onFileSelected"
                                    ></v-file-input>
                                    <div style="display:flex;justify-content:center">
                                        <v-avatar size="250" style="border: 1px solid #ccc">
                                            <v-img  v-if="info.image" :src="info.image" contain></v-img>
                                        </v-avatar>
                                    </div>
                                </v-col>
                                <v-col v-if="childBirthday" cols="10">
                                    <v-row justify="center">
                                        <v-col cols="3">
                                            <h2 >Children Birthday</h2>
                                        </v-col>
                                    </v-row>
                                    <v-row justify="space-between">
                                        <v-col cols="4">
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="child.name"
                                                    label="Երեխաի անունը"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                ></v-text-field>
                                            </v-card>
                                        </v-col>
                                        <v-col  cols="3">
                                            <v-menu
                                                nudge-bottom="80"
                                            >
                                                <template v-slot:activator="{ on }">
                                                    <v-card tile flat>
                                                        <v-text-field
                                                            v-model="child.birthday"
                                                            placeholder="Ծննդյան ամիս,տարի,օր"
                                                            color="#347cbb"
                                                            prepend-inner-icon="mdi-calendar-search"
                                                            dense
                                                            outlined
                                                            v-on="on"
                                                        ></v-text-field>
                                                    </v-card>
                                                </template>

                                                <v-card tile flat>
                                                    <v-date-picker v-model="child.birthday"></v-date-picker>
                                                </v-card>
                                            </v-menu>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-icon v-if="child.name && child.birthday"
                                                    color="#347cbb" dark x-large
                                                    @click="add()"
                                            >
                                                mdi-plus-circle
                                            </v-icon>
                                        </v-col>
                                    </v-row>
                                    <v-row v-for="(date,i) in dates" :key="i" justify="space-between">
                                        <v-col cols="4">
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="date.name"
                                                    label="Երեխաի անունը"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                    disabled
                                                ></v-text-field>
                                            </v-card>
                                        </v-col>
                                        <v-col  cols="3">
                                            <v-text-field
                                                v-model="date.birthday"
                                                placeholder="Ծննդյան ամիս,տարի,օր"
                                                color="#347cbb"
                                                prepend-inner-icon="mdi-calendar-search"
                                                dense
                                                outlined
                                                disabled
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-icon color="red" dark x-large @click="delDate(i)">
                                                mdi-delete-outline
                                            </v-icon>

                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col v-if="cv" cols="12">
                                    <v-row justify="center">
                                        <v-col cols="1">
                                            <h2 >CV</h2>
                                        </v-col>
                                    </v-row>
                                    <v-row no-gutters justify="space-between">
                                        <v-col cols="5">
                                            <v-text-field
                                                v-model="resume.full_name"
                                                :rules="nameRules"
                                                rounded
                                                outlined
                                                dense
                                                label="full name"
                                                color="#347cbb"
                                                clearable
                                            ></v-text-field>
                                        </v-col>
                                        <v-col  cols="5">
                                            <v-menu
                                                nudge-bottom="80"
                                            >
                                                <template v-slot:activator="{ on }">
                                                    <v-card tile flat>
                                                        <v-text-field
                                                            v-model="resume.birthday"
                                                            placeholder="Ծննդյան ամիս,տարի,օր"
                                                            color="#347cbb"
                                                            prepend-inner-icon="mdi-calendar-search"
                                                            dense
                                                            outlined
                                                            v-on="on"
                                                        ></v-text-field>
                                                    </v-card>
                                                </template>

                                                <v-card tile flat>
                                                        <v-date-picker width="410" v-model="resume.birthday"></v-date-picker>
                                                </v-card>
                                            </v-menu>
                                        </v-col>
                                    </v-row>
                                    <v-row no-gutters justify="space-between">
                                        <v-col cols="5">
                                            <v-text-field
                                                v-model="resume.city"
                                                :rules="nameRules"
                                                rounded
                                                outlined
                                                dense
                                                label="city"
                                                color="#347cbb"
                                                clearable
                                            ></v-text-field>
                                        </v-col>
                                        <v-col  cols="5">
                                            <v-text-field
                                                v-model="resume.phone"
                                                v-mask="'+(374)##-###-###'"
                                                :rules="nameRules"
                                                rounded
                                                outlined
                                                dense
                                                label="phone"
                                                color="#347cbb"
                                                clearable
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row no-gutters justify="space-between">
                                        <v-col cols="5">
                                            <v-card tile flat>
                                                <v-textarea
                                                    v-model="resume.family_status"
                                                    solo
                                                    dense
                                                    name="family_status"
                                                    label="family status"
                                                ></v-textarea>
                                            </v-card>
                                        </v-col>
                                        <v-col  cols="5">
                                            <v-card tile flat>
                                                <v-textarea
                                                    v-model="resume.personal_qualities"
                                                    solo
                                                    dense
                                                    name="personal_qualities"
                                                    label="personal qualities"
                                                ></v-textarea>
                                            </v-card>
                                        </v-col>
                                    </v-row>

                                    <v-row justify="center">
                                        <v-col cols="12">
                                            <h2 style="text-align:center">Experience</h2>
                                        </v-col>
                                    </v-row>
                                    <v-row no-gutters justify="space-between" align="center">
                                        <v-col cols="8">
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
                                            <v-card tile flat>
                                                <v-textarea
                                                    v-model="experience.description"
                                                    solo
                                                    dense
                                                    name="description"
                                                    label="description"
                                                ></v-textarea>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-icon v-if="experience.start && experience.end && experience.description"
                                                    color="#347cbb" dark x-large
                                                    @click="addExperience()"
                                            >
                                                mdi-plus-circle
                                            </v-icon>
                                        </v-col>
                                    </v-row>
                                    <v-row v-for="(experience,i) in experiences" :key="i" no-gutters justify="space-between" align="center">
                                        <v-col cols="8">
                                            <v-row>
                                                <v-col cols="12">
                                                    <v-divider></v-divider>
                                                </v-col>
                                            </v-row>
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="experience.start"
                                                    label="start"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                    disabled
                                                ></v-text-field>
                                            </v-card>
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="experience.end"
                                                    label="end"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                    disabled
                                                ></v-text-field>
                                            </v-card>
                                            <v-card tile flat>
                                                <v-textarea
                                                    v-model="experience.description"
                                                    solo
                                                    dense
                                                    name="description"
                                                    label="description"
                                                    disabled
                                                ></v-textarea>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-icon color="red" dark x-large @click="delExperience(i)">
                                                mdi-delete-outline
                                            </v-icon>
                                        </v-col>
                                    </v-row>

                                    <v-row justify="center">
                                        <v-col cols="12">
                                            <h2 style="text-align:center">Education</h2>
                                        </v-col>
                                    </v-row>
                                    <v-row no-gutters justify="space-between" align="center">
                                        <v-col cols="4">
                                                <v-menu
                                                    v-model="educationPeriodMenu"
                                                    :close-on-content-click="false"
                                                    nudge-bottom="40"
                                                >
                                                    <template v-slot:activator="{ on }">
                                                        <v-card tile flat>
                                                            <v-text-field
                                                                v-model="educationPeriod"
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
                                                            v-model="educationPeriod"
                                                            :width="periodWidth"
                                                            color="#347cbb"
                                                            range
                                                            no-title
                                                            scrollable
                                                        ></v-date-picker>
                                                    </v-card>
                                                </v-menu>
                                        </v-col>
                                        <v-col cols="4">
                                                <v-text-field
                                                    v-model="education.institution_name"
                                                    label="institution name"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                ></v-text-field>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-icon v-if="education.start && education.end && education.institution_name"
                                                    class="mb-7"
                                                    color="#347cbb" dark x-large
                                                    @click="addEducation()"
                                            >
                                                mdi-plus-circle
                                            </v-icon>
                                        </v-col>
                                    </v-row>

                                    <v-row v-for="(education,i) in educations" :key="i" no-gutters justify="space-between" align="center">
                                        <v-col cols="8">
                                            <v-row>
                                                <v-col cols="12">
                                                    <v-divider></v-divider>
                                                </v-col>
                                            </v-row>
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="education.start"
                                                    label="start"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                    disabled
                                                ></v-text-field>
                                            </v-card>
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="education.end"
                                                    label="end"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                    disabled
                                                ></v-text-field>
                                            </v-card>
                                            <v-card tile flat>
                                                <v-text-field
                                                    v-model="education.institution_name"
                                                    label="institution name"
                                                    color="#347cbb"
                                                    outlined
                                                    dense
                                                    clearable
                                                    disabled
                                                ></v-text-field>
                                            </v-card>
                                        </v-col>
                                        <v-col cols="2">
                                            <v-icon color="red" dark x-large @click="delEducation(i)">
                                                mdi-delete-outline
                                            </v-icon>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-form>
                        <v-card-actions v-if="!disabled">
                            <v-spacer></v-spacer>
                            <v-btn text @click="cancel">cancel</v-btn>
                            <v-btn  color="#347cbb" dark width="90" @click="save">save</v-btn>
                        </v-card-actions>
                    </v-card-text>
                </v-card>
            </template>
        </v-container>
    </section>

</template>

<script>
    import axios from "axios";

    export default {
        name: "MyInfo",
        props: ['user'],
        data:() => ({
            periodMenu: false,
            period: [],
            periodWidth: null,
            educationPeriodMenu: false,
            educationPeriod: [],
            date: new Date().toISOString().substr(0, 10),
            dates: [],
            child: {
                name: '',
                birthday : '',
            },
            resume: {
                full_name: '',
                birthday : '',
                city : '',
                phone : '',
                family_status : '',
                personal_qualities : '',
            },
            experience: {
                start: '',
                end: '',
                description: '',
            },
            experiences: [],
            education: {
                start: '',
                end: '',
                institution_name: '',
            },
            educations: [],
            info:{
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                image: '',
                childrens: '',
                imageFile: null,
            },
            disabled: true,
            clearable: false,
            errMessage: '',
            updatePassword: false,
            updateAvatar: false,
            childBirthday: false,
            cv: false,
            nameRules: [
                v => !!v || "This field is required",
            ],
            emailRules: [
                v => !!v || "This field is required",
                v => /.+@.+/.test(v) || "E-mail must be valid",
            ],
        }),

        methods:{
            calculatePeriodWidth () {
                this.periodWidth = document.getElementById("periodDiv").offsetWidth;
            },
            add(){
              this.dates.push(this.child);
              this.child = {
                  name: '',
                  birthday : '',
              }
            },
            addExperience(){
              this.experiences.push(this.experience);
              this.period = [];
                this.experience = {
                    start: '',
                    end: '',
                    description: '',
                }
            },
            addEducation(){
                this.educations.push(this.education);
                this.educationPeriod = [];
                this.education = {
                    start: '',
                    end: '',
                    institution_name: '',
                }
            },
            delDate(i){
                this.dates.splice(i,1);
            },
            delExperience(i){
                this.experiences.splice(i,1);
            },
            delEducation(i){
                this.educations.splice(i,1);
            },
            edit () {
                this.disabled = false;
                this.clearable = true;
            },
            save () {
                const fd = new FormData();
                fd.append("name", this.info.name);
                fd.append("email", this.info.email);
                fd.append("password",this.info.password);
                fd.append("password_confirmation",this.info.password_confirmation);
                fd.append("image",this.info.imageFile);
                this.dates.forEach((date, i) => {
                    fd.append(`childs[${i}]`, {});
                    fd.append(`childs[${i}][name]`, date.name);
                    fd.append(`childs[${i}][birthday]`, date.birthday);
                });
                fd.append("_method", 'PUT');
                axios.post(`/api/app/user/update/${this.$store.state.auth.user.id}`, fd)
                    .then(res =>  {
                        this.info = res.data;
                        this.dates = res.data.childrens;
                        this.disabled = true;
                        this.clearable = false;
                        this.updatePassword = false;
                        this.childBirthday = false;
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
                this.updatePassword = false;
                this.childBirthday = false;
                this.cv = false;
            },
            onFileSelected (event) {
                this.info.imageFile = event;
                const reader = new FileReader();
                reader.readAsDataURL(this.info.imageFile);
                reader.onload = e => this.info.image = e.target.result;
            },
        },

        watch: {
            period (val) {
                if (val.length > 1) {
                    if (val[0] > val[1]) {
                        const holder = val[0];
                        val[0] = val[1];
                        val[1] = holder;
                    }
                }

                this.experience.start = val[0];
                this.experience.end = val[1];
            },
            educationPeriod (val) {
                if (val.length > 1) {
                    if (val[0] > val[1]) {
                        const holder = val[0];
                        val[0] = val[1];
                        val[1] = holder;
                    }
                }

                this.education.start = val[0];
                this.education.end = val[1];
            }
        },

        created() {
            if(this.$store.state.auth.user){
                return axios.get(`/api/app/user/${this.$store.state.auth.user.id}`)
                    .then(res =>  {
                        this.info = res.data;
                        this.dates = res.data.childrens;
                    })
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
</style>
