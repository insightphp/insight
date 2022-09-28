<template>
  <div class="bg-white min-h-full">
    <slot name="header">
      <div class="fixed z-20 w-full">
        <!--<Portal for="header" />-->

        <Header @toggle-drawer="mobileOpen = !mobileOpen" :mobile-open="mobileOpen">
          <template #left-navigation>
            <ul>
              <li>Navigacia vľavo</li>
            </ul>
          </template>

          <template #right-navigation>
            <ul>
              <li>Navigacia vpravo</li>
            </ul>
          </template>
        </Header>
      </div>
    </slot>

    <slot name="sidebar">
      <Drawer :mobile-open="mobileOpen" />
    </slot>

    <div class="h-full min-w-max-content lg:pl-56 pt-16">
      <slot/>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Portal } from "@insightphp/inertia-view";
import { Drawer, Header } from "../../Components";
import { ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

const mobileOpen = ref(false)

const page = usePage()

console.log(page.props.value)
</script>
