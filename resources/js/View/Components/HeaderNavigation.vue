<template>
  <ul class="flex flex-row">
    <li v-for="item in statefulNavigation.items">
      <template v-if="item.childNavigation">
        <Menu class="w-48">
          <template #toggle>
            <button
                class="inline-flex items-center text-sm font-medium text-gray-700 px-3 py-2 rounded-lg transition-colors duration-150"
                :class="[ item.isActive.value || item.childNavigation.childActive.value ? 'bg-primary-50 text-primary-700' : 'hover:text-gray-600' ]"
            >
              {{ item.item.link.title }}
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 ml-0.5">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
              </svg>
            </button>
          </template>

          <MenuItem as="template" v-for="innerItem in item.childNavigation.items">
            <Portal class="menu-item" :component="innerItem.item.link" :class="{ 'bg-primary-50 text-primary-700': innerItem.isActive.value }" />
          </MenuItem>
        </Menu>
      </template>
      <template v-else>
        <Portal class="text-sm font-medium text-gray-700 px-3 py-2 rounded-lg transition-colors duration-150 flex" :class="{ 'bg-primary-50 text-primary-700': item.isActive.value }" :component="item.item.link" />
      </template>
    </li>
  </ul>
</template>

<script setup lang="ts">
import type { Models } from "../../models";
import { Portal } from "@insightphp/inertia-view";
import { useStatefulNavigation } from "../../Composables";
import { Menu, MenuItem } from "@insightphp/elements";

const props = defineProps<{
  navigation: Models.Navigation
}>()

const { navigation: statefulNavigation } = useStatefulNavigation(props.navigation)
</script>
