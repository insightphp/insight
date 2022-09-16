<template>
  <Portal
      :component="handler.formModel.renderAs"
      v-model="handler.form"
      :errors="handler.form.errors"
      @clear-error="onClearError($event)"
  />
</template>

<script setup lang="ts">
import type { FormHandler } from "../Composables";
import { Portal } from "@insightphp/inertia-view-components";
import { computed } from "vue";

const props = defineProps<{
  form: FormHandler
}>()

const handler = computed(() => props.form)

const onClearError = (name: string) => {
  if (handler.value.form.errors[name]) {
    handler.value.form.clearErrors(name)
  }
}
</script>
