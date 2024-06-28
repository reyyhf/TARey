<script>
import scheduleReportDetailMixin from '@Components/__mixins/reporting/schedule-report-detail'
import ExcelJS from 'exceljs'

import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'

export default {
  name: 'TeachingLoadReportDetail',
  mixins: [scheduleReportDetailMixin],
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
    },
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
          <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
              <v-btn outlined color="primary" dark v-bind="attrs" v-on="on">
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
        </div>
      </template>
      <div class="table-schedule" v-dragscroll ref="tableTabuSearch">
        {{ data?.data_teaching_weight }}
      </div>
    </card-component>
  </div>
</template>
