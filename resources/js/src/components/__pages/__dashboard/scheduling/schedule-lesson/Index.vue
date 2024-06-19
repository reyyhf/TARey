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
            v-model="payload.classroom_id"
            label="Kelas"
            itemName="name"
            icon="calendar"
            :originData="classrooms"
            rules="required"
          />
          <auto-complete-component
            v-model="payload.curriculum_type"
            label="Kurikulum"
            itemName="name"
            icon="calendar"
            :originData="curriculum_types"
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
  </div>
</template>
