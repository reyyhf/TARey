<script>
export default {
    name: 'InputComponent',
    inheritAttrs: false,
    props: {
        label: String,
        rules: String,
        type: String,
        icon: String,
        disabled: {
            type: Boolean,
            default: false,
        }
    },
    methods: {
        handlingInput(event) {
            this.$emit('input', event)
        }
    }
}
</script>

<template>
    <validation-provider v-slot="{ errors }" :name="label" :rules="rules">
        <v-text-field hide-details="auto" :disabled="disabled" v-bind="$attrs" @input="handlingInput" class="py-3"
            :type="type" outlined :prepend-inner-icon="`mdi-${icon}`" :label="label" :error-messages="errors">
        </v-text-field>
    </validation-provider>
</template>
