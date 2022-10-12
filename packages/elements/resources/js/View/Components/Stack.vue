<template>
<div class="inline-flex" :class="[{
      'flex-row': isHorizontal,
      'flex-col': isVertical,
      'items-center': align == 'center',
      'items-start': align == 'top',
      'items-end': align == 'bottom',
    }, gap ]">
  <template v-for="item in items">
    <Portal :component="item" />
  </template>

  <slot />
</div>
</template>

<script setup lang="ts">
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import { computed } from "vue";

const props = defineProps<{
  orientation: 'horizontal' | 'vertical'
  items: Array<Component>
  gap: string
  align: 'center' | 'top' | 'bottom'
}>()

const isHorizontal = computed(() => props.orientation === 'horizontal')
const isVertical = computed(() => props.orientation === 'vertical')
</script>
