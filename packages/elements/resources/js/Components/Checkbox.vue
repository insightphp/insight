<template>
  <label :for="name" class="inline-flex items-center">
    <input
        class="rounded focus:ring-primary-500 text-primary-600" type="checkbox" :id="name" :name="name" :value="modelValue" @change="onChange"
        :class="[$attrs.class,  hasError ? 'border-red-600' : 'border-gray-400']"
    >
    <span class="ml-2 text-sm" :class="{ 'text-red-600': hasError }" v-if="label">{{ label }} <span v-if="required" class="text-danger-500">*</span></span>
  </label>
  <p class="mt-1 text-xs text-danger-600" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
  name: string
  modelValue: string|null|number
  error: string|null
  label?: string|null
  required?: boolean
}>()

const hasError = computed(() => !!props.error)

const emit = defineEmits(['update:modelValue', 'input'])

function onChange(event: Event & any) {
  emit('input', event.target?.checked)
  emit('update:modelValue', event.target?.checked)
}
</script>
