<script setup lang="ts">
// import
import NewNav from "@/Components/NewNav.vue"
import Sidebar from "@/Components/Sidebar.vue"
import { ref } from "vue";

// data
const sidebar = ref(true)
const sidebarForm = ref(false)

// methods
const toggleSidebarMobile = () => {
  sidebar.value =!sidebar.value
}

const toggleSidebarForm = (value:boolean) => {
  sidebarForm.value = value
}

</script>

<template>
  <div class="bg-gray-50 dark:bg-gray-900 h-[100vh]">
    <!-- nav -->
    <NewNav @toggleSidebar="toggleSidebarMobile()" />

    <!-- body -->
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
      <!-- sidebar -->
      <Sidebar v-if="sidebar" />

      <!-- content -->
      <div class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
        <main>
          <!-- Header -->
          <div
            class="p-9 bg-white block sm:flex items-center justify-between border-b border-gray-200  dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
              <header class="mb-4" v-if="$slots.header">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                  <slot name="header" />
                </h1>
              </header>
              <div v-if="$slots.button"
                class="items-center justify-end block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
                @click="toggleSidebarForm(true)"
                >
                <slot name="button" />
              </div>
            </div>
          </div>

          <div class="flex flex-col h-full">
            <slot />
          </div>
        </main>
      </div>
    </div>
  </div>
</template>