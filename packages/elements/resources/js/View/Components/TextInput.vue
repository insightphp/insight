<template>
  <input
      :value="modelValue"
      @input="onChange"
      class="form-input"
      :class="{ 'has-error': hasError }"
      :type="type"
      :placeholder="placeholder || undefined"
      :name="name"
      :id="id"
      v-bind="$attrs"
  >
  <p class="input-error" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = withDefaults(defineProps<{
  id?: string
  name?: string
  modelValue?: string|null|number
  error?: string|null
  type?: string
  placeholder?: string|null
}>(), {
  type: 'text'
})

const hasError = computed(() => !!props.error)

const emit = defineEmits(['update:modelValue', 'input'])

function onChange(event: Event & any) {
  emit('input', event.target?.value)
  emit('update:modelValue', event.target?.value)
}
</script>
