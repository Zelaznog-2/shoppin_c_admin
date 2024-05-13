<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { defineProps, defineEmits } from 'vue';

const emit = defineEmits();

// props
const props = defineProps({
  form: Object,
  categories: Array<{
    name: string
    id: number
  }>
});


// data
const imagen = ref(props.form.preview);

// methods
const submit = () => {
  emit('submit');
}

const previewImage = (event) => {
  var input = event.target;
  if (input.files) {
    var reader = new FileReader();
    reader.onload = (e) => {
      imagen.value = e.target.result;
    }
    props.form.image = input.files[0];
    reader.readAsDataURL(input.files[0]);
  }
}


</script>
<template>
  <div>
    <div class="p-20 space-y-6">
      <form action="#">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-6 sm:col-span-3">
            <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categorías</label>
            <select v-model="form.category_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
              <option value="0" disabled>Seleccione una categoría</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
            <span class="text-red-500" v-if="form.errors['category_id']">{{ form.errors['category_id'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input type="text"
              v-model="form.name"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Nombre producto" required>
              <span class="text-red-500" v-if="form.errors['name']">{{ form.errors['name'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SKU</label>
            <input type="text"
              v-model="form.sku"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="SD25478..." required>
              <span class="text-red-500" v-if="form.errors['sku']">{{ form.errors['sku'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
            <input type="number"
              step="any"
              v-model.number="form.price"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="0.000,00" required>
              <span class="text-red-500" v-if="form.errors['price']">{{ form.errors['price'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Calificación</label>
            <input type="number"
              v-model.number="form.rating"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="0..." required>
              <span class="text-red-500" v-if="form.errors['rating']">{{ form.errors['rating'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Imagen</label>
            <input type="file"
              @change="previewImage($event)"
              accept="image/jpeg,image/png,image/jpg"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="0..." required>
              <span class="text-red-500" v-if="form.errors['rating']">{{ form.errors['rating'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vista previa</label>
            <img :src="imagen" alt="" class="h-40 w-40">
          </div>
        </div>
      </form>
    </div>
    <div class="items-center p-6 border-t flex justify-around border-gray-200 rounded-b dark:border-gray-700">
      <button
      @click="submit"
      class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-primary-800" type="submit">{{ form.id === 0 ? 'Guardar' : 'Actualizar' }}</button>

      <Link :href="route('products.index')" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-primary-800" type="submit">Cancelar</Link>
    </div>
  </div>
</template>