<template>
  <label :for="name" class="inline-flex items-start">
    <input
        type="checkbox"
        :id="id"
        :name="name"
        :class="[$attrs.class, {  'has-error': hasError }]"
        v-model="checked"
    >
    <span class="text-sm ml-2 -mt-[2.5px]" :class="{ 'text-red-600': hasError }">
      <slot>
        <span class="text-sm mr-1" v-if="label">{{ label }}</span>
      </slot>
      <span v-if="required" class="text-danger-500">*</span>
    </span>
  </label>
  <p class="mt-1 text-xs text-danger-600" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
import { computed, ref, watch } from "vue";

const props = defineProps<{
  id?: string
  name?: string
  modelValue?: boolean
  error?: string|null
  label?: string|null
  required?: boolean
}>()

const hasError = computed(() => !!props.error)

const emit = defineEmits(['update:modelValue', 'input'])

const checked = ref(props.modelValue)

watch(checked, newChecked => {
  emit('input', newChecked)
  emit('update:modelValue', newChecked)
})

watch(props, newProps => {
  if (newProps.modelValue != checked.value) {
    checked.value = newProps.modelValue
  }
})
</script>
