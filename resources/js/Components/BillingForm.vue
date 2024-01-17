<template>
  <div>
    <!-- Formulario -->
    <form @submit.prevent="submitForm" method="post">
      <!-- Campo: Email -->
      <div id="email_Div" class="mb-4">
        <label class="text-gray-700 text-sm font-bold">Email <span class="red">*</span></label>
        <input id="email" v-model="email.value" required class="border rounded px-3 py-2" placeholder="Ingrese su correo electrónico">
        <div v-if="email.showAlert" class="text-red-500 text-sm">Campo obligatorio</div>
        <div v-if="!email.isValid" class="text-red-500 text-sm">Formato de correo electrónico no válido</div>
      </div>

      <div id="password_Div" class="mb-4">1
      <label class="text-gray-700 text-sm font-bold" >Clave <span class="red">*</span></label>
      <input id="password" type="password" v-model="password.value" required class="border rounded px-3 py-2" placeholder="Ingrese su clave">
      <div v-if="password.showAlert" class="text-red-500 text-sm">Campo obligatorio</div>
      <div v-if="passwordLengthAlert" class="text-red-500 text-sm">La contraseña debe tener al menos 8 caracteres</div>
    </div>

    <div id="confirmPassword_Div" class="mb-4">
      <label class="text-gray-700 text-sm font-bold" >Confirmar Clave <span class="red">*</span></label>
      <input id="confirmation_password" type="password" v-model="confirmation_password.value" required class="border rounded px-3 py-2" placeholder="Confirmar clave">
      <div v-if="confirmation_password.showAlert" class="text-red-500 text-sm">Campo obligatorio</div>
      <div v-if="password.value !== confirmation_password.value" class="text-red-500 text-sm">Las contraseñas no coinciden</div>
    </div>

    <div id="firstName_Div" class="mb-4">
      <label class="text-gray-700 text-sm font-bold" >Primer Nombre <span class="red">*</span></label>
      <input id="first_name" v-model="first_name.value" required class="border rounded px-3 py-2" placeholder="Primer nombre" >
      <div v-if="first_name.showAlert" class="text-red-500 text-sm">Campo obligatorio</div>
    </div>

    <div id="lastName_Div" class="mb-4">
      <label class="text-gray-700 text-sm font-bold">Apellido <span class="red">*</span></label>
      <input id="last_name" v-model="last_name.value" required class="border rounded px-3 py-2" placeholder="Apellido">
      <div v-if="last_name.showAlert" class="text-red-500 text-sm">Campo obligatorio</div>
    </div>

    <div id="company_Div" class="mb-4">
      <label class="text-gray-700 text-sm font-bold" >Empresa (opcional)</label>
      <input id="company" v-model="company" class="border rounded px-3 py-2" placeholder="Empresa (opcional)" >
    </div>

    <div id="phoneNumber_Div" class="mb-4">
      <label class="text-gray-700 text-sm font-bold" >Telefono <span class="red">*</span></label>
      <input id="phone_number" v-model="phone_number.value" required class="border rounded px-3 py-2" placeholder="Telefono">
      <div v-if="phone_number.showAlert" class="text-red-500 text-sm">Campo obligatorio</div>
    </div>

    <div id="securityQuestion_Div" class="mb-4">
      <label class="text-gray-700 text-sm font-bold">Pregunta seguridad <span class="red">*</span></label>
      <select class="form-select border rounded px-3 py-2" v-model="security_question.value" required style="width: 420px;">
        <option value="" disabled selected class="placeholder-option" >¿Cual es el nombre de su mejor amigo de la escuela?</option>
        <option value="Pepito">Pepito</option>
        <option value="Juanito">Juanito</option>
        <option value="Pablito">Pablito</option>
        <option value="Pedrito">Pedrito</option>
      </select>
      <div v-if="security_question.showAlert" class="text-red-500 text-sm">Campo obligatorio</div>
    </div>
      
      <!-- Botón de Descargar -->
      <button id="downloadButton" download :disabled="!isFormValid" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-40 rounded-full">
        Descargar
      </button>

      <!-- Campo oculto para el token CSRF -->
      <input type="hidden" name="_token" :value="csrfToken">
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import Swal from 'sweetalert2';

