<template>
  <div class="flex flex-col w-full">
    <div class="inline-flex items-center px-2 py-2" :class="{ 'border-b': ! (isLast && ! modelValue) }">
      <input @change="onToggle" :checked="modelValue" :id="`filter-toggle-${id}`" type="checkbox" class="form-check">
      <label class="text-sm ml-2 font-medium" :for="`filter-toggle-${id}`">{{ name }}</label>
    </div>

    <div v-show="modelValue" class="bg-gray-25" :class="{ 'rounded-b': isLast }">
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
const emit = defineEmits(['update:modelValue'])

const props = defineProps<{
  isLast: boolean
  id: string
  name: string
  modelValue: boolean
}>()

const onToggle = (event: any) => {
  emit('update:modelValue', event.target.checked)
}
</script>
