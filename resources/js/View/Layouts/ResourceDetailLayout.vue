<template>
  <div class="w-full max-w-7xl mx-auto px-4 pt-12 pb-16">
    <Breadcrumbs>
      <template #separator>
        <ChevronRightIcon class="w-4 h-4 mx-2 text-gray-300" />
      </template>
      <HomeIcon class="w-4 h-4" />

      <Portal v-if="listResourcesLink" :component="listResourcesLink" />

      <span>{{ title }}</span>
    </Breadcrumbs>

    <div class="inline-flex items-center gap-3 mt-4">
      <h4 class="font-semibold text-gray-900 text-xl">{{ title }}</h4>
      <span class="badge danger" v-if="trashed">Deleted</span>
    </div>

    <slot />
  </div>
</template>

<script setup lang="ts">
import { ChevronRightIcon, HomeIcon } from "@heroicons/vue/24/outline";
import { Breadcrumbs } from "@insightphp/elements";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";

defineProps<{
  title: string
  listResourcesLink?: Component|null
  trashed?: boolean
}>()
</script>
