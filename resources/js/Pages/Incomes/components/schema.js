import { object, string, number, date, ref } from 'yup';

export const validationSchema = object({
  folio: string().max(50, 'Máximos de 50 caracteres en el folio').required('El folio es requerido'),
  supplier_id: number().min(1, 'Debe seleccionar un proveedor').required('El proveedor es requerida'),
  total_amount: number().min(1, 'El monto total debe ser mayor a 0').required('El monto total es requerida'),
  total_products: number().min(1, 'El total de productos debe ser mayor a 0').required('El total de producto es requerida'),
  total_unitary: number().min(1, 'El total unitario debe ser mayor a 0').required('El total unitario es requerida'),
  date: date().required('La fecha es requerida')
})

