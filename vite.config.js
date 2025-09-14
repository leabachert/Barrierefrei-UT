import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/styles.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        VitePWA({
            registerType: 'autoUpdate',
            manifest: {
                name: 'Barrierefrei@UT',
                short_name: 'Barrierefrei@UT',
                start_url: '/',
                scope: '/',
                workbox: {
                    navigateFallback: '/',
                },
                display: 'standalone',
                background_color: '#f0ebe0',
                theme_color: '#c7c1b5ff',
                icons: [
                    {
                        src: '/app-icons/icon-192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: '/app-icons/icon-512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    }
                ]
            }
        })
    ]
});

