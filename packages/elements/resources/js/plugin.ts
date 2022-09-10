import type { App } from "vue";
import {ViewComponentManager} from "@insightphp/inertia-view-components";

export interface PluginOptions {
  //
}

export default {
  install(app: App, options?: PluginOptions) {
    ViewComponentManager.registerComponentsInNamespace(
      import.meta.globEager('./Components/**/*.vue'), './Components', 'insight-elements',
    )
  }
}
