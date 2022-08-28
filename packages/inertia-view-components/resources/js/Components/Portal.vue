<template>
  <component
      :is="component._component.name"
      v-bind="component"
  ><slot /></component>
</template>

<script setup lang="ts">
defineProps<{
  component: {
    _component: {
      name: string
    }
  }
}>()
</script>
