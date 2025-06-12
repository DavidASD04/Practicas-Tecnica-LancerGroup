<template>
  <Layout>
    <div>
      <v-row class="mb-4">
        <v-col>
          <v-card>            <v-card-title class="d-flex align-center">
              <Link :href="route('authors.index')" class="text-decoration-none">
                <v-btn
                  icon="mdi-arrow-left"
                  variant="text"
                  class="mr-2"
                ></v-btn>
              </Link>
              <span class="text-h4">👤 {{ author.nombre }} {{ author.apellido }}</span>
            </v-card-title>
          </v-card>
        </v-col>
      </v-row>

      <v-row>
        <!-- Información del autor -->
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-account-details</v-icon>
              Información Personal
            </v-card-title>
            <v-card-text>
              <v-list>                <v-list-item>
                  <v-list-item-title>Nombre</v-list-item-title>
                  <v-list-item-subtitle class="text-h6">
                    {{ author.nombre }}
                  </v-list-item-subtitle>
                </v-list-item>
                
                <v-divider class="my-3"></v-divider>
                
                <v-list-item>
                  <v-list-item-title>Apellido</v-list-item-title>
                  <v-list-item-subtitle class="text-h6">
                    {{ author.apellido }}
                  </v-list-item-subtitle>
                </v-list-item>
                
                <v-divider class="my-3"></v-divider>
                
                <v-list-item>
                  <v-list-item-title>País de Origen</v-list-item-title>
                  <v-list-item-subtitle>
                    <v-chip color="primary" variant="outlined">
                      <v-icon left>mdi-earth</v-icon>
                      {{ author.pais }}
                    </v-chip>
                  </v-list-item-subtitle>
                </v-list-item>
                
                <v-divider class="my-3"></v-divider>
                
                <v-list-item>
                  <v-list-item-title>Fecha de Registro</v-list-item-title>
                  <v-list-item-subtitle>
                    {{ formatDate(author.fecha_registro) }}
                  </v-list-item-subtitle>
                </v-list-item>
                
                <v-divider class="my-3"></v-divider>
                
                <v-list-item>
                  <v-list-item-title>Total de Libros</v-list-item-title>
                  <v-list-item-subtitle>
                    <v-chip 
                      :color="author.cantidad_libros > 0 ? 'success' : 'grey'"
                      size="large"
                    >
                      <v-icon left>mdi-book-multiple</v-icon>
                      {{ author.cantidad_libros }} libro(s)
                    </v-chip>
                  </v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-card-text>            <v-card-actions>
              <Link :href="route('authors.edit', author.id)" class="text-decoration-none">
                <v-btn
                  color="primary"
                  prepend-icon="mdi-pencil"
                >
                  Editar Autor
                </v-btn>
              </Link>
              <v-spacer></v-spacer>
              <v-btn
                color="error"
                variant="outlined"
                @click="confirmDelete"
                prepend-icon="mdi-delete"
              >
                Eliminar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>

        <!-- Libros del autor -->
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-book-multiple</v-icon>
              Libros Publicados
            </v-card-title>
            <v-card-text>              <div v-if="author.books && author.books.length > 0">
                <v-list>
                  <Link 
                    v-for="book in author.books" 
                    :key="book.id"
                    :href="route('books.show', book.id)"
                    class="text-decoration-none"
                  >
                    <v-list-item>
                      <template v-slot:prepend>
                        <v-icon color="primary">mdi-book</v-icon>
                      </template>
                      <v-list-item-title>{{ book.nombre }}</v-list-item-title>
                      <v-list-item-subtitle>
                        {{ book.edicion }} - {{ formatDate(book.fecha_publicacion) }}
                      </v-list-item-subtitle>
                    </v-list-item>
                  </Link>
                </v-list>
              </div>              <div v-else class="text-center py-8">
                <v-icon size="64" color="grey">mdi-book-off</v-icon>
                <p class="text-h6 mt-4 text-grey">
                  Este autor no tiene libros registrados
                </p>
                <Link :href="route('books.create')" class="text-decoration-none">
                  <v-btn
                    color="primary"
                    class="mt-4"
                  >
                    Agregar Libro
                  </v-btn>
                </Link>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <!-- Dialog de confirmación de eliminación -->
      <v-dialog v-model="deleteDialog" max-width="500px">
        <v-card>
          <v-card-title class="text-h5">
            Confirmar eliminación
          </v-card-title>
          <v-card-text>
            ¿Estás seguro de eliminar al autor <strong>{{ author.nombre_completo }}</strong>?
            <br><br>
            <v-alert 
              v-if="author.cantidad_libros > 0"
              type="warning"
              variant="outlined"
            >
              Este autor tiene {{ author.cantidad_libros }} libro(s) asociado(s).
            </v-alert>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey" variant="text" @click="deleteDialog = false">
              Cancelar
            </v-btn>
            <v-btn color="error" variant="text" @click="deleteAuthor">
              Eliminar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import Layout from '@/Components/Layout.vue'

// Props del backend
const props = defineProps({
  author: Object
})

const deleteDialog = ref(false)

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const confirmDelete = () => {
  deleteDialog.value = true
}

const deleteAuthor = () => {
  router.delete(route('authors.destroy', props.author.id), {
    onSuccess: () => {
      showNotification('Autor eliminado exitosamente', 'success')
    },
    onError: () => {
      showNotification('Error al eliminar el autor', 'error')
    }
  })
}
</script>
