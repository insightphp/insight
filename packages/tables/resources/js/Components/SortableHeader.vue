<template>
<button
    @click.prevent="toggleSort"
    class="inline-flex items-center gap-1 group hover:text-primary-600 transition-colors duration-150"
    :class="{ 'text-primary-600': isSorted }"
>
  <slot />
  <template v-if="isSorted">
    <ArrowSmallUpIcon v-if="isSortedAsc" class="w-4 h-4" />
    <ArrowSmallDownIcon v-else class="w-4 h-4" />
  </template>
  <ArrowsUpDownIcon v-else class="w-4 h-4 text-gray-400 group-hover:text-primary-600 transition-colors duration-150" />
</button>
</template>

<script setup lang="ts">
import { ArrowSmallUpIcon, ArrowSmallDownIcon, ArrowsUpDownIcon } from "@heroicons/vue/24/outline";
import { packSortAs, unpackSortAs } from "../Composables/use-data-table";
import { computed, ref, watch } from "vue";

const emit = defineEmits(['updateSortAs'])

const props = withDefaults(defineProps<{
  sortableAs: string
  sortedAs: string
  firstSort?: 'asc' | 'desc'
  defaultSortAs?: string
  defaultSortDirection?: 'asc' | 'desc'
}>(), {
  firstSort: 'desc',
  defaultSortDirection: 'desc',
})

const secondSort = computed(() => props.firstSort === 'asc' ? 'desc' : 'asc')

const isCurrentlySorted = () => {
  const current = unpackSortAs(props.sortedAs)

  if (current.sortAs === props.sortableAs) {
    return true
  }

  if (current.sortAs === '' && props.defaultSortAs === props.sortableAs) {
    return true
  }

  return false
}

const isCurrentlySortedAsc = () => {
  const sorted = unpackSortAs(props.sortedAs)

  if (sorted.sortAs === props.sortableAs && sorted.direction === 'asc') {
    return true
  }

  if (props.defaultSortAs === props.sortableAs && sorted.sortAs === '' && props.defaultSortDirection === 'asc') {
    return true
  }

  return false
}

const isSorted = ref(isCurrentlySorted())
const isSortedAsc = ref(isCurrentlySortedAsc())

watch(props, () => {
  isSorted.value = isCurrentlySorted()
  isSortedAsc.value = isCurrentlySortedAsc()
})

const nextSort = () => {
  const current = unpackSortAs(props.sortedAs)

  if (props.defaultSortAs === props.sortableAs) {
    if (isCurrentlySortedAsc()) {
      return props.defaultSortDirection === 'desc' ? '' : packSortAs(props.sortableAs, 'desc')
    } else {
      return props.defaultSortDirection === 'asc' ? '' : packSortAs(props.sortableAs, 'asc')
    }
  }

  if (current.sortAs === props.sortableAs) {
    if (current.direction === props.firstSort) {
      return packSortAs(props.sortableAs, secondSort.value)
    } else if (current.direction === secondSort.value) {
      return ''
    }
  }

  return packSortAs(props.sortableAs, props.firstSort)
}

const toggleSort = () => {
  emit('updateSortAs', nextSort())
}
</script>
