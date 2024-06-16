import { mapActions } from "vuex";
import indexMixins from "@Components/__mixins/base/index";

const userMixins = {
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
                text: "Nama Pengguna",
                value: "name",
                sortable: true,
            },
            {
                text: "NUPTK",
                value: "nuptk",
                sortable: true,
            },
            {
                text: "Alamat Email",
                value: "nuptk",
                sortable: true,
            },
            {
                text: "Status Aktivasi Pengguna",
                value: "user_activation_status",
                sortable: true,
            },
            {
                text: "Aksi",
                value: "actions",
                align: "center",
                sortable: false,
            },
        ],
        genders: [
            {
                label: 'Pria',
                value: true,
            },
            {
                label: 'Wanita',
                value: false,
            }
        ],
        userRoleAccesses: [],
        userStatuses: [],
        payload: {
            name: null,
            email: null,
            password: null,
            nuptk: null,
            gender: null,
            birth_place: null,
            is_active: false,
            role_name: null,
            user_status_id: null,
        },
    }),
    methods: {
        ...mapActions({
            fetchData: "user/fetchUser",
            storeData: "user/storeUser",
            updateData: "user/updateUser",
            showData: "user/fetchDetailUser",
            destroyData: "user/destroyUser",
            fetchUserRoleAccess: "userRoleAccess/fetchUserRoleAccess",
            fetchUserStatus: "userStatus/fetchUserStatus",
        }),
    },
    computed: {
        textLabel() {
            return this.payload.is_active ? 'Aktif' : 'Tidak Aktif'
        },
    },
    async created() {
        await this.fetchUserRoleAccess().then((result) => {
            let data = result.data.data;

            data.forEach(element => {
                this.userRoleAccesses.push({
                    label: element.name,
                    value: element.name,
                });
            });
        }).catch((err) => {
            console.error(err);
        });

        await this.fetchUserStatus().then((result) => {
            let data = result.data.data;

            data.forEach(element => {
                this.userStatuses.push({
                    label: element.name,
                    value: element.id,
                });
            });
        }).catch((err) => {
            console.error(err);
        });
    }
};

export default userMixins;
