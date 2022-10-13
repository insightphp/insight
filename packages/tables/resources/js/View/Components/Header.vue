<script lang="ts">
import type { Component } from "@insightphp/inertia-view";
import type { Components } from "./index";
import { Portal } from "@insightphp/inertia-view";
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import { HeaderRowSelect } from "../../Components";
import type { RowSelectionSummary } from "../../Composables";

export default defineComponent({
  emits: ['selectNothing', 'selectEverything'],
  props: {
    cells: { type: Object as PropType<Array<Component<Components.Cell>>>, required: true },
    selectionSummary: { type: String as PropType<RowSelectionSummary>, required: false },
  },
  setup(props, { emit }) {
    return () => {
      let cells = props.cells.map(it => h(Portal, { component: it }))

      // If the bulk selection is enabled, we will also prepend Header Row selector
      // to easily select or unselect all rows within the table.
      if (props.selectionSummary) {
        cells.unshift(h(HeaderRowSelect, {
          selectionSummary: props.selectionSummary,
          onSelectNothing: () => emit('selectNothing'),
          onSelectEverything: () => emit('selectEverything')
        }))
      }

      return h('thead', {}, h('tr', {}, cells))
    }
  }
})
</script>
