<template>
<div class="bg-white flex flex-row items-center h-16 border-b border-gray-200 px-4">
  <!-- Logo -->
  <div class="hidden lg:inline-flex items-center">
    <svg class="w-8 h-8 mr-2 text-primary-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54.1 54.1" xml:space="preserve"><path fill="currentColor" d="M27,0C12.1,0,0,12.1,0,27c0,14.9,12.1,27,27,27c14.9,0,27-12.1,27-27C54,12.1,41.9,0,27,0z M43.3,19l-8.1,1.8l-8,1.8l8,1.8v7.3v0V39L27,40.8l-8.1,1.8v-7.3l8.1-1.8l8-1.8l-8-1.8l-8.1-1.8l-8.1-1.8v0v-7.3v0l8.1-1.8l8.1-1.8l8.1-1.8l8.1-1.8V19z"/></svg>
    <span class="text-black font-medium text-lg">Insight</span>
  </div>

  <button @click.prevent="emit('toggleDrawer')"
          class="lg:hidden rounded-lg p-2 transition-colors duration-300"
          :class="[ mobileOpen ? 'text-primary-700 bg-primary-100' : 'hover:bg-primary-100 hover:text-primary-700' ]"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
    </svg>
  </button>

  <!-- Left navigation -->
  <div class="hidden lg:block ml-4">
    <slot name="left-navigation" />
  </div>

  <!-- Center -->
  <div class="flex-1 flex flex-row items-center justify-center">
    <div>
      <span>Search here</span>
    </div>
  </div>

  <!-- Right Navigation -->
  <div class="hidden lg:block mr-2">
    <slot name="right-navigation" />
  </div>

  <!-- Right Menu -->
  <div>
    <Menu class="w-48" placement="bottom-right">
      <template #toggle>
        <button class="inline-flex items-center hover:bg-primary-50 text-sm text-gray-900 hover:text-primary-700 font-medium py-1 px-2 rounded-lg transition-colors duration-300">
          <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name=Peter+Stovka&color=9333ea&background=f3e8ff">
          <span class="hidden sm:block ml-2">Peter Štovka</span>
        </button>
      </template>

      <MenuItem class="menu-item">Repositories</MenuItem>
      <MenuItem class="menu-item">Issues <span class="badge warning ml-2">2 New</span></MenuItem>
      <MenuItem class="menu-item">Profile</MenuItem>
      <MenuItem class="menu-item">Settings</MenuItem>
      <MenuItem as="a" href="#" class="menu-item danger">Log Out</MenuItem>
    </Menu>

  </div>
</div>
</template>

<script setup lang="ts">
import { Menu, MenuItem } from "@insightphp/elements";
import { defineProps } from "vue";

const emit = defineEmits(['toggleDrawer'])
withDefaults(defineProps<{
  mobileOpen: boolean
}>(), {
  mobileOpen: false
})
</script>
