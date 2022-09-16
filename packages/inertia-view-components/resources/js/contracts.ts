export type ViewComponent<T = object> = T & {
  _component: {
    name: string
  }
}
