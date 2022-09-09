<template>
  <input
      :value="modelValue"
      @input="onChange"
      class="form-input text-gray-900 w-full text-sm focus:ring-4 rounded-lg"
      :class="[$attrs.class, hasError ? 'border-danger-300 focus:border-danger-300 focus:ring-danger-100' : 'border-gray-300 focus:ring-primary-100 focus:border-primary-300' ]"
      :type="type"
      :placeholder="placeholder || undefined"
      :name="name"
      :id="name"
  >
  <p class="mt-1 text-xs text-danger-600" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
  name: string
  modelValue: string|null|number
  error: string|null
  type: string
  placeholder: string|null
}>()

const hasError = computed(() => !!props.error)

const emit = defineEmits(['update:modelValue', 'input'])

function onChange(event: Event & any) {
  emit('input', event.target?.value)
  emit('update:modelValue', event.target?.value)
}
</script>
