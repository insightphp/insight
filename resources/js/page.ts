import { h, defineComponent } from "vue";

export default defineComponent({
  setup(props, { slots }) {
    return () => slots
  }
})
