<template>
<div class="p-16">
  <div class="data-table border border-gray-200 rounded-md">
    <Portal class="table" v-if="resourcesTable" :component="resourcesTable" />
  </div>
</div>
</template>

<script setup lang="ts">
import { usePage } from "@inertiajs/inertia-vue3";
import type { Pages } from "../models";
import { Portal } from "@insightphp/inertia-view";
import { computed } from "vue";

const page = usePage<Pages.ListResourcesPage>()

const resourcesTable = computed(() => page.props.value.resources)
</script>
