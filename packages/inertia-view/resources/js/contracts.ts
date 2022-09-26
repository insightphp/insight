export type Component<T = object> = T & {
  _component: {
    name: string
  }
}

export declare type ComponentDef = Promise<any> | (() => Promise<any>)

export declare type ComponentMap = Record<string, ComponentDef>
