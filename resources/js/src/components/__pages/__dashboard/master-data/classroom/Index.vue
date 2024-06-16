<script>
import ClassroomMixins from '@Components/__mixins/master-data/classroom';

export default {
    name: 'ClassroomIndex',
    mixins: [
        ClassroomMixins,
    ],
}
</script>

<template>
    <div class="classroom">
        <card-component title="Kelas" icon="town-hall" :withButtonAction="true" :buttonAction="buttonAction">
            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                :headerData="headers" :result="results">
            </table-component>
        </card-component>

        <update-or-create-component :closeAction="closeModal" :title="`${updateOrCreateTitle} Data`" v-model="showModal"
            :width="width">
            <template v-slot:form>
                <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan">
                    <input-component v-model="payload.name" icon="town-hall" type="text" label="Kelas" rules="required">
                    </input-component>

                    <radio-button-component v-model="payload.majority" icon="book-education" type="text" label="Jurusan"
                        :options="majorities" rules="required">

                    </radio-button-component>

                    <input-component v-model="payload.quota" icon="account-group" type="number" label="Jumlah Siswa"
                        rules="required|integer|min_value:1">
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

        <alert-component ref="alert"></alert-component>
    </div>
</template>
