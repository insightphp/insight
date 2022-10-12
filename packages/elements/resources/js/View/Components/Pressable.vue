<template>
<div class="inline-flex text-gray-600 rounded-md transition-colors duration-300 p-2" :class="[`hover:bg-${type}-50`, `hover:text-${type}-600`]">
  <Portal v-if="content" :component="content" />
  <slot v-else />
</div>
</template>

<script setup lang="ts">
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";

withDefaults(defineProps<{
  content?: Component
  type?: 'primary' | 'danger' | 'success'
}>(), {
  type: 'primary'
})
</script>
