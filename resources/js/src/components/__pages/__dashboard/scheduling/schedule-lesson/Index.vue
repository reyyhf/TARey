<script>
import scheduleLessonMixin from '@Components/__mixins/scheduling/schedule-lesson'

console.log(scheduleLessonMixin)

export default {
  name: 'ScheduleLessonIndex',
  mixins: [scheduleLessonMixin],
}
</script>

<template>
  <div class="schedulue-lesson">
    <card-component
      title="Jadwal Mata Pelajaran"
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
  </div>
</template>
