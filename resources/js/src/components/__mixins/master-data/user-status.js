import { mapActions } from "vuex";
import indexMixins from "@Components/__mixins/base/index";

const userStatusMixins = {
    mixins: [
        indexMixins,
    ],
    data: () => ({
        headers: [
            {
                text: "No.",
                value: "number",
                sortable: true,
            },
            {
                text: "Nama Status Guru",
                value: "name",
                sortable: true,
            },
            {
                text: "Minimal Beban Mengajar (Jam)",
                value: "minimum_teach_load_hour",
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
            minimum_teach_load_hour: null,
        },
    }),
    methods: {
        ...mapActions({
            fetchData: "userStatus/fetchUserStatus",
            storeData: "userStatus/storeUserStatus",
            updateData: "userStatus/updateUserStatus",
            showData: "userStatus/fetchDetailUserStatus",
            destroyData: "userStatus/destroyUserStatus",
        }),
    },
};

export default userStatusMixins;
