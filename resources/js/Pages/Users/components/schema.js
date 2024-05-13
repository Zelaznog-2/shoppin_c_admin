import { object, string, ref } from 'yup';

// const schema = yup.object({
//   password: yup.string()
//     .required('Password is required')
//     .min(8, 'Password must be at least 8 characters long'),
//   confirmPassword: yup.string()
//     .required('Confirm password is required')
//     .oneOf([yup.ref('password'), null], 'Passwords must match'),
// });
const phoneRegEx = /^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/;
const emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

export const validationSchemaNew = object({
  name: string().max(50, 'Máximo de 50 caracteres en el nombre').required('El nombre es requerido'),
  email: string().matches(emailRegex, 'El correo electrónico no es el formato correcto').email('El correo electrónico no es válido').required('El correo electrónico es requerido'),
  phone: string().matches(phoneRegEx, 'El teléfono no tiene el formato correcto').required('El teléfono es requerido'),
  password: string().min(8, 'La contraseña debe ser mayor a 8 dígitos').required('La contraseña es requerida'),
  password_confirmation: string().required('La confirmación de contraseña es requerida').oneOf([ref('password'), null], 'Las contraseña es no coinciden'),
})

export const validationSchemaEdit = object({
  name: string().max(50, 'Máximo de 50 caracteres en el nombre').required('El nombre es requerido'),
  email: string().matches(emailRegex, 'El correo electrónico no es el formato correcto').email('El correo electrónico no es válido').required('El correo electrónico es requerido'),
  phone: string().matches(phoneRegEx, 'El teléfono no tiene el formato correcto').required('El teléfono es requerido'),
})

