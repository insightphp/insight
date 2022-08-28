<template>
  <div class="space-y-6">
    <div v-for="item in items">
      <label class="block text-sm font-medium text-gray-700" v-if="item.label">
        {{ item.label }} <span v-if="item.isRequired" class="text-danger-500">*</span>
      </label>
      <div class="mt-1">
        <Portal
            :component="item.fieldView"
            :name="item.name"
            v-model="modelValue[item.name]"
            :inertia-form="modelValue"
            :errors="errors"
            :error="errors[item.name]"
            :field-path="[]"
        />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Portal } from "@insightphp/inertia-view-components";

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
</script>
