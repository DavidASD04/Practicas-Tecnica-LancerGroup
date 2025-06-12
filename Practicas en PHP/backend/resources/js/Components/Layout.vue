<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
      elevation="4"
    >      <v-app-bar-title>
        <Link :href="route('dashboard')" class="text-decoration-none text-white d-flex align-center">
          <v-icon class="mr-2">mdi-book-open-page-variant</v-icon>
          <span> Sistema de Biblioteca</span>
        </Link>
      </v-app-bar-title>

      <v-spacer></v-spacer>      <Link :href="route('authors.index')" class="text-decoration-none mr-2">
        <v-btn
          variant="text"
          color="white"
          :class="{ 'bg-white bg-opacity-20': $page.component.startsWith('Authors') }"
          size="large"
          class="nav-btn"
        >
          <v-icon left>mdi-account-edit</v-icon>
          Autores
        </v-btn>
      </Link>

      <Link :href="route('books.index')" class="text-decoration-none">
        <v-btn
          variant="text"
          color="white"
          :class="{ 'bg-white bg-opacity-20': $page.component.startsWith('Books') }"
          size="large"
          class="nav-btn"
        >
          <v-icon left>mdi-book</v-icon>
          Libros
        </v-btn>
      </Link>
    </v-app-bar>    <v-main>
      <v-container fluid>
        <slot />
      </v-container>
    </v-main>

    <!-- Indicador de carga global -->
    <v-overlay 
      v-model="isLoading" 
      class="align-center justify-center"
      persistent
    >
      <v-progress-circular
        indeterminate
        size="64"
        color="primary"
      ></v-progress-circular>
    </v-overlay>

    <!-- Snackbar para notificaciones -->
    <v-snackbar
      v-model="notification.show"
      :color="notification.color"
      :timeout="notification.timeout"
      top
    >
      {{ notification.text }}
      <template v-slot:actions>
        <v-btn
          color="white"
          variant="text"
          @click="notification.show = false"
        >
          Cerrar
        </v-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const isLoading = ref(false)

// Sistema de notificaciones reactivo
const notification = reactive({
  show: false,
  text: '',
  color: 'success',
  timeout: 4000
})

// Escuchar eventos de navegación de Inertia
onMounted(() => {
  router.on('start', () => {
    isLoading.value = true
  })
  
  router.on('finish', () => {
    isLoading.value = false
  })
  
  router.on('error', () => {
    isLoading.value = false
  })
})

// Método global para mostrar notificaciones
window.showNotification = (text, color = 'success') => {
  notification.text = text
  notification.color = color
  notification.show = true
}

// Exportar para uso en otros componentes
defineExpose({
  showNotification: window.showNotification
})
</script>

<style scoped>
.nav-btn {
  transition: all 0.3s ease;
}

.nav-btn:hover {
  background-color: rgba(255, 255, 255, 0.1) !important;
  transform: translateY(-1px);
}

.nav-btn:active {
  transform: translateY(0);
}
</style>