// Definimos el tipo para los campos del formulario
interface FormField {
  value: string;
  showAlert: boolean;
  isValid: boolean;
}

// Función para crear un campo con valores predeterminados
const createField = (): FormField => ({ value: '', showAlert: false, isValid: true });



// Campos del formulario
const email = ref(createField());
const password = ref(createField());
const confirmation_password = ref(createField());
const first_name = ref(createField());
const last_name = ref(createField());
const company = ref('');
const phone_number = ref(createField());
const security_question = ref(createField());

// Token CSRF
const csrfToken = ref(document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

// Variable adicional para la alerta de longitud de contraseña
const passwordLengthAlert = ref(false);


// Validar el formulario
const validateForm = () => {
  const requiredFields: FormField[] = [
    email.value,
    password.value,
    confirmation_password.value,
    first_name.value,
    last_name.value,
    phone_number.value,
    security_question.value,
  ];

  requiredFields.forEach(field => {
    field.showAlert = field.value.trim() === '';
  });

 // Validación específica para la contraseña
 password.value.showAlert = password.value.value.trim() === '';
if (password.value.value.trim().length < 8) {
  passwordLengthAlert.value = true;
} else {
  passwordLengthAlert.value = false;
}

  // Validación para el número de teléfono
  phone_number.value.showAlert = phone_number.value.value.trim() === '';
  const phoneNumberRegex = /^[0-9+\s]+$/; // Permitir números, "+" y espacios en blanco
  phone_number.value.isValid = phoneNumberRegex.test(phone_number.value.value.trim());
  
  //Validación correo electronico
  email.value.isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.value);

  // Verificar si todos los campos obligatorios y el formato de correo electrónico son válidos
  isFormValid.value =
    requiredFields.every(field => field.value.trim() !== '' && (field.isValid === undefined || field.isValid)) &&
    password.value.value.trim().length >= 8 && password.value.isValid &&
    phone_number.value.isValid;
};


// Enviar formulario, se activa cuando se envia el formulario
const submitForm = async () => {
  try {
    const response = await fetch('/submit-form', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken.value,
      },
        body: JSON.stringify({
        _token: csrfToken.value,
        email: email.value.value,
        password: password.value.value,
        confirmation_password: confirmation_password.value.value,
        first_name: first_name.value.value,
        last_name: last_name.value.value,
        company: company.value,
        phone_number: phone_number.value.value,
        security_question: security_question.value.value,
      }),
    });

    if (response.ok) {
      // Descargar el formulario en formato PDF

      const pdfBlob = await response.blob();
      const link = document.createElement('a');
      link.href = URL.createObjectURL(pdfBlob);
      // Establecer el nombre del archivo que se descargará al hacer clic en el enlace
      link.download = 'formulario.pdf';
      // Simula un click en el enlace para iniciar la descarga del archivo
      link.click();

      // Mostrar SweetAlert2 después de la descarga exitosa
      Swal.fire({
        title: '¡Éxito!',
        text: 'PDF descargado con éxito.',
        icon: 'success',
      });
    } else {
      console.error('Error en la respuesta del servidor:', response.status, response.statusText);
    }
  } catch (error) {
    console.error('Error al procesar la solicitud:', error);
  }
};

// Validar el formulario cuando cambian los campos
watch(
  [email.value, password.value, confirmation_password.value, first_name.value, last_name.value, phone_number.value, security_question.value],
  () => {
    validateForm();
  }
);

// Variable para habilitar/deshabilitar el botón de Descargar
const isFormValid = ref(false);

</script>

<style scoped src="./styles/billing-form-styles.css"></style>
