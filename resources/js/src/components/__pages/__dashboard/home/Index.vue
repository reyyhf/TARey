<script>
import home from '@Components/__mixins/dashboard/home'
import ExcelJS from 'exceljs'

import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'

export default {
    name: 'Dashboard',
    mixins: [home],
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

            pdf.save(`${this.data.title}.pdf`)
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
            a.download = `${this.data.title}.xlsx`
            document.body.appendChild(a)
            a.click()
            document.body.removeChild(a)
            URL.revokeObjectURL(url)
        })
        }
    },
    data() {
        return {
            barChartOptions: {
                responsive : true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    },
                    datalabels: {
                        display: false
                    }
                }
            },
            pieChartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    computed: {
        conflicts() {
            if(!this.data?.data?.result) return [0, 0, 0, 0, 0]
            return this.data.data.result.reduce((conflicts, classroom) => {
                const monday = classroom.schedules
                    .find((schedule) => schedule.order_direction === 1)
                    ?.lessons
                    ?.reduce((total, lesson) => total + (lesson?.score ? lesson.score / 20 : 0), 0);
                const tuesday = classroom.schedules
                    .find((schedule) => schedule.order_direction === 2)
                    ?.lessons
                    ?.reduce((total, lesson) => total + (lesson?.score ? lesson.score / 20 : 0), 0);
                const wednesday = classroom.schedules
                    .find((schedule) => schedule.order_direction === 3)
                    ?.lessons
                    ?.reduce((total, lesson) => total + (lesson?.score ? lesson.score / 20 : 0), 0);
                const thursday = classroom.schedules
                    .find((schedule) => schedule.order_direction === 4)
                    ?.lessons
                    ?.reduce((total, lesson) => total + (lesson?.score ? lesson.score / 20 : 0), 0);
                    const friday = classroom.schedules
                    .find((schedule) => schedule.order_direction === 5)
                    ?.lessons
                    ?.reduce((total, lesson) => total + (lesson?.score ? lesson.score / 20 : 0), 0);
                return [conflicts[0] + monday, conflicts[1] + tuesday, conflicts[2] + wednesday, conflicts[3] + thursday, conflicts[4] + friday]
            }, [0, 0, 0, 0, 0])
        },
        barChartData() {
            return {
                labels: [ 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat' ],
                datasets: [{
                    backgroundColor: ['#DA251C'],
                    data: this.conflicts
                }]
            }
        },
        pieChartData(){
            return {
                labels: ['Tetap', 'Honorer'],
                datasets: [{
                    backgroundColor: ['#29166F', '#DA251C'],
                    data: [this.data?.teacherPermanent.length, this.data?.teacherHonorary.length]
                }]
            }
        }
    }
}
</script>

<template>
  <div class="home">
    <div class="d-flex mb-5 flex-grow-1 card-container" style="gap: 16px;">
        <card-component
        :title="`Jumlah guru honorer dan tetap`"
        icon="chart-pie" class="flex-fill chart-card">
        <pie-chart :data="pieChartData" :options="pieChartOptions" class="chart"></pie-chart>
        </card-component>
        <card-component
        :title="`Jumlah Conflict`"
        icon="chart-bar" class="flex-fill chart-card">
        <bar-chart :data="barChartData" :options="barChartOptions" class="chart"></bar-chart>
        </card-component>
    </div>
    <card-component
      :title="`Jadwal ${data?.title || ''}`"
      icon="calendar-clock-outline"
    >
      <template v-slot:action>
        <div class="actions">
          <v-menu offset-y>
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
        <table-tabu-search v-if="data" :tabuSearchResult="data.data" :onlyToday="true" />
        <div v-else class="text-center">
          Mulai proses untuk menampilkan data
        </div>
      </div>
    </card-component>
  </div>
</template>
<style scoped>
.card-container {
  display: flex;
  gap: 16px;
}

.chart-card {
  flex: 1;
  display: flex;
  flex-direction: column;
  height: 100%; /* Ensure the card takes up full height */
  width: 100%; /* Ensure the card takes up full width */
}

.chart {
  flex-grow: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%; /* Ensure the chart takes up full height of the card */
}
</style>
