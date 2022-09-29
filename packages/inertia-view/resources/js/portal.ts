import type { PropType } from "vue";
import { defineComponent, h, mergeProps } from "vue";
import type { Component } from "./contracts";
import { resolveNamedComponent } from "./component-manager";
import { usePage } from "@inertiajs/inertia-vue3";

export default defineComponent({
  props: {
    component: { type: Object as PropType<Component<any>>, required: false },
    for: { type: String, required: false },
  },
  setup(props, { slots }) {
    let componentProps = {}
    let inertiaComponent: Component<any>|undefined = undefined

    if (props.component) {
      const { component, for: rm, ...passthroughProps } = props
      const { _component, ...componentDef } = component
      inertiaComponent = _component
      componentProps = mergeProps(passthroughProps, componentDef)
    } else if (props.for) {
      const page = usePage<{
        [key: typeof props.for]: Component
      }>()

      const { _component, ...componentDef } = page.props.value[props.for]

      inertiaComponent = _component
      componentProps = mergeProps(props, componentDef)
    } else {
      throw new Error("The Portal must have either [for] or [component] props set.")
    }

    if (typeof inertiaComponent === 'undefined') {
      throw new Error(`The component is missing _component meta property.`)
    }

    const resolvedComponent = resolveNamedComponent(inertiaComponent.name)

    if (resolvedComponent === undefined) {
      throw new Error(`The component with name [${inertiaComponent.name}] could not be resolved.`)
    }

    if (typeof resolvedComponent == 'function') {
      throw new Error(`The component is not loaded synchronously. Components renered within Portal must not be async components. Use import.meta.glob('path', { eager: true }) to import components synchronously.`)
    }

    return () => h(resolvedComponent.default, componentProps, slots)
  }
})
