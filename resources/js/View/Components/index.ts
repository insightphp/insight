import type { Component } from "@insightphp/inertia-view";
import type { InitialValue } from "../../Composables/use-filter";

export { default as Filter } from './Filter.vue'
export { default as Header } from './Header.vue'
export { default as Heroicon } from './Heroicon.vue'
export { default as HeaderNavigation } from './HeaderNavigation.vue'

export namespace Components {

  export interface Filter {
    filterables: Array<Component<Filterable>>
    initialValue: InitialValue
  }

  export interface Filterable {
    id: string
    title: string
  }

}
