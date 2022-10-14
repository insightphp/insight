<script lang="ts">
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import { SortableHeader } from "../../Components";

export default defineComponent({
  emits: ['updateSortAs'],
  props: {
    asHeader: { type: Boolean, required: false, default: false },
    value: { type: Object as PropType<Component|null> },
    align: { type: String as PropType<'left' | 'right' | 'center'>, default: 'left' },
    sortableAs: { type: String, required: false },
    sortedAs: { type: String, required: false },
    defaultSortAs: { type: String, required: false },
    defaultSortDirection: { type: String as PropType<'asc' | 'desc'>, required: false },
  },
  setup(props, { slots, emit }) {
    const tag = props.asHeader ? 'th' : 'td'

    const cellProps = {
      class: [ { 'left': 'text-left', 'right': 'text-right', 'center': 'text-center' }[props.align || 'left'] ]
    }

    if (props.value) {
      if (props.sortableAs) {
        // @ts-ignore TODO: There is some ts error...
        return () => h(tag, cellProps, h(SortableHeader, {
          sortableAs: props.sortableAs,
          sortedAs: props.sortedAs,
          defaultSortAs: props.defaultSortAs,
          defaultSortDirection: props.defaultSortDirection,
          onUpdateSortAs: (event: string) => emit('updateSortAs', event)
        }, () => h(Portal, { component: props.value })))
      } else {
        return () => h(tag, cellProps, h(Portal, { component: props.value }))
      }
    }

    return () => h(tag, cellProps, slots)
  }
})
</script>
