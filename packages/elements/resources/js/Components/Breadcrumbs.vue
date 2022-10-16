<script lang="ts">
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import BreadcrumbSeparator from './BreadcrumbSeparator.vue'
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";

export default defineComponent({
  props: {
    skipFirst: { type: Boolean, default: false },
    items: { type: Object as PropType<Array<Component>>, required: false }
  },
  setup(props, { slots }) {
    const children: Array<any> = []

    const { items, ...remainingProps } = props

    const renderSeparator = () => {
      if (slots.separator) {
        return h(slots.separator)
      }

      return h(BreadcrumbSeparator)
    }

    if (Array.isArray(items)) {
      items.forEach((component, index) => {
        const listItemProps: any = {}

        if (index + 1 == items.length) {
          listItemProps['data-breadcrumb-current'] = 'current'
        }

        if (index < items.length - 1 && !(index == 0 && props.skipFirst)) {
          children.push(h('li', listItemProps, [h(Portal, { component }), renderSeparator()]))
        } else {
          children.push(h('li', listItemProps, h(Portal, { component })))
        }
      })
    } else if (slots.default) {
      const defaultSlot = slots.default()

       if (Array.isArray(defaultSlot)) {
        const directChildren = Array.from(defaultSlot)
        directChildren.forEach((node: any, index) => {
          const listItemProps: any = {}

          if (index + 1 == directChildren.length) {
            listItemProps['data-breadcrumb-current'] = 'current'
          }

          if (index < directChildren.length - 1 && !(index == 0 && props.skipFirst)) {
            children.push(h('li', listItemProps, [node, renderSeparator()]))
          } else {
            children.push(h('li', listItemProps, node))
          }
        })
      }
    }

    const newProps: any = remainingProps

    if (newProps.class) {
      newProps.class = ['breadcrumbs', newProps.class]
    } else {
      newProps.class = 'breadcrumbs'
    }

    return () => h('ul', newProps, children)
  }
})
</script>
