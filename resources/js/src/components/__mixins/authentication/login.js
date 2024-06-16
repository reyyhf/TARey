import { mapActions } from "vuex";

const LoginMixins = {
    data: () => ({
        payload: {
            email: null,
            password: null,
        },
    }),
    computed: {
        version() {
            return import.meta.env.VITE_APP_VERSION;
        },
    },

    methods: {
        ...mapActions({
            login: "authentication/login",
        }),

        async loginHandler() {
            await this.login(this.payload)
                .then((response) => {
                    let result = response.data.meta;

                    this.$refs.alert.show(result.status, result.message);
                    setTimeout(() => {
                        this.$router.push({ name: "homepage" });
                    }, 800);
                })
                .catch((error) => {
                    console.log(error);
                    let result = error.response.data.meta;
                    this.$refs.alert.show(result.status, result.message);
                });
        },
    },
};

export default LoginMixins;
