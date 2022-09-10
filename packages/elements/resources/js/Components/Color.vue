<template>
  <input
      :value="modelValue"
      @input="onChange"
      class="h-8 p-2 bg-white border rounded-lg ring-4 ring-transparent"
      :class="[ hasError? 'border-danger-300 focus:border-danger-300 focus:ring-danger-100' : 'border-gray-200 focus:ring-primary-100 focus:border-primary-300']"
      :name="name"
      :id="id"
      type="color"
      v-bind="$attrs"
  >
  <p class="input-error" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps<{
  id?: string
  name?: string
  modelValue?: string|null|number
  error?: string|null
}>()

const hasError = computed(() => !!props.error)

const emit = defineEmits(['update:modelValue', 'input'])

function onChange(event: Event & any) {
  emit('input', event.target?.value)
  emit('update:modelValue', event.target?.value)
}
</script>
