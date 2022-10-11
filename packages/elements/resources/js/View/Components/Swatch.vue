<template>
  <Listbox v-model="selectedColor" v-slot="{ open }">
    <div class="relative w-full select" :class="{ 'open': open }">
      <ListboxButton class="w-full relative text-left select-button" :class="{ 'open': open, 'has-error': hasError }">
        <div class="px-3 py-2 flex items-center">
          <div v-if="selectedColor" class="h-6 w-full inline-flex rounded-md" :style="{ backgroundColor: selectedColor }"></div>
          <span v-else>{{ noSelectionLabel }}</span>
        </div>
      </ListboxButton>
      <Transition enter-from-class="opacity-0" enter-to-class="opacity-100" enter-active-class="transition-opacity duration-150" leave-active-class="transition-opacity duration-150" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <ListboxOptions class="w-full focus:outline-none shadow-lg bg-white z-10 absolute max-h-60 overflow-x-hidden overflow-y-auto w-full border rounded-b-lg -mt-0.5 select-option-list" :class="[ hasError ? 'border-danger-300' : 'border-gray-300' ]">
          <ListboxOption as="template" v-for="option in options" :key="option" :value="option" v-slot="{ active, selected }">
            <li class="relative px-3 py-2 cursor-pointer flex items-center justify-center" :class="{ 'bg-primary-100 text-primary-900': active }">
              <div class="w-full h-8 rounded-lg" :style="{ backgroundColor: option }"></div>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </Transition>
    </div>
  </Listbox>
  <InputError :error="error" />
</template>
<script lang="ts">
export default {
  inheritAttrs: false
}
</script>
<script setup lang="ts">
import InputError from "../../Components/InputError.vue";

import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'
import { computed, ref, watch } from "vue";

const emit = defineEmits(['change', 'update:modelValue'])

const props = withDefaults(defineProps<{
  options: Array<string>
  modelValue?: string|null|undefined
  error?: string|null
  noSelectionLabel: string
}>(), {
  noSelectionLabel: 'Choose color…'
})

const hasError = computed(() => !!props.error)
const selectedColor = ref<string>(props.modelValue as string)

// Watches selected value and emits model update.
watch(selectedColor, newSelectedColor => {
  emit('change', newSelectedColor)
  emit('update:modelValue', newSelectedColor)
})

// Updates internal value when model was changed externally.
watch(props, newProps => {
  if (selectedColor.value != newProps.modelValue) {
    selectedColor.value = newProps.modelValue as string
  }
})
</script>
