<template>
<div class="flex flex-row input-group">
  <div class="input-group-left" v-if="$slots.left || leftLabel">
    <slot name="left">
      <span>{{ leftLabel }}</span>
    </slot>
  </div>
  <slot />
  <div class="input-group-right" v-if="$slots.right || rightLabel">
    <slot name="right">
      <span>{{ rightLabel }}</span>
    </slot>
  </div>
</div>
</template>

<script setup lang="ts">
import { defineProps } from "vue";

defineProps<{
  leftLabel?: string
  rightLabel?: string
}>()
</script>
