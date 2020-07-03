<template>
    <v-app>
        <router-view name="navbar"></router-view>

        <v-content style="background-color: white">
            <router-view name="header"></router-view>
            <router-view></router-view>
            <router-view name="footer"></router-view>
        </v-content>
    </v-app>
</template>

<script>
export default {
    name: "App",
}
</script>