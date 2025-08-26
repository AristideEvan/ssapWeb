import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import vue from '@vitejs/plugin-vue';  // Import du plugin Vue

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/xlab.js',
            ],
            refresh: true,
        }),
        // vue(),
    ],
    // server: {
    //     port: 8000
    // }
});
