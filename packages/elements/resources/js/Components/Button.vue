<template>
<button v-bind="$attrs" :class="{ 'processing': processing }">
  <ProcessingIndicator
      v-if="processing"
      :ping="ping"
      :color-class="processingColor"
      class="mr-2"
  />

  <template v-if="processing && processingLabel">{{ processingLabel }}</template>
  <slot v-else />
</button>
</template>

<script setup lang="ts">
import ProcessingIndicator from "./ProcessingIndicator.vue";

withDefaults(defineProps<{
  processing?: boolean
  processingLabel?: string
  processingColor?: string
  ping?: boolean
}>(), {
  processing: false,
  ping: false
})
</script>
