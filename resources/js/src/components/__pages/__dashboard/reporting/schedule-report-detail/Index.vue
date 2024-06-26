<script>
import scheduleReportDetailMixin from '@Components/__mixins/reporting/schedule-report-detail'
import html2pdf from 'html2pdf.js'
import * as XLSX from 'xlsx'

export default {
  name: 'ScheduleReportDetail',
  mixins: [scheduleReportDetailMixin],
  methods: {
    downloadPdf() {
      const table = this.$refs.tableTabuSearch.getElementsByTagName('table')[0]
      const width = table.scrollWidth
      const height = table.scrollHeight
      html2pdf(table, {
        filename: `${this.data.title}.pdf`,
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { dpi: 192, letterRendering: true },
        jsPDF: { format: [width, height], orientation: 'landscape' },
      })
    },
    downloadExcel() {
      const table = this.$refs.tableTabuSearch.getElementsByTagName('table')[0]
      var workbook = XLSX.utils.table_to_book(table)
      XLSX.writeFile(workbook, `${this.data.title}.xlsb`, { cellStyles: true })
    },
  },
}
</script>

<template>
  <div class="schedulue-lesson">
    <card-component
      title="Laporan Jadwal Mata Pelajaran"
      icon="calendar-clock-outline"
    >
      <template v-slot:action>
        <div class="actions">
          <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
              <v-btn outlined color="primary" dark v-bind="attrs" v-on="on">
                <v-icon left> mdi-content-save-plus </v-icon>
                Dropdown
              </v-btn>
            </template>
            <v-list>
              <v-list-item style="cursor: pointer" @click="downloadPdf">
                <v-icon v-text="'mdi-file-pdf-box'" class="mr-2"></v-icon>
                <v-list-item-title>PDF</v-list-item-title>
              </v-list-item>
              <v-list-item style="cursor: pointer" @click="downloadExcel">
                <v-icon v-text="'mdi-microsoft-excel'" class="mr-2"></v-icon>
                <v-list-item-title>Excel</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </div>
      </template>
      <div class="table-schedule" v-dragscroll ref="tableTabuSearch">
        <table-tabu-search v-if="data" :tabuSearchResult="data.data" />
        <div v-else class="text-center">
          Mulai proses untuk menampilkan data
        </div>
      </div>
    </card-component>
  </div>
</template>
