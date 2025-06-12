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
              <span class="text-h4">📖 Crear Nuevo Libro</span>
            </v-card-title>
          </v-card>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" lg="8">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-book-plus</v-icon>
              Información del Libro
            </v-card-title>
            <v-card-text>              <form @submit.prevent="submitForm">
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      v-model="form.nombre"
                      label="Título del Libro"
                      prepend-icon="mdi-book"
                      variant="outlined"
                      :error-messages="formErrors.nombre"
                      required
                    ></v-text-field>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col cols="12" md="6">
                    <v-text-field
                      v-model="form.fecha_publicacion"
                      label="Fecha de Publicación"
                      prepend-icon="mdi-calendar"
                      variant="outlined"
                      type="date"
                      :error-messages="formErrors.fecha_publicacion"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      v-model="form.edicion"
                      label="Edición"
                      prepend-icon="mdi-numeric"
                      variant="outlined"
                      placeholder="1ra Edición"
                      :error-messages="formErrors.edicion"
                    ></v-text-field>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col cols="12">
                    <v-select
                      v-model="form.authors"
                      :items="authorsList"
                      item-title="nombre_completo"
                      item-value="id"
                      label="Autores"
                      prepend-icon="mdi-account-edit"
                      variant="outlined"
                      multiple
                      chips
                      closable-chips
                      placeholder="Selecciona uno o más autores"
                      :error-messages="formErrors.authors"
                    ></v-select>
                  </v-col>
                </v-row>

                <v-row class="mt-4">
                  <v-col cols="12">
                    <v-btn
                      type="submit"
                      color="primary"
                      size="large"
                      :loading="form.processing"
                      prepend-icon="mdi-content-save"
                      :disabled="!form.nombre"
                      block
                    >
                      Crear Libro
                    </v-btn>
                  </v-col>
                </v-row>
              </form>
            </v-card-text>
          </v-card>
        </v-col>

        <v-col cols="12" lg="4">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-information</v-icon>
              Información
            </v-card-title>
            <v-card-text>
              <v-alert 
                type="info" 
                variant="tonal"
                class="mb-4"
              >
                <strong>Consejos:</strong>
                <ul class="mt-2">
                  <li>El título es obligatorio</li>
                  <li>Puedes asociar múltiples autores</li>
                </ul>
              </v-alert>              <v-alert 
                type="success" 
                variant="tonal"
                v-if="form.authors.length > 0"
              >
                <strong>Autores seleccionados:</strong> {{ form.authors.length }}
              </v-alert>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </Layout>
</template>

<script setup>
import { computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import Layout from '@/Components/Layout.vue'

const props = defineProps({
  authors: {
    type: Array,
    default: () => []
  }
})

// Función para mostrar notificaciones
const showNotification = (message, type = 'info') => {
  if (window.showNotification) {
    window.showNotification(message, type)
  } else {
    console.log(`${type.toUpperCase()}: ${message}`)
  }
}

// Usar useForm de Inertia.js para manejo del formulario
const form = useForm({
  nombre: '',
  fecha_publicacion: '',
  edicion: '',
  authors: []
})

// Lista de autores con nombres completos
const authorsList = computed(() => {
  return (props.authors || []).map(author => ({
    ...author,
    nombre_completo: `${author.nombre} ${author.apellido}`
  }))
})

// Errores del formulario
const formErrors = computed(() => form.errors || {})

const submitForm = () => {
  console.log('Enviando formulario de libro:', form.data())
  console.log('Lista de autores disponibles:', authorsList.value)
  
  form.post(route('books.store'), {
    onSuccess: () => {
      console.log('Libro creado exitosamente')
      showNotification('Libro creado exitosamente', 'success')
    },
    onError: (errors) => {
      console.error('Errores de validación:', errors)
      showNotification('Error al crear el libro. Revisa los datos.', 'error')
    }
  })
}
</script>
