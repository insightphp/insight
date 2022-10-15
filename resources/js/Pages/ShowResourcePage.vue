<template>
  <div class="w-full max-w-7xl mx-auto px-4 pt-12 pb-16">
    <Breadcrumbs>
      <template #separator>
        <ChevronRightIcon class="w-4 h-4 mx-2 text-gray-300" />
      </template>
      <HomeIcon class="w-4 h-4" />
      <a href="">Users</a>
      <span>Peter Štovka</span>
    </Breadcrumbs>

    <div class="inline-flex items-center gap-3 mt-4">
      <h4 class="font-semibold text-gray-900 text-xl">Peter Štovka</h4>
      <span class="badge success">Active</span>
    </div>

    <Portal class="mt-6" v-if="page.props.value.details" :component="page.props.value.details" />
  </div>
</template>

<script setup lang="ts">
import { ChevronRightIcon, HomeIcon } from "@heroicons/vue/24/outline";
import { Breadcrumbs } from "@insightphp/elements";
import { usePage } from "@inertiajs/inertia-vue3";
import type { Pages } from "../models";
import { Portal } from "@insightphp/inertia-view";

const page = usePage<Pages.ShowResourcePage>()
</script>
