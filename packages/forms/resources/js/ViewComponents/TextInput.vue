<template>
  <input
      :value="modelValue"
      @input="onChange"
      class="form-input text-sm"
      :class="[$attrs.class, { 'has-error': !!error }]"
      :type="type"
      :placeholder="placeholder || undefined"
  >
  <p class="mt-1 text-xs text-danger-600" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
defineProps<{
  name: string
  modelValue: string|null|number
  error: string|null
  type: string
  placeholder: string|null
}>()

const emit = defineEmits(['update:modelValue'])

function onChange(event: Event & any) {
  emit('update:modelValue', event.target?.value)
}
</script>
