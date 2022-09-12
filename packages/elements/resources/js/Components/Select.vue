<template>
  <Listbox :multiple="multiple" :by="by" class="w-full" :class="$attrs.class" as="div" v-model="selectedValue" :name="name" v-slot="{ open }">
    <div class="relative w-full select" :class="{ 'open': open }">
      <ListboxButton class="w-full relative text-left select-button" :class="{ 'open': open, 'has-error': hasError }">
        <slot name="button" v-bind="{ clear, showClearButton: nullable && isSelected, label, open, value: selectedValue }">
          <SelectButton @clear="clear" :show-clear-button="nullable && isSelected" :label="label" />
        </slot>

        <slot name="multiSelection" v-bind="{ deselect: deselectOption, show: multiple && isSelected, selected: selectedValue, labelBy }">
          <div v-if="multiple && isSelected" class="flex flex-row flex-wrap border-t px-2 pt-2" :class="[ hasError ? 'border-danger-300' : 'border-gray-300' ]">
            <button tabindex="-1" @click.prevent="deselectOption(option)" class="focus:outline-none hover:border-primary-300 hover:bg-primary-200 hover:text-primary-700 transition-colors duration-150 mr-2 mb-2 px-1.5 py-0.5 rounded-lg text-xs inline-flex bg-primary-100 border-primary-200 border text-primary-900 items-center font-medium" :key="option[by]" v-for="option in selectedValue">
              {{ option[labelBy] }}
              <svg class="w-3.5 h-3.5 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
          <p v-if="maxLimitEnabled && maximumSelected" class="px-2 text-warning-700 text-xs inline-flex items-center font-medium mb-2 -mt-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
              <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
            </svg>
            {{ maxOptionsSelectedLabel }}
          </p>
        </slot>
      </ListboxButton>
      <Transition enter-from-class="opacity-0" enter-to-class="opacity-100" enter-active-class="transition-opacity duration-150" leave-active-class="transition-opacity duration-150" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <ListboxOptions class="w-full focus:outline-none shadow-lg bg-white z-10 absolute max-h-60 overflow-x-hidden overflow-y-auto w-full border rounded-b-lg -mt-0.5 select-option-list" :class="[ hasError ? 'border-danger-300' : 'border-gray-300' ]">
          <div v-if="searchable" class="w-full pl-2 pr-3 py-2 relative border-b border-gray-300 w-full">
            <div class="pointer-events-none absolute top-0 pl-4 bottom-0 left-0 flex items-center">
              <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>

            <input v-model="searchTerm" class="w-full py-1 pl-7 text-xs" :placeholder="searchPlaceholder" @keydown="handleKeyDownInput" type="text">
          </div>

          <template v-if="filteredOptions.length > 0">
            <ListboxOption v-for="option in filteredOptions" :key="option[by]" :value="option" as="template" v-slot="{ active, selected }" :disabled="maximumSelected && !isOptionSelected(option)">
              <slot name="option" v-bind="{ active, selected, option, labelBy }">
                <SelectOption :show-icon="showOptionIcon" :active="active" :selected="selected" :option="option" :label-by="labelBy" />
              </slot>
            </ListboxOption>
          </template>

          <ListboxOption v-else-if="isSearching" :disabled="true">
            <slot name="noOptions">
              <span class="text-xs text-warning-600 px-3 py-4 inline-flex items-center">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                {{ noResultsFoundLabel }}
              </span>
            </slot>
          </ListboxOption>

          <ListboxOption v-else :disabled="true">
            <slot name="noOptions">
              <span class="text-xs text-warning-600 px-3 py-4 inline-flex items-center">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                {{ noOptionsLabel }}
              </span>
            </slot>
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
import { computed, ref, watch } from "vue";
import SelectOption from "./SelectOption.vue";
import { Listbox, ListboxButton, ListboxOptions, ListboxOption } from '@headlessui/vue'
import SelectButton from "./SelectButton.vue";

type Option = { [key: string]: any }

type InternalValue = Array<Option>|Option

const emit = defineEmits(['update:modelValue', 'change'])

const handleKeyDownInput = (event: Event) => {
  event.stopPropagation()
  event.stopImmediatePropagation()
}

