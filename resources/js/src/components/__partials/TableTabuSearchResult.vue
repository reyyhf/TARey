<script>
import { dragscroll } from 'vue-dragscroll';

export default {
  name: 'TableTabuSearchResult',
  mixins: [],
  props: {
    tabuSearchResult: {
      type: Object,
      required: false,
    },
    onlyToday: {
      type: Boolean,
      default: false,
      required: false,
    },
  },
  data() {
    return {
      scheduleDays: [],
      isLoading: false,
      selectedLesson: null,
      showModal: false,
    }
  },
  methods: {
    closeModal() {
      this.showModal = false
    },
    getLesson(classroom, dayId, hourId) {
      if (!hourId) return

      const schedule = classroom.schedules.find(
        (schedule) => schedule.id === dayId
      )
      const lesson = schedule.lessons.find(
        (lesson) => lesson?.hour?.id === hourId
      )

      return lesson
    },
  },
  computed: {
    days() {
      if (!this.tabuSearchResult) return []
      const allSchedules = this.tabuSearchResult.result
        .flatMap((result) => result.schedules)
        .slice(0, 5)
      return [
        ...new Set(
          allSchedules.map((schedule) => ({
            id: schedule.id,
            name: schedule.name,
            total_hours: schedule.total_hours,
            hours: schedule.lessons.map((lesson) => lesson?.hour),
          }))
        ),
      ]
    },
    classrooms() {
      if (!this.tabuSearchResult) return []
      const romanToInt = {
        X: 10,
        XI: 11,
        XII: 12,
      }
      return this.tabuSearchResult.result.sort((a, b) => {
        const [gradeA, typeA, numberA] = a.classroom.name.split(' ')
        const [gradeB, typeB, numberB] = b.classroom.name.split(' ')

        if (typeA !== typeB) return typeA.localeCompare(typeB)

        const gradeDiff = romanToInt[gradeA] - romanToInt[gradeB]
        if (gradeDiff !== 0) return gradeDiff

        return parseInt(numberA) - parseInt(numberB)
      })
    },
  },
  directives: {
    dragscroll,
  },
}
</script>

<template>
  <div class="table-schedule" v-dragscroll>
    <table v-if="classrooms">
      <thead>
        <tr>
          <th rowspan="3">Hari</th>
          <th rowspan="3">Jam</th>
          <th :colspan="classrooms.length + 1">Kelas</th>
        </tr>
        <tr>
          <th v-for="classroom in classrooms">
            {{ classroom.classroom.name }}
          </th>
        </tr>
      </thead>
      <tbody>
        <template
          v-for="day in days"
          v-if="
            (day.order_direction === new Date().getDay() && onlyToday) ||
            !onlyToday
          "
        >
          <tr>
            <td :rowspan="day.hours.length + 1">{{ day.name }}</td>
          </tr>
          <tr v-for="hour in day.hours">
            <td>
              <div class="hour">
                <span> {{ hour?.started_at }}</span>
                <span class="duration">
                  {{ hour?.started_duration }} - {{ hour?.ended_duration }}
                </span>
              </div>
            </td>
            <template v-for="classroom in classrooms">
              <td
                v-for="lesson in [getLesson(classroom, day.id, hour?.id)]"
                v-ripple
                :class="`text-center border ${
                  lesson?.score ? 'constraint-error' : ''
                }`"
              >
                <v-dialog
                  :value="selectedLesson === lesson && lesson !== null"
                  width="500"
                  v-if="lesson"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <div
                      v-if="lesson"
                      class="lesson"
                      @click="selectedLesson = lesson"
                      v-on="on"
                      v-bind="attrs"
                    >
                      <span class="font-weight-bold">
                        {{ lesson.lesson.acronym }}</span
                      >
                      <span> &nbsp;({{ lesson.teacher.name }})</span>
                    </div>
                  </template>
                  <v-card>
                    <v-card-title class="font-weight-bold">
                      Detail
                    </v-card-title>
                    <v-card-text>
                      <input-component
                        :value="classroom.classroom.name"
                        icon="account"
                        type="text"
                        label="Kelas"
                        readonly
                      />
                      <input-component
                        :value="lesson.lesson.name"
                        icon="account"
                        type="text"
                        label="Mata Pelajaran"
                        readonly
                      />
                      <input-component
                        :value="`${lesson.hour.started_duration}-${lesson.hour.ended_duration}`"
                        icon="account"
                        type="text"
                        :label="`Jam Ke-${lesson.hour.started_at}`"
                        readonly
                      />
                      <input-component
                        :value="`${lesson.teacher.name} (${lesson.teacher.nuptk})`"
                        icon="account"
                        type="text"
                        label="Nama Pengajar"
                        readonly
                      />
                      <v-alert
                        border="top"
                        color="red"
                        dark
                        v-if="lesson.errors?.length"
                      >
                        <ul>
                          <li v-for="error in lesson.errors">{{ error }}</li>
                        </ul>
                      </v-alert>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn
                        color="primary"
                        text
                        @click="selectedLesson = null"
                      >
                        Close
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </td>
            </template>
          </tr>
        </template>
      </tbody>
    </table>
    <div v-else class="text-center">Mulai proses untuk menampilkan data</div>
    <div v-if="tabuSearchResult">
      Jumlah error: {{ tabuSearchResult.score / 20 }}
    </div>
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
table {
  overflow-x: hidden;
  border-radius: 16px;
  min-width: 100%;
}
td {
  min-width: 100px;
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
.hour {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.duration {
  font-size: 11px;
}
</style>
