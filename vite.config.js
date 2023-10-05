import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            // other configurations...
        }),
    ],
    build: {
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                collaborator: 'resources/js/collaborator.js'
            }
        }
    }
});
