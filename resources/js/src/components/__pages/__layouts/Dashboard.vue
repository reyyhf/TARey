<script>
import { mapActions } from "vuex";

export default {
    name: "Dashboard",
    data: () => ({
        drawer: null,
        dialog: false,
    }),
    methods: {
        ...mapActions({
            logout: "authentication/logout",
        }),
        async logoutHandler() {
            await this.logout()
                .then((response) => {
                    let result = response.data.meta;

                    this.$refs.alert.show(result.status, result.message);
                    setTimeout(() => {
                        this.$router.push({ name: "login-page" });
                    }, 800);
                })
                .catch((error) => {
                    let result = error.response.data.meta;
                    this.$refs.alert.show(result.status, result.message);
                })
                .finally(() => {
                    this.dialog = false;
                });
        },
    },
};
</script>

<template>
    <div class="dashboard-layout">
        <v-navigation-drawer
            class="height-app text-subtitle-1"
            color="black"
            v-model="drawer"
            temporary
            app
        >
            <sidebar></sidebar>
        </v-navigation-drawer>

        <v-app-bar app color="black">
            <v-app-bar-nav-icon
                color="white"
                @click="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-spacer></v-spacer>
            <v-btn outlined color="white" @click="dialog = true">
                Logout
                <v-icon right>mdi-logout</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main>
            <v-container class="mt-4">
                <router-view></router-view>
            </v-container>
        </v-main>

        <dialog-component
            v-on:confirm-action="logoutHandler"
            confirmText="Keluar"
            title="Keluar Dari Aplikasi"
            v-model="dialog"
            v-on:close-dialog="dialog = false"
        >
            <template v-slot:message>
                <v-container>
                    <p class="text-center font-weight-bold">
                        Apakah anda yakin akan keluar dari aplikasi ?
                    </p>
                </v-container>
            </template>
        </dialog-component>

        <alert-component ref="alert"></alert-component>
    </div>
</template>
