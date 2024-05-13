<script setup lang="ts">
// import
import { Link } from '@inertiajs/vue3';
import menu from "../Components/Menu.json";

</script>

<template>
  <div>
    <aside id="sidebar"
      class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
      aria-label="Sidebar">
      <div
        class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
          <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            <ul class="pb-2 space-y-2">
              <li v-for="item in menu">
                <Link
                  :href="route(item.route)"
                  class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700"
                  :class="route().current(item.route) ? 'bg-gray-700' : ''"
                  >
                  <font-awesome-icon :icon="['fas', item.icon]" />
                  <span class="ml-3">{{ item.name }}</span>
                </Link>
              </li>
            </ul>
          </div>
        </div>
        <div
          class="absolute bottom-0 left-0 justify-start hidden w-full p-4 space-x-4 bg-white lg:flex dark:bg-gray-800"
          sidebar-bottom-menu="">
          <Link :href="route('logout')" method="post" as="button"
            class="inline-flex items-center p-2 w-full text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
            <font-awesome-icon :icon="['fas', 'sign-out-alt']" size="lg"/>
            <span class="ml-3">Cerrar session</span>
          </Link>
        </div>
      </div>
    </aside>
  </div>
</template>