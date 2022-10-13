import { computed, reactive } from "vue";

export interface RowSelection {
  id: string|number
  selected: boolean
}

export declare type RowSelectionSummary = 'everything' | 'something' | 'nothing'

export function useRowSelection(identifiers: Array<string|number> = []) {
  const selections = reactive<Array<RowSelection>>([])

  const resetSelections = (identifiers: Array<string|number>) => {
    if (selections.length > 0) {
      selections.splice(0, selections.length)
    }

    selections.push(...identifiers.map(it => ({ id: it, selected: false })))
  }

  resetSelections(identifiers)

  const selectionSummary = computed<RowSelectionSummary>(() => {
    if (selections.length == 0) {
      return 'nothing'
    }

    if (selections.every(it => it.selected)) {
      return 'everything'
    }

    if (selections.some(it => it.selected)) {
      return 'something'
    }

    return 'nothing'
  })

  const selectEverything = () => {
    selections.forEach(it => it.selected = true)
  }

  const selectNothing = () => {
    selections.forEach(it => it.selected = false)
  }

  const selectedRows = computed(() => selections.filter(it => it.selected).map(it => it.id))

  return { selections, resetSelections, selectionSummary, selectEverything, selectNothing, selectedRows }
}
