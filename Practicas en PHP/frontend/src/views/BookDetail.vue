<template>
  <div>
    <v-row class="mb-4">
      <v-col>
        <v-btn
          :to="{ name: 'books' }"
          prepend-icon="mdi-arrow-left"
          variant="text"
        >
          Volver a Libros
        </v-btn>
      </v-col>
    </v-row>

    <v-row v-if="book">
      <v-col cols="12" md="8">
        <v-card class="mb-4">
          <v-card-title class="d-flex justify-space-between align-center">
            <span class="text-h4">📖 {{ book.nombre }}</span>
            <v-btn
              color="primary"
              :to="{ name: 'book-edit', params: { id: book.id } }"
              prepend-icon="mdi-pencil"
            >
              Editar
            </v-btn>
          </v-card-title>
        </v-card>

        <v-card class="mb-4">
          <v-card-title>Información del Libro</v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="6">
                <v-list>
                  <v-list-item>
                    <v-list-item-title>Nombre</v-list-item-title>
                    <v-list-item-subtitle>{{ book.nombre }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title>Edición</v-list-item-title>
                    <v-list-item-subtitle>{{ book.edicion }}</v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-col>
              <v-col cols="12" md="6">
                <v-list>
                  <v-list-item>
                    <v-list-item-title>Fecha de publicación</v-list-item-title>
                    <v-list-item-subtitle>{{ formatDate(book.fecha_publicacion) }}</v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>

        <v-card v-if="book.authors && book.authors.length > 0">
          <v-card-title>✍️ Autores</v-card-title>
          <v-card-text>
            <v-row>
              <v-col
                v-for="author in book.authors"
                :key="author.id"
                cols="12"
                md="6"
              >
                <v-card 
                  variant="outlined" 
                  class="mb-2"
                  :class="{ 'bg-red-lighten-5': author.deleted_at }"
                >
                  <v-card-title class="d-flex justify-space-between align-center">
                    <span>
                      {{ author.nombre }} {{ author.apellido }}
                      <v-chip
                        v-if="author.deleted_at"
                        color="error"
                        size="small"
                        class="ml-2"
                      >
                        Eliminado
                      </v-chip>
                    </span>
                  </v-card-title>
                  <v-card-text>
                    <p><strong>País:</strong> {{ author.pais }}</p>
                  </v-card-text>
                  <v-card-actions v-if="!author.deleted_at">
                    <v-btn
                      :to="{ name: 'author-detail', params: { id: author.id } }"
                      color="primary"
                      variant="text"
                    >
                      Ver Autor
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-row v-else-if="loading">
      <v-col class="text-center">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-col>
    </v-row>
    <v-row v-else>
      <v-col class="text-center">
        No se encontró el libro.
      </v-col>
    </v-row>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { booksService } from '../services/books'
import { useNotificationStore } from '../stores/notification'

const props = defineProps({
  id: {
    type: String,
    required: true
  }
})

const notification = useNotificationStore()
const book = ref(null)
const loading = ref(false)

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES')
}

const loadBook = async () => {
  loading.value = true
  try {
    const response = await booksService.getById(props.id)
    book.value = response.data.data
  } catch (error) {
    notification.showError('Error al cargar el libro')
    console.error(error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadBook()
})
</script>
