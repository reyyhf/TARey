<script>
import { mapActions } from 'vuex'

export default {
  data() {
    return {
      scheduleDays: [],
      tabuSearchResult: null,
      maxHours: 10,
    }
  },
  methods: {
    ...mapActions({
      fetchDays: 'scheduleDay/fetchScheduleDay',
      fetchScheduleLessons: 'scheduleLesson/fetchScheduleLessons',
      fetchTabuSearch: 'tabuSearch/fetchTabuSearch',
    }),
    handleTabuSearch() {
      this.fetchTabuSearch().then((result) => {
        this.tabuSearchResult = result.data.data
      })
    },
  },
  created() {
    this.fetchDays().then((result) => {
      this.scheduleDays = result.data.data
    })
  },
}
</script>

<template>
  <main class="schedule">
    <card-component title="Jadwal Mata Pelajaran" icon="calendar-clock-outline">
      <div class="actions">
        <v-btn color="primary" @click="handleTabuSearch">Proses</v-btn>
        <v-btn color="success" v-if="tabuSearchResult">Simpan</v-btn>
      </div>
      <div class="table-schedule">
        <table v-if="scheduleDays.length && tabuSearchResult">
          <thead>
            <tr>
              <th rowspan="3">Kelas</th>
            </tr>
            <tr>
              <th v-for="day in scheduleDays" :colspan="maxHours">
                {{ day.name }}
              </th>
            </tr>
            <tr>
              <template v-for="day in scheduleDays">
                <th
                  colspan="1"
                  class="text-center border"
                  v-for="i in maxHours"
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
                  <div v-if="lesson" class="lesson">
                    <span> {{ lesson.lesson.acronym }}</span>
                    <span> {{ lesson.teacher.name }}</span>
                  </div>
                </td>
              </template>
            </tr>
          </tbody>
        </table>
      </div>
    </card-component>
  </main>
</template>

<style scoped>
.table-schedule {
  overflow-x: auto;
  padding-bottom: 16px;
}
table {
  overflow-x: hidden;
}
td {
  min-width: 160px;
}
table,
th,
td {
  border: 1px solid;
  border-spacing: 0;
  border-collapse: collapse;
  padding: 16px;
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
  background: #555;
  border-radius: 16px;
  cursor: pointer;
}

/* Handle on hover */
.table-schedule::-webkit-scrollbar-thumb:hover {
  background: #555;
}
.actions {
  display: flex;
  justify-content: end;
  gap: 16px;
  margin-bottom: 16px;
}
.lesson {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.constraint-error {
  background-color: #f34545;
  color: white;
}
</style>
