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
      name: 'Forms',
      fileName: format => `forms.${format}.js`,
    },
    rollupOptions: {
      external: ['vue', '@insightphp/inertia-view-components'],
      output: {
        globals: {
          vue: 'Vue',
          '@insightphp/inertia-view-components': 'InertiaViewComponents',
        }
      }
    }
  }
})
