<template>
<div class="w-full max-w-7xl mx-auto px-4 pt-12 pb-16">
  <Portal class="w-full" v-if="resourcesTable" :component="resourcesTable" :handler="dataTable">
    <template v-if="shouldShowActions" #actions="{ handler }">
      <div class="w-full flex flex-row items-center justify-between">
        <div class="inline-flex">
          <!-- Left content  -->
        </div>

        <div class="inline-flex flex-row gap-3">
          <div class="block relative" v-if="page.props.value.isSearchable">
            <input v-model="handler.searchTerm.value" type="text" placeholder="Search…" class="pl-7">
            <MagnifyingGlassIcon class="text-gray-500 absolute top-1/2 -mt-2 left-2 w-4 h-4" />
          </div>

          <Portal v-if="page.props.value.filter" :component="page.props.value.filter" />
        </div>
      </div>
    </template>

    <template #bulkActions="{ selection, total, clear }">
      <div class="w-full flex flex-row items-center justify-between">
        <div class="inline-flex items-center gap-3">
          <button class="btn-link danger" @click.prevent="clear">
            Clear
          </button>
          <span class="font-medium text-primary-700 text-sm">Selected {{ selection.length }} of {{ total }}</span>
        </div>

        <div class="inline-flex flex-row gap-3">
          <button class="btn primary gap-2">
            <PlayIcon class="w-4 h-4" />
            Run Action
          </button>
        </div>
      </div>
    </template>
  </Portal>
</div>
</template>

<script setup lang="ts">
import { MagnifyingGlassIcon, PlayIcon } from '@heroicons/vue/24/outline'
import { usePage } from "@inertiajs/inertia-vue3";
import type { Pages } from "../models";
import { Portal } from "@insightphp/inertia-view";
import { computed } from "vue";
import { useDataTable } from "../../../packages/tables/resources/js/Composables/use-data-table";

const page = usePage<Pages.ListResourcesPage>()

const resourcesTable = computed(() => page.props.value.resources)

const dataTable = useDataTable()

const shouldShowActions = computed(() => page.props.value.isSearchable || !!page.props.value.filter)
</script>
