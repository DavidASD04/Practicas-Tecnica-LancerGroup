<template>
  <Layout>
    <div>
      <v-row class="mb-4">
        <v-col>
          <v-card>
            <v-card-title class="d-flex justify-space-between align-center">
              <span class="text-h4"> Libros</span>
              <Link :href="route('books.create')" class="text-decoration-none">
                <v-btn
                  color="primary"
                  prepend-icon="mdi-plus"
                >
                  Nuevo Libro
                </v-btn>
              </Link>
            </v-card-title>
          </v-card>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <v-card>
            <v-data-table
              :headers="headers"
              :items="books"
              :loading="loading"
              class="elevation-1"
              item-value="id"
            >              <template v-slot:item.nombre="{ item }">
                <strong>{{ item.nombre }}</strong>
              </template>

              <template v-slot:item.fecha_publicacion="{ item }">
                {{ formatDate(item.fecha_publicacion) }}
              </template>

              <template v-slot:item.edicion="{ item }">
                {{ item.edicion || 'N/A' }}
              </template>

              <template v-slot:item.actions="{ item }">
                <Link :href="route('books.show', item.id)" class="text-decoration-none">
                  <v-btn
                    icon="mdi-eye"
                    size="small"
                    color="info"
                    variant="text"
                    class="mr-1"
                  >
                  </v-btn>
                </Link>
                <Link :href="route('books.edit', item.id)" class="text-decoration-none">
                  <v-btn
                    icon="mdi-pencil"
                    size="small"
                    color="primary"
                    variant="text"
                    class="mr-1"
                  >
                  </v-btn>
                </Link>
                <v-btn
                  icon="mdi-delete"
                  size="small"
                  color="error"
                  variant="text"
                  @click="confirmDelete(item)"
                >
                </v-btn>
              </template>
            </v-data-table>
          </v-card>
        </v-col>
      </v-row>

      <!-- Dialog de confirmación -->
      <v-dialog v-model="deleteDialog" max-width="500px">
        <v-card>
          <v-card-title class="text-h5">
            Confirmar eliminación
          </v-card-title>
          <v-card-text>
            ¿Estás seguro de eliminar el libro <strong>{{ selectedBook?.nombre }}</strong>?
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
  books: Array
})

const loading = ref(false)
const deleteDialog = ref(false)
const selectedBook = ref(null)

const headers = [
  { title: 'Nombre', key: 'nombre', sortable: true },
  { title: 'Fecha Publicación', key: 'fecha_publicacion', sortable: true },
  { title: 'Edición', key: 'edicion', sortable: true },
  { title: 'Acciones', key: 'actions', sortable: false, width: '150px' }
]

const formatDate = (dateString) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const confirmDelete = (book) => {
  selectedBook.value = book
  deleteDialog.value = true
}

const deleteBook = () => {
  router.delete(route('books.destroy', selectedBook.value.id), {
    onSuccess: () => {
      deleteDialog.value = false
      selectedBook.value = null
      showNotification('Libro eliminado exitosamente', 'success')
    },
    onError: () => {
      showNotification('Error al eliminar el libro', 'error')
    }
  })
}
</script>
