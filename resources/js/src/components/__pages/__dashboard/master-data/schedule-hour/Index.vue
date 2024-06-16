<script>
import ScheduleLessonHourMixins from '@Components/__mixins/master-data/schedule-lesson-hour';

export default {
    name: 'ScheduleLessonHourIndex',
    mixins: [
        ScheduleLessonHourMixins
    ]
}
</script>

<template>
    <div class="schedule-lesson-hours">
        <card-component title="Jam Pelajaran" icon="progress-clock" :withButtonAction="true"
            :buttonAction="buttonAction">

            <v-container>
                <v-alert class="mb-3 text-center px-auto" dark color="primary" icon="mdi-alert-outline" dense
                    border="left" prominent>
                    Silahkan Memilih Data Hari Terlebih Dahulu Untuk Menampilkan Data
                </v-alert>
            </v-container>

            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                :headerData="headers" :result="results" :withCustomFilter="true">

                <template v-slot:custom-filter>
                    <v-autocomplete outlined dense class="pt-3" hide-details="auto" v-model="selectedDay"
                        item-value="id" label="Hari" item-text="name" prepend-inner-icon="mdi-calendar"
                        :items="scheduleDays">
                    </v-autocomplete>
                </template>

            </table-component>

            <update-or-create-component :closeAction="closeModal" :title="`${updateOrCreateTitle} Data`"
                v-model="showModal" :width="width">
                <template v-slot:form>
                    <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan">

                        <auto-complete-component v-model="payload.schedule_day_id" label="Hari" itemName="name"
                            icon="calendar" :originData="scheduleDays" rules="required">

                        </auto-complete-component>

                        <div v-if="dataId == null">
                            <div class="mb-3" v-for="duration, index in durations">
                                <v-row>
                                    <v-col cols="3">
                                        <input-component v-model="duration.started_at" type="number" label="Jam Dimulai"
                                            icon="clock" rules="required">
                                        </input-component>
                                    </v-col>

                                    <v-col cols="3">
                                        <input-component v-model="duration.ended_at" type="number" label="Jam Selesai"
                                            icon="clock" rules="required">
                                        </input-component>
                                    </v-col>

                                    <v-col cols="3">
                                        <v-menu ref="menu" v-model="duration.select_started_duration"
                                            :close-on-content-click="false" :nudge-right="40"
                                            :return-value.sync="duration.started_duration" transition="scale-transition"
                                            offset-y max-width="290px" min-width="290px">
                                            <template v-slot:activator="{ on, attrs }">
                                                <validation-provider rules="required" name="Durasi Awal"
                                                    v-slot="{ errors }">
                                                    <v-text-field :error-messages="errors" hide-details="auto"
                                                        v-model="duration.started_duration" class="mt-3"
                                                        label="Durasi Awal" outlined prepend-inner-icon="mdi-clock"
                                                        readonly v-bind="attrs" v-on="on">
                                                    </v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-time-picker v-if="duration.select_started_duration"
                                                v-model="duration.started_duration" format="24hr" min="06:00"
                                                max="18:30" full-width
                                                @click:minute="$refs.menu[index].save(duration.started_duration)">
                                            </v-time-picker>
                                        </v-menu>
                                    </v-col>

                                    <v-col cols="3">
                                        <v-menu ref="menu2" v-model="duration.select_ended_duration"
                                            :close-on-content-click="false" :nudge-right="40"
                                            :return-value.sync="duration.ended_duration" transition="scale-transition"
                                            offset-y max-width="290px" min-width="290px">
                                            <template v-slot:activator="{ on, attrs }">
                                                <validation-provider rules="required" name="Durasi Akhir"
                                                    v-slot="{ errors }">
                                                    <v-text-field :error-messages="errors" hide-details="auto"
                                                        v-model="duration.ended_duration" class="mt-3"
                                                        label="Durasi Akhir" outlined prepend-inner-icon="mdi-clock"
                                                        readonly v-bind="attrs" v-on="on">
                                                    </v-text-field>
                                                </validation-provider>
                                            </template>
                                            <v-time-picker v-if="duration.select_ended_duration"
                                                v-model="duration.ended_duration" format="24hr" min="06:00" max="18:30"
                                                full-width
                                                @click:minute="$refs.menu2[index].save(duration.ended_duration)">
                                            </v-time-picker>
                                        </v-menu>
                                    </v-col>

                                    <v-container>
                                        <v-btn block color="error" @click="removeDurationData(index)">
                                            <v-icon left> mdi-delete </v-icon>
                                            Hapus Data
                                        </v-btn>
                                    </v-container>
                                </v-row>
                            </div>

                            <v-row>
                                <v-col cols="12">
                                    <v-btn block color="primary" @click="addDurationData">
                                        <v-icon left> mdi-plus </v-icon>
                                        Tambah Data
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </div>

                        <div v-else-if="dataId">
                            <input-component v-model="payload.started_at" type="number" label="Jam Dimulai" icon="clock"
                                rules="required">
                            </input-component>

                            <input-component v-model="payload.ended_at" type="number" label="Jam Selesai" icon="clock"
                                rules="required">
                            </input-component>

                            <v-menu ref="updatedMenu" v-model="select_started_duration" :close-on-content-click="false"
                                :nudge-right="40" :return-value.sync="payload.started_duration"
                                transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                    <validation-provider rules="required" name="Durasi Awal" v-slot="{ errors }">
                                        <v-text-field :error-messages="errors" hide-details="auto"
                                            v-model="payload.started_duration" class="mt-3" label="Durasi Awal" outlined
                                            prepend-inner-icon="mdi-clock" readonly v-bind="attrs" v-on="on">
                                        </v-text-field>
                                    </validation-provider>
                                </template>
                                <v-time-picker v-if="select_started_duration" v-model="payload.started_duration"
                                    format="24hr" min="06:00" max="18:30" full-width
                                    @click:minute="$refs.updatedMenu.save(payload.started_duration)">
                                </v-time-picker>
                            </v-menu>
                            <v-menu ref="updatedMenu2" v-model="select_ended_duration" :close-on-content-click="false"
                                :nudge-right="40" :return-value.sync="payload.ended_duration"
                                transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                    <validation-provider rules="required" name="Durasi Akhir" v-slot="{ errors }">
                                        <v-text-field :error-messages="errors" hide-details="auto"
                                            v-model="payload.ended_duration" class="mt-3" label="Durasi Akhir" outlined
                                            prepend-inner-icon="mdi-clock" readonly v-bind="attrs" v-on="on">
                                        </v-text-field>
                                    </validation-provider>
                                </template>
                                <v-time-picker v-if="select_ended_duration" v-model="payload.ended_duration"
                                    format="24hr" min="06:00" max="18:30" full-width
                                    @click:minute="$refs.updatedMenu2.save(payload.ended_duration)">
                                </v-time-picker>
                            </v-menu>

                            <div class="my-3">
                                <switch-component v-model="payload.is_break_hour" label="Status Jam Pelajaran"
                                    icon="progress-clock" :textLabel="textLabel">
                                </switch-component>
                            </div>

                        </div>
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

        </card-component>
    </div>
</template>
