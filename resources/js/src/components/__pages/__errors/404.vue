<template>
    <div class="error-404 mx-3">
        <div class="text-center">
            <v-icon color="error" size="150">
                mdi-emoticon-sad-outline
            </v-icon>

            <v-card-text class="py-2">
                <h2 class="font-weight-bold error--text">
                    Halaman Tidak Ditemukan
                </h2>

                <v-btn class="mt-4" large outlined color="error" @click="$router.go(-1)">
                    <v-icon left>
                        mdi-arrow-left
                    </v-icon>
                    Kembali
                </v-btn>
            </v-card-text>
        </div>
    </div>
</template>
