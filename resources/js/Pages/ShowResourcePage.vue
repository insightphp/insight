<template>
  <div class="flex flex-col w-full">
    <Portal v-if="page.props.value.details" :component="page.props.value.details" />
  </div>
</template>

<script setup lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import type { Pages } from "../models";
import { Portal } from "@insightphp/inertia-view";

const page = usePage<Pages.ShowResourcePage>()
</script>
