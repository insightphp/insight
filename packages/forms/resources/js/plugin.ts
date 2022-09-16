import type { App } from "vue";
import { ComponentManager } from "@insightphp/inertia-view-components";

export interface PluginOptions {
  //
}

export default {
  install(app: App, options?: PluginOptions) {
    ComponentManager.registerComponentsInNamespace(
      import.meta.globEager('./Components/**/*.vue'), './Components', 'insight-forms',
    )
  }
}
