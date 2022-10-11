<template>
<div class="p-16">
  <p>toto je resource index</p>

  <Portal v-if="resourcesTable" :component="resourcesTable" />
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
