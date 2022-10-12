<script lang="ts">
import type { Component } from "@insightphp/inertia-view";
import type { Components } from "./index";
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import { Portal } from "@insightphp/inertia-view";
import { RowSelect } from "../../Components";
import type { RowSelection } from "../../Composables";

export default defineComponent({
  props: {
    id: { type: undefined as unknown as PropType<string|number>, required: false },
    cells: { type: Object as PropType<Array<Component<Components.Cell>>>, required: true },
    selection: { type: Object as PropType<RowSelection>, required: false}
  },
  setup(props) {
    return () => {
      const rowSelect = h(RowSelect, {
        selection: props.selection
      })

      return h('tr', [rowSelect, ...props.cells.map(it => h(Portal, { component: it }))])
    }
  }
})
</script>
