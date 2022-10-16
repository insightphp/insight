<template>
  <div class="w-full max-w-7xl mx-auto px-4 pt-12 pb-16">
    <template v-if="breadcrumbItems">
      <Breadcrumbs class="mb-4" :items="breadcrumbItems">
        <template #separator>
          <ChevronRightIcon class="w-4 h-4 mx-2 text-gray-300" />
        </template>
      </Breadcrumbs>
    </template>

    <div class="inline-flex items-center gap-3 mb-6">
      <h4 class="font-semibold text-gray-900 text-xl">{{ title }}</h4>
      <span class="badge danger" v-if="trashed">Deleted</span>
    </div>

    <slot />
  </div>
</template>

<script setup lang="ts">
import { ChevronRightIcon } from "@heroicons/vue/24/outline";
import { Breadcrumbs } from "@insightphp/elements";
import type { Component } from "@insightphp/inertia-view";

defineProps<{
  title: string
  listResourcesLink?: Component|null
  trashed?: boolean
  breadcrumbItems?: Array<Component>
}>()
</script>
