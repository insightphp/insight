<template>
  <div class="bg-gray-25 min-h-full">
    <slot name="header">
      <div class="fixed z-20 w-full">
        <Portal :component="header" :mobile-open="mobileOpen" @toggle-drawer="mobileOpen = !mobileOpen" />
      </div>
    </slot>

    <slot name="sidebar">
      <Drawer :mobile-open="mobileOpen" :navigation="navigation" />
    </slot>

    <div class="h-full min-w-max-content lg:pl-56 pt-16">
      <slot/>
    </div>
  </div>
</template>
<script setup lang="ts">
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import { Drawer, } from "../../Components";
import { ref } from "vue";
import type { Models } from "../../models";

const mobileOpen = ref(false)

const props = defineProps<{
  header: Component
  navigation: Models.Navigation
}>()
</script>
