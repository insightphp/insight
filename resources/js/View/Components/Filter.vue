<template>
  <div ref="filterEl" class="relative">
    <button class="relative btn gap-2 inline-flex items-center" @click.prevent="toggleFilter">
      <FunnelIcon class="w-4 h-4" />
      Filter
      <template v-if="selectedFilters > 0">
        <span class="block h-4 border-r border-gray-400"></span>
        <span class="text-primary-700 font-semibold">{{ selectedFilters }}</span>
      </template>
      <span v-if="selectedFilters > 0" class="-top-1/2 mt-1 right-0 absolute">
        <div class="relative inline-flex items-center justify-center">
          <div class="absolute block w-4 h-4 bg-primary-100 rounded-full"></div>
          <div class="absolute block w-3 h-3 bg-primary-300 rounded-full"></div>
          <div class="absolute block w-2 h-2 bg-primary-600 rounded-full"></div>
        </div>
      </span>
    </button>

    <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-200 ease-out"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
    >
      <div v-if="isOpen" class="flex flex-col bg-white w-64 absolute z-10 mt-2 right-0 rounded-md border border-gray-200">
        <div class="w-full grid grid-cols-3 bg-gray-50 rounded-t border-b p-2">
          <div class="flex justify-start items-center">
            <button @click.prevent="clearFilter" class="btn bg-white hover:bg-gray-50 text-xs px-2 py-1">Clear</button>
          </div>
          <div class="flex justify-center items-center">
            <span class="text-sm font-semibold text-gray-700">Filter</span>
          </div>
          <div class="flex justify-end items-center">
            <button @click.prevent="applyFilter" class="btn primary small text-xs">
              Apply
            </button>
          </div>
        </div>

        <template v-for="(filterable, index) in filterables">
          <CollapsibleFilterable
              :id="filterable.id"
              :name="filterable.title"
              v-model="filterState[filterable.id].selected"
              :is-last="index + 1 === filterables.length"
          >
            <Portal ref="filterableComponents" :component="filterable" v-model="filterState[filterable.id].value" />
          </CollapsibleFilterable>
        </template>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { FunnelIcon } from '@heroicons/vue/24/outline'
import { FunnelIcon as FunnelSolidIcon } from '@heroicons/vue/24/solid'
import { computed, ref } from "vue";
import { onEscapePress, useWindowEvent } from "../../Composables";
import type { Components } from "./index";
import type { Component } from "@insightphp/inertia-view";
import type { InitialValue } from "../../Composables/use-filter";
import { useFilter } from "../../Composables/use-filter";
import CollapsibleFilterable from "../../Components/CollapsibleFilterable.vue";
import { Portal } from "@insightphp/inertia-view";
import qs from "qs";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps<{
  filterables: Array<Component<Components.Filterable>>
  initialValue: InitialValue
}>()

const isOpen = ref<boolean>(false)
const filterEl = ref()
const filterableComponents = ref([])

const filterState = useFilter(props.filterables, props.initialValue)

const restoreFilter = () => {
  props.filterables.forEach(filterable => {
    filterState[filterable.id].selected = props.initialValue[filterable.id].selected
    filterState[filterable.id].value = props.initialValue[filterable.id].value
  })
}

const clearFilter = () => {
  const beforeClear = selectedFilters.value

  props.filterables.forEach(filterable => {
    filterState[filterable.id].selected = false
  })

  const afterClear = selectedFilters.value

  if (beforeClear != afterClear) {
    applyFilter()
  }
}

const applyFilter = () => {
  const queryValue = qs.parse(window.location.search.replace('?', ''))

  props.filterables.forEach((filterable, index) => {
    const component: any = filterableComponents.value[index]

    // Skip filter if not selected.
    if (! filterState[filterable.id].selected) {
      if (typeof component.removeFilterValueFromQuery === 'function') {
        component.removeFilterValueFromQuery(queryValue)
      } else {
        delete queryValue[filterable.id]
      }

      return
    }

    const originalValue = filterState[filterable.id].value
    if (typeof component.setFilterValueOnQuery === 'function') {
      component.setFilterValueOnQuery(queryValue, originalValue)
    } else {
      queryValue[filterable.id] = originalValue
    }
  })

  let destination = window.location.href.split('?')[0]
  const finalQueryParams = qs.stringify(queryValue)
  if (finalQueryParams && finalQueryParams.length > 0) {
    destination = `${destination}?${finalQueryParams}`
  }
  isOpen.value = false
  Inertia.visit(destination)
}

const safelyCloseFilter = () => {
  restoreFilter()

  isOpen.value = false
}

const toggleFilter = () => {
  if (! isOpen.value) {
    isOpen.value = true
    return
  }

  safelyCloseFilter()
}

useWindowEvent('click', (el: any) => {
  const clickedOutside = ! filterEl.value.contains(el.target)

  if (clickedOutside && isOpen.value) {
    safelyCloseFilter()
  }
})

onEscapePress(() => {
  if (isOpen.value) {
    safelyCloseFilter()
  }
})

const selectedFilters = computed(() => props.filterables.filter(it => filterState[it.id].selected).length)
</script>
