<script>
import { mapActions } from 'vuex'

export default {
  data() {
    return {
      scheduleDays: [],
      scheduleClassrooms: [],
      maxHours: 10,
    }
  },
  methods: {
    ...mapActions({
      fetchDays: 'scheduleDay/fetchScheduleDay',
      fetchScheduleLessons: 'scheduleLesson/fetchScheduleLessons',
      fetchTabuSearch: 'tabuSearch/fetchTabuSearch',
    }),
  },
  created() {
    this.fetchDays().then((result) => {
      this.scheduleDays = result.data.data
    })
    this.fetchTabuSearch().then((result) => {
      console.log(result.data.data)
    })
  },
}
</script>

<template>
  <main class="schedule">
    <card-component title="Jadwal Mata Pelajaran" icon="calendar-clock-outline">
      <div class="actions">
        <v-btn color="primary">Proses</v-btn>
        <v-btn color="success">Simpan</v-btn>
      </div>
      <div class="table-schedule">
        <table v-if="scheduleDays.length">
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
            <tr v-for="lesson in scheduleLessons">
              <td>
                {{ lesson.classroom.name }}
              </td>
              <template v-for="day in scheduleDays">
                <td
                  colspan="1"
                  class="text-center border"
                  v-for="i in maxHours"
                >
                  <div>
                    <span>
                      {{
                        lesson.schedule_lesson_items.find(
                          (item) =>
                            item.schedule_lesson_hour.started_at === i &&
                            item.schedule_lesson_hour.schedule_day_id === day.id
                        )?.lesson?.name
                      }}
                    </span>
                    <span>
                      {{
                        lesson.schedule_lesson_items.find(
                          (item) =>
                            item.schedule_lesson_hour.started_at === i &&
                            item.schedule_lesson_hour.schedule_day_id === day.id
                        )?.teacher?.nuptk
                      }}
                    </span>
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
</style>
