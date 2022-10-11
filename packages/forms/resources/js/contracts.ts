import type { Component } from "@insightphp/inertia-view";

export interface FormModel<InitialValue = { [key: string]: any }, ViewComponentProps = any> {
  initialValue: InitialValue
  action: string|null
  method: 'post'|'put'|'patch'|'delete'|null
  renderAs: Component<ViewComponentProps>
}