const props = withDefaults(defineProps<{
  name?: string
  modelValue?: Array<Option>|Option
  error?: string|null
  options: Array<Option>
  multiple?: boolean
  by?: string
  labelBy?: string
  nullable?: boolean
  noSelectionLabel?: string
  showOptionIcon?: boolean
  noOptionsLabel?: string
  noResultsFoundLabel?: string
  searchPlaceholder?: string
  searchable?: boolean
  searchableBy?: string
  maxOptionsSelectedLabel?: string
  max?: number
}>(), {
  by: 'value',
  labelBy: 'label',
  multiple: false,
  nullable: false,
  noSelectionLabel: 'Select value…',
  showOptionIcon: false,
  noOptionsLabel: 'No options available.',
  noResultsFoundLabel: 'No results found.',
  searchPlaceholder: 'Search…',
  searchable: false,
  searchableBy: 'label',
  max: -1,
  maxOptionsSelectedLabel: 'Maximum options selected.'
})

const maxLimitEnabled = computed(() => props.multiple && props.max > 0)
const maximumSelected = computed(() => maxLimitEnabled.value && (selectedValue.value as Array<Option>).length >= props.max)

const isOptionSelected = (option: Option) => {
  if (props.multiple) {
    return !!(selectedValue.value as Array<Option>).find(it => resolveIdentifier(option) == resolveIdentifier(it))
  }

  return resolveIdentifier(option) == resolveIdentifier(selectedValue.value)
}

const hasError = computed(() => !!props.error)
const isMultiple = computed(() => !!props.multiple)
const isSelected = computed(() => props.multiple ? (selectedValue.value as Array<Option>).length > 0 : selectedValue.value != null)

const searchTerm = ref('')
const isSearching = computed(() => !!searchTerm.value)

const matchesSearchTerm = (labelValue: string, termValue: string) => {
  const normalizeToken = (token: string) => token.toLowerCase().replace(/\s/g, '')

  return normalizeToken(labelValue).includes(normalizeToken(termValue))
}

const filteredOptions = computed(() => props.searchable ? props.options.filter(it => matchesSearchTerm(it[props.searchableBy], searchTerm.value)) : props.options)

// Resolve the value identifier which is used for value comparsion.
function resolveIdentifier(value: Option|undefined|null|{[key: string]: any}): string|null {
  return value ? (value as { [key: string]: any })[props.by] : null
}

// Resolve selected value from list of available options.
function resolveSelectedValue(availableOptions: Array<Option>, modelValue: InternalValue|undefined) {
  if (isMultiple.value) {
    if (Array.isArray(modelValue)) {
      const isSelected = (option: Option, selectedOptions: Array<Option>) => !!selectedOptions.find(it => resolveIdentifier(it) == resolveIdentifier(option))

      return availableOptions.filter(it => isSelected(it, modelValue))
    }

    throw new Error("The v-model is not array. When Select is in multiple mode, the v-model must be an array.")
  }

  if (modelValue) {
    if (Array.isArray(modelValue)) {
      throw new Error("The v-model passed is array, but the Select does not have :multiple attribute set.")
    }

    return availableOptions.find(it => resolveIdentifier(it) == resolveIdentifier(modelValue))
  }

  return undefined
}

// Internal value of the select.
const selectedValue = ref<InternalValue|undefined>(resolveSelectedValue(props.options as any, props.modelValue))

// Watches selected value and emits model update.
watch(selectedValue, newSelectedValue => {
  emit('change', newSelectedValue)
  emit('update:modelValue', newSelectedValue)
})

// Determine if the model has changed.
function areModelsDifferent(oldModelValue: Array<Option>|Option|undefined, newModelValue: Array<Option>|Option|undefined) {
  if (isMultiple.value) {
    return (oldModelValue as Array<Option>).map(it => resolveIdentifier(it)).filter(it => !!it).sort().join()
        != (newModelValue as Array<Option>).map(it => resolveIdentifier(it)).filter(it => !!it).sort().join()
  }

  return resolveIdentifier(newModelValue) != resolveIdentifier(oldModelValue)
}

// Updates internal value when model was changed externally.
watch(props, newProps => {
  if (areModelsDifferent(selectedValue.value as any, newProps.modelValue)) {
    selectedValue.value = resolveSelectedValue(newProps.options as any, newProps.modelValue)
  }
})

// The label of currently selected value.
const label = computed(() => {
  if (isMultiple.value) {
    return props.noSelectionLabel;
  }

  if (selectedValue.value) {
    return (selectedValue.value as { [key: string]: any })[props.labelBy]
  }

  return props.noSelectionLabel
})

// Clears the selected value.
const clear = () => {
  selectedValue.value = isMultiple.value ? [] : undefined
}

// Deselects the option.
const deselectOption = (option: Option) => {
  selectedValue.value = (selectedValue.value as Array<Option>).filter(it => resolveIdentifier(it) != resolveIdentifier(option))
}
</script>
