import { defineComponent, h } from "vue";
import type { PropType } from "vue"
import type { ViewComponent } from "./contracts";

export default defineComponent({
  props: {
    component: { type: Object as PropType<ViewComponent<any>>, required: false },
    for: { type: String, required: false }
  },
  setup(props, { slots }) {
    if (props.component) {
      // return () => h(props.component._component.name)
      return () => h('div', 'component passed')
    }

    if (props.for) {
      return () => h('div', 'prop name passed')
    }

    throw new Error("The Portal must have either [for] or [component] props filled. Nothing was specified.")
  }
})
