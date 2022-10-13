<template>
  <Menu class="w-48">
    <template #toggle>
      <button class="text-gray-600 rounded-md transition-colors duration-300 p-1 hover:bg-primary-50 hover:text-primary-600">
          <CogIcon class="w-6 h-6" />
      </button>
    </template>

    <MenuItem class="menu-item flex justify-between" @click.prevent="settings.compact = !settings.compact">
      Compact mode
      <CheckIcon v-if="settings.compact" class="w-4 h-4 text-primary-600" />
    </MenuItem>
  </Menu>
</template>

<script setup lang="ts">
import { CogIcon, CheckIcon } from '@heroicons/vue/24/outline'
import type { DataTableSettings } from "../Composables/use-settings";
import { Menu, MenuItem } from "@insightphp/elements";

const props = defineProps<{
  settings: DataTableSettings
}>()
</script>
