<script setup lang="ts">
// import
import NewLayout from '../../Layouts/NewAuthenticatedLayout.vue'
import { defineProps } from 'vue';
import Form from './components/Form.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { validationSchemaNew, validationSchemaEdit } from './components/schema'
import { ref } from 'vue';


// props
const props = defineProps<{
  product: {
    id: number,
    name: string,
    sku: string,
    image: string,
    price: number,
    stock: number,
    rating: number,
    category_id: number,
    category: {
      id: number,
      name: string,
    }
  },
  categories: {
    id: number,
    name: string,
  }[]
}>();

// data
const errores = ref('')

const form = useForm({
  id: 0,
  name: '',
  sku: '',
  image: '',
  preview: '',
  price: 0,
  stock: 0,
  rating: 0,
  category_id: 0,
})


// methods
const setProduct = () => {
  if (props.product) {
    form.id = props.product.id
    form.sku = props.product.sku
    form.name = props.product.name
    form.preview = props.product.image
    form.price = props.product.price
    form.stock = props.product.stock
    form.rating = props.product.rating
    form.category_id = props.product.category_id
  }
}


const submit = () => {
  errores.value = ''

  if (form.id === 0) {
    try {
      validationSchemaNew.validateSync(form);
    } catch (error) {
      errores.value = error.message
      return false;
    }
    form.post(route('products.store'), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'El producto ha sido creado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'El producto no ha sido creado.',
          'error'
        )
      }
    })
  } else {
    try {
      validationSchemaEdit.validateSync(form);
    } catch (error) {
      errores.value = error.message
      return false;
    }
    form.put(route('products.update', form.id), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'El producto ha sido actualizado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'El producto no ha sido actualizado.',
          'error'
        )
      }
    })
  }
}

// onMounted
setProduct()

</script>

<template>
  <Head :title="`${form.id === 0 ? 'Nuevo' : 'Actualizar'} Producto`" />

  <NewLayout>
    <template #header>
      <h1>{{ form.id === 0 ? 'Nuevo' : 'Actualizar' }} Producto</h1>
    </template>

    <div class="overflow-x-auto">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">


          <div class="block bg-red-300 p-4 mx-6 mt-8 text-white rounded-md" v-if="errores">
            <h4>Error</h4>
            {{ errores }}
          </div>

          <Form
            :form="form"
            :categories="categories"
            @submit="submit()"
          />
        </div>
      </div>
    </div>

  </NewLayout>
</template>