<template>
  <div class="px-4 py-3">
    <select @change="onValueChange" v-model="internalValue" class="w-full text-xs px-2 py-1">
      <option v-for="option in options" :value="option.id">{{ option.title }}</option>
    </select>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'

const emit = defineEmits(['update:modelValue'])

const props = defineProps<{
  id: string
  options: Array<{ id: string, title: string }>
  modelValue: string | null
}>()

const internalValue = ref<string>(props.modelValue === null ? props.options[0].id : props.modelValue)
if (props.modelValue === null) {
  emit('update:modelValue', internalValue.value)
}

const onValueChange = () => {
  emit('update:modelValue', internalValue.value)
}

watch(props, newProps => {
  if (props.modelValue !== newProps.modelValue) {
    internalValue.value = newProps.modelValue === null ? newProps.options[0].id : newProps.modelValue
    emit('update:modelValue', internalValue.value)
  }
})
</script>
