<template>
<p>Are you sure you want to delete user with name {{ name }}?</p>
</template>

<script setup lang="ts">
defineProps<{
  name: string
}>()
</script>
