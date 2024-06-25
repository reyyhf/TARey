<script>
import { mapActions } from 'vuex'
import { dragscroll } from 'vue-dragscroll'

export default {
  data() {
    return {
      scheduleDays: [],
      tabuSearchResult: null,
      isLoading: false,
      lesson: null,
    }
  },
  methods: {
    ...mapActions({
      fetchDays: 'scheduleDay/fetchScheduleDay',
      fetchScheduleLessons: 'scheduleLesson/fetchScheduleLessons',
      fetchTabuSearch: 'tabuSearch/fetchTabuSearch',
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
        })
        .catch((err) => {
          this?.$refs?.alert?.show(
            result?.data?.meta?.status,
            result?.data?.meta?.message
          )
          console.log(err)
        })
        .finally(() => {
          this.isLoading = false
        })
    },
    showLessonDetail(lesson) {},
  },
  computed: {
    maxHours: function () {},
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
  directives: {
    dragscroll,
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
          <v-btn color="success" v-if="tabuSearchResult">Simpan</v-btn>
        </div>
      </template>
      <div class="table-schedule" v-dragscroll>
        <table v-if="scheduleDays.length && tabuSearchResult">
          <thead>
            <tr>
              <th rowspan="3">Kelas</th>
            </tr>
            <tr>
              <th v-for="day in scheduleDays" :colspan="day.total_hours">
                {{ day.name }}
              </th>
            </tr>
            <tr>
              <template v-for="day in scheduleDays">
                <th
                  colspan="1"
                  class="text-center border"
                  v-for="i in day.total_hours"
                >
                  {{ i }}
                </th>
              </template>
            </tr>
          </thead>
          <tbody>
            <tr v-for="result in tabuSearchResult.result">
              <td>
                {{ result.classroom.name }}
              </td>
              <template v-for="day in result.schedules">
                <td
                  colspan="1"
                  v-for="lesson in day.lessons"
                  :class="`text-center border ${
                    lesson?.score ? 'constraint-error' : ''
                  }`"
                >
                  <div
                    v-if="lesson"
                    class="lesson"
                    @click="showLessonDetail(lesson)"
                  >
                    <span> {{ lesson.lesson.acronym }}</span>
                    <span> {{ lesson.teacher.name }}</span>
                  </div>
                </td>
              </template>
            </tr>
          </tbody>
        </table>
        <div v-else class="text-center">
          Mulai proses untuk menampilkan data
        </div>
      </div>
    </card-component>

    <v-dialog v-model="lesson" width="500"> aa </v-dialog>

    <alert-component ref="alert"></alert-component>
  </main>
</template>

<style scoped>
.table-schedule {
  overflow-x: auto;
  padding-bottom: 16px;
}
.table-schedule * {
  user-select: none;
}
table {
  overflow-x: hidden;
  border-radius: 16px;
}
td {
  min-width: 160px;
}
table,
th,
td {
  border: 1px solid rgba(0, 0, 0, 0.3);
  border-spacing: 0;
  border-collapse: collapse;
  text-align: center;
}

table {
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
  gap: 16px;
  align-items: center;
}
td:not(.lesson),
th {
  padding: 16px;
}
tbody tr:hover {
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
</style>
