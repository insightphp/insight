<script lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import { defineComponent, h, mergeProps } from "vue";

export default defineComponent({
  props: {
    fullName: { type: String, required: true },
    dimensions: { type: String, required: true },
  },
  setup(props) {
    const page = usePage<{
      _heroicons?: Record<string, string>
    }>()

    const source = page.props.value._heroicons ? page.props.value._heroicons[props.fullName] : undefined

    if (! source) {
      throw new Error("The Heroicon could not be rendered. Source is missing.")
    }

    const template = document.createElement('template')
    template.innerHTML = source
    const svg = template.content.firstChild as HTMLElement
    const svgProps: Record<string, string|null> = {}
    Array.from(svg.getAttributeNames()).forEach(attribute => {
      if (attribute) {
        svgProps[attribute] = svg.getAttribute(attribute)
      }
    })
    svgProps['innerHTML'] = svg.innerHTML

    return () => h('svg', mergeProps(svgProps, { class: props.dimensions }))
  }
})
</script>
