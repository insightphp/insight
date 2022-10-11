<script lang="ts">
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import type { Components } from "./index";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";

export default defineComponent({
  props: {
    header: { type: Object as PropType<Component<Components.Header>|null>, required: false },
    footer: { type: Object as PropType<Component<Components.Footer>|null>, required: false },
    rows: { type: Object as PropType<Array<Component<Components.Row>>>, required: false }
  },


  setup(props) {
    return () => h('table', {}, [
        h(Portal, { component: props.header }),
        h('tbody', (props.rows || []).map(it => h(Portal, { component: it }))),
        props.footer ? h(Portal, { component: props.footer }) : undefined,
    ])
  }
})
</script>
