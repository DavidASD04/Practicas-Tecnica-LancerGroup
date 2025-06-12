<template>
  <Layout>
    <div>
      <v-row class="mb-4">
        <v-col>
          <v-card>            <v-card-title class="d-flex justify-space-between align-center">
              <span class="text-h4">  Autores</span>
              <Link :href="route('authors.create')" class="text-decoration-none">
                <v-btn
                  color="primary"
                  prepend-icon="mdi-plus"
                >
                  Nuevo Autor
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
              :items="authors"
              :loading="loading"
              class="elevation-1"
              item-value="id"
            >              <template v-slot:item.nombre="{ item }">
                <strong>{{ item.nombre }}</strong>
              </template>

              <template v-slot:item.apellido="{ item }">
                <strong>{{ item.apellido }}</strong>
              </template>              <template v-slot:item.actions="{ item }">
                <v-btn
                  icon="mdi-eye"
                  size="small"
                  color="info"
                  variant="text"
                  class="mr-1"
                  @click="viewAuthorDetails(item)"
                >
                </v-btn>
                <Link :href="route('authors.edit', item.id)" class="text-decoration-none">
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
      </v-row>      <!-- Dialog de confirmación -->
      <v-dialog v-model="deleteDialog" max-width="500px">
        <v-card>
          <v-card-title class="text-h5">
            Confirmar eliminación
          </v-card-title>
          <v-card-text>
            ¿Estás seguro de que quieres suspender al autor <strong>{{ selectedAuthor?.nombre }} {{ selectedAuthor?.apellido }}</strong>?
            <br><br>
            <v-alert type="info" variant="tonal" class="mt-2">
              <v-icon left>mdi-information</v-icon>
              El autor será suspendido pero no eliminado permanentemente. Podrás restaurarlo más tarde.
            </v-alert>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey" variant="text" @click="deleteDialog = false">
              Cancelar
            </v-btn>
            <v-btn color="warning" variant="text" @click="deleteAuthor">
              Suspender
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Modal de detalles del autor -->
      <AuthorModal 
        v-model="authorModal" 
        :author="selectedAuthorForModal"
        @close="closeAuthorModal"
      />
    </div>
  </Layout>
</template>

<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import Layout from '@/Components/Layout.vue'
import AuthorModal from '@/Components/AuthorModal.vue'

// Props del backend
const props = defineProps({
  authors: Array
})

const loading = ref(false)
const deleteDialog = ref(false)
const selectedAuthor = ref(null)
const authorModal = ref(false)
const selectedAuthorForModal = ref(null)

// Función para mostrar notificaciones
const showNotification = (message, type = 'info') => {
  if (window.showNotification) {
    window.showNotification(message, type)
  } else {
    console.log(`${type.toUpperCase()}: ${message}`)
  }
}

const headers = [
  { title: 'Nombre', key: 'nombre', sortable: true },
  { title: 'Apellido', key: 'apellido', sortable: true },
  { title: 'País', key: 'pais', sortable: true },
  { title: 'Acciones', key: 'actions', sortable: false, width: '150px' }
]

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const confirmDelete = (author) => {
  selectedAuthor.value = author
  deleteDialog.value = true
}

const deleteAuthor = () => {
  router.delete(route('authors.destroy', selectedAuthor.value.id), {
    onSuccess: () => {
      deleteDialog.value = false
      selectedAuthor.value = null
      showNotification('Autor suspendido exitosamente', 'success')
    },
    onError: () => {
      showNotification('Error al suspender el autor', 'error')
    }
  })
}

const viewAuthorDetails = async (author) => {
  // Hacer una petición para obtener los detalles completos del autor
  try {
    const response = await fetch(route('authors.show', author.id), {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    
    if (response.ok) {
      const data = await response.json()
      selectedAuthorForModal.value = data.props.author
      authorModal.value = true
    } else {
      showNotification('Error al cargar los detalles del autor', 'error')
    }
  } catch (error) {
    console.error('Error:', error)
    showNotification('Error al cargar los detalles del autor', 'error')
  }
}

const closeAuthorModal = () => {
  authorModal.value = false
  selectedAuthorForModal.value = null
}
</script>
