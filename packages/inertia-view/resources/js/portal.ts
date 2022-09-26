import { defineComponent, h } from "vue";
import type { PropType } from "vue"
import type { Component } from "./contracts";
import { resolveNamedComponent } from "./component-manager";
import { usePage } from "@inertiajs/inertia-vue3";

export default defineComponent({
  props: {
    component: { type: Object as PropType<Component<any>>, required: false },
    for: { type: String, required: false },
  },
  setup(props, { slots }) {
    if (props.component) {
      const { component, ...passthroughProps } = props
      const { _component, ...componentDef } = component

      return () => h(
        resolveNamedComponent(_component.name) as any,
        { ...passthroughProps, ...componentDef },
        slots
      )
    }

    if (props.for) {
      const page = usePage<{
        [key: typeof props.for]: Component
      }>()

      const { _component, ...componentDef } = page.props.value[props.for]

      return () => h(
        resolveNamedComponent(_component.name) as any,
        { ...props, ...componentDef },
        slots
      )
    }

    throw new Error("The Portal must have either [for] or [component] props set.")
  }
})
