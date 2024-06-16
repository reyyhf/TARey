import { mapActions } from "vuex";
import indexMixins from "@Components/__mixins/base/index";

const semesterMixins = {
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
                    text: "Awal Tahun Ajaran",
                    value: "started_year",
                    sortable: true,
                },
                {
                    text: "Akhir Tahun Ajaran",
                    value: "ended_year",
                    sortable: true,
                },
                {
                    text: "Status Tahun Ajaran",
                    value: "is_active",
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
                started_year: null,
                ended_year: null,
                is_active: false,
            },
            startedYear: new Date().getFullYear(),
        };
    },

    methods: {
        ...mapActions({
            fetchData: "semester/fetchSemester",
            storeData: "semester/storeSemester",
            updateData: "semester/updateSemester",
            showData: "semester/fetchDetailSemester",
            destroyData: "semester/destroySemester",
        }),
    },
    computed: {
        textLabel() {
            return this.payload.is_active ? 'Aktif' : 'Tidak Aktif'
        },
    }
};

export default semesterMixins;
