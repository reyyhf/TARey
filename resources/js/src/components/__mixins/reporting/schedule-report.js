import { mapActions } from 'vuex'
import indexMixins from '@Components/__mixins/base/index'

const scheduleReportMixin = {
  mixins: [indexMixins],
  data() {
    return {
      headers: [
        {
          text: 'No.',
          value: 'number',
          sortable: true,
        },
        {
          text: 'Judul',
          value: 'title',
          sortable: true,
        },
        {
          text: 'Aksi',
          value: 'actions',
          align: 'center',
          sortable: false,
        },
      ],
    }
  },

  methods: {
    ...mapActions({
      fetchData: 'scheduleReport/fetchScheduleReports',
      storeData: 'scheduleReport/storeScheduleReport',
      showData: 'scheduleReport/fetchDetailScheduleReport',
      updateData: 'scheduleReport/updateScheduleReport',
      destroyData: 'scheduleReport/destroyScheduleReport',
      fetchClassroomsData: 'classroom/fetchClassroom',
    }),
  },
}

export default scheduleReportMixin
