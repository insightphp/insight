<template>
  <p class="input-error" v-if="error">{{ error }}</p>
</template>

<script setup lang="ts">
defineProps<{
  error?: string|null
}>()
</script>
