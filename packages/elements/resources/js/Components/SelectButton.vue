<template>
  <div class="select-button-content">
    <span class="text-sm">{{ label }}</span>
    <span class="absolute top-0 bottom-0 flex items-start pt-2 right-0 pr-3 text-gray-500">
    <!-- Clear select button -->
    <button tabindex="-1" v-if="showClearButton" @click.prevent="emit('clear')">
      <svg class="w-5 h-5 text-danger-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
      </svg>
    </button>
      <!-- Dropdown icon -->
    <svg v-else class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
    </svg>
  </span>
  </div>
</template>

<script setup lang="ts">
const emit = defineEmits(['clear'])

defineProps<{
  showClearButton: boolean
  label: string
}>()
</script>
