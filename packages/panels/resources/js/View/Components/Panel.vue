<template>
  <div class="border border-gray-200 rounded-md bg-white">
    <div class="border-b border-gray-200 flex flex-row items-center justify-between py-3 px-4" v-if="actions || title || subtitle">
      <div class="inline-flex flex-col">
        <div class="inline-flex items-center gap-2">
          <h4 class="text-lg font-semibold text-gray-900" v-if="title">{{ title }}</h4>
        </div>

        <p class="text-sm text-gray-600 mt-1" v-if="subtitle">{{ subtitle }}</p>
      </div>

      <div class="inline-flex gap-3">
        <Portal v-if="actions" :component="actions" />
      </div>
    </div>

    <div class="flex flex-col divide-y divide-gray-200" v-if="items.length > 0">
      <template v-for="item in items">
        <Portal :component="item" />
      </template>
    </div>

    <template v-else>
      <slot name="empty">
        <div class="flex items-center flex-col py-10">
          <div class="inline-flex relative items-center justify-center w-14 h-14">
            <div class="absolute w-14 h-14 block bg-primary-50 rounded-full"></div>
            <div class="absolute w-10 h-10 block bg-primary-100 rounded-full"></div>
            <QueueListIcon class="absolute w-5 h-5 text-primary-600" />
          </div>

          <h5 class="text-gray-900 font-semibold mt-2">The panel is empty.</h5>
          <p class="text-sm text-gray-600 max-w-sm text-center mt-1">The panel does not have any items. Add fields to you resource to display on the panel or disable the panel on the resource.</p>
        </div>
      </slot>
    </template>
  </div>
</template>

<script setup lang="ts">
import { QueueListIcon } from "@heroicons/vue/24/outline";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";

defineProps<{
  title?: string|null
  subtitle?: string|null
  actions?: Component|null
  items: Array<Component>
}>()
</script>
