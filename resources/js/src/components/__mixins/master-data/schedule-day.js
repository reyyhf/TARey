import { mapActions } from "vuex";
import indexMixins from "@Components/__mixins/base/index";

const scheduleDayMixins = {
    mixins: [
        indexMixins,
    ],
    data() {
        return {
            headers: [
                {
                    text: "No.",
                    value: "number",
                    sortable: true,
                },
                {
                    text: "Hari",
                    value: "name",
                    sortable: true,
                },
                {
                    text: "Maksimal Jam Belajar",
                    value: "total_hours",
                    sortable: true,
                },
                {
                    text: "Aksi",
                    value: "actions",
                    align: "center",
                    sortable: false,
                },
            ],
            payload: {
                total_hours: null,
            },
            started_year: '-',
            ended_year: '-',
            maximum_teach_load_hour: 10,
        };
    },

    methods: {
        ...mapActions({
            fetchData: "scheduleDay/fetchScheduleDay",
            fetchActiveSemesterData: "semester/fetchActiveSemester",
            updateData: "scheduleDay/updateScheduleDay",
            showData: "scheduleDay/fetchDetailScheduleDay",
        }),
    },

    async created() {
        await this.fetchActiveSemesterData().then((response) => {
            let result = response.data.data;
            this.started_year = result.started_year;
            this.ended_year = result.ended_year;
        }).catch((err) => {
            console.error(err);
        });
    },
};

export default scheduleDayMixins;
