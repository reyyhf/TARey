<script>
export default {
    name: 'CardComponent',
    props: {
        title: String,
        icon: String,
        showModal: Boolean,
        width: String,
        withButtonAction: Boolean,
        buttonAction: Object,
        titleClass: String,
        withAction: {
            type: Boolean,
            default: false,
        },
        color: {
            type: String,
            default: 'black',
        }
    },
}
</script>

<template>
    <v-card :width="width">
        <v-card-title :class="`font-weight-bold ${titleClass}`">
            <v-icon left :color="color"> {{ `mdi-${icon}` }}</v-icon>
            {{ title }}

            <v-spacer></v-spacer>

            <slot name="action"></slot>

            <v-btn v-if="withButtonAction" color="primary" outlined @click.native="buttonAction.action">
                <v-icon left>
                    mdi-{{ buttonAction.icon }}
                </v-icon>
                {{ buttonAction.text }}
            </v-btn>
        </v-card-title>

        <v-divider></v-divider>
        <v-card-text class="py-4">
            <slot></slot>
        </v-card-text>

        <v-card-actions class="py-3" v-if="withAction">
            <slot name="card-action"></slot>
        </v-card-actions>
    </v-card>
</template>
