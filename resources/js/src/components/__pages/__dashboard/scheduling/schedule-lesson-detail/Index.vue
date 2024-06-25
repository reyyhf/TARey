<script>
import scheduleLessonItemMixin from '@Components/__mixins/scheduling/schedule-lesson-item'

export default {
  name: 'ScheduleLessonItemIndex',
  mixins: [scheduleLessonItemMixin],
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
            itemName="name"
            icon="calendar"
            :originData="lessons"
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
        </form-component>
      </template>
    </update-or-create-component>

    <dialog-component
      v-on:confirm-action="destroy"
      confirmText="Hapus"
      title="Hapus Data"
      v-model="dialog"
      v-on:close-dialog="dialog = false"
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
