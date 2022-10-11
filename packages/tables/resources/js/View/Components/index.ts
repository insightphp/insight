import type { Component } from "@insightphp/inertia-view";

export { default as Cell } from './Cell.vue'
export { default as Footer } from './Footer.vue'
export { default as Header } from './Header.vue'
export { default as Row } from './Row.vue'
export { default as Table } from './Table.vue'

export namespace Components {
  export interface Table {
    header: Component<Components.Header>|null
    footer: Component<Components.Footer>|null
    rows: Array<Component<Components.Row>>
  }

  export interface Cell {
    asHeader: boolean
  }

  export interface Footer {
    cells: Array<Component<Components.Cell>>
  }

  export interface Row {
    cells: Array<Component<Components.Cell>>
  }

  export interface Header {
    cells: Array<Component<Components.Cell>>
  }

}
