<script>
import { mapActions } from 'vuex'

export default {
  mixins: [],
  data() {
    return {
      scheduleDays: [],
      tabuSearchResult: null,
      isLoading: false,
      selectedLesson: null,
      showModal: false,
      payload: {
        data: null,
        title: 'Report TS',
      },
    }
  },
  methods: {
    ...mapActions({
      fetchDays: 'scheduleDay/fetchScheduleDay',
      fetchScheduleLessons: 'scheduleLesson/fetchScheduleLessons',
      fetchTabuSearch: 'tabuSearch/fetchTabuSearch',
      storeScheduleReport: 'scheduleReport/storeScheduleReport',
    }),
    handleTabuSearch() {
      this.isLoading = true
      this.fetchTabuSearch()
        .then((result) => {
          this?.$refs?.alert?.show(
            result?.data?.meta?.status,
            result?.data?.meta?.message
          )
          this.tabuSearchResult = result.data.data
          this.payload.data = result.data.data
        })
        .catch((err) => {
          this?.$refs?.alert?.show('error', err?.message)
          console.log(err)
        })
        .finally(() => {
          this.isLoading = false
        })
    },
    closeModal() {
      this.showModal = false
    },
    submit() {
      this.isLoading = true
      this.storeScheduleReport({
        title: this.payload.title,
        data: JSON.stringify(this.payload.data),
      })
        .then((result) => {
          this.$router.push({ name: 'schedule-report' })
          this?.$refs?.alert?.show(
            result?.data?.meta?.status,
            result?.data?.meta?.message
          )
        })
        .catch((err) => {
          this?.$refs?.alert?.show('error', err?.message)
          console.log(err)
        })
        .finally(() => {
          this.isLoading = false
        })
    },
  },
  mounted() {
    this.fetchDays()
      .then((result) => {
        this.scheduleDays = result.data.data
      })
      .catch((err) => {
        this?.$refs?.alert?.show(
          result?.data?.meta?.status,
          result?.data?.meta?.message
        )
        console.log(err)
      })
  },
}
</script>

<template>
  <main class="schedule">
    <card-component
      title="Tabu Search"
      icon="calendar-clock-outline"
      :withLoading="isLoading"
    >
      <template v-slot:action>
        <div class="actions">
          <v-btn
            color="primary"
            @click="handleTabuSearch"
            :disabled="isLoading"
          >
            Proses
          </v-btn>
          <v-btn
            color="success"
            v-if="tabuSearchResult"
            @click="showModal = true"
            >Simpan</v-btn
          >
        </div>
      </template>
      <div class="table-schedule" v-dragscroll>
        <table-tabu-search
          v-if="scheduleDays.length && tabuSearchResult"
          :tabuSearchResult="tabuSearchResult"
        />
        <div v-else class="text-center">
          Mulai proses untuk menampilkan data
        </div>
      </div>
    </card-component>

    <update-or-create-component
      :closeAction="closeModal"
      :title="`Buat Laporan`"
      v-model="showModal"
    >
      <template v-slot:form>
        <form-component
          ref="form"
          :methodHandler="submit"
          buttonSubmitText="Simpan"
        >
          <input-component
            icon="progress-clock"
            v-model="payload.title"
            type="text"
            defa
            label="Judul Laporan"
            rules="required"
          >
          </input-component>
        </form-component>
      </template>
    </update-or-create-component>

    <alert-component ref="alert"></alert-component>
  </main>
</template>

<style scoped>
.actions {
  display: flex;
  justify-content: end;
  gap: 16px;
  align-items: center;
}
</style>
