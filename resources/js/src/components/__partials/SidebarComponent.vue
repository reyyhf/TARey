<script>
import sidebarMenu from "@Components/__mixins/sidebar/menu.js";
export default {
    name: "Sidebar",
    mixins: [sidebarMenu],
    data: () => ({
        selectedMenu: 1,
    }),
    computed: {
        menus() {
            return sidebarMenu;
        },
    },
};
</script>

<template>
    <div class="sidebar-layout">
        <v-list-item>
            <v-list-item-avatar>
                <v-img src="../../../assets/images/logo.jpeg"></v-img>
            </v-list-item-avatar>

            <v-list-item-content>
                <v-list-item-title>
                    <p class="font-weight-bold white--text my-auto text-h6">
                        Penjadwalan
                    </p>
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>

        <v-divider class="white"></v-divider>

        <v-list nav dense v-for="(item, index) in menus" :key="index">
            <v-subheader
                class="text-subtitle-2 white--text ml-2 font-weight-bold"
            >
                {{ item.header }}
            </v-subheader>
            <v-list-item-group v-model="selectedMenu" color="white">
                <v-list-item
                    class="white--text"
                    link
                    v-for="subitem in item.submenu"
                    :key="subitem.title"
                    :to="{ name: subitem.route }"
                >
                    <v-list-item-icon class="ml-4 px-0">
                        <v-icon color="white">{{ subitem.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="font-weight-bold">{{
                            subitem.title
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </div>
</template>

<style>
/* width */
::-webkit-scrollbar {
    width: 8px;
}

/* Track */
::-webkit-scrollbar-track {
    background: white;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #555;
    border-radius: 16px;
    cursor: pointer;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
