<script>
import ScheduleDayMixins from '@Components/__mixins/master-data/schedule-day';

export default {
    name: 'ScheduleDayIndex',
    mixins: [
        ScheduleDayMixins,
    ],
}
</script>

<template>
    <div class="schedule-day">
        <card-component :title="`Data Hari Pada Tahun Ajaran : ${started_year} / ${ended_year}`" icon="calendar">
            <table-component v-on:edit-data="view" v-on:destroy-data="showDestroyModal" :withLoading="isLoading"
                :headerData="headers" :result="results" :withDestroyData="false">
            </table-component>
        </card-component>

        <update-or-create-component :closeAction="closeModal" :title="`${updateOrCreateTitle} Data`" v-model="showModal"
            :width="width">
            <template v-slot:form>
                <form-component ref="form" :methodHandler="submit" buttonSubmitText="Simpan">
                    <input-component v-model="payload.total_hours" icon="progress-clock" type="number"
                        label="Maksimal Jam Belajar"
                        :rules="'required|integer|min_value:1|max_value:' + maximum_teach_load_hour">
                    </input-component>
                </form-component>
            </template>
        </update-or-create-component>

        <alert-component ref="alert"></alert-component>
    </div>
</template>
