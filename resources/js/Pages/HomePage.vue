<template>
<p>this is home page {{ counter }}</p>
</template>

<script setup lang="ts">
import { ref } from "vue";

const counter = ref(1)
</script>
