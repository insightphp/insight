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
      name: 'InertiaViewComponents',
      fileName: format => `InertiaViewComponents.${format}.js`,
    },
    rollupOptions: {
      external: ['vue', '@inertiajs/inertia-vue3'],
      output: {
        globals: {
          vue: 'Vue',
          '@inertiajs/inertia-vue3': 'InertiaVue',
        }
      }
    }
  }
})
