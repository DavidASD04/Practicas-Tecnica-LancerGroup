<template>
  <div>
    <v-row justify="center" class="mb-8">
      <v-col cols="12" md="8">
        <v-card class="text-center pa-8" elevation="4">
          <v-card-title class="text-h3 mb-4">
            📚 Sistema de Biblioteca
          </v-card-title>
          <v-card-text class="text-h6 text-grey-darken-1">
            Administra autores y libros de manera eficiente
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row justify="center">
      <v-col cols="12" md="5" class="mb-4">
        <v-card
          class="text-center pa-6 h-100"
          elevation="3"
          hover
          @click="$router.push({ name: 'authors' })"
          style="cursor: pointer;"
        >
          <v-icon size="80" color="primary" class="mb-4">
            mdi-account-edit
          </v-icon>
          <v-card-title class="text-h4 mb-2">
            ✍️ Autores
          </v-card-title>
          <v-card-text class="text-body-1">
            Gestiona la información de los autores de tu biblioteca
          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn
              color="primary"
              variant="elevated"
              size="large"
              :to="{ name: 'authors' }"
            >
              Ver Autores
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="12" md="5" class="mb-4">
        <v-card
          class="text-center pa-6 h-100"
          elevation="3"
          hover
          @click="$router.push({ name: 'books' })"
          style="cursor: pointer;"
        >
          <v-icon size="80" color="success" class="mb-4">
            mdi-book
          </v-icon>
          <v-card-title class="text-h4 mb-2">
            📚 Libros
          </v-card-title>
          <v-card-text class="text-body-1">
            Administra el catálogo de libros disponibles
          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn
              color="success"
              variant="elevated"
              size="large"
              :to="{ name: 'books' }"
            >
              Ver Libros
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script setup>
// No necesita lógica adicional
</script>
