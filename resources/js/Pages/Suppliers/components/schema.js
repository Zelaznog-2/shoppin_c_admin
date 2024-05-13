import { object, string } from 'yup';

const phoneRegEx = /^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/;
export const validationSchema = object({
  name: string().max(20, 'Máximos de 20 caracteres en el nombre').required('El nombre es requerido'),
  phone: string().matches(phoneRegEx, 'El teléfono no tiene el formato correcto').required('El teléfono es requerido')
})

