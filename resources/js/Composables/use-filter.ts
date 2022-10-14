import type { Components } from "../View/Components";
import type { UnwrapNestedRefs } from "vue";
import { reactive } from "vue";

export interface FilterableState {
  selected: boolean
  value: any
}

export type InitialValue = Record<string, FilterableState>

export type FilterState = Record<string, FilterableState>

export function useFilter(filterables: Array<Components.Filterable>, initialValue: InitialValue): UnwrapNestedRefs<FilterState> {
  const state: FilterState = {}

  filterables.forEach(filterable => {
    state[filterable.id] = {
      selected: initialValue[filterable.id].selected,
      value: initialValue[filterable.id].value
    }
  })

  return reactive(state)
}
