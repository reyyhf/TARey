import { mapActions } from "vuex";
import indexMixins from "@Components/__mixins/base/index";

const scheduleLessonHourMixins = {
    mixins: [
        indexMixins,
    ],
    data() {
        return {
            width: "700",
            headers: [
                {
                    text: "Jam Pelajaran",
                    value: "schedule_lesson_hour_name",
                    sortable: true,
                },
                {
                    text: "Durasi Jam Pelajaran",
                    value: "detail_duration",
                    sortable: true,
                },
                {
                    text: "Status Jam Pelajaran",
                    value: "is_break_hour",
                    sortable: true,
                },
                {
                    text: "Aksi",
                    value: "actions",
                    align: "center",
                    sortable: false,
                },
            ],
            select_started_duration: null,
            select_ended_duration: null,
            scheduleDays: [],
            durations: [],
            selectedDay: null,
            payload: {
                schedule_day_id: null,
                started_at: null,
                ended_at: null,
                started_duration: null,
                ended_duration: null,
                order_direction: 1,
                is_break_hour: false,
            },
        };
    },

    methods: {
        ...mapActions({
            fetchScheduleDays: "scheduleDay/fetchScheduleDay",
            fetchData: "scheduleLessonHour/fetchScheduleLessonHour",
            storeData: "scheduleLessonHour/storeScheduleLessonHour",
            updateData: "scheduleLessonHour/updateScheduleLessonHour",
            showData: "scheduleLessonHour/fetchDetailScheduleLessonHour",
            destroyData: "scheduleLessonHour/destroyScheduleLessonHour",
        }),

        async loadData() {
            this.isLoading = true;

            if (this.selectedDay) {
                await this.fetchData({ schedule_day_id: this.selectedDay }).then((result) => {
                    this.results = result.data.data;
                }).catch((err) => {
                    console.error(err);
                }).finally(() => {
                    this.isLoading = false;
                });
            } else {
                await this.fetchData().then((result) => {
                    this.results = result.data.data;
                }).catch((err) => {
                    console.error(err);
                }).finally(() => {
                    this.isLoading = false;
                });
            }
        },

        addDurationData() {
            this.durations.push({
                started_at: null,
                ended_at: null,
                started_duration: null,
                ended_duration: null,
                select_started_duration: null,
                select_ended_duration: null,
            });
        },

        removeDurationData(index) {
            this.durations.splice(index, 1);
        },

        closeModal() {
            this.resetForm();
            this.durations = [];
            this.showModal = false;
            this.dataId = null;
        },

        async submit() {
            let payload = this.payload;

            if (this.dataId) {
                let updatePayload = Object.assign(payload, { id: this.dataId });
                await this.updateDataHandler(updatePayload);
            } else {
                let storePayload = {
                    schedule_day_id: this.payload.schedule_day_id,
                    durations: this.durations
                }
                await this.storeDataHandler(storePayload);
            }
        },
    },

    async created() {
        await this.fetchScheduleDays().then((result) => {
            let data = result.data.data;
            this.scheduleDays = data;
        }).catch((err) => {
            console.error(err);
        });
    },

    computed: {
        schedule_day_id() {
            return this.selectedDay;
        },

        textLabel() {
            return this.payload.is_break_hour ? 'Jam Istirahat' : 'Jam Pelajaran'
        },
    },

    watch: {
        async schedule_day_id(value) {
            if (value) {
                await this.fetchData({ schedule_day_id: value }).then((result) => {
                    let data = result.data.data;
                    this.results = data;
                }).catch((err) => {
                    console.error(err);
                });
            }
        }
    }
};

export default scheduleLessonHourMixins;
