<script>
export default {
    name: 'DialogComponent',
    data: () => ({
        width: '400',
    }),
    props: [
        'value',
        'message',
        'title',
        'confirmText',
    ]
}
</script>

<template>
    <v-dialog :value="value" :width="width" persistent>
        <card-component :withAction="true" :width="width" :title="title" titleClass="error--text" color="error"
            icon="alert-circle">
            <slot name="message"></slot>

            <template v-slot:card-action>
                <v-spacer></v-spacer>
                <v-btn outlined color="gray" v-on:click="$emit('close-dialog')">Batal</v-btn>
                <v-btn outlined color="error" v-on:click="$emit('confirm-action')">{{ confirmText }}</v-btn>
            </template>
        </card-component>
    </v-dialog>
</template>
