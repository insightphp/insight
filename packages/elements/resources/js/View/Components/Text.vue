<script lang="ts">
import { defineComponent, h, mergeProps } from "vue";
import type { PropType } from "vue";

export default defineComponent({
  props: {
    as: { type: String, default: 'span'},
    value: { type: String, required: false },
    asHtml: { type: Boolean, required: false, default: false },
    color: { type: String as PropType<'primary' | 'secondary'>,  required: false },
    size: { type: String as PropType<'small' | null>, required: false }
  },
  setup(props, { slots }) {
    return () => {
      let { as: renderAs, asHtml, value, color, size, ...otherProps } = props

      const resolveColorClass = () => {
        if (color == 'primary') {
          return 'text-gray-900'
        } else if (color == 'secondary') {
          return 'text-gray-600'
        }

        return {}
      }

      const resolveSizeClass = () => {
        if (size === 'small') {
          return 'text-sm';
        }

        return {}
      }

      const finalProps = mergeProps(otherProps, {
        class: [ resolveColorClass(), resolveSizeClass() ]
      })

      if (value) {
        if (asHtml) {
          return h(renderAs, mergeProps({
            innerHTML: value
          }, finalProps))
        }

        return h(renderAs, finalProps, value)
      }

      return h(renderAs, finalProps, slots)
    }
  }
})
</script>
