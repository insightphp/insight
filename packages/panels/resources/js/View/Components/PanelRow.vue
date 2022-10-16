<template>
  <div class="w-full odd:bg-gray-50 flex flex-row px-4 py-3">
    <div class="w-1/3">
      <span class="text-sm text-gray-600" v-if="title">{{ title }}</span>
    </div>
    <div>
      <Portal v-if="value" :component="value" />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";

defineProps<{
  title?: string|null
  value?: Component|null
}>()
</script>
