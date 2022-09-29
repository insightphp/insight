<template>
  <div class="p-8">
    <h4 class="text-2xl font-medium">Welcome Back, Peter</h4>

    <div class="bg-white mt-6 border border-gray-200 shadow-sm drop-shadow-sm p-4 rounded-lg">
      <p>{{ location }}</p>
      <Link href="/insight/dashboard/overview">Dashboard / Overview</Link>
    </div>
    <div class="mt-4">
      <p>Counter: {{ counter }}</p>
      <button class="btn small mt-2" @click.prevent="counter++">Add</button>
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const counter = ref(1)

defineProps<{
  location: string
}>()
</script>
