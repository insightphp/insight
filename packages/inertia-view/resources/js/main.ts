import InertiaView from "./plugin";
import type { PluginOptions as InertiaViewPluginOptions } from "./plugin";
import { ComponentManager, registerComponents, resolveNamedComponent } from "./component-manager";
import { PageManager, registerPages, resolvePage } from "./page-manager";
import Portal from './portal'

export * from './contracts'

export {
  InertiaView, InertiaViewPluginOptions,
  registerComponents, resolveNamedComponent,
  registerPages, resolvePage,
  ComponentManager, PageManager,
  Portal
}
