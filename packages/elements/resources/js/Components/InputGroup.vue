<template>
<div class="flex flex-row input-group">
  <div class="input-group-widget input-group-left bg-gray-100 flex items-center justify-center" v-if="hasLeftWidget">
    <slot name="left">
      <span class="text-sm font-medium text-gray-700 px-2">{{ leftLabel }}</span>
    </slot>
  </div>
  <div class="w-full" :class="{ 'input-group-has-left': hasLeftWidget, 'input-group-has-right': hasRightWidget }">
    <slot />
  </div>
  <div class="input-group-widget input-group-right bg-gray-100 flex items-center justify-center" v-if="hasRightWidget">
    <slot name="right">
      <span class="text-sm font-medium text-gray-700 px-2">{{ rightLabel }}</span>
    </slot>
  </div>
</div>
</template>

<script setup lang="ts">
import { computed, defineProps, useSlots } from "vue";

const slots = useSlots()

const props = defineProps<{
  leftLabel?: string
  rightLabel?: string
}>()

const hasLeftWidget = computed(() => slots.left || props.leftLabel)
const hasRightWidget = computed(() => slots.right || props.rightLabel)
</script>
