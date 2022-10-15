<template>
  <TransitionRoot appear :show="visible" as="template" @afterLeave="emit('closed')">
    <Dialog as="div" @close="emit('close')" class="relative z-50">
      <TransitionChild
          as="template"
          enter="duration-200 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild
              as="template"
              enter="duration-200 ease-out"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
          >
            <slot />
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup lang="ts">
import { Dialog, TransitionChild, TransitionRoot } from '@headlessui/vue'

const emit = defineEmits(['close', 'closed'])

defineProps<{
  visible: boolean
}>()
</script>
