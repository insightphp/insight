import {defineConfig} from "vite";
import * as path from 'path'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    vue()
  ],
  build: {
    manifest: true,
    lib: {
      entry: path.resolve(__dirname, 'resources/js/main.ts'),
      name: 'Elements',
      fileName: format => `elements.${format}.js`,
    },
    rollupOptions: {
      external: ['vue', '@insightphp/inertia-view', '@inertiajs/inertia', '@inertiajs/inertia-vue3'],
      output: {
        globals: {
          vue: 'Vue',
          '@insightphp/inertia-view': 'InertiaView',
          '@inertiajs/inertia': 'Inertia',
          '@inertiajs/inertia-vue3': 'InertiaVue',
        }
      }
    }
  }
})
