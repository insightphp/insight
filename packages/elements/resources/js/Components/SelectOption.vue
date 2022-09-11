<template>
  <li
      class="relative pl-3 py-2 cursor-pointer last:rounded-b-lg"
      :class="{ 'text-gray-700 font-medium': selected, 'bg-primary-100 text-primary-900': active }"
  >
    <span class="text-sm">{{ option[labelBy] }}</span>

    <span v-if="selected && showIcon" class="absolute top-0 bottom-0 right-0 flex items-center pr-3 text-primary-900">
      <slot name="icon">
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg>
      </slot>
    </span>
  </li>
</template>

<script setup lang="ts">
import type { Option } from "./contracts";

withDefaults(defineProps<{
  selected: boolean
  active: boolean
  option: Option
  labelBy: string
  showIcon?: boolean
}>(), {
  showIcon: false
})
</script>
