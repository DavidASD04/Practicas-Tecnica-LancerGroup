<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
      elevation="4"
    >
      <v-app-bar-title>
        <v-icon class="mr-2">mdi-book-open-page-variant</v-icon>
        📚 Sistema de Biblioteca
      </v-app-bar-title>

      <v-spacer></v-spacer>

      <v-btn
        :to="{ name: 'authors' }"
        text
        class="mr-2"
      >
        <v-icon left>mdi-account-edit</v-icon>
        Autores
      </v-btn>

      <v-btn
        :to="{ name: 'books' }"
        text
      >
        <v-icon left>mdi-book</v-icon>
        Libros
      </v-btn>
    </v-app-bar>

    <v-main>
      <v-container fluid>
        <router-view />
      </v-container>
    </v-main>

    <!-- Snackbar para notificaciones -->
    <v-snackbar
      v-model="snackbar.show"
      :color="snackbar.color"
      :timeout="snackbar.timeout"
      top
    >
      {{ snackbar.text }}
      <template v-slot:actions>
        <v-btn
          color="white"
          variant="text"
          @click="snackbar.show = false"
        >
          Cerrar
        </v-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>

<script setup>
import { reactive } from 'vue'
import { useNotificationStore } from './stores/notification'

const notificationStore = useNotificationStore()
const snackbar = reactive(notificationStore.snackbar)
</script>
