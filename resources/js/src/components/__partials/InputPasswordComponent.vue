<script>
export default {
    name: 'InputPasswordComponent',
    inheritAttrs: false,
    props: {
        rules: String,
    },
    data: () => ({
        showPassword: false,
    }),
    methods: {
        handlingInput(event) {
            this.$emit('input', event)
        }
    }
}
</script>

<template>
    <validation-provider v-slot="{ errors }" name="Kata Sandi" :rules="rules">
        <v-text-field class="py-3" hide-details="auto" v-bind="$attrs" @input="handlingInput" outlined
            prepend-inner-icon="mdi-lock-outline" label="Kata Sandi"
            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'"
            @click:append="showPassword = !showPassword" :error-messages="errors" autocomplete>
        </v-text-field>
    </validation-provider>
</template>
