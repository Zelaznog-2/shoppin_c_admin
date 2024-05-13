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
  income: {
    id: number,
    folio: string,
    date: string,
    total_amount: number,
    total_products: number,
    total_unitary: number,
    supplier_id: number,
    income_products: []
  }
  products: {
    id: number,
    name: string,
  }[],
  suppliers: {
    id: number,
    name: string,
  }[]
}>();

// data
const errores = ref('')

const form = useForm({
  id: 0,
  folio: '',
  date: '',
  total_amount: 0,
  total_products: 0,
  total_unitary: 0,
  supplier_id: 0,
  products: [],
})


// methods
const setIncome = () => {
  if (props.income) {
    form.id = props.income.id
    form.folio = props.income.folio
    form.date = props.income.date
    form.total_amount = props.income.total_amount
    form.total_products = props.income.total_products
    form.total_unitary = props.income.total_unitary
    form.supplier_id = props.income.supplier_id
    form.products = props.income.income_products
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
    form.post(route('incomes.store'), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'El ingreso ha sido creado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'El ingreso no ha sido creado.',
          'error'
        )
      }
    })
  } else {
    form.put(route('incomes.update', form.id), {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire(
          'Actualizado!',
          'El ingreso ha sido actualizado.',
          'success'
        )
      },
      onError: () => {
        Swal.fire(
          'Error!',
          'El ingreso no ha sido actualizado.',
          'error'
        )
      }
    })
  }
}

// mounted
setIncome()

</script>

<template>
  <Head :title="`${form.id === 0 ? 'Nuevo' : 'Actualizar'} Ingreso`" />

  <NewLayout>
    <template #header>
      <h1>{{ form.id === 0 ? 'Nuevo' : 'Actualizar' }} Ingreso</h1>
    </template>

    <div class="overflow-x-auto">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow">


          <div class="block bg-red-300 p-4 mx-6 mt-8 text-white rounded-md" v-if="errores">
            <h4>Error</h4>
            {{ errores }}
          </div>

          <Form :form="form" :products="products" :suppliers="suppliers" @submit="submit()"/>
        </div>
      </div>
    </div>

  </NewLayout>
</template>