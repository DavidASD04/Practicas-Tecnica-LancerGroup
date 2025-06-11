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

    <v-row justify="center">
      <v-col cols="12" md="8">
        <v-card>
          <v-card-title class="text-h5">
            {{ isEdit ? '✏️ Editar Libro' : '➕ Crear Nuevo Libro' }}
          </v-card-title>
          
          <v-card-text>
            <v-form ref="form" v-model="valid" @submit.prevent="submitForm">
              <v-text-field
                v-model="formData.nombre"
                label="Nombre del Libro *"
                :rules="nameRules"
                required
                variant="outlined"
                class="mb-3"
              ></v-text-field>

              <v-text-field
                v-model="formData.fecha_publicacion"
                label="Fecha de Publicación *"
                type="date"
                :rules="dateRules"
                required
                variant="outlined"
                class="mb-3"
              ></v-text-field>

              <v-text-field
                v-model="formData.edicion"
                label="Edición *"
                :rules="nameRules"
                required
                variant="outlined"
                class="mb-3"
              ></v-text-field>

              <v-card variant="outlined" class="mb-3">
                <v-card-title class="text-h6">
                  Autores * (Selecciona al menos uno)
                </v-card-title>
                <v-card-text>
                  <v-row>
                    <v-col
                      v-for="author in availableAuthors"
                      :key="author.id"
                      cols="12"
                      md="6"
                    >
                      <v-checkbox
                        v-model="formData.authors"
                        :value="author.id"
                        :label="`${author.nombre} ${author.apellido}`"
                        hide-details
                      ></v-checkbox>
                    </v-col>
                  </v-row>
                  <v-alert
                    v-if="formData.authors.length === 0"
                    type="warning"
                    variant="tonal"
                    class="mt-3"
                  >
                    Debes seleccionar al menos un autor
                  </v-alert>
                </v-card-text>
              </v-card>
            </v-form>
          </v-card-text>

          <v-card-actions class="pa-4">
            <v-spacer></v-spacer>
            <v-btn
              :to="{ name: 'books' }"
              color="grey"
              variant="text"
            >
              Cancelar
            </v-btn>
            <v-btn
              color="success"
              :loading="loading"
              :disabled="!valid || formData.authors.length === 0"
              @click="submitForm"
            >
              {{ isEdit ? '💾 Actualizar' : '💾 Guardar' }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { booksService } from '../services/books'
import { useNotificationStore } from '../stores/notification'

const props = defineProps({
  id: {
    type: String,
    default: null
  }
})

const router = useRouter()
const notification = useNotificationStore()

const form = ref(null)
const valid = ref(false)
const loading = ref(false)
const availableAuthors = ref([])

const isEdit = computed(() => !!props.id)

const formData = reactive({
  nombre: '',
  fecha_publicacion: '',
  edicion: '',
  authors: []
})

const nameRules = [
  v => !!v || 'Este campo es requerido',
  v => (v && v.length >= 2) || 'Debe tener al menos 2 caracteres'
]

const dateRules = [
  v => !!v || 'La fecha es requerida'
]

const loadAuthors = async () => {
  try {
    const response = await booksService.getAuthorsForSelect()
    availableAuthors.value = response.data.data
  } catch (error) {
    notification.showError('Error al cargar los autores')
    console.error(error)
  }
}

const loadBook = async () => {
  if (!props.id) return
  
  loading.value = true
  try {
    const response = await booksService.getById(props.id)
    const book = response.data.data
    
    formData.nombre = book.nombre
    formData.fecha_publicacion = book.fecha_publicacion
    formData.edicion = book.edicion
    formData.authors = book.authors.map(author => author.id)
  } catch (error) {
    notification.showError('Error al cargar el libro')
    console.error(error)
  } finally {
    loading.value = false
  }
}

const submitForm = async () => {
  const { valid: isValid } = await form.value.validate()
  if (!isValid || formData.authors.length === 0) return

  loading.value = true
  try {
    if (isEdit.value) {
      await booksService.update(props.id, formData)
      notification.showSuccess('Libro actualizado exitosamente')
    } else {
      await booksService.create(formData)
      notification.showSuccess('Libro creado exitosamente')
    }
    
    router.push({ name: 'books' })
  } catch (error) {
    if (error.response?.data?.errors) {
      const errors = error.response.data.errors
      let errorMessage = 'Error de validación:\n'
      Object.keys(errors).forEach(key => {
        errorMessage += `${errors[key].join(', ')}\n`
      })
      notification.showError(errorMessage)
    } else {
      notification.showError(`Error al ${isEdit.value ? 'actualizar' : 'crear'} el libro`)
    }
    console.error(error)
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await loadAuthors()
  if (isEdit.value) {
    await loadBook()
  }
})
</script>
