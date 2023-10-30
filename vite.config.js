import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/admin.css",
                "resources/css/tailwind.css",
                "resources/scss/app.scss",
                "resources/js/app.js",
                "resources/js/metrics.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        sourcemap: true,
    },
});
