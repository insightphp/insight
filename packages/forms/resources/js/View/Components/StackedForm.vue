<template>
<form @submit.prevent="submit" class="border border-gray-200 rounded-md bg-white flex flex-col divide-y divide-gray-200">
  <template v-for="control in controls">
    <Portal
        :component="control"
        :form="form"
    />
  </template>
  <div class="flex justify-end bg-gray-50 rounded-b-md px-4 py-3">
    <button type="submit" class="btn primary">Submit</button>
  </div>
</form>
</template>

<script setup lang="ts">
import type { Component } from "@insightphp/inertia-view";
import { Portal } from "@insightphp/inertia-view";
import { useForm } from "@inertiajs/inertia-vue3";
import { Method } from "@inertiajs/inertia";

const props = defineProps<{
  // TODO: ADD FORM CONTROL TYPE
  controls: Array<Component<{
    name: string
  }>>
  value: any
  method: Method
  action: string
}>()

const form = useForm(props.value)

const submit = () => {
  if (props.method && props.action) {
    form.submit(props.method, props.action, {

    })
  } else {
    console.warn("The form does not have action/method set and is unable to be submited.")
  }
}
</script>
