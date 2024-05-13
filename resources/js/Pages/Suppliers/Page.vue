<script setup lang="ts">
// import
import NewLayout from '../../Layouts/NewAuthenticatedLayout.vue'
import { defineProps } from 'vue';
import Form from './components/Form.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { validationSchema } from './components/schema'
import { ref } from 'vue';


// props
const props = defineProps<{
  supplier: {
    id: number,
    name: string,
    phone: string
  }
}>();

// data
const errores = ref('')

const form = useForm({
  id: 0,
  name: '',
  phone: '',
})


// methods
const setSupplier = () => {
  if (props.supplier) {
    form.id = props.supplier.id
    form.name = props.supplier.name
    form.phone = props.supplier.phone
  }
}


const submit = () => {
  errores.value = ''
  try {
      validationSchema.validateSync(form);
    } catch (error) {
      errores.value = error.message
      return false;
    }

  if (form.id === 0) {
    form.post(route('suppliers.store'), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'El proveedor ha sido creado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'El proveedor no ha sido creado.',
          'error'
        )
      }
    })
  } else {
    form.put(route('suppliers.update', form.id), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'El proveedor ha sido actualizado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'El proveedor no ha sido actualizado.',
          'error'
        )
      }
    })
  }
}

// onMounted
setSupplier()

</script>

<template>
  <Head :title="`${form.id === 0 ? 'Nuevo' : 'Actualizar'} Proveedor`" />

  <NewLayout>
    <template #header>
      <h1>{{ form.id === 0 ? 'Nuevo' : 'Actualizar' }} Proveedor</h1>
    </template>

    <div class="overflow-x-auto">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">


          <div class="block bg-red-300 p-4 mx-6 mt-8 text-white rounded-md" v-if="errores">
            <h4>Error</h4>
            {{ errores }}
          </div>

          <Form :form="form" @submit="submit()"/>
        </div>
      </div>
    </div>

  </NewLayout>
</template>