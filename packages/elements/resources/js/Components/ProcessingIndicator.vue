<template>
<span class="inline-flex items-center text-sm text-gray-700 processing-indicator">
  <slot name="icon">
    <span v-if="ping" class="processing-animation-ping flex mx-[3px] h-2.5 w-2.5 relative">
      <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" :class="[colorClass || 'bg-primary-500']"></span>
      <span class="relative inline-flex rounded-full h-2.5 w-2.5" :class="[colorClass || 'bg-primary-500']"></span>
    </span>
    <svg v-else class="processing-animation-spin animate-spin w-4 h-4" :class="[colorClass || 'text-primary-700']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
  </slot>

  <template v-if="$slots.default || label">
    <span class="ml-2">
      <slot>{{ label }}</slot>
    </span>
  </template>
</span>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  label?: string
  ping?: boolean
  colorClass?: string
}>(), {
  ping: false,
})
</script>
