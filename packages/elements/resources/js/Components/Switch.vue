<template>
  <SwitchGroup>
    <div class="flex items-center" :class="[$attrs.class, { 'flex-row-reverse justify-end': placement == 'left' }]">
      <SwitchLabel class="text-sm" :class="{ 'text-red-600': hasError, 'ml-2': placement == 'left', 'mr-2 -mt-[3px]': placement == 'right'  }">
          <slot>
            <span class="text-sm mr-1" v-if="label">{{ label }}</span>
          </slot>
          <span v-if="required" class="text-danger-500">*</span>
      </SwitchLabel>
      <Switch
          v-model="checked"
          :class='checked ? "bg-primary-600" : "bg-gray-300"'
          class="relative inline-flex h-4 w-8 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
      >
        <span
            :class='checked ? "translate-x-5" : "translate-x-1"'
            class="inline-block h-2.5 w-2.5 transform rounded-full bg-white transition-transform"
        />
      </Switch>
    </div>
  </SwitchGroup>

  <p class="mt-1 text-xs text-danger-600" v-if="error">{{ error }}</p>
</template>
<script lang="ts">
export default {
  inheritAttrs: false
}
</script>
<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

const props = withDefaults(defineProps<{
  id?: string
  name?: string
  modelValue?: boolean
  error?: string|null
  label?: string|null
  required?: boolean
  placement: 'left' | 'right'
}>(), {
  placement: 'left'
})

const hasError = computed(() => !!props.error)

const emit = defineEmits(['update:modelValue', 'input'])

const checked = ref(props.modelValue)

watch(checked, newChecked => {
  emit('input', newChecked)
  emit('update:modelValue', newChecked)
})

watch(props, newProps => {
  if (newProps.modelValue != checked.value) {
    checked.value = newProps.modelValue
  }
})
</script>
