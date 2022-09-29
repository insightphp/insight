<template>
  <a v-if="external" :href="location">
    <slot>{{ title }}</slot>
  </a>
  <Link v-else :href="location">
    <slot>{{ title }}</slot>
  </Link>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/inertia-vue3";
import type { Models } from "../../models";
import { useActivatedLink } from "../../Composables";
import { computed, watch } from "vue";

const props = withDefaults(defineProps<{
  title: string
  location: string
  method?: string|null
  as?: string|null
  external?: boolean
  isActive?: Models.LinkActivation|null
}>(), {
  external: false
})

const { active, updateActivation } = useActivatedLink(props.isActive || null)
const activation = computed(() => props.isActive)
watch(activation, newActivation => updateActivation(newActivation || null))
</script>
