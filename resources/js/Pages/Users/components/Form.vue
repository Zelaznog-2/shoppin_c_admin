<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { defineProps, defineEmits } from 'vue';

const emit = defineEmits();

// props
defineProps({
  form: Object
});

const submit = () => {
  emit('submit');
}

</script>
<template>
  <div>
    <div class="p-20 space-y-6">
      <form action="#">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-6 sm:col-span-3">
            <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text"
              v-model="form.name"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Nombre Apellido" required>
              <span class="text-red-500" v-if="form.errors['name']">{{ form.errors['name'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
            <input type="tel"
              v-model="form.phone"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="52 55 1234-5678" required>
              <span class="text-red-500" v-if="form.errors['phone']">{{ form.errors['phone'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input type="email"
              v-model="form.email"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="example@company.com" required>
              <span class="text-red-500" v-if="form.errors['email']">{{ form.errors['email'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
            <input type="password"
              v-model="form.password"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="**********" required>
              <span class="text-red-500" v-if="form.errors['password']">{{ form.errors['password'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="position" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmar contraseña</label>
            <input type="password"
              v-model="form.password_confirmation"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="**********" required>
              <span class="text-red-500" v-if="form.errors['password']">{{ form.errors['password'] }}</span>
          </div>
        </div>
      </form>
    </div>
    <div class="items-center p-6 border-t flex justify-around border-gray-200 rounded-b dark:border-gray-700">
      <button
      @click="submit"
      class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-primary-800" type="submit">{{ form.id === 0 ? 'Guardar' : 'Actualizar' }}</button>

      <Link :href="route('users.index')" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-primary-800" type="submit">Cancelar</Link>
    </div>
  </div>
</template>