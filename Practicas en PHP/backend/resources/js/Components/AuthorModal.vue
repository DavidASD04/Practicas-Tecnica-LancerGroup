<template>
  <Modal 
    v-model="isOpen" 
    :title="`Detalles del Autor: ${author?.nombre_completo || 'Cargando...'}`"
    max-width="700px"
    @close="closeModal"
  >
    <div v-if="author">
      <v-row>
        <v-col cols="12" md="6">
          <v-card variant="outlined" class="mb-4">
            <v-card-title class="text-h6">
              <v-icon left>mdi-account</v-icon>
              Información Personal
            </v-card-title>
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
                  <v-list-item-subtitle>
                    <v-chip color="primary" small>
                      <v-icon left small>mdi-earth</v-icon>
                      {{ author.pais }}
                    </v-chip>
                  </v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Fecha de Registro</v-list-item-title>
                  <v-list-item-subtitle>{{ formatDate(author.fecha_registro) }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
        
        <v-col cols="12" md="6">
          <v-card variant="outlined" class="mb-4">
            <v-card-title class="text-h6">
              <v-icon left>mdi-chart-line</v-icon>
              Estadísticas
            </v-card-title>
            <v-card-text>
              <v-list>
                <v-list-item>
                  <v-list-item-title>Total de Libros</v-list-item-title>
                  <v-list-item-subtitle>
                    <v-chip color="success" size="large">
                      {{ author.books?.length || 0 }} libros
                    </v-chip>
                  </v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Creado</v-list-item-title>
                  <v-list-item-subtitle>{{ formatDate(author.created_at) }}</v-list-item-subtitle>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title>Última Actualización</v-list-item-title>
                  <v-list-item-subtitle>{{ formatDate(author.updated_at) }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      
      <!-- Lista de libros del autor -->
      <v-card variant="outlined" v-if="author.books && author.books.length > 0">
        <v-card-title class="text-h6">
          <v-icon left>mdi-book-multiple</v-icon>
          Libros Publicados
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6" v-for="book in author.books" :key="book.id">
              <v-card variant="outlined" class="mb-2">
                <v-card-title class="text-subtitle-1">
                  <v-icon left small>mdi-book</v-icon>
                  {{ book.nombre }}
                </v-card-title>
                <v-card-subtitle v-if="book.fecha_publicacion">
                  Publicado: {{ formatDate(book.fecha_publicacion) }}
                </v-card-subtitle>
                <v-card-text v-if="book.edicion">
                  <v-chip size="small" color="info">{{ book.edicion }}</v-chip>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
      
      <!-- Mensaje si no tiene libros -->
      <v-alert v-else type="info" variant="tonal" class="mt-4">
        <v-icon left>mdi-information</v-icon>
        Este autor aún no tiene libros registrados.
      </v-alert>
    </div>
    
    <!-- Loading state -->
    <div v-else class="text-center py-8">
      <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
      <p class="mt-4">Cargando información del autor...</p>
    </div>

    <template #actions>
      <v-btn color="secondary" @click="closeModal">Cerrar</v-btn>
      <v-btn color="primary" variant="outlined" @click="editAuthor" v-if="author">
        <v-icon left>mdi-pencil</v-icon>
        Editar Autor
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
  author: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['update:modelValue', 'close'])

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

const editAuthor = () => {
  if (props.author?.id) {
    router.visit(`/authors/${props.author.id}/edit`)
    closeModal()
  }
}

const formatDate = (date) => {
  if (!date) return 'No disponible'
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>
