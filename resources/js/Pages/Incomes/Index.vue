<script setup lang="ts">
import NewLayout from '../../Layouts/NewAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import List from './components/List.vue';

// props
defineProps<{
  incomes: Array<Object>
}>()

</script>

<template>

  <Head title="Ingresos" />

  <NewLayout>
    <template #header>
      Ingresos
    </template>

    <template #button>
      <Link
        :href="route('incomes.create')"
        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none">
        <font-awesome-icon :icon="['fas', 'plus']" class="mr-2"/>
        Ingresos
      </Link>
    </template>

    <div class="overflow-x-auto">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">
          <List :data="incomes" />
        </div>
      </div>
    </div>
  </NewLayout>
</template>
