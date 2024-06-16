<script>
import UserStatusMixins from '@Components/__mixins/master-data/user-status';

export default {
    name: 'UserStatusIndex',
    mixins: [
        UserStatusMixins
    ],
}
</script>

<template>
    <div class="user-status">
        <card-component title="Status Guru" icon="account-star" :withButtonAction="true" :buttonAction="buttonAction">
            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                :headerData="headers" :result="results">
            </table-component>
        </card-component>

        <update-or-create-component :closeAction="closeModal" :title="`${updateOrCreateTitle} Data`" v-model="showModal"
            :width="width">
            <template v-slot:form>
                <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan">
                    <input-component v-model="payload.name" icon="account-star" type="text" label="Nama Status Guru"
                        rules="required">
                    </input-component>

                    <input-component v-model="payload.minimum_teach_load_hour" icon="clock-outline" type="number"
                        label="Minimal Jam Beban Mengajar" rules="required|integer|min_value:1|max_value:10">
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
