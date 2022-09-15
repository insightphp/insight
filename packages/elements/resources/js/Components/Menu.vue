<template>
<Menu as="div" class="relative inline-block">
  <MenuButton as="template">
    <slot name="toggle" />
  </MenuButton>

  <transition
      enter-active-class="transition duration-150"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
  >
  <MenuItems class="outline-menu absolute z-10" :class="[$attrs.class, {
    'left-0 mt-1': placement == 'bottom-left',
    'right-0 mt-1': placement == 'bottom-right',
  }]">
    <slot />
  </MenuItems>
  </transition>
</Menu>
</template>
<script lang="ts">
export default {
  inheritAttrs: false
}
</script>
<script setup lang="ts">
import { Menu, MenuButton, MenuItems } from '@headlessui/vue'

const props = withDefaults(defineProps<{
  placement: 'bottom-left' | 'bottom-right'
}>(), {
  placement: 'bottom-left'
})
</script>
