<!-- Archivo: HomePage.vue -->

<template>
    <div>
      <iframe v-if="usuarioHaIniciadoSesion" name="miIframe" src="/submit-form" width="600" height="800" ></iframe>
    </div>
  </template>
  
  <script setup lang="ts">
import { ref, onMounted } from 'vue';

const usuarioHaIniciadoSesion = ref(false);

// Función para verificar el inicio de sesión
const verificarInicioSesion = () => {
  // ... tu lógica para verificar el inicio de sesión ...
  // Cambia el valor de usuarioHaIniciadoSesion según sea necesario
  usuarioHaIniciadoSesion.value = true; // o false, dependiendo de tu lógica
};

// Llama a verificarInicioSesion cuando el componente se monta
onMounted(() => {
  verificarInicioSesion();
});
  </script>
  