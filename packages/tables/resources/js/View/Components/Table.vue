<script lang="ts">
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import type { Components } from "./index";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import { useRowSelection } from "../../Composables";

export default defineComponent({
  props: {
    header: { type: Object as PropType<Component<Components.Header>|null>, required: false },
    footer: { type: Object as PropType<Component<Components.Footer>|null>, required: false },
    rows: { type: Object as PropType<Array<Component<Components.Row>>>, required: false }
  },
  setup(props) {
    const rows = props.rows || []

    const identifiers: Array<string|number> = rows.map((row, index) => {
      if (row.id === null) {
        throw new Error(`Bulk selection is enabled but the row at index [${index}] does not have valid identifier.`)
      }

      return row.id
    })

    const { selections, selectionSummary, selectEverything, selectNothing } = useRowSelection(identifiers)

    const renderHeader = (header: Component<Components.Header>) => {
      return h(Portal, {
        component: header,
        selectionSummary: selectionSummary.value,
        onSelectEverything: () => selectEverything(),
        onSelectNothing: () => selectNothing()
      })
    }

    const renderRow = (row: Component<Components.Row>, index: number) => {
      return h(Portal, { component: row, selection: selections[index] })
    }

    // const testClick = () => {
      //console.log(selections)
    // }

    return () => h('table', {}, [
        // h('button', { onClick: testClick }, 'Peter'),
        props.header ? renderHeader(props.header) : undefined,
        h('tbody', rows.map((it, idx) => renderRow(it, idx))),
        props.footer ? h(Portal, { component: props.footer }) : undefined,
    ])
  }
})
</script>
