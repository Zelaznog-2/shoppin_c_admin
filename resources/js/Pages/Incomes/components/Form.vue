<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { defineProps, defineEmits, ref } from 'vue';

const emit = defineEmits();

// props
const props = defineProps({
  form: Object,
  suppliers: Array<{
    name: string
    id: number
  }>,
  products: Array<{
    name: string
    id: number
  }>
});

const submit = () => {
  emit('submit');
}

// method
const updateTotal = () => {
  let totalAmount = 0
  let totalProducts = 0
  let totalUnitary = 0
  props.form?.products.map((item:any) => {
    item.total = (item.quantity * parseFloat(item.unitary))
    totalAmount += item.total
    totalProducts += parseFloat(item.quantity)
    totalUnitary += item.unitary
    return item
  })

  console.log('totalAmuont', totalAmount, 'totalUnitary', totalUnitary, 'totalProducts', totalProducts, 'pruebas');

  props.form.total_amount = totalAmount
  props.form.total_products = totalProducts
  props.form.total_unitary = totalUnitary
}

const checkProductSelect = ($event:any, index:number) => {
  const value = parseInt($event.target.value)
  const isUnique = ref(0)

  props.form?.products.map((item:any) => {
    if (item.id === value) {
      isUnique.value++
    }
  })

  if (isUnique.value > 1) {
    $event.target.value = 0
    Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Ya selecciono ese producto",
      showConfirmButton: false,
      timer: 1500
    });
  } else {
    $event.target.value = value
  }


}

const addProduct = () => {
  props.form?.products.push({
    id: 0,
    quantity: 1,
    unitary: 1,
    total: ( 1 * 1 )
  })
  updateTotal()
}

const removeProduct = (index: number) => {
  props.form.products.splice(index, 1)
  updateTotal()
}

</script>
<template>
  <div>
    <div class="p-20 space-y-6">
      <form action="#">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-6 sm:col-span-3">
            <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proveedor</label>
            <select v-model="form.supplier_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
              <option value="0" disabled>Seleccione un proveedor</option>
              <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>
            </select>
            <span class="text-red-500" v-if="form.errors['supplier_id']">{{ form.errors['supplier_id'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Folio</label>
            <input type="text"
              v-model="form.folio"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Folio" required>
              <span class="text-red-500" v-if="form.errors['folio']">{{ form.errors['folio'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
            <input type="date"
              v-model="form.date"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Fecha..." required>
              <span class="text-red-500" v-if="form.errors['date']">{{ form.errors['date'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total productos</label>
            <input type="number"
              readonly
              v-model="form.total_products"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="..." required>
              <span class="text-red-500" v-if="form.errors['total_products']">{{ form.errors['total_products'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total unitario</label>
            <input type="number"
              readonly
              v-model="form.total_unitary"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="..." required>
              <span class="text-red-500" v-if="form.errors['total_unitary']">{{ form.errors['total_unitary'] }}</span>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monto total</label>
            <input type="number"
              readonly
              v-model="form.total_amount"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="..." required>
              <span class="text-red-500" v-if="form.errors['total_amount']">{{ form.errors['total_amount'] }}</span>
          </div>
        </div>
        <hr class="mt-8">
        <!-- Products -->
        <div class="flex justify-between items-center mt-8">
          <span class=" text-white text-2xl ">Productos</span>
        </div>
        <div class="grid grid-cols-4 gap-4 mt-4" :class="`${index > 1 ? 'border-t-solid' : ''}`" v-for="(item, index) in form.products" :key="`product-${index}`">
          <div class="sm:col-span-1 col-span-4">
            <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
            <select
              v-mode.number="item.id"
              @change="checkProductSelect($event, index)"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
              <option value="0" disabled>Seleccione un producto</option>
              <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
            </select>

          </div>
          <div class="sm:col-span-1 col-span-4">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
            <input type="number"
              min="1"
              step="1"
              v-model.number="item.quantity"
              @keyup="updateTotal"
              @change="updateTotal"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="..." required>
          </div>
          <div class="sm:col-span-1 col-span-4">
            <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio Unitario</label>
            <input type="number"
              min="1"
              step="1"
              v-model.number="item.unitary"
              @keyup="updateTotal"
              @change="updateTotal"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="..." required>
          </div>
          <div class="flex justify-around items-end sm:col-span-1 col-span-4">
            <span class="text-white border-solid bg-gray-800 text-xl px-6 py-1"> = </span>
            <span class="text-white border-solid bg-gray-800 text-xl px-6 py-1">{{ item.total }}</span>
            <button
              type="button"
              @click="removeProduct(index)"
              class="text-white text-2xl mr-2 !border-gray-600 border-solid-alt rounded-full h-10 w-10 hover:bg-gray-600 hover:text-red-400">
              <font-awesome-icon :icon="['fas', 'times']" class=""/>
            </button>
          </div>
          <span class="text-red-500" v-if="form.errors[`products.${index}.id`]">{{ form.errors[`products.${index}.id`] }}</span>
          <span class="text-red-500" v-if="form.errors[`products.${index}.unitary`]">{{ form.errors[`products.${index}.unitary`] }}</span>
          <span class="text-red-500" v-if="form.errors[`products.${index}.quantity`]">{{ form.errors[`products.${index}.quantity`] }}</span>
        </div>
        <div class="flex justify-center mt-10">
          <button
            type="button"
            @click="addProduct"
            class="text-white text-2xl !border-gray-600 border-solid-alt rounded-xl py-2 px-4 hover:bg-gray-600 hover:text-green-400">
            Agregar
            <font-awesome-icon :icon="['fas', 'plus']" class=""/>
          </button>
        </div>
      </form>
    </div>
    <div class="items-center p-6 border-t flex justify-around border-gray-200 rounded-b dark:border-gray-700">
      <button
      @click="submit"
      class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-primary-800" type="submit">{{ form.id === 0 ? 'Guardar' : 'Actualizar' }}</button>

      <Link :href="route('incomes.index')" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-primary-800" type="submit">Cancelar</Link>
    </div>
  </div>
</template>