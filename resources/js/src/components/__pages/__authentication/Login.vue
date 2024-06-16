<script>
import LoginMixins from '@Components/__mixins/authentication/login';

export default {
    name: 'Login',
    mixins: [
        LoginMixins
    ],
}
</script>

<template>
    <div class="auth-login mx-3">
        <div>
            <v-img src="../../../assets/images/logo.jpeg" class="mx-auto mb-6 " height="100" max-height="100"
                max-width="100">
            </v-img>
        </div>
        <v-card-text class="py-0">
            <form-component :methodHandler="loginHandler" buttonSubmitText="Login">
                <input-component v-model="payload.email" icon="email" type="email" label="Alamat Email"
                    rules="required|email">
                </input-component>

                <input-password v-model="payload.password" rules="required"></input-password>
            </form-component>
            <p class="mt-5 text-center font-weight-bold">
                Versi : {{ version }}
            </p>
        </v-card-text>

        <alert-component ref="alert"></alert-component>
    </div>
</template>
