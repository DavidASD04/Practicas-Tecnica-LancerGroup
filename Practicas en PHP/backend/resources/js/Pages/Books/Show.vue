<template>
  <Layout>
    <div>
      <v-row class="mb-4">
        <v-col>
          <v-card>
            <v-card-title class="d-flex align-center">
              <Link :href="route('books.index')" class="text-decoration-none">
                <v-btn
                  icon="mdi-arrow-left"
                  variant="text"
                  class="mr-2"
                ></v-btn>
              </Link>
              <span class="text-h4">📖 {{ book.nombre }}</span>
            </v-card-title>
          </v-card>
        </v-col>
      </v-row>

      <v-row>
        <!-- Información del libro -->
        <v-col cols="12" md="8">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-book-open</v-icon>
              Información del Libro
            </v-card-title>
            <v-card-text>
              <v-row>                <v-col cols="12" md="6">
                  <v-list>
                    <v-list-item>
                      <v-list-item-title>Título</v-list-item-title>
                      <v-list-item-subtitle class="text-h6">{{ book.nombre }}</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item v-if="book.fecha_publicacion">
                      <v-list-item-title>Fecha de Publicación</v-list-item-title>
                      <v-list-item-subtitle>{{ formatDate(book.fecha_publicacion) }}</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item v-if="book.edicion">
                      <v-list-item-title>Edición</v-list-item-title>
                      <v-list-item-subtitle>{{ book.edicion }}</v-list-item-subtitle>
                    </v-list-item>
                  </v-list>
                </v-col>
                <v-col cols="12" md="6">
                  <v-list>
                    <v-list-item>
                      <v-list-item-title>Número de Autores</v-list-item-title>
                      <v-list-item-subtitle>{{ book.cantidad_autores }} autor(es)</v-list-item-subtitle>
                    </v-list-item>
                  </v-list>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <Link :href="route('books.edit', book.id)" class="text-decoration-none">
                <v-btn
                  color="primary"
                  prepend-icon="mdi-pencil"
                >
                  Editar Libro
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

        <!-- Autores del libro -->
        <v-col cols="12" md="4">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-account-edit</v-icon>
              Autores ({{ book.cantidad_autores }})
            </v-card-title>
            <v-card-text>
              <div v-if="book.authors && book.authors.length > 0">
                <v-list>
                  <Link 
                    v-for="author in book.authors" 
                    :key="author.id"
                    :href="route('authors.show', author.id)"
                    class="text-decoration-none"
                  >
                    <v-list-item>
                      <template v-slot:prepend>
                        <v-icon color="primary">mdi-account</v-icon>
                      </template>
                      <v-list-item-title>{{ author.nombre }} {{ author.apellido }}</v-list-item-title>
                      <v-list-item-subtitle v-if="author.pais">
                        {{ author.pais }}
                      </v-list-item-subtitle>
                    </v-list-item>
                  </Link>
                </v-list>
              </div>
              <div v-else class="text-center py-8">
                <v-icon size="64" color="grey">mdi-account-off</v-icon>
                <p class="text-h6 mt-4 text-grey">
                  Este libro no tiene autores asignados
                </p>
                <Link :href="route('books.edit', book.id)" class="text-decoration-none">
                  <v-btn
                    color="primary"
                    class="mt-4"
                  >
                    Asignar Autores
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
            ¿Estás seguro de eliminar el libro <strong>{{ book.nombre }}</strong>?
            <v-alert 
              type="warning"
              variant="outlined"
              class="mt-4"
            >
              Esta acción no se puede deshacer.
            </v-alert>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey" variant="text" @click="deleteDialog = false">
              Cancelar
            </v-btn>
            <v-btn color="error" variant="text" @click="deleteBook">
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
  book: Object
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

const deleteBook = () => {
  router.delete(route('books.destroy', props.book.id), {
    onSuccess: () => {
      showNotification('Libro eliminado exitosamente', 'success')
    },
    onError: () => {
      showNotification('Error al eliminar el libro', 'error')
    }
  })
}
</script>
