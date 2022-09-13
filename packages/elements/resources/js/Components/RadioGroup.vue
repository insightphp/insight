<template>
  <div class="inline-flex" :class="{
    'flex-col space-y-2': placement == 'vertical',
    'flex-row space-x-2': placement == 'horizontal',
  }">
    <Radio
        v-for="(option, index) in options"
        :id="`${id}-option-${index}`"
        :label="option[labelBy]"
        :value="option[by]"
        v-model="selectedValue"
    />
  </div>
  
  <InputError :error="error" />
</template>

<script setup lang="ts">
import { Radio } from "./";
import { ref, watch } from "vue";
import InputError from "./InputError.vue";

type Option = { [key: string]: any }

const emit = defineEmits(['change', 'update:modelValue'])

const props = withDefaults(defineProps<{
  id?: string
  options: Array<Option>
  placement?: 'horizontal' | 'vertical'
  by?: string
  labelBy?: string
  modelValue?: Option|null
  error?: string|null
}>(), {
  id: 'radio-group',
  placement: 'vertical',
  by: 'value',
  labelBy: 'label',
})

// Resolve the value identifier which is used for value comparsion.
function resolveIdentifier(value: Option|undefined|null|{[key: string]: any}): string|null {
  return value ? (value as { [key: string]: any })[props.by] : null
}

// Resolve selected value from list of available options.
function resolveSelectedValue(availableOptions: Array<Option>, modelValue: Option|null|undefined) {
  return modelValue ? availableOptions.find(it => resolveIdentifier(it) == resolveIdentifier(modelValue)) : undefined
}

const selectedValue = ref<string|number|undefined>(resolveIdentifier(resolveSelectedValue(props.options, props.modelValue)) || undefined)

function findSelectedValueOption(id: string|number|undefined|null) {
  return props.options.find(it => resolveIdentifier(it) == id)
}

// Watches selected value and emits model update.
watch(selectedValue, newSelectedValue => {
  const value = findSelectedValueOption(newSelectedValue)

  emit('change', value)
  emit('update:modelValue', value)
})

// Updates internal value when model was changed externally.
watch(props, newProps => {
  const newSelection = resolveIdentifier(newProps.modelValue) || undefined

  if (selectedValue.value != newSelection) {
    selectedValue.value = newSelection
  }
})
</script>
