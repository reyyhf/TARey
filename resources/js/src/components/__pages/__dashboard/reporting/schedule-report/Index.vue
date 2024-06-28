<script>
import scheduleReportMixin from '@Components/__mixins/reporting/schedule-report'

export default {
  name: 'ScheduleReportIndex',
  mixins: [scheduleReportMixin],
}
</script>

<template>
  <div class="schedulue-lesson">
    <card-component
      title="Laporan Jadwal Mata Pelajaran"
      icon="calendar-clock-outline"
      :withButtonAction="false"
      :buttonAction="buttonAction"
    >
      <table-component
        v-on:edit-data="view"
        v-on:destroy-data="showDestroyModal"
        :withLoading="isLoading"
        :withUpdate="false"
        :withDetail="true"
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
  </div>
</template>
