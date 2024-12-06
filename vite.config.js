import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/admin.css",
                "resources/css/tailwind.css",
                "resources/css/index.css",
                "resources/css/about.css",
                "resources/css/account.css",
                "resources/css/agb.css",
                "resources/css/contacts.css",
                "resources/css/datenschutz.css",
                "resources/css/impression.css",
                "resources/scss/app.scss",
                "resources/js/app.js",
                "resources/js/metrics.js",
                "resources/js/index.js",
                "resources/js/account.js",
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
