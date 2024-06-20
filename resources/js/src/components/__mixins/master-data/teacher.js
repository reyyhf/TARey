import { mapActions } from 'vuex'
import indexMixins from '@Components/__mixins/base/index'

const teacherMixins = {
  mixins: [indexMixins],
  data: () => ({
    headers: [
      {
        text: 'No.',
        value: 'number',
        sortable: true,
      },
      {
        text: 'Nama Guru',
        value: 'name',
        sortable: true,
      },
      {
        text: 'NUPTK',
        value: 'nuptk',
        sortable: true,
      },
      {
        text: 'Alamat Email',
        value: 'nuptk',
        sortable: true,
      },
      {
        text: 'Status Aktivasi Guru',
        value: 'user_activation_status',
        sortable: true,
      },
      {
        text: 'Aksi',
        value: 'actions',
        align: 'center',
        sortable: false,
      },
    ],
    genders: [
      {
        label: 'Pria',
        value: false,
      },
      {
        label: 'Wanita',
        value: true,
      },
    ],
    userStatuses: [],
    lessons: [],
    classrooms: [],
    payload: {
      name: null,
      email: null,
      password: null,
      nuptk: null,
      gender: null,
      birth_place: null,
      is_active: false,
      role_name: 'Guru',
      user_status_id: null,
      teacher_lessons: [],
      maximum_teaching_load: null,
      teacher_lessons_name: [],
      teacher_classrooms: [],
      teacher_classrooms_name: [],
    },
  }),
  methods: {
    ...mapActions({
      fetchData: 'teacher/fetchTeacher',
      storeData: 'teacher/storeTeacher',
      updateData: 'user/updateUser',
      showData: 'user/fetchDetailUser',
      destroyData: 'user/destroyUser',
      fetchUserStatus: 'userStatus/fetchUserStatus',
      fetchLesson: 'lesson/fetchLesson',
      fetchClassroom: 'classroom/fetchClassroom',
    }),
  },
  computed: {
    textLabel() {
      return this.payload.is_active ? 'Aktif' : 'Tidak Aktif'
    },
  },
  async created() {
    await this.fetchUserStatus()
      .then((result) => {
        let data = result.data.data

        data.forEach((element) => {
          this.userStatuses.push({
            label: element.name,
            value: element.id,
          })
        })
      })
      .catch((err) => {
        console.error(err)
      })

    await this.fetchLesson()
      .then((result) => {
        let data = result.data.data
        this.lessons = data
      })
      .catch((err) => {
        console.error(err)
      })

    await this.fetchClassroom()
      .then((result) => {
        let data = result.data.data
        this.classrooms = data
      })
      .catch((err) => {
        console.error(err)
      })
  },
}

export default teacherMixins
