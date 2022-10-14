<template>
  <a v-if="external" :href="location" :class="{ 'btn': asButton, [buttonType]: asButton }">
    <slot>
      <template v-if="content">
        <Portal :component="content" />
      </template>
      <template v-else>
        {{ title }}
      </template>
    </slot>
  </a>
  <Link
      v-else
      :href="location"
      :as="props.as || undefined"
      :method="method || undefined"
      :data="data || undefined"
      :preserve-scroll="preserveScroll"
      :class="{ 'btn': asButton, [buttonType]: asButton }"
  >
    <template v-if="content">
      <Portal :component="content" />
    </template>
    <template v-else>
      {{ title }}
    </template>
  </Link>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/inertia-vue3";
import { Portal } from "@insightphp/inertia-view";
import type { Component } from "@insightphp/inertia-view";

const props = withDefaults(defineProps<{
  title: string
  location: string
  method?: string|null
  as?: string|null
  external?: boolean
  isActive?: boolean
  content?: Component
  asButton?: boolean
  buttonType?: string
  data?: Record<string, any>|null
  preserveScroll: boolean
}>(), {
  external: false,
  isActive: false,
  buttonType: 'primary'
})
</script>
