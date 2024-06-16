import { fileURLToPath, URL } from 'node:url';

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vuePlugin from '@vitejs/plugin-vue2';
import { VuetifyResolver } from 'unplugin-vue-components/resolvers';
import Components from 'unplugin-vue-components/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vuePlugin(),
        Components({
            resolvers: [
                VuetifyResolver(),
            ]
        }),

    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js/src', import.meta.url)),
            '@Components': fileURLToPath(new URL('./resources/js/src/components', import.meta.url)),
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    lodash: ['lodash'],
                    VeeValidate: ['vee-validate'],
                },
            }
        },
    },
});
