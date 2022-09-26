import type { App } from "vue";
import type { ComponentMap } from "./contracts";
import ComponentManager from "./component-manager";

export interface PluginOptions {
  components?: Record<string, Array<ComponentMap>|ComponentMap>
}

export default {
  install(app: App, options?: PluginOptions): any {
    if (options?.components) {
      Object.keys(options.components).forEach(namespace => {
        const value = options.components![namespace]

        if (Array.isArray(value)) {
          value.forEach(componentMap => ComponentManager.addComponents(componentMap, namespace))
        } else {
          ComponentManager.addComponents(value, namespace)
        }
      })
    }
  }
}
