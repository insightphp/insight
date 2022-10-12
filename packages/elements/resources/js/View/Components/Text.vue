<!-- text-gray-600 text-gray-900 -->
<script lang="ts">
import { defineComponent, h, mergeProps } from "vue";
import type { PropType } from "vue";

export default defineComponent({
  props: {
    as: { type: String, default: 'span'},
    value: { type: String, required: false },
    asHtml: { type: Boolean, required: false, default: false },
    color: { type: String as PropType<'primary' | 'secondary'>, default: 'primary' }
  },
  setup(props, { slots }) {
    return () => {
      let { as: renderAs, asHtml, value, color, ...otherProps } = props

      const resolveColorClass = () => {
        if (color == 'primary') {
          return 'text-gray-900'
        }

        return 'text-gray-600'
      }

      const finalProps = mergeProps(otherProps, {
        class: [ resolveColorClass() ]
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
