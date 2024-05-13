<script setup >
//import
import NavLink from './NavLink.vue';
import { defineEmits } from 'vue';

// data
const emit = defineEmits(['toggleSidebar']);

// methods
const toggleSidebar = () => {
  emit('toggleSidebar');
};

</script>

<template>
  <nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
      <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
          <div class="flex items-center justify-start">
            <button
              class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
              @click="toggleSidebar()"
            >
              <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"></path>
              </svg>
              <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
              </svg>
            </button>
            <NavLink :class="'flex ml-2 md:mr-24'" :href="route('dashboard')">
              <img src="/logo_bag_green.png" class="h-9" alt="">
              <span
                class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Shopping C</span>
            </NavLink>
          </div>
          <div class="flex items-center">
            <div class="hidden mr-3 -mb-1 sm:block">
              <span></span>
            </div>

            <div class="flex items-center ml-3">
              <div>
                <button type="button"
                  class="flex text-sm justify-center items-center bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                  id="user-menu-button-2">
                  <span class="text-white mr-3">{{ $page.props.auth.user.name }}</span>

                  <img
                    class="w-8 h-8 rounded-full"
                    src="https://w7.pngwing.com/pngs/312/283/png-transparent-man-s-face-avatar-computer-icons-user-profile-business-user-avatar-blue-face-heroes-thumbnail.png"
                    alt="user photo"
                  >
                </button>
              </div>

            </div>
          </div>
        </div>
      </div>
    </nav>
</template>