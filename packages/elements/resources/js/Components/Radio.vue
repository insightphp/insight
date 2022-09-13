<template>
  <div class="inline-flex flex-row">
    <input :id="id" :name="name" :value="value" v-model="selectedValue" type="radio">
    <label class="text-sm -mt-[2px] ml-1" :class="{ 'text-danger-600': hasError }" :for="id">
      <slot>
        {{ label }}
      </slot>
    </label>
  </div>
  <InputError :error="error" />
</template>

<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { InputError } from "./";

const props = defineProps<{
  id?: string
  name?: string
  value?: string|number
  modelValue?: string|number
  error?: string|null
  label?: string
}>()

const hasError = computed(() => !!props.error)

const emit = defineEmits(['update:modelValue', 'input'])
const selectedValue = ref(props.modelValue)

watch(selectedValue, newChecked => {
  emit('input', newChecked)
  emit('update:modelValue', newChecked)
})

watch(props, newProps => {
  if (newProps.modelValue != selectedValue.value) {
    selectedValue.value = newProps.modelValue
  }
})
</script>
