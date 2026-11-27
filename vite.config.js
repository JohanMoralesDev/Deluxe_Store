import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // Los recursos fuente existentes están en public/assets; se conservan
    // allí y Vite publica sus compilados en public/build.
    publicDir: false,
    plugins: [
        laravel({
            input: [
                'public/assets/css/style.css',
                'public/assets/css/carrito.css',
                'public/assets/css/catalogo.css',
                'public/assets/css/nuevo.css',
                'public/assets/css/admin.css',
                'public/assets/css/auth.css',
                'public/assets/css/assistant.css',
                'public/assets/js/script.js',
                'public/assets/js/admin.js',
                'public/assets/js/assistant.js',
            ],
            refresh: true,
        }),
    ],
});
