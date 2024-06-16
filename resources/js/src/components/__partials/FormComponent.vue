<script>
export default {
    name: 'FormComponent',
    props: {
        methodHandler: Function,
        buttonSubmitText: String,
    },
}
</script>

<template>
    <validation-observer v-slot="{ handleSubmit }" ref="observer">
        <v-form @submit.prevent="handleSubmit(methodHandler)">
            <slot></slot>

            <v-btn large color="primary" outlined block type="submit" class="px-4 mt-4">
                {{ buttonSubmitText }}
            </v-btn>
        </v-form>
    </validation-observer>
</template>
