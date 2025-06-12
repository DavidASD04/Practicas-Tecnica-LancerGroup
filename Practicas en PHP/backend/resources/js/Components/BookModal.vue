<template>
  <Modal 
    v-model="isOpen" 
    :title="`Detalles del Libro: ${book?.nombre || 'Cargando...'}`"
    max-width="800px"
    @close="closeModal"
  >
    <div v-if="book">
      <v-row>
        <v-col cols="12" md="6">
          <v-card variant="outlined" class="mb-4">
            <v-card-title class="text-h6">
              <v-icon left>mdi-book</v-icon>
              Información del Libro
            </v-card-title>
            <v-card-text>
              <v-list>
                <v-list-item>
                  <v-list-item-title>Título</v-list-item-title>
                  <v-list-item-subtitle class="text-h6">{{ book.nombre }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item v-if="book.fecha_publicacion">
                  <v-list-item-title>Fecha de Publicación</v-list-item-title>
                  <v-list-item-subtitle>
                    <v-chip color="primary" small>
                      <v-icon left small>mdi-calendar</v-icon>
                      {{ formatDate(book.fecha_publicacion) }}
                    </v-chip>
                  </v-list-item-subtitle>
                </v-list-item>
                <v-list-item v-if="book.edicion">
                  <v-list-item-title>Edición</v-list-item-title>
                  <v-list-item-subtitle>
                    <v-chip color="info" small>{{ book.edicion }}</v-chip>
                  </v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>ID del Libro</v-list-item-title>
                  <v-list-item-subtitle>#{{ book.id }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
        
        <v-col cols="12" md="6">
          <v-card variant="outlined" class="mb-4">
            <v-card-title class="text-h6">
              <v-icon left>mdi-chart-line</v-icon>
              Información del Sistema
            </v-card-title>
            <v-card-text>
              <v-list>
                <v-list-item>
                  <v-list-item-title>Total de Autores</v-list-item-title>
                  <v-list-item-subtitle>
                    <v-chip color="success" size="large">
                      {{ book.authors?.length || 0 }} autores
                    </v-chip>
                  </v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Creado</v-list-item-title>
                  <v-list-item-subtitle>{{ formatDate(book.created_at) }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Última Actualización</v-list-item-title>
                  <v-list-item-subtitle>{{ formatDate(book.updated_at) }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      
      <!-- Lista de autores del libro -->
      <v-card variant="outlined" v-if="book.authors && book.authors.length > 0">
        <v-card-title class="text-h6">
          <v-icon left>mdi-account-multiple</v-icon>
          Autores
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6" lg="4" v-for="author in book.authors" :key="author.id">
              <v-card variant="outlined" class="mb-2" @click="viewAuthor(author)" style="cursor: pointer">
                <v-card-title class="text-subtitle-1">
                  <v-icon left small>mdi-account</v-icon>
                  {{ author.nombre_completo }}
                </v-card-title>
                <v-card-subtitle>
                  <v-chip size="small" color="primary">
                    <v-icon left small>mdi-earth</v-icon>
                    {{ author.pais }}
                  </v-chip>
                </v-card-subtitle>
              </v-card>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
      
      <!-- Mensaje si no tiene autores -->
      <v-alert v-else type="warning" variant="tonal" class="mt-4">
        <v-icon left>mdi-alert</v-icon>
        Este libro no tiene autores asignados.
      </v-alert>
    </div>
    
    <!-- Loading state -->
    <div v-else class="text-center py-8">
      <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
      <p class="mt-4">Cargando información del libro...</p>
    </div>

    <template #actions>
      <v-btn color="secondary" @click="closeModal">Cerrar</v-btn>
      <v-btn color="primary" variant="outlined" @click="editBook" v-if="book">
        <v-icon left>mdi-pencil</v-icon>
        Editar Libro
      </v-btn>
    </template>
  </Modal>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import Modal from './Modal.vue'

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  book: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['update:modelValue', 'close', 'view-author'])

const isOpen = ref(props.modelValue)

watch(() => props.modelValue, (newValue) => {
  isOpen.value = newValue
})

watch(isOpen, (newValue) => {
  emit('update:modelValue', newValue)
})

const closeModal = () => {
  isOpen.value = false
  emit('close')
}

const editBook = () => {
  if (props.book?.id) {
    router.visit(`/books/${props.book.id}/edit`)
    closeModal()
  }
}

const viewAuthor = (author) => {
  emit('view-author', author)
}

const formatDate = (date) => {
  if (!date) return 'No disponible'
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>
