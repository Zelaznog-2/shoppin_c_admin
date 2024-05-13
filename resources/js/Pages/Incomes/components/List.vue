<script setup lang="ts">
// import
import { Link } from '@inertiajs/vue3';
import { VueGoodTable } from 'vue-good-table-next';
import { defineProps, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import swal from'sweetalert2';

// props
defineProps<{
  data: Array<Object>
}>();

// refs
const form = useForm({})
// data
const columnsData =  [
  {
    label: 'ID',
    field: 'id',
  },{
    label: 'Proveedor',
    field: 'supplier.name',
  },{
    label: 'Usuario',
    field: 'user.name',
  },{
    label: 'Folio',
    field: 'folio',
  },{
    label: 'Fecha',
    field: 'date',
  },{
    label: 'Total Unitario',
    field: 'total_unitary',
  },{
    label: 'Total Productos',
    field: 'total_products',
  },{
    label: 'Total Monetario',
    field: 'total_amount',
  },{
    label: 'Acciones',
    field: 'action',
    sortable: false,
    searchable: false,
  }
]

// types
type ItemPro = {
  id: Number,
  name: String,
}

// methods
const deleteItem = (item:ItemPro) => {
  swal.fire({
    title: `¿Estas seguro que quiere eliminar la categoría ${item.name}?`,
    text: "¡No podrás revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#98C44B',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      form.delete(route('incomes.destroy', item.id), {
        preserveScroll: true,
        onSuccess: () => {
          swal.fire(
            'Eliminado!',
            'La categoría ha sido eliminado.',
            'success'
          )
        },
        onError: () => {
          swal.fire(
            'Error!',
            'La categoría no ha sido eliminado.',
            'error'
          )
        }
      })
    }
  })
}

</script>
<template>
  <div class="p-4">
    <vue-good-table
      :columns="columnsData"
      :rows="data"
      :pagination="true"
      :pagination-options="{
        enabled: true,
        nextLabel: 'Siguiente',
        prevLabel: 'Anterior',
        rowsPerPageLabel: 'Filas por paginas',
        ofLabel: 'de',
        pageLabel: 'paginas',
        allLabel: 'Todos',
        rowsPerPage: 10,
        currentPage: 1,
      }"
      :search-options="{
        enabled: true,
        placeholder: 'Buscar...',
      }"
      max-height="600px"
      :fixed-header="true"
      theme="nocturnal"
    >
      <template template v-slot:emptystate="props">
        <h6 class="text-center">No hay registro</h6>
      </template>
      <template v-slot:table-row="props">
        <span v-if="props.column.field == 'action'">
          <button class="mr-4 ml-4 text-blue-600" >
            <Link :href="route('incomes.edit', [props.row.id])">
              <font-awesome-icon :icon="['fas', 'edit']" class="mr-2"/>
            </Link>
          </button>
          <button class="ml-4 text-red-600" @click="deleteItem(props.row)">
            <font-awesome-icon :icon="['fas', 'trash-alt']" class="mr-2"/>
          </button>
        </span>
        <span v-else>
          {{ props.formattedRow[props.column.field] }}
        </span>
      </template>
    </vue-good-table>
  </div>
</template>