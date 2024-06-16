<script>
export default {
    name: 'RadioButtonComponent',
    inheritAttrs: false,
    props: {
        label: String,
        rules: String,
        type: String,
        icon: String,
        options: Array,
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
        <v-radio-group column v-bind="$attrs" @change="handlingInput" :error-messages="errors">
            <template v-slot:label>
                <v-icon left> {{ `mdi-${icon}` }}</v-icon>
                {{ label }}
            </template>
            <v-radio v-for="option in options" :key="option.value" :label="option.label" :value="option.value">
                <template v-slot:label>
                    <div>{{ option.label }}</div>
                </template>
            </v-radio>
        </v-radio-group>
    </validation-provider>
</template>
