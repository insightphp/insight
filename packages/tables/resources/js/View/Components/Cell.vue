<script lang="ts">
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";

export default defineComponent({
  props: {
    asHeader: { type: Boolean, required: false, default: false },
    value: { type: Object as PropType<Component|null> }
  },
  setup(props) {
    return () => h(props.asHeader ? 'th' : 'td', props.value ? h(Portal, { component: props.value }) : 'Cell')
  }
})
</script>
