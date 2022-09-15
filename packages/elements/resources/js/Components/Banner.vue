<template>
<div class="banner flex flex-row relative" v-if="shouldShow">
  <slot v-if="dismissable" name="dismiss" v-bind="{ dismiss }">
    <button @click.prevent="dismiss" class="absolute top-2 right-2 z-10">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </slot>
  <div v-if="hasIcon" class="mr-3">
    <slot name="icon" />
  </div>
  <div class="flex flex-col">
    <slot />
  </div>
</div>
</template>

<script setup lang="ts">
import { computed, ref, useSlots } from "vue";

const emit = defineEmits(['dismiss'])

const props = defineProps<{
  dismissable?: boolean
  static?: boolean
}>()

const slots = useSlots()

const isVisible = ref(true)

const hasIcon = computed(() => !!slots.icon)

const shouldShow = computed(() => props.static === true ? true : isVisible.value)

function dismiss() {
  if (props.static) {
    emit('dismiss')
  } else {
    isVisible.value = false
  }
}
</script>
