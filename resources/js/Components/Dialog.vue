<script lang="ts">
import type { DialogHandler } from "../Composables/use-dialog-handler";
import { defineComponent, h } from "vue";
import type { PropType } from "vue";
import { DialogScreen } from "./index";

export default defineComponent({
  props: {
    dialog: { type: Object as PropType<DialogHandler>, required: true }
  },

  setup(props, { slots }) {
    return () => {
      return h(DialogScreen, {
        visible: props.dialog.visible.value,
        onClose: () => props.dialog.close(false),
        onClosed: () => props.dialog.hideContent(),
      }, props.dialog.visibleContent.value ? slots.default : undefined)
    }
  }
})
</script>
