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
      name: 'Insight',
      fileName: format => `insight.${format}.js`,
    },
    rollupOptions: {
      external: ['vue', '@inertiajs/inertia', '@inertiajs/inertia-vue3', '@insightphp/inertia-view'],
      output: {
        globals: {
          vue: 'Vue',
          '@inertiajs/inertia': 'Inertia',
          '@inertiajs/inertia-vue3': 'InertiaVue',
          '@insightphp/inertia-view': 'InertiaView',
        }
      }
    }
  }
})
