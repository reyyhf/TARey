<script>
import userMixins from '@Components/__mixins/master-data/user';

export default {
    name: 'UserIndex',
    mixins: [
        userMixins,
    ],
}
</script>

<template>
    <div class="user">
        <card-component title="Pengguna" icon="account-group" :withButtonAction="true" :buttonAction="buttonAction">
            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                :headerData="headers" :result="results" :withViewData="true" v-on:view-data="viewData">
            </table-component>
        </card-component>

        <update-or-create-component :closeAction="closeModal" :title="`${updateOrCreateTitle} Data`" v-model="showModal"
            :width="width">
            <template v-slot:form>
                <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan">

                    <input-component v-model="payload.name" icon="account" type="text" label="Nama Pengguna"
                        rules="required">
                    </input-component>

                    <input-component v-model="payload.email" icon="email-outline" type="email" label="Alamat Email"
                        rules="required|email">
                    </input-component>

                    <input-password v-if="dataId == null" v-model="payload.password" rules="required"></input-password>

                    <input-component v-model="payload.nuptk" icon="card-bulleted-outline" type="text" label="NUPTK"
                        rules="required|integer">
                    </input-component>

                    <input-component v-model="payload.birth_place" icon="map-marker-outline" type="text"
                        label="Tempat Lahir" rules="required">
                    </input-component>

                    <radio-button-component v-model="payload.gender" icon="gender-male-female" type="text"
                        label="Jenis Kelamin" :options="genders" rules="required">
                    </radio-button-component>

                    <switch-component v-model="payload.is_active" label="Status Aktivasi Pengguna"
                        icon="account-check-outline" :textLabel="textLabel">
                    </switch-component>

                    <radio-button-component v-model="payload.role_name" icon="shield-account" type="text"
                        label="Hak Akses Pengguna" :options="userRoleAccesses" rules="required">
                    </radio-button-component>

                    <!-- <radio-button-component v-if="payload.role_name === 'Guru'" v-model="payload.user_status_id"
                        icon="account-star" type="text" label="Status Guru" :options="userStatuses" rules="required">
                    </radio-button-component> -->
                </form-component>
            </template>
        </update-or-create-component>

        <update-or-create-component :closeAction="closeViewModal" title="Lihat Data" v-model="viewModal" :width="width">
            <template v-slot:form>
                <input-component :disabled="true" v-model="payload.name" icon="account" type="text"
                    label="Nama Pengguna">
                </input-component>

                <input-component :disabled="true" v-model="payload.email" icon="email-outline" type="email"
                    label="Alamat Email">
                </input-component>

                <input-component :disabled="true" v-model="payload.nuptk" icon="card-bulleted-outline" type="text"
                    label="NUPTK" rules="required|integer">
                </input-component>

                <input-component :disabled="true" v-model="payload.birth_place" icon="map-marker-outline" type="text"
                    label="Tempat Lahir">
                </input-component>

                <input-component :disabled="true" v-model="payload.gender_name" icon="gender-male-female" type="text"
                    label="Jenis Kelamin">
                </input-component>

                <input-component :disabled="true" v-model="payload.user_activation_status" icon="account-check"
                    type="text" label="Status Aktivasi Pengguna">
                </input-component>

                <input-component :disabled="true" v-model="payload.role_name" icon="shield-account" type="text"
                    label="Hak Akses Pengguna">
                </input-component>

                <!-- <input-component v-if="payload.user_status_name" :disabled="true" v-model="payload.user_status_name"
                    icon="account-star" type="text" label="Status Guru">
                </input-component> -->
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
