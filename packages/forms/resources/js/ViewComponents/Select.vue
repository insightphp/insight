<template>
  <select
      class="text-gray-900 w-full text-sm focus:ring-4 rounded-lg"
      :class="[$attrs.class, hasError ? 'border-danger-300 focus:border-danger-300 focus:ring-danger-100' : 'border-gray-300 focus:ring-primary-100 focus:border-primary-300' ]"
      :name="name"
      :id="name"
  >
    <option v-for="option in options" :value="option.value">{{ option.label }}</option>
  </select>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
  name: string
  modelValue: string|null|number
  error: string|null
  options: Array<{
    label: string
    value: any
    options: { [key: string]: any }
  }>
}>()

const hasError = computed(() => !!props.error)
</script>
