<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/NewAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      Dashboard
    </template>

    <!-- <template #button>
      <Link :href="''"
        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none">
      Agregar
      </Link>
    </template> -->

    <div class="py-12 h-full">
      <div class="p-6 text-white">Bienvenido/a {{ $page.props.auth.user.name }}</div>
    </div>
  </AuthenticatedLayout>
</template>
