<script lang="ts">
import type { Component } from "@insightphp/inertia-view";
import type { Components } from "./index";
import { Portal } from "@insightphp/inertia-view";
import { defineComponent, h } from "vue";
import type { PropType } from "vue";

export default defineComponent({
  props: {
    cells: { type: Object as PropType<Array<Component<Components.Cell>>>, required: true }
  },
  setup(props) {
    return () => h('thead', {}, h('tr', {}, props.cells.map(it => h(Portal, { component: it }))))
  }
})
</script>
