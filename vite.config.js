import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        if (id.includes('alpinejs')) {
                            return 'alpine'; // Separate Alpine.js
                        }
                        if (id.includes('preline')) {
                            return 'preline'; // Separate Preline UI
                        }
                        return 'vendor'; // Other vendor dependencies
                    }
                },
            },
        },
        chunkSizeWarningLimit: 1000, // Increase limit to suppress warning
    },
});
