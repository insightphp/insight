<template>
  <a v-if="external" :href="location">
    <slot>{{ title }}</slot>
  </a>
  <Link v-else :href="location">
    <slot>{{ title }}</slot>
  </Link>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/inertia-vue3";

const props = withDefaults(defineProps<{
  title: string
  location: string
  method?: string|null
  as?: string|null
  external?: boolean
  isActive?: boolean
}>(), {
  external: false,
  isActive: false
})
</script>
