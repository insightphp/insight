import type { Component } from '@insightphp/inertia-view'
import type { Components as ElementComponents } from '@insightphp/elements'
import type { Components as TableComponents } from '@insightphp/tables'

export namespace Models {

  export interface Navigation {
    items: Array<NavigationItem>
  }

  export interface NavigationItem {
    link: Component<ElementComponents.Link>
    childNavigation: Navigation|null
  }

  export interface User {
    name: string|null
    profilePhotoUrl: string|null
    shouldShowName: boolean
  }

}

export namespace Pages {

  export interface ListResourcesPage {
    resources: Component<TableComponents.Table>|null
  }

}
