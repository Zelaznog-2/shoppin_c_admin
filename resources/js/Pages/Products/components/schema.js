import { object, string, mixed, number} from 'yup';

export const validationSchemaNew = object({
  name: string().max(100, 'Máximos de 100 caracteres en el nombre').required('El nombre es requerido'),
  sku: string().max(20, 'Máximos de 100 caracteres en el nombre').required('El sku es requerido'),
  price: number().min(1, 'El precio debe ser mayor a 0').required('El precio es requerido'),
  image: mixed().required('La imagen es requerida').test('fileType', 'Archivo no es imagen', (value) => {
    return value && (value.type.startsWith('image/'))
  }),
  category_id: number().min(1, 'Debe seleccionar una categoría').required('La categoría es requerida'),
})

export const validationSchemaEdit = object({
  name: string().max(100, 'Máximos de 100 caracteres en el nombre').required('El nombre es requerido'),
  sku: string().max(20, 'Máximos de 100 caracteres en el nombre').required('El sku es requerido'),
  price: number().min(1, 'El precio debe ser mayor a 0').required('El precio es requerido'),
  image: mixed().optional().test('fileType', 'Archivo no es imagen', (value) => {
    if (value === '') {
      return true;
    }
    return value && (value.type.startsWith('image/'))
  }),
  category_id: number().min(1, 'Debe seleccionar una categoría').required('La categoría es requerida'),
})

