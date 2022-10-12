<script lang="ts">
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";

export default defineComponent({
  props: {
    asHeader: { type: Boolean, required: false, default: false },
    value: { type: Object as PropType<Component|null> },
    align: { type: String as PropType<'left' | 'right' | 'center'>, default: 'left' }
  },
  setup(props, { slots }) {
    const tag = props.asHeader ? 'th' : 'td'

    const cellProps = {
      class: [ { 'left': 'text-left', 'right': 'text-right', 'center': 'text-center' }[props.align || 'left'] ]
    }

    if (props.value) {
      return () => h(tag, cellProps, h(Portal, { component: props.value }))
    }

    return () => h(tag, cellProps, slots)
  }
})
</script>
