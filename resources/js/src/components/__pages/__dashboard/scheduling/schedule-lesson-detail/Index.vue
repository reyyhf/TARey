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
      title="Detail Jadwal Mata Pelajaran"
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
  </main>
</template>
