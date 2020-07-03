<template>
    <v-stepper v-model="e1" :loading="loading">
        <v-stepper-header>
            <template v-for="n in steps">
                <v-stepper-step
                    :key="`${n}-step`"
                    :complete="e1 > n"
                    :step="n"
                >
                    <h3 v-if="n === 1">Ընդհանուր</h3>
                    <h3 v-if="n === 2">Փորց</h3>
                    <h3 v-if="n === 3">Կրթություն</h3>
                    <h3 v-if="n === 4">Այլ ինֆորմացիա</h3>
                    <h3 v-if="n === 5">Գրաֆիկ</h3>
                </v-stepper-step>

                <v-divider
                    v-if="n !== steps"
                    :key="n"
                ></v-divider>
            </template>
        </v-stepper-header>

        <v-stepper-items>
            <v-stepper-content
                v-for="n in steps"
                :key="`${n}-content`"
                :step="n"
            >

                <v-card
                    v-if="n === 1"
                    class="mb-12"
                >
                    <v-row no-gutters justify="space-around" class="pt-4">
                        <v-col cols="5">
                            <v-text-field
                                v-model="resume.full_name"
                                :rules="nameRules"
                                rounded
                                outlined
                                dense
                                label="Անուն Ազգանուն"
                                color="#347cbb"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col  cols="5">
                            <v-menu
                                nudge-bottom="40"
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
                                    <v-date-picker width="495" v-model="resume.birthday"></v-date-picker>
                                </v-card>
                            </v-menu>
                        </v-col>
                    </v-row>
                    <v-row no-gutters justify="space-around">
                        <v-col cols="5">
                            <v-text-field
                                v-model="resume.address"
                                :rules="nameRules"
                                rounded
                                outlined
                                dense
                                label="Հասցե"
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
                                label="հեռախոսահամար"
                                color="#347cbb"
                                clearable
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row no-gutters justify="space-around">
                        <v-col cols="5">
                            <v-card tile flat>
                                <v-textarea
                                    v-model="resume.family_status"
                                    solo
                                    dense
                                    name="family_status"
                                    label="Ընտանիքի մասին կարճ տեղեկություններ"
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
                                    label="Ձեր մասին"
                                ></v-textarea>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-row no-gutters justify="space-around">
                        <v-col cols="5">
                            <v-row no-gutters >
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="resume.face_book"
                                        rounded
                                        outlined
                                        dense
                                        label="Ֆեյսբուք"
                                        color="#347cbb"
                                        clearable
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="resume.instagram"
                                        rounded
                                        outlined
                                        dense
                                        label="Ինստագրամ"
                                        color="#347cbb"
                                        clearable
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="resume.you_tube"
                                        rounded
                                        outlined
                                        dense
                                        label="Յութուբ"
                                        color="#347cbb"
                                        clearable
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col  cols="5">
                            <v-file-input
                                class="mt-4"
                                label="Ֆայլ"
                                color="#347cbb"
                                multiple
                                dense
                                outlined
                                @change="onFilesSelected"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                    <v-row no-gutters justify="center">
                        <v-col cols="11">
                            <v-card tile outlined>
                                <v-row no-gutters justify="space-around">
                                    <v-col
                                        v-for="(image, i) in resume.images"
                                        :key="i"
                                        cols="3"
                                    >
                                        <v-card tile flat>
                                            <v-img :class="{ avatar: avatarIndex === i }" :src="image" contain height="300" style="position:relative">
                                                <div style="display:flex;justify-content:flex-end">

                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on }">
                                                            <v-btn  icon v-on="on"  @click="delImg(i)">
                                                                <v-icon style="color:red">mdi-window-close</v-icon>
                                                            </v-btn>
                                                        </template>

                                                        <span class="pa-3">Delete Image</span>
                                                    </v-tooltip>
                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on }">
                                                            <v-btn style="position:absolute;left:0" icon v-on="on"  @click="checkAvatar(i)">
                                                                <v-icon style="color:green">mdi-check</v-icon>
                                                            </v-btn>
                                                        </template>

                                                        <span class="pa-3">Check Avatar</span>
                                                    </v-tooltip>
                                                </div>
                                            </v-img>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card>

                <v-card
                    v-if="n === 2"
                    class="mb-12"
                >
                    <v-row no-gutters justify="space-around" align="center">
                        <v-col cols="5">
                            <v-card tile flat>
                                <v-menu
                                    v-model="experiencePeriodMenu"
                                    :close-on-content-click="false"
                                    nudge-bottom="40"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-card class="experiencePeriod" tile flat>
                                            <v-text-field
                                                v-model="experiencePeriod"
                                                placeholder="Period"
                                                color="#347cbb"
                                                prepend-inner-icon="mdi-calendar-search"
                                                outlined
                                                v-on="on"
                                            ></v-text-field>
                                        </v-card>
                                    </template>

                                    <v-card tile flat>
                                        <v-date-picker
                                            v-model="experiencePeriod"
                                            width="395"
                                            color="#347cbb"
                                            range
                                            no-title
                                            scrollable
                                        ></v-date-picker>
                                    </v-card>
                                </v-menu>
                            </v-card>
                        </v-col>
                        <v-col cols="5">
                            <v-card tile flat>
                                <v-textarea
                                    v-model="experience.description"
                                    solo
                                    dense
                                    name="description"
                                    label="description"
                                    rows="2"
                                ></v-textarea>
                            </v-card>
                        </v-col>
                        <v-col cols="1">
                            <v-icon v-if="experience.start && experience.end && experience.description"
                                    color="#347cbb" dark x-large
                                    @click="addExperience()"
                            >
                                mdi-plus-circle
                            </v-icon>
                        </v-col>
                    </v-row>
                    <v-row v-for="(experience,i) in resume.experiences" :key="i" no-gutters justify="space-around" align="center">
                        <v-col cols="1" >
                                <h1 class="mb-6">{{ i+1 }}.</h1>
                        </v-col>
                        <v-col cols="2">
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
                        </v-col>
                        <v-col cols="2">
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
                        </v-col>
                        <v-col cols="4">
                            <v-card tile flat>
                                <v-textarea
                                    v-model="experience.description"
                                    solo
                                    dense
                                    name="description"
                                    label="description"
                                    rows="2"
                                ></v-textarea>
                            </v-card>
                        </v-col>
                        <v-col cols="1">
                            <v-icon class="mb-4" color="red" dark x-large @click="delExperience(i)">
                                mdi-delete-outline
                            </v-icon>
                        </v-col>
                    </v-row>
                </v-card>

                <v-card
                    v-if="n === 3"
                    class="mb-12 pt-4"
                >
                    <v-row no-gutters justify="space-between" align="center">
                        <v-col cols="5">
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
                                        ></v-text-field>
                                    </v-card>
                                </template>

                                <v-card tile flat>
                                    <v-date-picker
                                        v-model="educationPeriod"
                                        width="395"
                                        color="#347cbb"
                                        range
                                        no-title
                                        scrollable
                                    ></v-date-picker>
                                </v-card>
                            </v-menu>
                        </v-col>
                        <v-col cols="5">
                            <v-text-field
                                v-model="education.institution_name"
                                label="institution name"
                                color="#347cbb"
                                outlined
                                dense
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="1">
                            <v-icon v-if="education.start && education.end && education.institution_name"
                                    class="mb-7"
                                    color="#347cbb" dark x-large
                                    @click="addEducation()"
                            >
                                mdi-plus-circle
                            </v-icon>
                        </v-col>
                    </v-row>
                    <v-row v-for="(education,i) in resume.educations" :key="i" no-gutters justify="space-between" align="center">
                        <h2 class="mb-6">{{ i+1 }}.</h2>
                        <v-col cols="3">
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
                        </v-col>
                        <v-col cols="3">
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
                        </v-col>
                        <v-col cols="3">
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
                        <v-col cols="1">
                            <v-icon class="mb-6" color="red" dark x-large @click="delEducation(i)">
                                mdi-delete-outline
                            </v-icon>
                        </v-col>
                    </v-row>
                </v-card>

                <v-card
                    v-if="n === 4"
                    class="mb-12"
                >
                    <v-row  justify="space-around">
                        <v-col cols="5">
                            <h2>Ինչպիսի աշխատանք եք փնտրում</h2>
                            <v-container fluid>
                                <v-checkbox hide-details v-for="(type,i) in globalWorkTypes" :key="i" v-model="resume.workTypes" :label="type.description" :value="type.id"></v-checkbox>
                            </v-container>
                        </v-col>
                        <v-col cols="5">
                            <h2>Երեխայի տարիք</h2>
                            <v-container fluid>
                                <v-checkbox hide-details v-for="(age,i) in globalChildrenAges" :key="i" v-model="resume.childrenAges" :label="age.description" :value="age.id"></v-checkbox>
                            </v-container>
                        </v-col>
                    </v-row>
                    <v-row justify="space-around">
                        <v-col cols="5">
                            <h2>Երեխաների քանակ</h2>
                            <v-container fluid>
                                <v-checkbox hide-details v-for="(amount,i) in globalChildrenAmounts" :key="i" v-model="resume.childrenAmounts" :label="amount.description" :value="amount.id"></v-checkbox>
                            </v-container>
                        </v-col>
                        <v-col cols="5">
                            <h2>Լեզուներ</h2>
                            <v-container fluid>
                                <v-checkbox hide-details v-for="(language,i) in globalOwnLanguages" :key="i" v-model="resume.ownLanguages" :label="language.description" :value="language.id"></v-checkbox>
                            </v-container>
                        </v-col>
                    </v-row>
                    <v-row justify="space-around">
                        <v-col cols="5">
                            <h2>Տարածաշրջան</h2>
                            <v-container fluid>
                                <v-checkbox :checked="region.id" hide-details v-for="(region,i) in globalRegions" :key="i" v-model="resume.regions" :label="region.name" :value="region.id"></v-checkbox>
                            </v-container>
                        </v-col>
                        <v-col cols="5">
                            <h2>Ունակություններ</h2>
                            <v-container fluid>
                                <v-checkbox hide-details v-for="(skill,i) in globalSkills" :key="i" v-model="resume.skills" :label="skill.description" :value="skill.id"></v-checkbox>
                            </v-container>
                        </v-col>
                    </v-row>
                    <v-row justify="space-around">
                        <v-col cols="5">
                            <h2>Վատ սովորություններ</h2>
                            <v-container fluid>
                                <v-checkbox  hide-details v-for="(badHabit,i) in globalBadHabits" :key="i" v-model="resume.bad_habits" :checked="badHabit.id" :label="badHabit.description" :value="badHabit.id"></v-checkbox>
                            </v-container>
                        </v-col>
                        <v-col cols="5">
                            <h2>Կարծիքներ ձեր մասին նախորդ աշխատատեղերից</h2>
                            <v-file-input
                                class="mt-4"
                                label="Ֆայլ"
                                color="#347cbb"
                                multiple
                                dense
                                outlined
                                @change="onFilesSelected"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                </v-card>

                <v-card
                    v-if="n === 5"
                    class="mb-12"
                >
                    <v-card text tile>

                        <v-card-text>
                            <v-data-table :hide-default-footer="true"  :headers="headers" :items="grafiks">
                                <template v-slot:item.start="{item}">
                                    <v-menu
                                        nudge-bottom="40"
                                        :close-on-content-click="false"
                                    >
                                        <template v-slot:activator="{ on }">
                                                <v-text-field
                                                    v-model="item.start"
                                                    placeholder="Start"
                                                    color="#347cbb"
                                                    prepend-inner-icon="mdi-calendar-search"
                                                    dense
                                                    outlined
                                                    v-on="on"
                                                ></v-text-field>
                                        </template>
                                        <v-card tile flat>
                                            <v-time-picker style="width:100%" v-model="item.start" format="24hr" :max="item.end"></v-time-picker>
                                        </v-card>
                                    </v-menu>
                                </template>
                                <template v-slot:item.end="{item}">
                                    <v-menu
                                        nudge-bottom="40"
                                        :close-on-content-click="false"
                                    >
                                        <template v-slot:activator="{ on }">
                                                <v-text-field
                                                    v-model="item.end"
                                                    placeholder="End"
                                                    color="#347cbb"
                                                    prepend-inner-icon="mdi-calendar-search"
                                                    dense
                                                    outlined
                                                    v-on="on"
                                                ></v-text-field>
                                        </template>
                                        <v-card tile flat>
                                            <v-time-picker style="width:100%" v-model="item.end" format="24hr" :min="item.start"></v-time-picker>
                                        </v-card>
                                    </v-menu>
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-card>

                <v-row>
                    <v-col cols="6" style="display: flex;justify-content: flex-start">
                        <v-btn :disabled="n === 1" text @click="backStep(n)">Back</v-btn>
                        <v-btn
                            v-if="n!==5"
                            color="primary"
                            @click="nextStep(n)"
                        >
                            Continue
                        </v-btn>
                    </v-col>

                    <v-col cols="6" style="display: flex;justify-content: flex-end">
                        <v-btn
                            v-if="n === 5"
                            color="primary"
                            @click="save"
                        >
                            Save
                        </v-btn>
                    </v-col>
                </v-row>

            </v-stepper-content>
        </v-stepper-items>
        <v-dialog v-model="dialog" max-width="30%" persistent>
            <v-card>
                <v-card-title>
                    <h3 class="text-center">Your Cv created Successful</h3>
                </v-card-title>
                <v-divider></v-divider>
                <div style="display:flex;justify-content:flex-end">
                    <v-btn class="mr-4 mb-4 mt-4" color="primary">See Cv</v-btn>
                    <v-btn class="mr-4 mb-4 mt-4" @click="cancelCv">Cancel</v-btn>
                </div>
            </v-card>
        </v-dialog>
    </v-stepper>

