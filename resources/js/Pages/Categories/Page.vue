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
  category: {
    id: number,
    name: string,
    description: string
  }
}>();

// data
const errores = ref('')

const form = useForm({
  id: 0,
  name: '',
  description: '',
})


// methods
const setCategory = () => {
  if (props.category) {
    form.id = props.category.id
    form.name = props.category.name
    form.description = props.category.description
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
    form.post(route('categories.store'), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'La categoría ha sido creado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'La categoría no ha sido creado.',
          'error'
        )
      }
    })
  } else {
    form.put(route('categories.update', form.id), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'La categoría ha sido actualizado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'La categoría no ha sido actualizado.',
          'error'
        )
      }
    })
  }
}

// onMounted
setCategory()

</script>

<template>
  <Head :title="`${form.id === 0 ? 'Nueva' : 'Actualizar'} Categoría`" />

  <NewLayout>
    <template #header>
      <h1>{{ form.id === 0 ? 'Nueva' : 'Actualizar' }} Categoría</h1>
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