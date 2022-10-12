<template>
<div class="w-full max-w-7xl mx-auto px-4 pt-12 pb-16">

  <Portal class="w-full" v-if="resourcesTable" :component="resourcesTable">
    <template #actions>
      <div class="w-full flex flex-row items-center justify-between">
        <div class="inline-flex">
          <!-- Left content  -->
        </div>

        <div class="inline-flex flex-row gap-3">
          <div class="block relative">
            <input type="text" placeholder="Search…" class="pl-7">
            <MagnifyingGlassIcon class="text-gray-500 absolute top-1/2 -mt-2 left-2 w-4 h-4" />
          </div>

          <button class="btn gap-2">
            <FunnelIcon class="w-4 h-4" />
            Filter
          </button>
        </div>
      </div>
    </template>
  </Portal>

</div>
</template>

<script setup lang="ts">
import { MagnifyingGlassIcon, FunnelIcon } from '@heroicons/vue/24/outline'
import { usePage } from "@inertiajs/inertia-vue3";
import type { Pages } from "../models";
import { Portal } from "@insightphp/inertia-view";
import { computed } from "vue";

const page = usePage<Pages.ListResourcesPage>()

const resourcesTable = computed(() => page.props.value.resources)
</script>
