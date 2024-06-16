<script>
import teacherMixins from '@Components/__mixins/master-data/teacher';

export default {
    name: 'TeacherIndex',
    mixins: [
        teacherMixins,
    ],
}
</script>

<template>
    <div class="teacher">
        <card-component title="Guru" icon="briefcase-account" :withButtonAction="true" :buttonAction="buttonAction">
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

                    <input-component v-model="payload.nuptk" icon="card-bulleted" type="text" label="NUPTK"
                        rules="required|integer">
                    </input-component>

                    <input-component v-model="payload.birth_place" icon="map-marker" type="text" label="Tempat Lahir"
                        rules="required">
                    </input-component>

                    <radio-button-component v-model="payload.gender" icon="gender-male-female" type="text"
                        label="Jenis Kelamin" :options="genders" rules="required">
                    </radio-button-component>

                    <switch-component v-model="payload.is_active" label="Status Aktivasi Pengguna" icon="account-check"
                        :textLabel="textLabel">
                    </switch-component>

                    <radio-button-component v-model="payload.user_status_id" icon="account-star" type="text"
                        label="Status Guru" :options="userStatuses" rules="required">
                    </radio-button-component>

                    <auto-complete-component v-model="payload.teacher_lessons" label="Mata Pelajarn Yang Diampu"
                        itemName="name" icon="book-open-page-variant" :originData="lessons" :multiple="true"
                        :withChips="true" rules="required">

                    </auto-complete-component>

                    <auto-complete-component v-model="payload.teacher_classrooms" label="Kelas Yang Diampu"
                        itemName="name" icon="notebook-check" :originData="classrooms" :multiple="true"
                        :withChips="true" rules="required">

                    </auto-complete-component>

                    <input-component v-model="payload.maximum_teaching_load" icon="progress-clock" type="number"
                        label="Maksimal Jam Mengajar" rules="required|integer|min_value:1">
                    </input-component>
                </form-component>
            </template>
        </update-or-create-component>

        <update-or-create-component :closeAction="closeViewModal" title="Lihat Data" v-model="viewModal">
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

                <input-component :disabled="true" v-model="payload.maximum_teaching_load" icon="progress-clock"
                    type="number" label="Maksimal Jam Mengajar">
                </input-component>

                <input-component :disabled="true" v-model="payload.gender_name" icon="gender-male-female" type="text"
                    label="Jenis Kelamin">
                </input-component>

                <input-component :disabled="true" v-model="payload.user_activation_status" icon="account-check"
                    type="text" label="Status Aktivasi Pengguna">
                </input-component>

                <input-component :disabled="true" v-model="payload.role_name" icon="cast-education" type="text"
                    label="Hak Akses Pengguna">
                </input-component>

                <input-component :disabled="true" v-model="payload.user_status_name" icon="account-star" type="text"
                    label="Status Guru">
                </input-component>

                <div class="lessons" v-if="payload.teacher_lessons_name && payload.teacher_lessons_name.length">
                    <p class="mb-2 mx-2 font-weight-bold gray--text"> Mata Pelajaran Yang Diampu</p>
                    <v-chip dense class="mx-1" color="info" v-for="lesson_name in payload.teacher_lessons_name">
                        {{ lesson_name.name }}
                    </v-chip>
                </div>

                <div class="lessons" v-if="payload.teacher_classrooms_name && payload.teacher_classrooms_name.length">
                    <p class="mb-2 ma-2 font-weight-bold gray--text"> Kelas Yang Diampu</p>
                    <v-chip dense class="mx-1" color="success" v-for="classroom in payload.teacher_classrooms_name">
                        {{ classroom.name }}
                    </v-chip>
                </div>
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
