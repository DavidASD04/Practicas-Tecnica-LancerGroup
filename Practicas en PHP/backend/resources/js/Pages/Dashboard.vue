<template>
  <Layout>
    <div class="dashboard">
      <v-row>
        <v-col cols="12">
          <v-card class="mb-6">
            <v-card-title class="text-h4 text-center py-6">
               Bienvenido al Sistema de Biblioteca
            </v-card-title>
            <v-card-text class="text-center">
              <p class="text-h6 mb-4">Gestiona tu colección de libros y autores de manera eficiente</p>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="6">
          <v-card color="primary" dark class="text-center">
            <v-card-title>
              <v-icon left size="large">mdi-account-edit</v-icon>
              Autores
            </v-card-title>
            <v-card-text>
              <div class="text-h2 mb-2">{{ stats.authors }}</div>
              <div>Autores registrados</div>
            </v-card-text>            <v-card-actions>
              <v-spacer></v-spacer>
              <Link :href="route('authors.index')" class="text-decoration-none">
                <v-btn 
                  variant="outlined" 
                  color="white"
                >
                  Ver Autores
                </v-btn>
              </Link>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-col>

        <v-col cols="12" md="6">
          <v-card color="secondary" dark class="text-center">
            <v-card-title>
              <v-icon left size="large">mdi-book</v-icon>
              Libros
            </v-card-title>
            <v-card-text>
              <div class="text-h2 mb-2">{{ stats.books }}</div>
              <div>Libros en catálogo</div>
            </v-card-text>            <v-card-actions>
              <v-spacer></v-spacer>
              <Link :href="route('books.index')" class="text-decoration-none">
                <v-btn 
                  variant="outlined" 
                  color="white"
                >
                  Ver Libros
                </v-btn>
              </Link>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>

      <v-row class="mt-6">
        <v-col cols="12">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-chart-line</v-icon>
              Acciones Rápidas
            </v-card-title>
            <v-card-text>              <v-row>
                <v-col cols="12" sm="6" md="3">
                  <Link :href="route('authors.create')" class="text-decoration-none">
                    <v-btn
                      color="primary"
                      block
                      size="large"
                      prepend-icon="mdi-account-plus"
                    >
                      Nuevo Autor
                    </v-btn>
                  </Link>
                </v-col>
                <v-col cols="12" sm="6" md="3">
                  <Link :href="route('books.create')" class="text-decoration-none">
                    <v-btn
                      color="secondary"
                      block
                      size="large"
                      prepend-icon="mdi-book-plus"
                    >
                      Nuevo Libro
                    </v-btn>
                  </Link>                </v-col>
                <v-col cols="12" sm="6" md="3">
                  <Link :href="route('authors.index')" class="text-decoration-none">
                    <v-btn
                      color="info"
                      block
                      size="large"
                      prepend-icon="mdi-view-list"
                    >
                      Lista Autores
                    </v-btn>
                  </Link>
                </v-col>
                <v-col cols="12" sm="6" md="3">
                  <Link :href="route('books.index')" class="text-decoration-none">
                    <v-btn
                      color="success"
                      block
                      size="large"
                      prepend-icon="mdi-view-grid"
                    >
                      Catálogo Libros
                    </v-btn>
                  </Link>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </Layout>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import Layout from '@/Components/Layout.vue'

// Props recibidas del backend
const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      authors: 0,
      books: 0
    })
  }
})
</script>

<style scoped>
.dashboard {
  padding: 20px;
}
</style>
