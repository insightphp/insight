<template>
  <MenuItem :as="as" v-slot="attributes">
    <slot v-bind="attributes" />
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
