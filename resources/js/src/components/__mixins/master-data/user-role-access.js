import { mapGetters, mapActions, mapMutations } from "vuex";

const userAccessRoleMixins = {
    data() {
        return {
            userRoleAccesses: [],
            isLoading: false,
            headers: [
                {
                    text: "No.",
                    value: "number",
                    sortable: true,
                },
                {
                    text: "Nama Hak Akses",
                    value: "name",
                    sortable: true,
                }
            ],
        };
    },

    async mounted() {
        await this.loadUserRoleAccess();
    },

    computed: {
        ...mapGetters({
            userRoleAccess: "userRoleAccess/getUserRoleAccess",
        }),
    },

    methods: {
        ...mapActions({
            fetchData: "userRoleAccess/fetchUserRoleAccess",
        }),

        ...mapMutations({
            setUserRoleAccess: "userRoleAccess/setUserRoleAccess",
        }),

        async loadUserRoleAccess() {

            this.isLoading = true;

            await this.fetchData().then((result) => {
                this.userRoleAccesses = result.data.data;
            }).catch((err) => {
                console.error(err);
            }).finally(() => {
                this.isLoading = false;
            })

        },
    },
};

export default userAccessRoleMixins;
