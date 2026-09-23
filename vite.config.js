import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// The Blade layouts load `public/css/style.css` directly and do not use @vite,
// so JS is the only bundled entry. Tailwind and the Bunny font plugin were
// configured but unused, and the CSS entry pointed at a file that never existed.
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: [
                'resources/views/**',
                'public/css/style.css',
            ],
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
