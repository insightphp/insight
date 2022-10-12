<template>
  <div class="data-table border border-gray-200 rounded-md">
    <div class="bg-white rounded-t-md flex flex-row items-center justify-between py-3 px-4">
      <div class="inline-flex flex-col">
        <div class="inline-flex items-center gap-2">
          <h4 class="text-lg font-semibold text-gray-900" v-if="title">{{ title }}</h4>
          <span class="badge primary" v-if="totalItems">{{ totalItems }} {{ title }}</span>
        </div>

        <p class="text-sm text-gray-600 mt-1" v-if="subtitle">{{ subtitle }}</p>
      </div>

      <slot name="headerActions">
        <Portal v-if="headerActions" :component="headerActions" />
      </slot>
    </div>

    <div class="bg-white w-full py-3 px-4 border-t border-gray-200" v-if="$slots.actions">
      <slot name="actions" />
    </div>

    <Table class="table" :header="header" :rows="rows" :footer="footer" />

    <!--<div class="bg-white flex items-center flex-col border-t border-gray-200 py-10">-->
    <!--  <div class="inline-flex relative items-center justify-center w-14 h-14">-->
    <!--    <div class="absolute w-14 h-14 block bg-primary-50 rounded-full"></div>-->
    <!--    <div class="absolute w-10 h-10 block bg-primary-100 rounded-full"></div>-->
    <!--    <MagnifyingGlassIcon class="absolute w-5 h-5 text-primary-600" />-->
    <!--  </div>-->

    <!--  <h5 class="text-gray-900 font-semibold mt-2">No users found.</h5>-->
    <!--  <p class="text-sm text-gray-600 max-w-xs text-center mt-1">Your search "Adriana" did not match any users. Please try again or add a new user.</p>-->

    <!--  <div class="inline-flex items-center gap-3 mt-4">-->
    <!--    <button class="btn">Clear search</button>-->
    <!--    <button class="btn primary gap-2">-->
    <!--      <PlusIcon class="w-4 h-4" />-->
    <!--      Add User-->
    <!--    </button>-->
    <!--  </div>-->
    <!--</div>-->

    <div class="bg-white flex items-center border-t border-gray-200 px-4 py-3 rounded-b-md justify-between">
      <div class="inline-flex items-center gap-3">
        <span class="font-medium text-gray-700 text-sm">Page 1 of 10</span>
        <span class="block h-4 border-r border-gray-300"></span>
        <div class="inline-flex items-center gap-2">
          <span class="font-medium text-gray-700 text-sm">Per page</span>
          <select class="text-gray-700 py-1.5 pr-8 font-medium" name="per-page" id="per-page">
            <option value="">25</option>
            <option value="">50</option>
            <option value="">100</option>
            <option value="">500</option>
          </select>
        </div>
      </div>

      <DataTablePagination :links="paginationLinks" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { MagnifyingGlassIcon, ArrowLeftIcon, ArrowRightIcon } from '@heroicons/vue/24/outline'
import Table from "./Table.vue";
import type { Component } from "@insightphp/inertia-view";
import type { Components } from "./index";
import { Portal } from "@insightphp/inertia-view";
import type { Models } from "./index";
import { Link } from "@inertiajs/inertia-vue3";
import DataTablePagination from "../../Components/DataTablePagination.vue";

const props = defineProps<{
  title?: string|null
  subtitle?: string|null
  totalItems?: number|null
  headerActions?: Component|null
  header: Component<Components.Header>
  footer: Component<Components.Footer>
  rows: Array<Component<Components.Row>>
  paginationLinks: Array<Models.PaginationLink>
}>()
</script>
