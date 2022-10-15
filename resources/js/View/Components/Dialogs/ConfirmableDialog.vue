<template>
  <DialogPanel class="flex relative flex-col w-full max-w-lg transform overflow-hidden rounded-xl bg-white p-6 text-left align-middle shadow-xl transition-all">
    <button @click.prevent="close" class="absolute right-4 top-4 text-gray-600 hover:text-gray-700 transition-colors duration-300"><XMarkIcon class="w-4 h-4" /></button>
    <div class="inline-flex flex-row gap-3">
      <div v-if="icon" class="w-10 h-10 flex-shrink-0 flex items-center justify-center">
        <div :class="[`bg-${look}-50`]" class="w-10 h-10 absolute rounded-full"></div>
        <div :class="[`bg-${look}-100`]" class="w-6 h-6 absolute rounded-full"></div>
        <Portal :class="[`text-${look}-600`]" class="absolute" :component="icon" />
      </div>

      <div class="inline-flex flex-col">
        <DialogTitle class="font-semibold text-gray-900 text-lg">{{ title }}</DialogTitle>
        <DialogDescription class="text-gray-600 text-sm mt-1" v-if="message">{{ message }}</DialogDescription>
      </div>
    </div>
    <div class="inline-flex flex-row-reverse self-end gap-3 mt-4">
      <Portal v-if="confirmUsing" :component="confirmUsing" @success="onConfirmSuccess" />
      <button v-else @click.prevent="close" class="btn" :class="[look]">{{ confirmLabel }}</button>

      <button @click.prevent="close" class="btn">{{ cancelLabel }}</button>
    </div>
  </DialogPanel>
</template>

<script setup lang="ts">
import { XMarkIcon } from "@heroicons/vue/24/solid";
import { DialogPanel, DialogTitle, DialogDescription } from "@headlessui/vue";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import type { Components } from "@insightphp/elements";

const props = withDefaults(defineProps<{
  title: string
  message?: string|null
  icon?: Component|null
  confirmLabel: string
  cancelLabel: string
  look?: string
  close: () => void
  confirmUsing?: Component<Components.Link>
}>(), {
  look: 'primary'
})

const onConfirmSuccess = () => {
  props.close()
}
</script>
