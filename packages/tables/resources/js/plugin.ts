import type { App } from "vue";
import { registerComponents } from "@insightphp/inertia-view";

export interface PluginOptions {
  //
}

export default {
  install(app: App, options?: PluginOptions) {
    registerComponents(import.meta.glob('./View/Components/**/*.vue', { eager: true }), 'insight-tables')
  }
}
