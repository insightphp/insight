<template>
  <MenuItem :as="as" v-slot="{ active }">
    <slot />
  </MenuItem>
</template>
<script setup lang="ts">
import { MenuItem } from "@headlessui/vue";

withDefaults(defineProps<{
  as: string
}>(), {
  as: 'button'
})
</script>
