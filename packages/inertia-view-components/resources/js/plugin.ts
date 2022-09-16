import type { App } from "vue";
import ComponentManager from "./component-manager";

export interface PluginOptions {
  components?: Record<string, Record<string, Record<string, Promise<any> | (() => Promise<any>)>>>
}

export default {
  install(app: App, options?: PluginOptions): any {
    if (options?.components) {
      Object.keys(options.components).forEach(namespace => {
        Object.keys(options.components![namespace]).forEach(basePath => {
          ComponentManager.registerComponentsInNamespace(options.components![namespace][basePath], basePath, namespace)
        })
      })
    }
  }
}
