<template>
  <div class="border border-gray-200 rounded-md bg-white">
    <div class="flex flex-row items-center justify-between py-3 px-4">
      <div class="inline-flex flex-col">
        <div class="inline-flex items-center gap-2">
          <h4 class="text-lg font-semibold text-gray-900">Details</h4>
        </div>

        <!--<p class="text-sm text-gray-600 mt-1" v-if="subtitle">{{ subtitle }}</p>-->
      </div>

      <div class="inline-flex gap-3">
        <!--<button class="btn danger gap-2">-->
        <!--  <TrashIcon class="w-4 h-4" />-->
        <!--  Delete-->
        <!--</button>-->

        <button class="btn gap-2">
          <PencilIcon class="w-4 h-4" />
          Edit
        </button>
      </div>
    </div>

    <div class="border-t border-gray-200 flex flex-col divide-y divide-gray-200">
      <div class="w-full odd:bg-gray-50 flex flex-row px-4 py-3">
        <div class="w-1/3">
          <span class="text-sm text-gray-600">Name</span>
        </div>
        <div>
          <span class="text-sm text-gray-900">Peter Štovka</span>
        </div>
      </div>

      <div class="w-full odd:bg-gray-50 flex flex-row px-4 py-3">
        <div class="w-1/3">
          <span class="text-sm text-gray-600">Name</span>
        </div>
        <div>
          <span class="text-sm text-gray-900">Peter Štovka</span>
        </div>
      </div>

      <div class="w-full odd:bg-gray-50 flex flex-row px-4 py-3">
        <div class="w-1/3">
          <span class="text-sm text-gray-600">Name</span>
        </div>
        <div>
          <span class="text-sm text-gray-900">Peter Štovka</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { PencilIcon } from "@heroicons/vue/24/outline";
</script>
