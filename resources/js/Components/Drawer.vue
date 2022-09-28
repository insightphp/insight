<template>
<div class="fixed bg-white border-r border-gray-200 z-10 min-h-full h-full w-full sm:w-56 pt-16 lg:left-0 transition-all duration-300"
    :class="[mobileOpen ? 'left-0' : '-left-full sm:-left-56']"
>
  <div class="px-4 pt-4">
    <ul class="side-menu">
      <li><a href="">Dashboard</a></li>
      <li><a href="">Projects</a></li>
      <li><a href="">Issues</a></li>
      <li>
        <button>Projects</button>
        <ul>
          <li><a href="">Elements</a></li>
          <li><a href="">Forms</a></li>
          <li><a href="">Tables</a></li>
        </ul>
        <span class="caret"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg></span>
      </li>
      <li class="expanded">
        <button>Settings</button>
        <ul>
          <li><a href="">Profile</a></li>
          <li><a href="">Team</a></li>
          <li class="expanded">
            <button>Billing</button>
            <ul>
              <li><a href="">Invoices</a></li>
              <li class="expanded">
                <button>Payments</button>
                <ul>
                  <li><a href="">History</a></li>
                  <li class="active"><a href="">Failed Payments</a></li>
                </ul>
                <span class="caret"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg></span>
              </li>
            </ul>
            <span class="caret"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg></span>
          </li>
        </ul>
        <span class="caret"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg></span>
      </li>
    </ul>
  </div>
</div>
</template>

<script setup lang="ts">
const emit = defineEmits(['mobileClose'])

withDefaults(defineProps<{
  mobileOpen: boolean
}>(), {
  mobileOpen: false
})
</script>
