<script>
import LessonMixins from '@Components/__mixins/master-data/lesson'

export default {
    name: 'LessonIndex',
    mixins: [
        LessonMixins,
    ],
}
</script>

<template>
    <div class="lesson">
        <card-component title="Mata Pelajaran" icon="book-check" :withButtonAction="true" :buttonAction="buttonAction">
            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                :headerData="headers" :result="results">
            </table-component>
        </card-component>

        <update-or-create-component :closeAction="closeModal" :title="`${updateOrCreateTitle} Data`" v-model="showModal"
            :width="width">
            <template v-slot:form>
                <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan">
                    <input-component v-model="payload.name" icon="book-check" type="text" label="Mata Pelajaran"
                        rules="required">
                    </input-component>

                    <input-component v-model="payload.acronym" icon="label-outline" type="text" label="Akronim"
                        rules="required">
                    </input-component>

                    <auto-complete-component v-model="payload.lesson_category_id" icon="cast-education"
                        label="Kategori Mata Pelajaran" itemName="name" rules="required" :originData="lessonCategories">
                    </auto-complete-component>
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
