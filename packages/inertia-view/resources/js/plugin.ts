import type { App } from "vue";
import type { ComponentMap } from "./contracts";
import { registerComponents } from "./component-manager";
import { registerPages } from "./page-manager";

export interface PluginOptions {
  components?: Record<string, Array<ComponentMap>|ComponentMap>
  pages?: Record<string, Array<ComponentMap>|ComponentMap>
}

export default {
  install(app: App, options?: PluginOptions): any {
    if (options?.components) {
      Object.keys(options.components).forEach(namespace => {
        registerComponents(options.components![namespace], namespace)
      })
    }

    if (options?.pages) {
      Object.keys(options.pages).forEach(namespace => {
        registerPages(options.pages![namespace], namespace)
      })
    }
  }
}
