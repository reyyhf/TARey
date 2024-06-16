<script>
export default {
    name: 'SwitchComponent',
    inheritAttrs: false,
    data: () => ({
        falseValue: false,
        trueValue: true
    }),
    props: {
        label: String,
        icon: String,
        rules: String,
        textLabel: String,
    },
    methods: {
        handlingInput(event) {
            this.$emit('input', event)
        }
    },
}
</script>

<template>
    <validation-provider v-slot="{ errors }" :name="label" :rules="rules">
        <div class="mx-2">
            <v-icon color="gray" left>{{ `mdi-${icon}` }}</v-icon>
            <span class="gray--text">{{ label }}</span>
        </div>
        <v-switch dense v-bind="$attrs" :false-value="falseValue" :true-value="trueValue" @input="handlingInput"
            @change="handlingInput" class="my-2 mx-2" inset :label="textLabel" :error-messages="errors">
        </v-switch>
    </validation-provider>
</template>
