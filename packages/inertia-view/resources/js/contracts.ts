export type Component<T = object> = T & {
  _component: {
    name: string
  }
}

// TODO: This type is probably wrong.
export declare type ComponentDef = Promise<any> | (() => Promise<any>)|any

export declare type ComponentMap = Record<string, ComponentDef>
