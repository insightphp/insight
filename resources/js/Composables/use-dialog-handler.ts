import { ref } from "vue";
import type { Ref } from "vue";

export interface DialogHandler {
  visible: Ref<boolean>
  visibleContent: Ref<boolean>
  close: (withContent: boolean) => void
  hideContent: () => void
}

export function useDialogHandler() {
  const visible = ref<boolean>(false)
  const visibleContent = ref<boolean>(false)

  const open = () => {
    visible.value = true
    visibleContent.value = true
  }

  const close = (withContent: boolean = true) => {
    visible.value = false
    if (withContent) {
      hideContent()
    }
  }

  const hideContent = () => {
    visibleContent.value = false
  }

  const dialog: DialogHandler = {
    visible, visibleContent, close, hideContent
  }

  return {
    dialog, open, close, visible
  }
}
