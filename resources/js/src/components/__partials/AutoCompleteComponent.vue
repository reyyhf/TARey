<script>
export default {
    name: 'AutoCompleteComponent',
    data: () => ({
        emptyText: 'Data Tidak Ditemukan',
        menuProps: {
            closeOnClick: true,
            // offsetY: true,
            // offsetOverflow: true,
            transition: 'fade-transition',
        },
    }),
    props: {
        originData: Array,
        label: String,
        rules: String,
        type: String,
        icon: String,
        itemName: String,
        multiple: {
            type: Boolean,
            default: false
        },
        withChips: {
            type: Boolean,
            default: false
        },
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
        <v-autocomplete hide-details="auto" :menu-props="menuProps" :chips="withChips" :small-chips="withChips"
            :multiple="multiple" :item-text="itemName" item-value="id" class="py-3" v-bind="$attrs"
            @input="handlingInput" outlined :prepend-inner-icon="`mdi-${icon}`" :label="label" :items="originData"
            :error-messages="errors" :no-data-text="emptyText">
        </v-autocomplete>
    </validation-provider>
</template>
