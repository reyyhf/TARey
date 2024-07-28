<script>
import scheduleReportDetailMixin from '@Components/__mixins/reporting/teaching-load-detail'
import ExcelJS from 'exceljs'
import { dragscroll } from 'vue-dragscroll'
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'

export default {
  name: 'TeachingLoadReportDetail',
  mixins: [scheduleReportDetailMixin],
  data() {
    return {
      isList: false,
    }
  },
  methods: {
    downloadPdf() {
      const table = this.$refs.tableTabuSearch.getElementsByTagName('table')[0]

      // Use html2canvas to capture the table as an image
      html2canvas(table).then((canvas) => {
        const imgData = canvas.toDataURL('image/png')
        const pdf = new jsPDF('l', 'pt', [
          table.scrollWidth,
          table.scrollHeight,
        ])
        const imgProps = pdf.getImageProperties(imgData)
        const pdfWidth = pdf.internal.pageSize.getWidth()
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width

        const pageHeight = pdf.internal.pageSize.getHeight()
        let position = 0

        // Add the image to the PDF
        pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight)

        // If the content height is larger than the page height, add new pages
        while (pdfHeight + position > pageHeight) {
          position -= pageHeight
          pdf.addPage()
          pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight)
        }

        pdf.save(`laporan_beban_mengajar_${this.data.title}.pdf`)
      })
    },
    downloadExcel() {
      const table = this.$refs.tableTabuSearch.getElementsByTagName('table')[0]
      const workbook = new ExcelJS.Workbook()
      const worksheet = workbook.addWorksheet('Sheet 1')

      // Define the border style
      const borderStyle = {
        top: { style: 'thin' },
        left: { style: 'thin' },
        bottom: { style: 'thin' },
        right: { style: 'thin' },
      }

      // Track merged cells to avoid overlapping
      const mergedCells = []

      // Check if a cell is already merged
      function isMergedCell(row, col) {
        return mergedCells.some(([startRow, startCol, endRow, endCol]) => {
          return (
            row >= startRow && row <= endRow && col >= startCol && col <= endCol
          )
        })
      }

      // Iterate over table rows and cells to add data to the worksheet
      for (let rowIndex = 0; rowIndex < table.rows.length; rowIndex++) {
        const row = table.rows[rowIndex]
        let colIndex = 1

        for (let cellIndex = 0; cellIndex < row.cells.length; cellIndex++) {
          const cell = row.cells[cellIndex]

          // Find the first non-merged cell
          while (isMergedCell(rowIndex + 1, colIndex)) {
            colIndex++
          }

          const excelCell = worksheet.getRow(rowIndex + 1).getCell(colIndex)
          excelCell.value = cell.innerText
          excelCell.border = borderStyle

          // Handle colspan
          if (cell.colSpan > 1) {
            worksheet.mergeCells(
              rowIndex + 1,
              colIndex,
              rowIndex + 1,
              colIndex + cell.colSpan - 1
            )
            mergedCells.push([
              rowIndex + 1,
              colIndex,
              rowIndex + 1,
              colIndex + cell.colSpan - 1,
            ])
            for (let i = 0; i < cell.colSpan; i++) {
              worksheet.getRow(rowIndex + 1).getCell(colIndex + i).border =
                borderStyle
            }
            colIndex += cell.colSpan
          } else {
            colIndex++
          }

          // Handle rowspan
          if (cell.rowSpan > 1) {
            worksheet.mergeCells(
              rowIndex + 1,
              colIndex - (cell.colSpan || 1),
              rowIndex + cell.rowSpan,
              colIndex - (cell.colSpan || 1)
            )
            mergedCells.push([
              rowIndex + 1,
              colIndex - (cell.colSpan || 1),
              rowIndex + cell.rowSpan,
              colIndex - (cell.colSpan || 1),
            ])
            for (let i = 0; i < cell.rowSpan; i++) {
              worksheet
                .getRow(rowIndex + 1 + i)
                .getCell(colIndex - (cell.colSpan || 1)).border = borderStyle
            }
          }
        }
      }

      // Write the workbook to a file and trigger download
      workbook.xlsx.writeBuffer().then((buffer) => {
        const blob = new Blob([buffer], {
          type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        })
        const url = URL.createObjectURL(blob)
        const a = document.createElement('a')
        a.href = url
        a.download = `laporan_beban_mengajar_${this.data.title}.xlsx`
        document.body.appendChild(a)
        a.click()
        document.body.removeChild(a)
        URL.revokeObjectURL(url)
      })
    },
    getClassrooms(dayId, hour) {
      if (!dayId || !hour || !this.teacherId) return []
      const teacher = this.data.data_teaching_weight.find(
        (teacher) => teacher.id === this.teacherId
      )
      const classrooms = teacher.classrooms.filter((classroom) => {
        return classroom.schedules.some((schedule) => {
          return schedule.id === dayId && !!schedule.lessons[hour - 1]
        })
      })
      return classrooms
    },
  },
  computed: {
    teacherLessons() {
      if (!this.teacherId) return []
      const teacher = this.data.data_teaching_weight.find(
        (teacher) => teacher.id === this.teacherId
      )
      const lessons = teacher?.classrooms?.reduce((allLessons, classroom) => {
        const lessons = classroom.schedules.reduce(
          (lessonInSchedule, schedule) => {
            const lessons = schedule.lessons
              .filter((lesson) => !!lesson)
              .map((lesson) => ({
                lesson,
                schedule,
                classroom,
              }))

            return [...lessonInSchedule, ...lessons]
          },
          []
        )

        return [...allLessons, ...lessons]
      }, [])
      return lessons
    },
  },
  directives: {
    dragscroll,
  },
}
</script>

