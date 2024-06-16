<script>
export default {
    name: 'UpdateOrCreateComponent',
    inheritAttrs: false,
    props: {
        value: {
            type: Array | String | Number | Boolean,
            default: null
        },
        closeAction: {
            type: Function,
            default: () => { }
        },
        title: {
            type: String,
            default: null
        },
        width: {
            type: String,
            default: '600'
        },
    },
}
</script>

<template>
    <v-dialog scrollable :value="value" @input="$emit('input')" persistent :max-width="width">
        <card-component :title="title" :min-width="width">
            <template v-slot:action>
                <v-btn color="primary" outlined @click.native="closeAction">
                    <v-icon left>
                        mdi-close
                    </v-icon>
                    Tutup
                </v-btn>
            </template>

            <slot name="form"></slot>
        </card-component>
    </v-dialog>
</template>
