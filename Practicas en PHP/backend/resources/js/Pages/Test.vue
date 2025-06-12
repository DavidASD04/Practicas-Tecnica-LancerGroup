<template>
  <Layout>
    <div>
      <v-card>
        <v-card-title>
          🧪 Página de Prueba de Navegación
        </v-card-title>
        <v-card-text>
          <p>Esta es una página de prueba para verificar que la navegación funcione correctamente.</p>
          
          <v-row class="mt-4">
            <v-col>
              <h3>Pruebas de Navegación:</h3>
              
              <div class="mt-4">
                <Link :href="route('dashboard')" class="text-decoration-none mr-4">
                  <v-btn color="primary" variant="outlined">
                    <v-icon left>mdi-home</v-icon>
                    Ir al Dashboard
                  </v-btn>
                </Link>
                
                <Link :href="route('authors.index')" class="text-decoration-none mr-4">
                  <v-btn color="success" variant="outlined">
                    <v-icon left>mdi-account-edit</v-icon>
                    Ir a Autores
                  </v-btn>
                </Link>
                
                <Link :href="route('books.index')" class="text-decoration-none">
                  <v-btn color="info" variant="outlined">
                    <v-icon left>mdi-book</v-icon>
                    Ir a Libros
                  </v-btn>                </Link>
              </div>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </div>
  </Layout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import Layout from '@/Components/Layout.vue'
</script>
