<template>
  <div class="p-8">
    <p>this is home page {{ counter }}</p>
    <button @click.prevent="counter++">Add</button>
  </div>
</template>
<script setup lang="ts">
import { ref } from "vue";

const counter = ref(1)
</script>
