<script lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import { defineComponent, h, mergeProps, ref, watch } from "vue";

function createSvgElement(name: string, icons?: Record<string, string>) {
  const source = icons ? icons[name] : undefined
  if (! source) {
    throw new Error(`The Heroicon [${name}] could not be rendered. Source is missing.`)
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
  return svgProps
}

export default defineComponent({
  props: {
    fullName: { type: String, required: true },
    dimensions: { type: String, required: true },
  },
  setup(props) {
    const page = usePage<{
      _heroicons?: Record<string, string>
    }>()

    const svg = ref(createSvgElement(props.fullName, page.props.value._heroicons))

    watch(props, newProps => {
      svg.value = createSvgElement(newProps.fullName, page.props.value._heroicons)
    })

    return () => h('svg', mergeProps(svg.value, { class: props.dimensions }))
  }
})
</script>
