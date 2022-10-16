<template>
  <div class="w-full max-w-7xl mx-auto px-4 pt-12 pb-16">
    <Breadcrumbs :items="breadcrumbItems">
      <template #separator>
        <ChevronRightIcon class="w-4 h-4 mx-2 text-gray-300" />
      </template>
    </Breadcrumbs>

    <div class="inline-flex items-center gap-3 mt-4">
      <h4 class="font-semibold text-gray-900 text-xl">{{ title }}</h4>
    </div>

    <template v-if="form">
      <Portal class="mt-4" :component="form" />
    </template>
  </div>
</template>

<script setup lang="ts">
import { ChevronRightIcon } from "@heroicons/vue/24/outline";
import { Breadcrumbs } from "@insightphp/elements";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import { usePage } from "@inertiajs/inertia-vue3";

defineProps<{
  edit: boolean
  title: string
  breadcrumbItems: Array<Component>
  form: Component|null
}>()
</script>
