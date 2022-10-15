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
      :data="linkData"
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
import { computed } from "vue";

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
  preserveScroll?: boolean
  additionalData?: Record<string, any>|null
}>(), {
  external: false,
  isActive: false,
  buttonType: 'primary',
  preserveScroll: false,
})

const linkData = computed(() => {
  let data = {}
  if (props.data) {
    data = { ...data, ...props.data }
  }
  if (props.additionalData) {
    data = { ...data, ...props.additionalData }
  }

  return Object.keys(data).length > 0 ? data : undefined
})
</script>
