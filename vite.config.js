import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/admin.css",
                "resources/css/tailwind.css",
                "resources/scss/app.scss",
                "resources/js/app.js",
                "resources/js/metrics.js",
                "node_modules/video.js/dist/video-js.min.css",
                "resources/scss/vjs-admin.scss",
            ],
            refresh: true,
        }),
    ],
    build: {
        sourcemap: true,
    },
});
