<template>
  <div class="flex flex-row input-group" :class="{ 'has-error': hasError }">
    <div class="input-group-widget bg-gray-100 input-group-left" v-if="hasLeftWidget">
      <slot name="left">
        <div class="h-full rounded-l-lg flex items-center justify-center">
          <span class="text-xs font-medium text-gray-700 px-3">{{ leftLabel }}</span>
        </div>
      </slot>
    </div>
    <div class="w-full" :class="{ 'input-group-has-left': hasLeftWidget, 'input-group-has-right': hasRightWidget }">
      <slot />
    </div>
    <div class="input-group-widget bg-gray-100 input-group-right" v-if="hasRightWidget">
      <slot name="right">
        <div class="h-full  rounded-r-lg flex items-center justify-center">
          <span class="text-xs font-medium text-gray-700 px-3">{{ rightLabel }}</span>
        </div>
      </slot>
    </div>
  </div>
  <p class="input-error" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
import { computed, defineProps, useSlots } from "vue";

const slots = useSlots()

const props = defineProps<{
  leftLabel?: string
  rightLabel?: string
  error?: string|null|undefined
}>()

const hasError = computed(() => !!props.error)

const hasLeftWidget = computed(() => slots.left || props.leftLabel)
const hasRightWidget = computed(() => slots.right || props.rightLabel)
</script>