<template>
  <div class="schedulue-lesson">
    <card-component
      :title="`Laporan Beban Mengajar: ${data?.title || ''}`"
      icon="calendar-clock-outline"
    >
      <template v-slot:action>
        <div class="actions">
          <auto-complete-component
            v-model="teacherId"
            label="Guru"
            itemName="name"
            icon="notebook-check"
            :originData="teachers"
            itemValue="profile_id"
            :multiple="false"
            :withChips="false"
            class="select-teacher"
            density="compact"
          >
          </auto-complete-component>
          <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                outlined
                color="primary"
                dark
                v-bind="attrs"
                v-on="on"
                style="margin-left: -24px"
              >
                <v-icon left> mdi-content-save-plus </v-icon>
                Download
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
          <v-btn
            outlined
            color="primary"
            dark
            icon
            v-bind="attrs"
            v-on="on"
            style="margin-left: 16px"
            @click="isList = !isList"
          >
            <v-icon v-if="isList"> mdi mdi-format-list-bulleted </v-icon>
            <v-icon v-else> mdi mdi-calendar-month-outline </v-icon>
          </v-btn>
        </div>
      </template>
      <div
        :class="isList ? 'd-none' : 'table-schedule'"
        ref="tableTabuSearch"
        v-dragscroll
      >
        <table v-if="days && teacherId">
          <thead>
            <tr>
              <th rowspan="2">Hari</th>
              <th :colspan="maxTotalHours">Jam Pelajaran</th>
            </tr>
            <tr>
              <th v-for="hour in maxTotalHours">
                {{ hour }}
              </th>
            </tr>
          </thead>
          <tbody>
            <template v-for="day in days">
              <tr :rowspan="day.total_hours">
                <td>{{ day.name }}</td>
                <template v-for="hour in maxTotalHours">
                  <td
                    v-for="classrooms in [getClassrooms(day.id, hour)]"
                    :class="classrooms.length > 1 ? 'constraint-error' : ''"
                  >
                    <div class="classroom">
                      <div v-for="(classroom, index) in classrooms">
                        <span>
                          {{ classroom.name }}
                        </span>
                        <span>
                          {{
                            classroom.schedules.find(
                              (schedule) => schedule.id === day.id
                            )?.lessons[hour - 1]?.lesson?.name
                          }}
                        </span>
                        <hr
                          v-if="
                            classrooms.length > 1 &&
                            index !== classrooms.length - 1
                          "
                        />
                      </div>
                    </div>
                  </td>
                </template>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
      <div :class="isList ? '' : 'd-none'">
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">No</th>
                <th class="text-left">Hari</th>
                <th class="text-left">Akronim</th>
                <th class="text-left">Nama</th>
                <th class="text-left">Kelas</th>
                <th class="text-left">Mulai</th>
                <th class="text-left">Selesai</th>
                <th class="text-left">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(teacherLesson, index) in teacherLessons">
                <td>{{ index + 1 }}</td>
                <td>{{ teacherLesson.schedule.name }}</td>
                <td>{{ teacherLesson.lesson.lesson.acronym }}</td>
                <td>{{ teacherLesson.lesson.lesson.name }}</td>
                <td>{{ teacherLesson.classroom.name }}</td>
                <td>{{ teacherLesson.lesson.hour.started_duration }}</td>
                <td>{{ teacherLesson.lesson.hour.ended_duration }}</td>
                <td>{{ teacherLesson.classroom.quota }}</td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </div>
    </card-component>
  </div>
</template>

<style scoped>
.table-schedule {
  overflow-x: auto;
  padding-bottom: 16px;
}
.table-schedule * {
  user-select: none;
}
.table-schedule table {
  overflow-x: hidden;
  border-radius: 16px;
  min-width: 100%;
}
.table-schedule td {
  min-width: 100px;
}
.table-schedule table,
.table-schedule th,
.table-schedule td {
  border: 1px solid rgba(0, 0, 0, 0.3);
  border-spacing: 0;
  border-collapse: collapse;
  text-align: center;
}

.table-schedule table {
  border-radius: 16px;
}

.table-schedule::-webkit-scrollbar {
  height: 8px;
}

/* Track */
.table-schedule::-webkit-scrollbar-track {
  background: transparent;
}

/* Handle */
.table-schedule::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.3);
  border-radius: 16px;
  cursor: pointer;
}

/* Handle on hover */
.table-schedule::-webkit-scrollbar-thumb:hover {
  background: rgba(0, 0, 0, 0.3);
}
.actions {
  display: flex;
  justify-content: end;
  align-items: center;
}
.table-schedule td:not(.lesson),
.table-schedule th {
  padding: 16px;
}
.table-schedule tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.02);
}
.lesson {
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;
  width: 100%;
  height: 100%;
  padding: 16px;
}
.constraint-error {
  background-color: #f34545;
  color: white;
}
.select-teacher {
  scale: 0.7;
}
.classroom {
  display: flex;
  flex-direction: column;
}
.classroom > div {
  display: flex;
  flex-direction: column;
}
.classroom hr {
  border: 1px solid white;
}
</style>
