import type { Component } from "@insightphp/inertia-view";
import { ref } from "vue";

export type DialogComponent = Component<{ id?: string }>

const dialog = ref<DialogComponent|null>(null)
const isVisible = ref<boolean>(false)
const displayedDialogs: Array<string> = []
const pendingDialogs: Array<DialogComponent> = []

export function useDialogQueue() {
  const pushDialogComponent = (dialog: DialogComponent, ignoreSameDialog: boolean = false) => {
    if (! dialog.id) {
      console.warn("The dialog does not have identifier. Does the dialog extend the Dialog component?")
      return
    }

    if (displayedDialogs.includes(dialog.id) && !ignoreSameDialog) {
      return
    }

    pendingDialogs.push(dialog)
    showNextDialog()
  }

  const showNextDialog = () => {
    // If there is currently visible dialog
    // we won't display the next dialog.
    if (isVisible.value) {
      return
    }

    // If there are no pending dialogs, we just skip the dialog.
    if (pendingDialogs.length <= 0) {
      return
    }

    const nextDialog = pendingDialogs.shift()
    if (nextDialog) {
      dialog.value = nextDialog
      displayedDialogs.push(nextDialog.id!)
      isVisible.value = true
    }
  }

  const close = () => {
    isVisible.value = false
  }

  return {
    pushDialogComponent,
    showNextDialog,
    dialog,
    close,
    isVisible
  }
}
