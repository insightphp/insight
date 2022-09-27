import { Insight } from "./insight";
import type { InsightApp } from "./insight";
import { registerComponents, registerPages } from "@insightphp/inertia-view";

export interface ConfigureInsight {
  //
}

/**
 * Creates new Insight application.
 */
export function bootInsight(config: Partial<ConfigureInsight> = {}): InsightApp {
  registerPages(import.meta.glob('./Pages/**/*Page.vue'), 'insight')
  registerComponents(import.meta.glob('./Components/**/*.vue', { eager: true }), 'insight')
  return Insight
}