</template>

<script>
    import axios from "axios";

    export default {
        name: "Cv",
        data:() => ({
            grafiks:[
                {text: 'Երկ', day: 'mon' , start: '', end : ''},
                {text: 'Երք', day: 'tue' , start: '', end : ''},
                {text: 'Չրք', day: 'wed' , start: '', end : ''},
                {text: 'Հնգ', day: 'thu' , start: '', end : ''},
                {text: 'Ուրբ', day: 'fri' , start: '', end : ''},
                {text: 'Շբթ', day: 'sat' , start: '', end : ''},
                {text: 'Կրկ', day: 'sun' , start: '', end : ''},
            ],
            e1: 3,
            steps: 5,
            step: 1,
            loading: true,
            avatarIndex: '',
            dialog: false,
            cvId: '',
            headers: [
                { text: "Շաբաթվա օր", value: "text" },
                { text: "Սկիզբ", value: "start"},
                { text: "Վերջ", value: "end"},
            ],
            experiencePeriodMenu: false,
            experiencePeriod: [],
            educationPeriodMenu: false,
            educationPeriod: [],
            resume: {
                full_name: '',
                birthday : '',
                address : '',
                phone : '',
                family_status : '',
                personal_qualities : '',
                face_book : '',
                instagram : '',
                you_tube : '',
                imageFiles: [],
                images: [],
                experiences: [],
                educations: [],
                workTypes : [],
                childrenAges : [],
                childrenAmounts : [],
                ownLanguages : [],
                bad_habits : [],
                regions : [],
                skills : [],
            },
            experience: {
                start: '',
                end: '',
                description: '',
            },
            education: {
                start: '',
                end: '',
                institution_name: '',
            },
            globalWorkTypes : [],
            globalChildrenAges : [],
            globalChildrenAmounts : [],
            globalOwnLanguages : [],
            globalBadHabits : [],
            globalRegions : [],
            globalSkills : [],




            errMessage: '',
            nameRules: [
                v => !!v || "This field is required",
            ],
        }),
        watch: {
            steps (val) {
                if (this.e1 > val) {
                    this.e1 = val
                }
            },
            experiencePeriod (val) {
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
        methods: {
            cancelCv(){
                this.dialog = false;
                window.location.href = '/prof';
            },
            delImg(index){
                this.resume.images.splice(index, 1);
            },
            checkAvatar(index){
                this.avatarIndex = index;
            },
            onFilesSelected (event) {
                this.resume.imageFiles = event;
                this.resume.imageFiles.forEach(imageFile => {
                    const reader = new FileReader();
                    reader.readAsDataURL(imageFile);
                    reader.onload = e => this.resume.images.push(e.target.result);
                });
            },
            nextStep (n) {
                this.e1 = n + 1;
            },
            backStep (n) {
                this.e1 = n - 1;
            },
            next(){
                this.active_tab += 1;
            },
            back(){
                this.active_tab -= 1;
            },
            addExperience(){
                this.resume.experiences.push(this.experience);
                this.experiencePeriod = [];
                this.experience = {
                    start: '',
                    end: '',
                    description: '',
                }
            },
            addEducation(){
                this.resume.educations.push(this.education);
                this.educationPeriod = [];
                this.education = {
                    start: '',
                    end: '',
                    institution_name: '',
                }
            },
            delExperience(i){
                this.resume.experiences.splice(i,1);
            },
            delEducation(i){
                this.resume.educations.splice(i,1);
            },
            save () {
                const fd = new FormData();

                fd.append("resume", []);
                fd.append("resume[full_name]", this.resume.full_name);
                fd.append("resume[birthday]", this.resume.birthday);
                fd.append("resume[address]", this.resume.address);
                fd.append("resume[phone]", this.resume.phone);
                fd.append("resume[family_status]", this.resume.family_status);
                fd.append("resume[personal_qualities]", this.resume.personal_qualities);
                fd.append("resume[face_book]", this.resume.face_book);
                fd.append("resume[instagram]", this.resume.instagram);
                fd.append("resume[you_tube]", this.resume.you_tube);
                fd.append("resume[avatar_index]", this.avatarIndex);

                fd.append("images", []);
                this.resume.imageFiles.forEach((image, i) => {
                    fd.append(`images[${i}]`, image);
                });

                fd.append("resume[experiences]", []);
                this.resume.experiences.forEach((experience, i) => {
                    fd.append(`resume[experiences][${i}][start]`, experience.start);
                    fd.append(`resume[experiences][${i}][end]`, experience.end);
                    fd.append(`resume[experiences][${i}][description]`, experience.description);
                });

                fd.append("resume[educations]", []);
                this.resume.educations.forEach((education, i) => {
                    fd.append(`resume[educations][${i}][start]`, education.start);
                    fd.append(`resume[educations][${i}][end]`, education.end);
                    fd.append(`resume[educations][${i}][institution_name]`, education.institution_name);
                });

                fd.append("resume[workTypes]", []);
                this.resume.workTypes.forEach((type, i) => {
                    fd.append(`resume[workTypes][${i}]`, type);
                });

                fd.append("resume[childrenAges]", []);
                this.resume.childrenAges.forEach((age, i) => {
                    fd.append(`resume[childrenAges][${i}]`, age);
                });

                fd.append("resume[childrenAmounts]", []);
                this.resume.childrenAmounts.forEach((amount, i) => {
                    fd.append(`resume[childrenAmounts][${i}]`, amount);
                });

                fd.append("resume[ownLanguages]", []);
                this.resume.ownLanguages.forEach((lang, i) => {
                    fd.append(`resume[ownLanguages][${i}]`, lang);
                });

                fd.append("resume[badHabits]", []);
                this.resume.badHabits.forEach((badHab, i) => {
                    fd.append(`resume[badHabits][${i}]`, badHab);
                });

                fd.append("resume[regions]", []);
                this.resume.regions.forEach((region, i) => {
                    fd.append(`resume[regions][${i}]`, region);
                });

                fd.append("resume[skills]", []);
                this.resume.skills.forEach((skill, i) => {
                    fd.append(`resume[skills][${i}]`, skill);
                });

                this.grafiks.forEach((graf, i) => {
                    fd.append(`grafiks[${i}]`, []);
                    fd.append(`grafiks[${i}][text]`, graf.text);
                    fd.append(`grafiks[${i}][day]`, graf.day);
                    fd.append(`grafiks[${i}][start]`, graf.start);
                    fd.append(`grafiks[${i}][end]`, graf.end);
                });

                axios.post(`/api/app/baby-sitter/create/cv/${this.$store.state.auth.user.id}`,fd)
                    .then(res =>  {
                        this.dialog = true;
                        this.cvId = res.data;
                    })
                    .catch(err => {
                        this.errMessage = err.response.data;
                        setTimeout(() => {
                            this.errMessage = "";
                        }, 2000)
                    });
            },
        },
        created() {
            if(this.$store.state.auth.user){
                axios.get(`/api/app/baby-sitter/info-for-cv/${this.$store.state.auth.user.id}`)
                    .then(res =>  {
                        if(res.data.cv){
                            this.resume = res.data.cv;
                            console.log(res.data.cv);
                        }
                        this.globalWorkTypes = res.data.work_types;
                        this.globalChildrenAges = res.data.children_ages;
                        this.globalChildrenAmounts = res.data.children_amounts;
                        this.globalOwnLanguages = res.data.own_languages;
                        this.globalBadHabits = res.data.bad_habits;
                        this.globalRegions = res.data.regions;
                        this.globalSkills = res.data.skills;

                        this.loading = false;
                    })
                    .catch(err => {
                        this.errMessage = err.response.data;
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
    .avatar {
        border: 1px solid black;
        opacity: 0.5;
    }
</style>
