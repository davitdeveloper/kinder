<template>
    <section style="margin: 0 16.57%;">
        <v-container>
            <v-row justify="space-between" align="center">
                <v-col cols="6" class="petlya">
                    <h1 class="title register">Գրանցվել</h1>
                    <v-img src="/images/shape2.png" width="45" class="titer"></v-img>
                </v-col>
                <v-col cols="5">
                    <div class="gic"></div>
                </v-col>
            </v-row>
            <v-form v-model="valid" method="post" action="/register" ref="form">
                <input :value="$csrf" name="_token" type="hidden"/>
                <v-row class="mt-12">
                    <v-col cols="6">
                        <v-text-field
                            name="name"
                            :rules="nameRules"
                            label="Անուն"
                            color="#347cbb"
                            rounded
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                            name="email"
                            :rules="emailRules"
                            type="email"
                            label="Էլ․ հասցե"
                            color="#347cbb"
                            rounded
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="6">
                        <v-text-field
                            name="password"
                            :rules="passwordRules"
                            type="password"
                            label="Գաղտնաբառ"
                            color="#347cbb"
                            rounded
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <v-text-field
                            name="password_confirmation"
                            :rules="passwordRules"
                            type="password"
                            label="Հաստատել գաղտնաբառը"
                            color="#347cbb"
                            rounded
                            outlined
                            dense
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row justify="center">
                    <v-btn color="#347cbb" dark rounded large width="250" type="submit" :disabled="!valid">Գրանցվել</v-btn>
                </v-row>
            </v-form>
        </v-container>
    </section>
</template>

<script>
export default {
    name: "Register",
    data: () => ({
        valid: false,
        nameRules: [
            v => !!v || 'Name is required',
        ],
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        passwordRules: [
            v => !!v || 'Password is required',
        ],
    }),
}
</script>

<style scoped>
.border {
    border: 1px solid black;
}

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

.register {
    color: #4dc0a6;
    font-size: 3vw !important;
    position: absolute;
    top: 45px;
    left: 75%;
}

.gic {
    height: 2px;
    margin-top: 60px;
    background: url(/images/shape3.png);
    background-size: contain;
}
</style>