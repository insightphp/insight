<template>
  <DialogScreen :visible="isVisible" @close="close" @closed="showNextDialog">
    <Portal v-if="dialog" :component="dialog" />
  </DialogScreen>
</template>

<script setup lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import { watch } from 'vue'
import { useDialogQueue } from "../Composables/use-dialog-queue";
import DialogScreen from "./DialogScreen.vue";

const page = usePage<{
  _dialog?: Component<{ id?: string }>|null
}>()

const {
  pushDialogComponent,
  isVisible,
  close,
  dialog,
  showNextDialog
} = useDialogQueue()

const handleDialog = (dialog: Component<{ id?: string }>|null) => {
  if (dialog) {
    pushDialogComponent(dialog)
  }
}

watch(page.props, newProps => {
  handleDialog(newProps._dialog || null)
})

handleDialog(page.props.value._dialog || null)
</script>
