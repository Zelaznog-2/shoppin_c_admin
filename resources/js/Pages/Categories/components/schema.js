import { object, string } from 'yup';

export const validationSchema = object({
  name: string().max(20, 'Máximos de 20 caracteres en el nombre').required('El nombre es requerido'),
  description: string().max(150, 'Máximos de 150 caracteres en el descripción').required('La descripción es requerido')
})

