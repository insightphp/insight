<template>
  <div class="flex flex-col w-full px-2 py-1">
    <div class="inline-flex flex-row items-center py-0.5" v-for="value in internalValue">
      <input v-model="value.selected" :id="`checkbox-option-${id}-${value.option.id}`" type="checkbox">
      <label class="text-sm text-gray-700 ml-2" :for="`checkbox-option-${id}-${value.option.id}`">{{ value.option.title }}</label>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, watch } from "vue";

const emit = defineEmits(['update:modelValue'])

interface Option {
  id: string
  title: string
}

const props = defineProps<{
  id: string
  options: Array<Option>
  modelValue: Array<string>
}>()

const internalValue = reactive<Array<{ option: Option, selected: boolean }>>(
    props.options.map(it => ({ option: it, selected: props.modelValue.includes(it.id) }))
)

watch(internalValue, newValue => {
  emit('update:modelValue', newValue.filter(it => it.selected).map(it => it.option.id).sort())
})

emit('update:modelValue', internalValue.filter(it => it.selected).map(it => it.option.id).sort())
</script>
