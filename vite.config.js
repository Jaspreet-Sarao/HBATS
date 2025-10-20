import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/style.css', 
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/admission.js',
                'resources/js/discharge.js',
                'resources/js/passcode.js',
                'resources/js/dashboard.js'
            ],
            refresh: true,
        }),
    ],
});
