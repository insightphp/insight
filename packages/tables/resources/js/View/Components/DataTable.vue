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

    <div class="bg-white w-full py-3 px-4 border-t border-gray-200" v-if="$slots.actions && selectedRows.length <= 0">
      <slot name="actions" v-bind="{ handler }" />
    </div>

    <div class="bg-white w-full py-3 px-4 border-t border-gray-200" v-if="$slots.bulkActions && selectedRows.length > 0">
      <slot name="bulkActions" v-bind="{ selection: selectedRows, total: rows.length, clear: selectNothing }" />
    </div>

    <div v-if="handler.isSearching.value && rows.length === 0" class="bg-white flex items-center flex-col border-t border-gray-200 py-10">
      <div class="inline-flex relative items-center justify-center w-14 h-14">
        <div class="absolute w-14 h-14 block bg-primary-50 rounded-full"></div>
        <div class="absolute w-10 h-10 block bg-primary-100 rounded-full"></div>
        <MagnifyingGlassIcon class="absolute w-5 h-5 text-primary-600" />
      </div>

      <h5 class="text-gray-900 font-semibold mt-2">No resources found.</h5>
      <p class="text-sm text-gray-600 max-w-sm text-center mt-1">Your search "{{ handler.searchTerm.value }}" did not match any resources. Please try again or add a new resource.</p>

      <div class="inline-flex items-center gap-3 mt-4">
        <button class="btn" @click.prevent="handler.searchTerm.value = ''">Clear search</button>
        <!--<button class="btn primary gap-2">-->
        <!--  <PlusIcon class="w-4 h-4" />-->
        <!--  Add User-->
        <!--</button>-->
      </div>
    </div>

    <Table
        v-else
        class="table"
        :class="{ 'compact': settings.compact }"
        :header="header"
        :rows="rows"
        :footer="footer"
        :selections="selections"
        :selection-summary="selectionSummary"
        :enable-bulk-selection="enableBulkSelection"
        :sorted-as="handler.sortAs.value"
        :default-sort-as="defaultSortAs"
        :default-sort-direction="defaultSortDirection"
        @select-everything="selectEverything"
        @select-nothing="selectNothing"
        @update-sort-as="onUpdateSortAs"
    />

    <div class="bg-white flex items-center border-t border-gray-200 px-4 py-3 rounded-b-md justify-between">
      <div class="inline-flex items-center gap-3">
        <template v-if="enableSettings">
          <DataTableSettings :settings="settings" />
          <span class="block h-4 border-r border-gray-300"></span>
        </template>
        <span class="font-medium text-gray-700 text-sm">Page {{ currentPage }} of {{ lastPage }}</span>
        <span class="block h-4 border-r border-gray-300"></span>
        <div class="inline-flex items-center gap-2">
          <span class="font-medium text-gray-700 text-sm">Per page</span>
          <select v-model="handler.perPage.value" class="text-gray-700 py-1.5 pr-8 font-medium">
            <option :value="25">25</option>
            <option :value="50">50</option>
            <option :value="100">100</option>
            <option :value="500">500</option>
          </select>
        </div>
      </div>

      <DataTablePagination :links="paginationLinks" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { MagnifyingGlassIcon, PlusIcon } from "@heroicons/vue/24/outline";
import Table from "./Table.vue";
import type { Component } from "@insightphp/inertia-view";
import type { Components } from "./index";
import { Portal } from "@insightphp/inertia-view";
import type { Models } from "./index";
import DataTablePagination from "../../Components/DataTablePagination.vue";
import { useRowSelection } from "../../Composables";
import DataTableSettings from "../../Components/DataTableSettings.vue";
import { useSettings } from "../../Composables/use-settings";
import type { DataTableHandler } from "../../Composables/use-data-table";
import { watch } from "vue";

const props = withDefaults(defineProps<{
  title?: string|null
  subtitle?: string|null
  totalItems?: number|null
  lastPage?: number|null
  currentPage?: number|null
  headerActions?: Component|null
  header: Component<Components.Header>
  footer: Component<Components.Footer>
  rows: Array<Component<Components.Row>>
  paginationLinks: Array<Models.PaginationLink>
  enableBulkSelection?: boolean
  enableSettings?: boolean
  settingsKey?: string
  handler: DataTableHandler
  defaultSortAs?: string
  defaultSortDirection?: 'asc' | 'desc'
}>(), {
  enableBulkSelection: true,
  enableSettings: true,
  settingsKey: 'insight-data-table'
})

if (! props.handler) {
  throw new Error("The data table handler is not set.")
}

const makeRowIds = (rows: Array<Components.Row>|undefined) => {
  const ids = (rows || [])
      .map((it, index) => {
        if (! it.id) {
          throw new Error(`Bulk selection is enabled but the row at index [${index}] does not have valid identifier.`)
        }

        return it.id
      })

  return ids
}

const { selections, resetSelections, selectionSummary, selectEverything, selectNothing, selectedRows } = useRowSelection(props.enableBulkSelection ? makeRowIds(props.rows) : [])

const { settings } = useSettings(props.settingsKey)

watch(props, newProps => {
  if (props.enableBulkSelection) {
    const newRows = (newProps.rows || []).map(it => `${it.id}`).join()
    const currentRows = selections.map(it => `${it.id}`).join()
    if (newRows !== currentRows) {
      resetSelections(makeRowIds(newProps.rows))
    }
  }
})

const onUpdateSortAs = (sortAs: string) => {
  props.handler.sortAs.value = sortAs
}
</script>
