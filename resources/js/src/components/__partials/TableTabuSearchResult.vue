<script>
import { mapActions } from 'vuex'
import { dragscroll } from 'vue-dragscroll'

export default {
  name: 'TableTabuSearchResult',
  mixins: [],
  props: {
    tabuSearchResult: {
      type: Object,
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
    ...mapActions({
      fetchDays: 'scheduleDay/fetchScheduleDay',
    }),
    closeModal() {
      this.showModal = false
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
  directives: {
    dragscroll,
  },
}
</script>

<template>
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
        <tr v-for="result in tabuSearchResult?.result">
          <td>
            {{ result.classroom.name }}
          </td>
          <template v-for="day in result.schedules">
            <td
              v-ripple
              colspan="1"
              v-for="lesson in day.lessons"
              :class="`text-center border ${
                lesson?.score ? 'constraint-error' : ''
              }`"
            >
              <v-dialog
                :value="selectedLesson === lesson && lesson !== null"
                width="500"
                v-if="lesson !== null"
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
                    <span> {{ lesson.teacher.name }}</span>
                  </div>
                </template>

                <v-card>
                  <v-card-title class="font-weight-bold"> Detail </v-card-title>
                  <v-card-text>
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
                    <v-btn color="primary" text @click="selectedLesson = null">
                      Close
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </td>
          </template>
        </tr>
      </tbody>
    </table>
    <div v-else class="text-center">Mulai proses untuk menampilkan data</div>
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
