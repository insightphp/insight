export type Component<T = object> = T & {
  _component: {
    name: string
  }
}
