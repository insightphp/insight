<template>
  <div class="inline-flex items-center gap-3">
    <template v-for="link in links">
      <template v-if="link.type == 'prev'">
        <Link v-if="link.url" :href="link.url" class="btn gap-2">
          <ArrowLeftIcon class="w-4 h-4" />
          <span v-html="previousLabel || link.title"></span>
        </Link>
        <button disabled v-else class="btn gap-2">
          <ArrowLeftIcon class="w-4 h-4" />
          <span v-html="previousLabel || link.title"></span>
        </button>
      </template>
    </template>

    <div class="inline-flex items-center gap-2">
      <template v-for="link in links">
        <Link v-if="link.type == 'page' && link.url" :href="link.url" class="btn" :class="{ 'bg-gray-100 border-gray-100': link.active, 'border-transparent text-gray-500': !link.active }">{{ link.title }}</Link>
        <span v-else-if="link.type == 'page' && !link.url" :class="{ 'bg-gray-100 border-gray-100': link.active, 'border-transparent text-gray-500': !link.active }">{{ link.title }}</span>
      </template>
    </div>

    <template v-for="link in links">
      <template v-if="link.type == 'next'">
        <Link v-if="link.url" :href="link.url" class="btn gap-2">
          <span v-html="nextLabel || link.title"></span>
          <ArrowRightIcon class="w-4 h-4" />
        </Link>
        <button disabled v-else class="btn gap-2">
          <span v-html="nextLabel || link.title"></span>
          <ArrowRightIcon class="w-4 h-4" />
        </button>
      </template>
    </template>
  </div>
</template>

<script setup lang="ts">
import { ArrowLeftIcon, ArrowRightIcon } from '@heroicons/vue/24/outline'
import type { Models } from "../View/Components";
import { Link } from "@inertiajs/inertia-vue3";

withDefaults(defineProps<{
  links: Array<Models.PaginationLink>
  previousLabel?: string|null
  nextLabel?: string|null
}>(), {
  previousLabel: 'Previous',
  nextLabel: 'Next'
})
</script>
