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
              <span class="text-h4">✏️ Editar Libro</span>
            </v-card-title>
          </v-card>
        </v-col>
      </v-row>      <v-row justify="center">
        <v-col cols="12" lg="8">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-book-edit</v-icon>
              Información del Libro
            </v-card-title>
            <v-card-text>
              <form @submit.prevent="submitForm">
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      v-model="form.nombre"
                      label="Título del Libro"
                      prepend-icon="mdi-book"
                      variant="outlined"
                      :error-messages="form.errors.nombre"
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
                      :error-messages="form.errors.fecha_publicacion"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      v-model="form.edicion"
                      label="Edición"
                      prepend-icon="mdi-numeric"
                      variant="outlined"
                      placeholder="1ra Edición"
                      :error-messages="form.errors.edicion"
                    ></v-text-field>
                  </v-col>
                </v-row>                <v-row>
                  <v-col cols="12">                    <v-select
                      v-model="form.authors"
                      :items="authorsList"
                      item-title="nombre_completo"
                      item-value="id"
                      label="Autores (Requerido)"
                      prepend-icon="mdi-account-edit"
                      variant="outlined"
                      multiple
                      chips
                      closable-chips
                      placeholder="Selecciona uno o más autores"
                      :error-messages="form.errors.authors"
                      required
                      hint="Debes seleccionar al menos un autor para el libro"
                      persistent-hint
                    >
                      <template v-slot:chip="{ item, props }">
                        <v-chip v-bind="props" color="primary" closable>
                          <v-icon left small>mdi-account</v-icon>
                          {{ item.title }}
                        </v-chip>
                      </template>
                    </v-select>
                  </v-col>
                </v-row>

                <v-row class="mt-4">
                  <v-col cols="12" sm="6">
                    <Link :href="route('books.show', book.id)" class="text-decoration-none">
                      <v-btn
                        color="info"
                        size="large"
                        prepend-icon="mdi-eye"
                        block
                        variant="outlined"
                      >
                        Ver Libro
                      </v-btn>
                    </Link>
                  </v-col>
                  <v-col cols="12" sm="6">                    <v-btn
                      type="submit"
                      color="primary"
                      size="large"
                      :loading="form.processing"
                      prepend-icon="mdi-content-save"
                      :disabled="!form.nombre || !form.authors || form.authors.length === 0"
                      block
                    >
                      Actualizar Libro
                    </v-btn>
                  </v-col>
                </v-row>
              </form>
            </v-card-text>
          </v-card>        </v-col>
      </v-row>
    </div>
  </Layout>
</template>

<script setup>
import { computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import Layout from '@/Components/Layout.vue'

// Props del backend
const props = defineProps({
  book: Object,
  authors: Array
})

// Función para mostrar notificaciones
const showNotification = (message, type = 'info') => {
  if (window.showNotification) {
    window.showNotification(message, type)
  } else {
    console.log(`${type.toUpperCase()}: ${message}`)
  }
}

// Usar useForm de Inertia.js con datos iniciales del libro
const form = useForm({
  nombre: props.book.nombre || '',
  fecha_publicacion: props.book.fecha_publicacion || '',
  edicion: props.book.edicion || '',
  authors: props.book.author_ids || []
})

// Lista de autores con nombres completos
const authorsList = computed(() => {
  return (props.authors || []).map(author => ({
    ...author,
    nombre_completo: `${author.nombre} ${author.apellido}`
  }))
})

const submitForm = () => {
  console.log('Actualizando libro:', form.data())
  console.log('Lista de autores disponibles:', authorsList.value)
  
  form.put(route('books.update', props.book.id), {
    onSuccess: () => {
      console.log('Libro actualizado exitosamente')
      showNotification('Libro actualizado exitosamente', 'success')
    },
    onError: (errors) => {
      console.error('Errores de validación:', errors)
      showNotification('Error al actualizar el libro. Revisa los datos.', 'error')
    }
  })
}
</script>
