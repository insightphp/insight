import type { ViewComponent } from "@insightphp/inertia-view-components";

export interface FormModel<InitialValue = { [key: string]: any }, ViewComponentProps = any> {
  initialValue: InitialValue
  action: string|null
  method: 'post'|'put'|'patch'|'delete'|null
  renderAs: ViewComponent<ViewComponentProps>
}
