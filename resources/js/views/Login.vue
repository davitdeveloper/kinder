<template>
    <section style="margin: 0 16.57%;">
        <v-container>
            <v-row justify="space-between" align="center">
                <v-col cols="6" class="petlya">
                    <h1 class="title login">Մուտք</h1>
                    <v-img src="/images/shape2.png" width="45" class="titer"></v-img>
                </v-col>
                <v-col cols="6" class="pl-10">
                    <div class="gic"></div>
                </v-col>
            </v-row>

            <v-form v-model="valid" method="post" action="/login" ref="form">
                <input :value="$csrf" name="_token" type="hidden" />
                <v-row class="mt-12" justify="center">
                    <v-col cols="6">
                        <v-text-field
                            name="email"
                            :rules="emailRules"
                            label="Էլ․ հասցե"
                            color="#347cbb"
                            rounded
                            outlined
                            dense
                            type="email"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row justify="center">
                    <v-col cols="6">
                        <v-text-field
                            name="password"
                            :rules="passwordRules"
                            label="Գաղտնաբառ"
                            color="#347cbb"
                            rounded
                            outlined
                            dense
                            type="password"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row justify="center">
                    <v-btn color="#347cbb" dark rounded large width="250" type="submit" :disabled="!valid">Մուտք</v-btn>
                </v-row>
            </v-form>
        </v-container>
    </section>
</template>

<script>
export default {
    name: "Login",
    data: () => ({
        valid: false,
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

.login {
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
