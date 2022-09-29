<template>
  <div class="bg-white grid grid-cols-5 h-16 border-b border-gray-200 px-4">

    <!-- Left Side -->
    <div class="lg:col-span-2 flex flex-row items-center">
      <!-- Logo -->
      <div class="hidden lg:inline-flex items-center">
        <svg class="w-8 h-8 mr-2 text-primary-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54.1 54.1" xml:space="preserve"><path fill="currentColor" d="M27,0C12.1,0,0,12.1,0,27c0,14.9,12.1,27,27,27c14.9,0,27-12.1,27-27C54,12.1,41.9,0,27,0z M43.3,19l-8.1,1.8l-8,1.8l8,1.8v7.3v0V39L27,40.8l-8.1,1.8v-7.3l8.1-1.8l8-1.8l-8-1.8l-8.1-1.8l-8.1-1.8v0v-7.3v0l8.1-1.8l8.1-1.8l8.1-1.8l8.1-1.8V19z"/></svg>
        <span class="text-black font-medium text-lg">Insight</span>
      </div>

      <!-- Mobile Drawer Toggle -->
      <button @click.prevent="emit('toggleDrawer')"
              class="lg:hidden rounded-lg p-2 transition-colors duration-300"
              :class="[ mobileOpen ? 'text-primary-700 bg-primary-100' : 'hover:bg-primary-100 hover:text-primary-700' ]"
      >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/>
        </svg>
      </button>

      <!-- Left navigation -->
      <div class="hidden lg:block ml-4">
        <slot name="left-navigation">
          <Portal v-if="leftNavigation" :component="leftNavigation"/>
        </slot>
      </div>
    </div>

    <!-- Center -->
    <div class="col-span-3 lg:col-span-1 flex flex-row items-center justify-center">
      <slot name="center">
        <button v-if="showSearch" @click.prevent="emit('toggleSearch')" class="w-full max-w-xs flex justify-between items-center border border-gray-300 rounded-lg px-2 py-2">
          <span class="inline-flex items-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>

            <span class="text-sm ml-2">Search…</span>
          </span>

          <div class="inline-flex items-center space-x-2">
            <kbd class="text-xs font-sans text-gray-400 border rounded px-2" v-if="isMac">⌘K</kbd>
            <kbd class="text-xs font-sans text-gray-400 border rounded px-2" v-else>CTRL+K</kbd>
          </div>
        </button>
      </slot>
    </div>

    <!-- Right Side -->
    <div class="lg:col-span-2 flex flex-row items-center justify-end">
      <!-- Right Navigation -->
      <div class="hidden lg:block mr-2">
        <slot name="right-navigation">
          <Portal v-if="rightNavigation" :component="rightNavigation"/>
        </slot>
      </div>

      <!-- Right Menu -->
      <div>
        <Menu class="w-48" placement="bottom-right">
          <template #toggle>
            <button class="inline-flex items-center hover:bg-primary-50 text-sm text-gray-900 hover:text-primary-700 font-medium py-1 px-2 rounded-lg transition-colors duration-300">
              <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name=Peter+Stovka&color=9333ea&background=f3e8ff">
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
  </div>
</template>

<script setup lang="ts">
import { Menu, MenuItem } from "@insightphp/elements";
import { computed, defineProps } from "vue";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";

const emit = defineEmits(['toggleDrawer', 'toggleSearch'])

withDefaults(defineProps<{
  mobileOpen: boolean
  leftNavigation?: Component | null
  rightNavigation?: Component | null
  showSearch?: boolean
}>(), {
  mobileOpen: false,
  showSearch: false
})

const isMac = computed(() => navigator.platform.toUpperCase().indexOf('MAC') >= 0)
</script>
