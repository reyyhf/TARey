import { mapActions } from "vuex";
import indexMixins from "@Components/__mixins/base/index";

const classroomMixins = {
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
                    text: "Nama Ruang Kelas",
                    value: "name",
                    sortable: true,
                },
                {
                    text: "Jurusan",
                    value: "majority",
                    sortable: true,
                },
                {
                    text: "Jumlah Siswa",
                    value: "quota",
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
                name: null,
                majority: null,
                quota: null,
            },
            majorities: [
                {
                    label: 'IPA',
                    value: 'IPA',
                },
                {
                    label: 'IPS',
                    value: 'IPS',
                }
            ],
        };
    },

    methods: {
        ...mapActions({
            fetchData: "classroom/fetchClassroom",
            storeData: "classroom/storeClassroom",
            updateData: "classroom/updateClassroom",
            showData: "classroom/fetchDetailClassroom",
            destroyData: "classroom/destroyClassroom",
        }),
    },
};

export default classroomMixins;
