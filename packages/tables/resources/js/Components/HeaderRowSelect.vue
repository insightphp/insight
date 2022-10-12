<template>
  <th class="header-row-select">
    <!--<button @click.prevent="toggleSelection">toggle</button>-->
    <input @click="toggleSelection" ref="checkbox" type="checkbox">
  </th>
</template>

<script setup lang="ts">
import type { RowSelectionSummary } from "../Composables";
import { onMounted, ref, watch } from "vue";

const emit = defineEmits(['selectNothing', 'selectEverything'])

const props = defineProps<{
  selectionSummary?: RowSelectionSummary
}>()

const checkbox = ref<HTMLInputElement>()

const setChecked = (value: boolean) => {
  const box = checkbox.value
  if (box) {
    box.checked = value
  }
}

const setIndeterminate = (value: boolean) => {
  const box = checkbox.value
  if (box) {
    box.indeterminate = value
  }
}

const setEverything = () => {
  setChecked(true)
  setIndeterminate(false)
}

const setNothing = () => {
  setChecked(false)
  setIndeterminate(false)
}

const setSomething = () => {
  setChecked(false)
  setIndeterminate(true)
}

const toggleSelection = (event: Event) => {
  event.preventDefault()
  event.stopImmediatePropagation()
  event.stopPropagation()

  if (props.selectionSummary == 'something' || props.selectionSummary == 'nothing') {
    emit('selectEverything')
  } else if (props.selectionSummary == 'everything') {
    emit('selectNothing')
  }

  return false
}

const setSelection = (selection: RowSelectionSummary) => {
  if (selection == 'everything') {
    setEverything()
  } else if (selection == 'something') {
    setSomething()
  } else if (selection == 'nothing') {
    setNothing()
  }
}

onMounted(() => {
  if (props.selectionSummary) {
    setSelection(props.selectionSummary)
  }
})

watch(props, newProps => {
  // Little workaround since HTML click on element is fired
  // after we set selection on the checkbox thus our selection is overwritten.
  setTimeout(() => {
    if (newProps.selectionSummary) {
      setSelection(newProps.selectionSummary)
    }
  })
})
</script>
