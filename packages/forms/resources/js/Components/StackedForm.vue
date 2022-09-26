<template>
  <div class="space-y-6">
    <div v-for="item in items">
      <label :for="item.name" class="block text-sm font-medium text-gray-700" v-if="item.label">
        {{ item.label }} <span v-if="item.isRequired" class="text-danger-500">*</span>
      </label>
      <p class="text-xs text-gray-500 mt-0.5 mb-1" v-if="item.hint">{{ item.hint }}</p>
      <div class="mt-1">
        <Portal
            :component="item.fieldView"
            :name="item.name"
            v-model="modelValue[item.name]"
            :inertia-form="modelValue"
            :errors="errors"
            :error="errors[item.name]"
            :field-path="[]"
            :required="item.isRequired"
            @input="onInput(item, $event)"
            class="w-full"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Portal } from "@insightphp/inertia-view";

const emit = defineEmits(['input', 'clearError'])

defineProps<{
  items: Array<{
    label: string|null
    name: string
    hint: string|null
    isRequired: boolean
    fieldView: any
  }>
  modelValue: any
  errors: Record<string, string>
}>()

const onInput = (item: { name: string }, value: any) => {
  emit('input', { name: item.name, value: value })
  emit('clearError', item.name)
}
</script>
