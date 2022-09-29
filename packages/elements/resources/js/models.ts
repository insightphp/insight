export namespace Models {

  export interface LinkActivatedOnRoute {
    route: string
    params: Record<string, string|number>|Array<string|number>
  }

  export interface LinkActivation {
    activatedOnRoutes: Array<LinkActivatedOnRoute>
    activatedOnLocations: Array<string>
  }

}
