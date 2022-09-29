<template>
<div class="fixed bg-white border-r border-gray-200 z-10 min-h-full h-full w-full sm:w-56 pt-16 lg:left-0 transition-all duration-300"
    :class="[mobileOpen ? 'left-0' : '-left-full sm:-left-56']"
>
  <div class="px-4 pt-4">
    <NavigationTree :navigation="navigation">
      <template #item="{ item, active }">
        <li :class="{ 'active': active.value }">
          <Portal :component="item.link" />
        </li>
      </template>

      <template #caret="{ toggle }">
        <span @click.prevent="toggle" class="caret"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg></span>
      </template>
    </NavigationTree>
  </div>
</div>
</template>

<script setup lang="ts">
import type { Models } from "../models";
import NavigationTree from "./NavigationTree.vue";
import { Portal } from "@insightphp/inertia-view";

const emit = defineEmits(['mobileClose'])

const props = withDefaults(defineProps<{
  mobileOpen: boolean
  navigation: Models.Navigation
}>(), {
  mobileOpen: false
})
</script>
