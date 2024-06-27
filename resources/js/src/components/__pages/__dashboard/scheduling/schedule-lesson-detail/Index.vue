<script>
import scheduleLessonItemMixin from '@Components/__mixins/scheduling/schedule-lesson-item'

export default {
  name: 'ScheduleLessonItemIndex',
  mixins: [scheduleLessonItemMixin],
  methods: {
    getItemText(item) {
      return `${item.started_at} (${item.started_duration}-${item.ended_duration})`
    },
    async submit() {
      let payload = this.payload

      if (this.dataId) {
        let updatePayload = Object.assign(payload, {
          id: this.dataId,
          schedule_lesson_id: this.$route.params.id,
        })
        await this.updateDataHandler(updatePayload)
      } else {
        let updatePayload = Object.assign(payload, {
          schedule_lesson_hour_ids: this.hourFields.map(
            (field) => field.selectedHourId
          ),
          schedule_lesson_id: this.$route.params.id,
        })
        await this.storeDataHandler(updatePayload)
      }
    },
    closeDialogConfirmation() {
      this.dialog = false
      this.dataId = null
    },
  },
}
</script>

<template>
  <main class="schedule-lesson-detail">
    <card-component
      :title="`Jadwal Mata Pelajaran ${scheduleLesson?.classroom.name || ''}`"
      icon="calendar-clock-outline"
      :withButtonAction="true"
      :buttonAction="buttonAction"
    >
      <table-component
        v-on:edit-data="view"
        v-on:destroy-data="showDestroyModal"
        :withLoading="isLoading"
        :headerData="headers"
        :result="results"
      >
      </table-component>
    </card-component>

    <update-or-create-component
      :closeAction="closeModal"
      :title="`${updateOrCreateTitle} Data`"
      v-model="showModal"
      :width="width"
    >
      <template v-slot:form>
        <form-component
          ref="form"
          :methodHandler="submit"
          buttonSubmitText="Simpan"
        >
          <auto-complete-component
            v-model="payload.lesson_id"
            label="Mata Pelajaran"
            itemName="lesson_name"
            itemValue="lesson_id"
            icon="calendar"
            :originData="curriculums"
            rules="required"
          />
          <auto-complete-component
            v-if="!!payload.lesson_id"
            v-model="payload.teacher_id"
            label="Pengajar"
            itemName="name"
            itemValue="profile_id"
            icon="calendar"
            :originData="teachers"
            rules="required"
          />
          <template v-for="(field, index) in hourFields" v-if="dataId === null">
            <v-divider class="my-4" v-if="index === 0" />
            <auto-complete-component
              v-if="field.showDay"
              v-model="field.selectedDayId"
              label="Hari"
              itemName="name"
              icon="calendar"
              :originData="
                days.map((day, i) => ({
                  disabled: hourFields.some(
                    (f, i) => f.selectedDayId === day.id && i !== index
                  ),
                  ...day,
                }))
              "
              rules="required"
            />
            <auto-complete-component
              v-model="field.selectedHourId"
              label="Jam Pelajaran Ke-"
              :itemName="getItemText"
              outlined
              icon="calendar"
              :originData="
                (
                  days.find(
                    (day) =>
                      day.id ===
                      (field.showDay
                        ? field.selectedDayId
                        : hourFields[index - 1]?.selectedDayId)
                  )?.schedule_lesson_hours || []
                ).map((hour) => ({
                  ...hour,
                  disabled: field.showDay
                    ? hour.id === hourFields[index + 1]?.selectedHourId
                    : hour.id === hourFields[index - 1]?.selectedHourId,
                }))
              "
              rules="required"
            />
            <v-divider class="my-4" v-if="!field.showDay" />
          </template>
          <template v-if="dataId !== null">
            <auto-complete-component
              v-model="payload.schedule_day_id"
              label="Hari"
              itemName="name"
              icon="calendar"
              :originData="days"
              rules="required"
            />
            <auto-complete-component
              v-if="!!payload.schedule_day_id"
              v-model="payload.schedule_lesson_hour_id"
              label="Jam Pelajaran Ke-"
              itemName="started_at"
              icon="calendar"
              :originData="hours"
              rules="required"
            />
          </template>
        </form-component>
      </template>
    </update-or-create-component>

    <dialog-component
      v-on:confirm-action="destroy"
      confirmText="Hapus"
      title="Hapus Data"
      v-model="dialog"
      v-on:close-dialog="closeDialogConfirmation"
    >
      <template v-slot:message>
        <v-container>
          <p class="text-center font-weight-bold">
            Apakah anda yakin akan menghapus data ini ?
          </p>
        </v-container>
      </template>
    </dialog-component>

    <alert-component ref="alert"></alert-component>
  </main>
</template>
