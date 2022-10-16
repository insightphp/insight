<template>
  <div class="w-full flex flex-row px-4 py-3 grid grid-cols-3">
    <div class="pt-1.5">
      <label class="text-sm text-gray-600" :for="name" v-if="label">{{ label }} <span class="text-danger-500" v-if="isRequired">*</span></label>
    </div>
    <div class="col-span-2">
      <Portal
          class="w-full"
          v-if="control"
          :name="name"
          :component="control"
          v-model="form[name]"
          :error="form.errors[name]"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import type { InertiaForm } from "@inertiajs/inertia-vue3";

defineProps<{
  name: string
  label: string|null
  isRequired: boolean
  control: Component
  form: InertiaForm<any>
}>()
</script>
