import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 'resources/css/admin/admin.scss', 'resources/css/public-part/layout.scss', 'resources/js/app.js' ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery'
        },
    },
    build: {
        chunkSizeWarningLimit: 1600,
    },
});
