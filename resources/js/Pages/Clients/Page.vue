<script setup lang="ts">
// import
import NewLayout from '../../Layouts/NewAuthenticatedLayout.vue'
import { defineProps } from 'vue';
import Form from './components/Form.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { validationSchemaEdit, validationSchemaNew } from './components/schema'
import { ref } from 'vue';


// props
const props = defineProps<{
  user: {
    id: number,
    name: string,
    email: string,
    phone: string,
    created_at: string,
    updated_at: string,
  }
}>();

// data
const errores = ref('')


const form = useForm({
  id: 0,
  name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
  role_id: 3,
})


// methods
const setUser = () => {
  if (props.user) {
    form.id = props.user.id
    form.name = props.user.name
    form.email = props.user.email
    form.phone = props.user.phone
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
    form.post(route('clients.store'), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'El cliente ha sido creado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'El cliente no ha sido creado.',
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
    form.put(route('clients.update', form.id), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'El cliente ha sido actualizado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'El cliente no ha sido actualizado.',
          'error'
        )
      }
    })
  }
}

// onMounted
setUser()

</script>

<template>
  <Head :title="`${form.id === 0 ? 'Nuevo' : 'Actualizar'} Clientes`" />

  <NewLayout>
    <template #header>
      <h1>{{ form.id === 0 ? 'Nuevo' : 'Actualizar' }} Clientes</h1>
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