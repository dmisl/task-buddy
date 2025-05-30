import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';


export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/login.css',
                'resources/css/home.css',
                'resources/css/style.css',
                'resources/js/app.js',
                'resources/js/emoji.js',
                'resources/js/placeholders.js',
                'resources/js/goalCreate.js',
                'resources/css/goalShow.css',
            ],
            refresh: true,
        }),
    ],
});
