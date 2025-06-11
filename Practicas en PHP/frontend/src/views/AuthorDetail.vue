<template>
  <div>
    <v-row class="mb-4">
      <v-col>
        <v-btn
          :to="{ name: 'authors' }"
          prepend-icon="mdi-arrow-left"
          variant="text"
        >
          Volver a Autores
        </v-btn>
      </v-col>
    </v-row>

    <v-row v-if="author">
      <v-col cols="12" md="8">
        <v-card class="mb-4">
          <v-card-title class="d-flex justify-space-between align-center">
            <span class="text-h4">👤 {{ author.nombre_completo }}</span>
            <v-btn
              color="primary"
              :to="{ name: 'author-edit', params: { id: author.id } }"
              prepend-icon="mdi-pencil"
            >
              Editar
            </v-btn>
          </v-card-title>
        </v-card>

        <v-row>
          <v-col cols="12" md="6">
            <v-card>
              <v-card-title>Información Personal</v-card-title>
              <v-card-text>
                <v-list>
                  <v-list-item>
                    <v-list-item-title>Nombre</v-list-item-title>
                    <v-list-item-subtitle>{{ author.nombre }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title>Apellido</v-list-item-title>
                    <v-list-item-subtitle>{{ author.apellido }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title>País</v-list-item-title>
                    <v-list-item-subtitle>{{ author.pais }}</v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>

          <v-col cols="12" md="6">
            <v-card>
              <v-card-title>Estadísticas</v-card-title>
              <v-card-text>
                <v-list>
                  <v-list-item>
                    <v-list-item-title>Fecha de registro</v-list-item-title>
                    <v-list-item-subtitle>{{ formatDate(author.fecha_registro) }}</v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-title>Cantidad de libros</v-list-item-title>
                    <v-list-item-subtitle>{{ author.cantidad_libros }}</v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>

        <v-card class="mt-4" v-if="author.books && author.books.length > 0">
          <v-card-title>📚 Libros del Autor</v-card-title>
          <v-card-text>
            <v-row>
              <v-col
                v-for="book in author.books"
                :key="book.id"
                cols="12"
                md="6"
              >
                <v-card variant="outlined" class="mb-2">
                  <v-card-title class="text-h6">{{ book.nombre }}</v-card-title>
                  <v-card-text>
                    <p><strong>Edición:</strong> {{ book.edicion }}</p>
                    <p><strong>Publicado:</strong> {{ formatDate(book.fecha_publicacion) }}</p>
                  </v-card-text>
                  <v-card-actions>
                    <v-btn
                      :to="{ name: 'book-detail', params: { id: book.id } }"
                      color="primary"
                      variant="text"
                    >
                      Ver Libro
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>

        <v-card class="mt-4" v-else>
          <v-card-text class="text-center py-8">
            <v-icon size="64" color="grey-lighten-1" class="mb-4">
              mdi-book-off
            </v-icon>
            <p class="text-h6 text-grey-darken-1">
              Este autor aún no tiene libros registrados.
            </p>
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
        <p>No se encontró el autor.</p>
      </v-col>
    </v-row>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { authorsService } from '../services/authors'
import { useNotificationStore } from '../stores/notification'

const props = defineProps({
  id: {
    type: String,
    required: true
  }
})

const notification = useNotificationStore()
const author = ref(null)
const loading = ref(false)

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES')
}

const loadAuthor = async () => {
  loading.value = true
  try {
    const response = await authorsService.getById(props.id)
    author.value = response.data.data
  } catch (error) {
    notification.showError('Error al cargar el autor')
    console.error(error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadAuthor()
})
</script>
