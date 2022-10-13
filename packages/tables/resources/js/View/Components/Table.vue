<script lang="ts">
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import type { Components } from "./index";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import type { RowSelectionSummary, RowSelection } from "../../Composables";

export default defineComponent({
  emits: ['selectEverything', 'selectNothing'],
  props: {
    header: { type: Object as PropType<Component<Components.Header>|null>, required: false },
    footer: { type: Object as PropType<Component<Components.Footer>|null>, required: false },
    rows: { type: Object as PropType<Array<Component<Components.Row>>>, required: false },
    selections: { type: Object as PropType<Array<RowSelection>>, required: false },
    selectionSummary: { type: String as PropType<RowSelectionSummary>, required: false },
    enableBulkSelection: { type: Boolean, default: false, required: false },
  },
  setup(props, { emit, attrs }) {
    const rows = props.rows || []

    const renderHeader = (header: Component<Components.Header>) => {
      return h(Portal, {
        component: header,
        selectionSummary: props.enableBulkSelection ? props.selectionSummary : undefined,
        onSelectEverything: () => emit('selectEverything'),
        onSelectNothing: () => emit('selectNothing')
      })
    }

    const renderRow = (row: Component<Components.Row>, index: number) => {
      if (props.enableBulkSelection) {
        if (!props.selections || props.selections.length != rows.length) {
          throw new Error("The bulk selection is enabled, however no selections have been passed to the table.")
        }
      }

      return h(Portal, {
        component: row,
        selection: props.enableBulkSelection ? props.selections![index] : undefined
      })
    }

    return () => h('table', {}, [
        props.header ? renderHeader(props.header) : undefined,
        h('tbody', rows.map((it, idx) => renderRow(it, idx))),
        props.footer ? h(Portal, { component: props.footer }) : undefined,
    ])
  }
})
</script>
