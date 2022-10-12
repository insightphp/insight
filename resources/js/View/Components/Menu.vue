<template>
  <Menu class="w-48" placement="bottom-right">
    <template #toggle>
      <button>
        <Portal v-if="toggle" :component="toggle" />
        <Pressable v-else>
          <EllipsisVerticalIcon class="w-4 h-4" />
        </Pressable>
      </button>
    </template>

    <template v-for="item in navigation.items">
      <MenuItem as="template" v-slot="{ active, close }">
        <Link @click="close" class="menu-item flex w-full" v-bind="item.link" :is-active="item.link.isActive || active" />
      </MenuItem>
    </template>
  </Menu>
</template>

<script setup lang="ts">
import { EllipsisVerticalIcon } from '@heroicons/vue/24/outline'
import { Menu, MenuItem, Link } from "@insightphp/elements";
import type { Models } from "../../models";
import Pressable from "../../../../packages/elements/resources/js/View/Components/Pressable.vue";
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";


defineProps<{
  navigation: Models.Navigation
  toggle?: Component
}>()
</script>
