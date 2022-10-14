<template>
<td class="row-select">
  <input v-model="props.selection.selected" type="checkbox">
</td>
</template>

<script setup lang="ts">
import type { RowSelection } from "../Composables";

const props = defineProps<{
  selection: RowSelection
}>()
</script>
