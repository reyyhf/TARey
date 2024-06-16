<script>
import LessonCategoryMixins from '@Components/__mixins/master-data/lesson-category'

export default {
    name: 'LessonCategoryIndex',
    mixins: [
        LessonCategoryMixins,
    ],
}
</script>

<template>
    <div class="lesson-category">
        <card-component title="Kategori Pelajaran" icon="cast-education" :withButtonAction="true"
            :buttonAction="buttonAction">

            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                :headerData="headers" :result="results">
            </table-component>
        </card-component>

        <update-or-create-component :closeAction="closeModal" :title="`${updateOrCreateTitle} Data`" v-model="showModal"
            :width="width">
            <template v-slot:form>
                <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan">
                    <input-component v-model="payload.name" icon="cast-education" label="Kategori Pelajaran"
                        rules="required" type="text">
                    </input-component>
                </form-component>
            </template>
        </update-or-create-component>

        <dialog-component v-on:confirm-action="destroy" confirmText="Hapus" title="Hapus Data" v-model="dialog"
            v-on:close-dialog="dialog = false">
            <template v-slot:message>
                <v-container>
                    <p class="text-center font-weight-bold">
                        Apakah anda yakin akan menghapus data ini ?
                    </p>
                </v-container>
            </template>
        </dialog-component>

        <alert-component ref="alert">

        </alert-component>
    </div>
</template>
