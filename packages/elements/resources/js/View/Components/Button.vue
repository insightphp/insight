<template>
  <button class="btn" :class="[ type ? [type] : [] ]">
    <slot>
      <Portal v-if="content" :component="content" />
    </slot>
  </button>
</template>

<script setup lang="ts">
import { Portal } from "@insightphp/inertia-view";
import type { Component } from "@insightphp/inertia-view";

defineProps<{
  content?: Component|null
  type?: string|null
}>()
</script>
