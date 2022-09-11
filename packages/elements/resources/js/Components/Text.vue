<script lang="ts">
import { h, defineComponent } from "vue";

export default defineComponent({
  props: { as: { type: [String], default: 'span'} },
  setup(props, { slots }) {
    let { as: renderAs, ...otherProps } = props

    return () => h(renderAs, otherProps, slots)
  }
})
</script>
