<template>
  <div>
    <v-row class="mb-4">
      <v-col>
        <v-card>
          <v-card-title class="d-flex justify-space-between align-center">
            <span class="text-h4">📚 Libros</span>
            <v-btn
              color="success"
              :to="{ name: 'book-create' }"
              prepend-icon="mdi-plus"
            >
              Nuevo Libro
            </v-btn>
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
          >
            <template v-slot:item.nombre="{ item }">
              <strong>{{ item.nombre }}</strong>
            </template>

            <template v-slot:item.fecha_publicacion="{ item }">
              {{ formatDate(item.fecha_publicacion) }}
            </template>

            <template v-slot:item.actions="{ item }">
              <v-btn
                icon="mdi-eye"
                size="small"
                color="info"
                variant="text"
                :to="{ name: 'book-detail', params: { id: item.id } }"
                class="mr-1"
              >
              </v-btn>
              <v-btn
                icon="mdi-pencil"
                size="small"
                color="primary"
                variant="text"
                :to="{ name: 'book-edit', params: { id: item.id } }"
                class="mr-1"
              >
              </v-btn>
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
          ¿Estás seguro de eliminar el libro <strong>"{{ selectedBook?.nombre }}"</strong>?
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
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { booksService } from '../services/books'
import { useNotificationStore } from '../stores/notification'

const notification = useNotificationStore()

const books = ref([])
const loading = ref(false)
const deleteDialog = ref(false)
const selectedBook = ref(null)

const headers = [
  { title: 'Nombre', key: 'nombre', sortable: true },
  { title: 'Fecha de Publicación', key: 'fecha_publicacion', sortable: true },
  { title: 'Edición', key: 'edicion', sortable: true },
  { title: 'Acciones', key: 'actions', sortable: false, width: '150px' }
]

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES')
}

const loadBooks = async () => {
  loading.value = true
  try {
    const response = await booksService.getAll()
    books.value = response.data.data
  } catch (error) {
    notification.showError('Error al cargar los libros')
    console.error(error)
  } finally {
    loading.value = false
  }
}

const confirmDelete = (book) => {
  selectedBook.value = book
  deleteDialog.value = true
}

const deleteBook = async () => {
  try {
    await booksService.delete(selectedBook.value.id)
    notification.showSuccess('Libro eliminado exitosamente')
    loadBooks()
  } catch (error) {
    notification.showError('Error al eliminar el libro')
    console.error(error)
  } finally {
    deleteDialog.value = false
    selectedBook.value = null
  }
}

onMounted(() => {
  loadBooks()
})
</script>
