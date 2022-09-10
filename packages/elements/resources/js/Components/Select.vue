<template>
  <Listbox :multiple="multiple" class="w-full" :class="$attrs.class" as="div" v-model="selectedValue" :name="name" v-slot="{ open }">
    <div class="relative w-full">
      <ListboxButton
          class="w-full relative text-left py-2 px-3 border bg-white ring-transparent ring-4 text-sm focus:outline-none"
          :class="[
              open ? 'border-b-transparent rounded-t-lg' : 'rounded-lg',
              hasError ? 'border-danger-300 focus:border-danger-300 focus:ring-danger-100' : 'border-gray-300 focus:border-primary-300 focus:ring-primary-100'
          ]"
      >
        <span>{{ selectedLabel }}</span>
        <span class="absolute top-0 bottom-0 flex items-center right-0 pr-3 text-gray-500">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
          </svg>
        </span>
      </ListboxButton>
      <Transition
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          enter-active-class="transition-opacity duration-150"
          leave-active-class="transition-opacity duration-150"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
      >
        <ListboxOptions class="bg-white w-full focus:outline-none shadow-lg -mt-0.5 border absolute z-10 max-h-60 rounded-b-lg"
                        :class="[ hasError ? 'border-danger-300' : 'border-gray-300' ]"
        >
          <ListboxOption
              v-for="option in options"
              :key="option.value"
              :value="option"
              as="template"
              v-slot="{ active, selected }"
          >
            <li class="relative pl-3 py-2 cursor-pointer last:rounded-b-lg" :class="[
                selected ? 'text-primary-900 font-medium' : '',
                active ? 'bg-primary-100 text-primary-900' : '',
              ]">
              <span class="text-sm">{{ option.label }}</span>

              <span v-if="selected" class="absolute top-0 bottom-0 right-0 flex items-center pr-3">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </Transition>
    </div>
  </Listbox>
  <p class="input-error" v-if="error">{{ error }}</p>
</template>
<script lang="ts">
export default {
  inheritAttrs: false
}
</script>
<script setup lang="ts">
import { computed, ref } from "vue";
import type { Option } from "./contracts";

import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'

const props = defineProps<{
  name?: string
  modelValue?: Array<Option>|Option|Array<string>|string
  error?: string|null
  options: Array<Option>
  multiple?: boolean
}>()

const hasError = computed(() => !!props.error)

const isMultiple = computed(() => !!props.multiple)

const selectedValue = ref<Array<Option>|Option|null>(isMultiple.value ? [] : null)

const selectedLabel = computed(() => {
  if (isMultiple.value) {
    if ((selectedValue.value as Array<Option>).length > 0) {
      return 'Multiple values selected'
    } else {
      return 'Select values…'
    }
  }

  if (selectedValue.value) {
    return (selectedValue.value as Option).label
  }

  return 'Select value…'
})
</script>
