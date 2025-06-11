<template>
  <div>
    <v-row class="mb-4">
      <v-col>
        <v-card>
          <v-card-title class="d-flex justify-space-between align-center">
            <span class="text-h4">✍️ Autores</span>
            <v-btn
              color="primary"
              :to="{ name: 'author-create' }"
              prepend-icon="mdi-plus"
            >
              Nuevo Autor
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
            :items="authors"
            :loading="loading"
            class="elevation-1"
            item-value="id"
          >
            <template v-slot:item.nombre_completo="{ item }">
              <strong>{{ item.nombre_completo }}</strong>
            </template>

            <template v-slot:item.actions="{ item }">
              <v-btn
                icon="mdi-eye"
                size="small"
                color="info"
                variant="text"
                :to="{ name: 'author-detail', params: { id: item.id } }"
                class="mr-1"
              >
              </v-btn>
              <v-btn
                icon="mdi-pencil"
                size="small"
                color="primary"
                variant="text"
                :to="{ name: 'author-edit', params: { id: item.id } }"
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
          ¿Estás seguro de eliminar al autor <strong>{{ selectedAuthor?.nombre_completo }}</strong>?
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
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { authorsService } from '../services/authors'
import { useNotificationStore } from '../stores/notification'

const notification = useNotificationStore()

const authors = ref([])
const loading = ref(false)
const deleteDialog = ref(false)
const selectedAuthor = ref(null)

const headers = [
  { title: 'Nombre Completo', key: 'nombre_completo', sortable: true },
  { title: 'País', key: 'pais', sortable: true },
  { title: 'Acciones', key: 'actions', sortable: false, width: '150px' }
]

const loadAuthors = async () => {
  loading.value = true
  try {
    const response = await authorsService.getAll()
    authors.value = response.data.data
  } catch (error) {
    notification.showError('Error al cargar los autores')
    console.error(error)
  } finally {
    loading.value = false
  }
}

const confirmDelete = (author) => {
  selectedAuthor.value = author
  deleteDialog.value = true
}

const deleteAuthor = async () => {
  try {
    await authorsService.delete(selectedAuthor.value.id)
    notification.showSuccess('Autor eliminado exitosamente')
    loadAuthors()
  } catch (error) {
    notification.showError('Error al eliminar el autor')
    console.error(error)
  } finally {
    deleteDialog.value = false
    selectedAuthor.value = null
  }
}

onMounted(() => {
  loadAuthors()
})
</script>
