<template>
  <Layout>
    <div>
      <v-row class="mb-4">
        <v-col>
          <v-card>
            <v-card-title class="d-flex align-center">
              <Link :href="route('authors.index')" class="text-decoration-none">
                <v-btn
                  icon="mdi-arrow-left"
                  variant="text"
                  class="mr-2"
                ></v-btn>
              </Link>
              <span class="text-h4">✏️ Editar Autor</span>
            </v-card-title>
          </v-card>
        </v-col>
      </v-row>

      <v-row justify="center">
        <v-col cols="12" md="8" lg="6">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-account-edit</v-icon>
              Información del Autor
            </v-card-title>
            <v-card-text>
              <v-form @submit.prevent="submitForm">
                <v-row>
                  <v-col cols="12" sm="6">
                    <v-text-field
                      v-model="form.nombre"
                      label="Nombre"
                      :error-messages="formErrors.nombre"
                      prepend-icon="mdi-account"
                      variant="outlined"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-text-field
                      v-model="form.apellido"
                      label="Apellido"
                      :error-messages="formErrors.apellido"
                      prepend-icon="mdi-account-outline"
                      variant="outlined"
                      required
                    ></v-text-field>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col cols="12">
                    <v-autocomplete
                      v-model="form.pais"
                      :items="countries"
                      label="País"
                      :error-messages="formErrors.pais"
                      prepend-icon="mdi-earth"
                      variant="outlined"
                      required
                      clearable
                      no-data-text="No se encontraron países"
                      :search-input.sync="countrySearch"
                    ></v-autocomplete>
                  </v-col>
                </v-row>

                <v-row class="mt-4">
                  <v-col cols="12" sm="6">
                    <Link :href="route('authors.show', author.id)" class="text-decoration-none">
                      <v-btn
                        color="info"
                        size="large"
                        prepend-icon="mdi-eye"
                        block
                        variant="outlined"
                      >
                        Ver Autor
                      </v-btn>
                    </Link>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <v-btn
                      type="submit"
                      color="primary"
                      size="large"
                      :loading="form.processing"
                      prepend-icon="mdi-content-save"
                      :disabled="!form.nombre || !form.apellido || !form.pais"
                      block
                    >
                      Actualizar Autor
                    </v-btn>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </Layout>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import Layout from '@/Components/Layout.vue'

// Props del backend
const props = defineProps({
  author: Object
})

// Lista de países del mundo
const countries = ref([
  'Afganistán', 'Albania', 'Alemania', 'Andorra', 'Angola', 'Antigua y Barbuda', 'Arabia Saudita', 'Argelia', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaiyán',
  'Bahamas', 'Bangladés', 'Barbados', 'Baréin', 'Bélgica', 'Belice', 'Benín', 'Bielorrusia', 'Birmania', 'Bolivia', 'Bosnia y Herzegovina', 'Botsuana', 'Brasil', 'Brunéi', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Bután',
  'Cabo Verde', 'Camboya', 'Camerún', 'Canadá', 'Catar', 'Chad', 'Chile', 'China', 'Chipre', 'Colombia', 'Comoras', 'Congo', 'República del Congo', 'Corea del Norte', 'Corea del Sur', 'Costa Rica', 'Costa de Marfil', 'Croacia', 'Cuba',
  'Dinamarca', 'Dominica',
  'Ecuador', 'Egipto', 'El Salvador', 'Emiratos Árabes Unidos', 'Eritrea', 'Eslovaquia', 'Eslovenia', 'España', 'Estados Unidos', 'Estonia', 'Etiopía',
  'Fiyi', 'Filipinas', 'Finlandia', 'Francia',
  'Gabón', 'Gambia', 'Georgia', 'Ghana', 'Granada', 'Grecia', 'Guatemala', 'Guinea', 'Guinea-Bisáu', 'Guinea Ecuatorial', 'Guyana',
  'Haití', 'Honduras', 'Hungría',
  'India', 'Indonesia', 'Irak', 'Irán', 'Irlanda', 'Islandia', 'Islas Marshall', 'Islas Salomón', 'Israel', 'Italia',
  'Jamaica', 'Japón', 'Jordania',
  'Kazajistán', 'Kenia', 'Kirguistán', 'Kiribati', 'Kuwait',
  'Laos', 'Lesoto', 'Letonia', 'Líbano', 'Liberia', 'Libia', 'Liechtenstein', 'Lituania', 'Luxemburgo',
  'Madagascar', 'Malasia', 'Malaui', 'Maldivas', 'Malí', 'Malta', 'Marruecos', 'Mauricio', 'Mauritania', 'México', 'Micronesia', 'Moldavia', 'Mónaco', 'Mongolia', 'Montenegro', 'Mozambique',
  'Namibia', 'Nauru', 'Nepal', 'Nicaragua', 'Níger', 'Nigeria', 'Noruega', 'Nueva Zelanda',
  'Omán',
  'Países Bajos', 'Pakistán', 'Palaos', 'Palestina', 'Panamá', 'Papúa Nueva Guinea', 'Paraguay', 'Perú', 'Polonia', 'Portugal',
  'Reino Unido', 'República Centroafricana', 'República Checa', 'República Dominicana', 'Ruanda', 'Rumanía', 'Rusia',
  'Samoa', 'San Cristóbal y Nieves', 'San Marino', 'San Vicente y las Granadinas', 'Santa Lucía', 'Santo Tomé y Príncipe', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leona', 'Singapur', 'Siria', 'Somalia', 'Sri Lanka', 'Suazilandia', 'Sudáfrica', 'Sudán', 'Sudán del Sur', 'Suecia', 'Suiza', 'Surinam',
  'Tailandia', 'Tanzania', 'Tayikistán', 'Timor Oriental', 'Togo', 'Tonga', 'Trinidad y Tobago', 'Túnez', 'Turkmenistán', 'Turquía', 'Tuvalu',
  'Ucrania', 'Uganda', 'Uruguay', 'Uzbekistán',
  'Vanuatu', 'Venezuela', 'Vietnam',
  'Yemen',
  'Yibuti',
  'Zambia', 'Zimbabue'
])

// Variable reactiva para la búsqueda de países
const countrySearch = ref('')

// Función para mostrar notificaciones
const showNotification = (message, type = 'info') => {
  if (window.showNotification) {
    window.showNotification(message, type)
  } else {
    console.log(`${type.toUpperCase()}: ${message}`)
  }
}

// Usar useForm de Inertia.js con datos iniciales del autor
const form = useForm({
  nombre: props.author.nombre || '',
  apellido: props.author.apellido || '',
  pais: props.author.pais || ''
})

// Errores del formulario
const formErrors = computed(() => form.errors || {})

const submitForm = () => {
  console.log('Actualizando autor:', form.data())
  
  form.put(route('authors.update', props.author.id), {
    onSuccess: () => {
      console.log('Autor actualizado exitosamente')
      showNotification('Autor actualizado exitosamente', 'success')
    },
    onError: (errors) => {
      console.error('Errores de validación:', errors)
      showNotification('Error al actualizar el autor. Revisa los datos.', 'error')
    }
  })
}
</script>
