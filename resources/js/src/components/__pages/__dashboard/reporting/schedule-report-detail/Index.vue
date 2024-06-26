<script>
import scheduleReportDetailMixin from '@Components/__mixins/reporting/schedule-report-detail'

export default {
  name: 'ScheduleReportDetail',
  mixins: [scheduleReportDetailMixin],
}
</script>

<template>
  <div class="schedulue-lesson">
    <card-component
      title="Laporan Jadwal Mata Pelajaran"
      icon="calendar-clock-outline"
    >
      <div class="table-schedule" v-dragscroll>
        <table-tabu-search v-if="data" :tabuSearchResult="data.data" />
        <div v-else class="text-center">
          Mulai proses untuk menampilkan data
        </div>
      </div>
    </card-component>
  </div>
</template>
