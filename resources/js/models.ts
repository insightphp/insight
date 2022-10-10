import type { Component } from '@insightphp/inertia-view'
import type { Components } from '@insightphp/elements'

export namespace Models {

  export interface Navigation {
    items: Array<NavigationItem>
  }

  export interface NavigationItem {
    link: Component<Components.Link>
    childNavigation: Navigation|null
  }

  export interface User {
    name: string|null
    profilePhotoUrl: string|null
    shouldShowName: boolean
  }

}
