<script>
import SemesterMixins from '@Components/__mixins/master-data/semester';

export default {
    name: 'YearOfEducationIndex',
    mixins: [
        SemesterMixins,
    ]
}
</script>

<template>
    <div class="year-of-education">
        <card-component title="Tahun Ajaran" icon="chair-school" :withButtonAction="true" :buttonAction="buttonAction">
            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                :headerData="headers" :result="results">
            </table-component>
        </card-component>

        <update-or-create-component :closeAction="closeModal" :title="`${updateOrCreateTitle} Data`" v-model="showModal"
            :width="width">
            <template v-slot:form>
                <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan">
                    <input-component v-model="payload.started_year" type="number" icon="calendar"
                        label="Mulai Tahun Ajaran" :rules="'required|integer|min_value:' + startedYear">
                    </input-component>

                    <input-component v-model="payload.ended_year" type="number" icon="calendar"
                        label="Selesai Tahun Ajaran" :rules="'required|integer|min_value:' + payload.started_year">
                    </input-component>

                    <switch-component v-model="payload.is_active" label="Status Tahun Ajaran" icon="list-status"
                        :textLabel="textLabel">
                    </switch-component>

                    <v-alert class="mb-6 text-center" dark color="info" icon="mdi-alert-outline" dense border="left"
                        prominent>
                        Jika ingin Menambahkan Tahun Ajaran Baru,
                        Pastikan Status yang dimasukkan
                        berupa status "Tidak Aktif"
                    </v-alert>

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
