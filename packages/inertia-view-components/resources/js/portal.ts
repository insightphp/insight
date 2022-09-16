import { defineComponent, h } from "vue";
import type { PropType } from "vue"
import type { ViewComponent } from "./contracts";
import ComponentManager from "./component-manager";
import { usePage } from "@inertiajs/inertia-vue3";

export default defineComponent({
  props: {
    component: { type: Object as PropType<ViewComponent<any>>, required: false },
    for: { type: String, required: false },
  },
  setup(props, { slots }) {
    if (props.component) {
      const { component, ...passthroughProps } = props
      const { _component, ...componentDef } = component

      return () => h(
        ComponentManager.getComponentWithName(_component.name) as any,
        { ...passthroughProps, ...componentDef },
        slots
      )
    }

    if (props.for) {
      const page = usePage<{
        [key: typeof props.for]: ViewComponent
      }>()

      const { _component, ...componentDef } = page.props.value[props.for]

      return () => h(
        ComponentManager.getComponentWithName(_component.name) as any,
        { ...props, ...componentDef },
        slots
      )
    }

    throw new Error("The Portal must have either [for] or [component] props filled. Nothing was specified.")
  }
})
