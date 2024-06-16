import { mapActions, mapGetters } from "vuex";
import indexMixins from "@Components/__mixins/base/index";

const curriculumMixins = {
    mixins: [
        indexMixins,
    ],
    data() {
        return {
            lessons: [],
            classrooms: [],
            headers: [
                {
                    text: "Nama Mata Pelajaran",
                    value: "lesson_name",
                    sortable: true,
                },
                {
                    text: "Struktur Kurikulum",
                    value: "curricular",
                    sortable: false,
                },
                {
                    text: "Aksi",
                    value: "actions",
                    align: "center",
                    sortable: false,
                },
            ],
            payload: {
                curricular: [],
                lesson_id: null,
                maximum_hours_per_week: null,
                removed_data: [],
            },
            lessonData: {
                acronym: null,
                lesson_category_name: null,
            },
            removedData: [],
        };
    },

    methods: {
        ...mapActions({
            fetchData: "curriculum/fetchCurriculum",
            storeData: "curriculum/storeCurriculum",
            updateData: "curriculum/updateCurriculum",
            showData: "curriculum/fetchDetailCurriculum",
            destroyData: "curriculum/destroyCurriculum",
            fetchLessonData: "lesson/fetchLesson",
            fetchDetailLessonData: "lesson/fetchDetailLesson",
            fetchClassroomLabelData: "classroom/fetchClassroomLabel",
        }),

        resetForm() {
            this.payload = {};
            this.lessonData = {
                acronym: null,
                lesson_category_name: null,
            };
            this.removedData = [];
            this.$refs.form.$refs.observer.reset();
        },

        addCurriculumData() {
            this.payload.curricular.push({
                classroom_label: null,
                maximum_hours_per_week: null,
            });
        },

        removeCurriculumData(index) {
            this.removedData.push(this.payload.curricular[index]);
            this.payload.curricular.splice(index, 1);
            this.payload.removed_data = this.removedData;
        },

        async view(id) {
            this.showModal = true;
            this.dataId = id;
            this.updateOrCreateTitle = 'Ubah';
            await this.showData({ id: id }).then((response) => {
                return response.data.data.forEach(element => {
                    this.payload = element;
                    this.payload.curricular = element.curricular;
                });
            });
        },
    },

    async created() {
        await this.fetchLessonData().then((result) => {
            let data = result.data.data;
            this.lessons = data;
        })

        await this.fetchClassroomLabelData().then((result) => {
            let data = result.data.data;
            this.classrooms = data;
        })
    },

    computed: {
        ...mapGetters({
            getClassroomLabels: "classroom/getClassroom",
        }),

        lesson_id() {
            return this.payload.lesson_id;
        },

        classroomLabels() {
            let curricularData = this.payload.curricular.map(element => {
                return element && element.classroom_label;
            });

            let data = [];

            this.getClassroomLabels.forEach(element => {
                if (curricularData.includes(element.label)) {
                    data.push({
                        ...element,
                        label: element.label,
                        disabled: true,
                    });
                } else {
                    data.push({
                        ...element,
                        label: element.label,
                    });
                }
            })

            return data.map(element => {
                return element;
            });
        }
    },

    watch: {
        async lesson_id(value) {
            if (value) {
                await this.fetchDetailLessonData({ id: value }).then((response) => {
                    let result = response.data.data;
                    this.lessonData.acronym = result.acronym;
                    this.lessonData.lesson_category_name = result.lesson_category_name;
                });
            }
        }
    },
};

export default curriculumMixins;
