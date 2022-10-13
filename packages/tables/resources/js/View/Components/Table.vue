<script lang="ts">
import type { PropType } from "vue";
import { defineComponent, h } from "vue";
import type { Components } from "./index";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import type { RowSelection, RowSelectionSummary } from "../../Composables";

export default defineComponent({
  emits: ['selectEverything', 'selectNothing', 'updateSortAs'],
  props: {
    header: { type: Object as PropType<Component<Components.Header>|null>, required: false },
    footer: { type: Object as PropType<Component<Components.Footer>|null>, required: false },
    rows: { type: Object as PropType<Array<Component<Components.Row>>>, required: false },
    selections: { type: Object as PropType<Array<RowSelection>>, required: false },
    selectionSummary: { type: String as PropType<RowSelectionSummary>, required: false },
    enableBulkSelection: { type: Boolean, default: false, required: false },
    sortedAs: { type: String, required: false },
    defaultSortAs: { type: String, required: false },
    defaultSortDirection: { type: String as PropType<'asc' | 'desc'>, required: false },
  },
  setup(props, { emit }) {
    const renderHeader = (header: Component<Components.Header>) => {
      return h(Portal, {
        component: header,
        sortedAs: props.sortedAs,
        defaultSortAs: props.defaultSortAs,
        defaultSortDirection: props.defaultSortDirection,
        selectionSummary: props.enableBulkSelection ? props.selectionSummary : undefined,
        onSelectEverything: () => emit('selectEverything'),
        onSelectNothing: () => emit('selectNothing'),
        onUpdateSortAs: (event: string) => emit('updateSortAs', event)
      })
    }

    const renderRow = (row: Component<Components.Row>, index: number) => {
      return h(Portal, {
        component: row,
        selection: props.enableBulkSelection && props.selections && index <= props.selections.length - 1 ? props.selections[index] : undefined
      })
    }

    return () => {
      const renderedRows = (props.rows || []).map((it, idx) => renderRow(it, idx))

      return h('table', {}, [
        props.header ? renderHeader(props.header) : undefined,
        h('tbody', renderedRows),
        props.footer ? h(Portal, { component: props.footer }) : undefined,
      ])
    }
  }
})
</script>
