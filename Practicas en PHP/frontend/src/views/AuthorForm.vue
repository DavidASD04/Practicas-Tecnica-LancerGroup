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

    <v-row justify="center">
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="text-h5">
            {{ isEdit ? '✏️ Editar Autor' : '➕ Crear Nuevo Autor' }}
          </v-card-title>
          
          <v-card-text>
            <v-form ref="form" v-model="valid" @submit.prevent="submitForm">
              <v-text-field
                v-model="formData.nombre"
                label="Nombre *"
                :rules="nameRules"
                required
                variant="outlined"
                class="mb-3"
              ></v-text-field>

              <v-text-field
                v-model="formData.apellido"
                label="Apellido *"
                :rules="nameRules"
                required
                variant="outlined"
                class="mb-3"
              ></v-text-field>

              <v-text-field
                v-model="formData.pais"
                label="País *"
                :rules="nameRules"
                required
                variant="outlined"
                class="mb-3"
              ></v-text-field>
            </v-form>
          </v-card-text>

          <v-card-actions class="pa-4">
            <v-spacer></v-spacer>
            <v-btn
              :to="{ name: 'authors' }"
              color="grey"
              variant="text"
            >
              Cancelar
            </v-btn>
            <v-btn
              color="primary"
              :loading="loading"
              :disabled="!valid"
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
import { authorsService } from '../services/authors'
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

const isEdit = computed(() => !!props.id)

const formData = reactive({
  nombre: '',
  apellido: '',
  pais: ''
})

const nameRules = [
  v => !!v || 'Este campo es requerido',
  v => (v && v.length >= 2) || 'Debe tener al menos 2 caracteres'
]

onMounted(() => {
  if (isEdit.value) {
    loadAuthor()
  }
})

const loadAuthor = async () => {
  if (!props.id) return
  
  loading.value = true
  try {
    const response = await authorsService.getById(props.id)
    const author = response.data.data
    
    formData.nombre = author.nombre
    formData.apellido = author.apellido
    formData.pais = author.pais
  } catch (error) {
    notification.showError('Error al cargar el autor')
    console.error(error)
  } finally {
    loading.value = false
  }
}

const submitForm = async () => {
  const { valid: isValid } = await form.value.validate()
  if (!isValid) return

  loading.value = true
  try {
    if (isEdit.value) {
      await authorsService.update(props.id, formData)
      notification.showSuccess('Autor actualizado exitosamente')
    } else {
      await authorsService.create(formData)
      notification.showSuccess('Autor creado exitosamente')
    }
    
    router.push({ name: 'authors' })
  } catch (error) {
    if (error.response?.data?.errors) {
      const errors = error.response.data.errors
      let errorMessage = 'Error de validación:\n'
      Object.keys(errors).forEach(key => {
        errorMessage += `${errors[key].join(', ')}\n`
      })
      notification.showError(errorMessage)
    } else {
      notification.showError(`Error al ${isEdit.value ? 'actualizar' : 'crear'} el autor`)
    }
    console.error(error)
  } finally {
    loading.value = false
  }
}
</script>
