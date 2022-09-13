<script lang="ts">
import { defineComponent, h } from "vue";
import BreadcrumbSeparator from './BreadcrumbSeparator.vue'

export default defineComponent({
  props: { skipFirst: { type: Boolean, default: false } },
  setup(props, { slots }) {
    const children: Array<any> = []
    if (slots.default) {
      const defaultSlot = slots.default()

      const renderSeparator = () => {
        if (slots.separator) {
          return h(slots.separator)
        }

        return h(BreadcrumbSeparator)
      }

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

    const newProps: any = { ...props }

    if (newProps.class) {
      newProps.class = ['breadcrumbs', newProps.class]
    } else {
      newProps.class = 'breadcrumbs'
    }

    return () => h('ul', newProps, children)
  }
})
</script>
