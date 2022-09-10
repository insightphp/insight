<template>
  <select
      :class="{ 'has-error': hasError }"
      :name="name"
      :id="id"
      v-bind="$attrs"
  >
    <template v-if="options">
      <option v-for="option in options" :value="option.value">{{ option.label }}</option>
    </template>
  </select>
  <p class="input-error" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
import { computed } from "vue";
import type { Option } from "./contracts";

const props = defineProps<{
  id?: string
  name?: string
  modelValue?: string|null|number
  error?: string|null
  options: Array<Option>
}>()

const hasError = computed(() => !!props.error)
</script>
