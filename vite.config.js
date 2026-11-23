import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'assets/css/style.css',
                'assets/css/Carrito.css',
                'assets/css/Catalogo.css',
                'assets/css/Nuevo.css',
                'assets/css/admin.css',
                'assets/js/script.js',
                'assets/js/carrito.js',
                'assets/js/admin.js',
            ],
            refresh: true,
        }),
    ],
});
