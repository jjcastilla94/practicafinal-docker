 import { defineConfig } from 'vite';
 import laravel from 'laravel-vite-plugin';
 import vue from '@vitejs/plugin-vue';  // Importamos plugin de Vue
 import tailwindcss from '@tailwindcss/vite';

 export default defineConfig({
     plugins: [
         laravel({
             input: [
                 'resources/css/app.css',
                 'resources/js/app.js',
             ],
             refresh: true,
         }),
         vue(),         // Añadimos soporte para .vue
         tailwindcss(),
     ],
     resolve: {
         alias: {
             'vue': 'vue/dist/vue.esm-bundler.js',
         },
     },    
 });