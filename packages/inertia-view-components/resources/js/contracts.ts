export type ViewComponent<T> = T & {
  _component: {
    name: string
  }
}
