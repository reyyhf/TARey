<script>
export default {
    name: 'AlertComponent',
    data: () => ({
        alert: false,
        color: null,
        icon: null,
        message: null,
    }),
    methods: {
        show(color, message) {
            this.color = color;
            this.icon = this.color === 'success' ? 'check-circle' : 'alert-circle';
            this.message = message;
            this.alert = true;
        }
    }
}
</script>

<template>
    <v-snackbar v-model="alert" :color="color" timeout="1500" transition="fade-transition" top right>
        <v-icon left>{{ `mdi-${icon}` }}</v-icon>

        <span class="font-weight-bold subtitle-1">{{ message }}</span>
    </v-snackbar>
</template>
