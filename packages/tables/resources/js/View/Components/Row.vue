<script lang="ts">
import type { Component } from "@insightphp/inertia-view";
import type { Components } from "./index";
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import { Portal } from "@insightphp/inertia-view";

export default defineComponent({
  props: {
    cells: { type: Object as PropType<Array<Component<Components.Cell>>>, required: true }
  },
  setup(props) {
    return () => h('tr', props.cells.map(it => h(Portal, { component: it })))
  }
})
</script>
