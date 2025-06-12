<template>
  <Layout>
    <div>
      <v-row class="mb-4">
        <v-col>
          <v-card>            <v-card-title class="d-flex align-center">
              <Link :href="route('authors.index')" class="text-decoration-none">
                <v-btn
                  icon="mdi-arrow-left"
                  variant="text"
                  class="mr-2"
                ></v-btn>
              </Link>
              <span class="text-h4">➕ Crear Nuevo Autor</span>
            </v-card-title>
          </v-card>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" md="8" lg="6">
          <v-card>
            <v-card-title>
              <v-icon left>mdi-account-plus</v-icon>
              Información del Autor
            </v-card-title>
            <v-card-text>              <v-form @submit.prevent="submitForm">
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
                </v-row>                <v-row>
                  <v-col cols="12">
                    <v-autocomplete
                      v-model="form.pais"
                      :items="countriesList"
                      label="País"
                      :error-messages="formErrors.pais"
                      prepend-icon="mdi-earth"
                      variant="outlined"
                      required
                      no-data-text="No se encontraron países"
                      item-title="nombre"
                      item-value="nombre"
                      clearable
                    ></v-autocomplete>
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
                      :disabled="!form.nombre || !form.apellido || !form.pais"
                      block
                    >
                      Crear Autor
                    </v-btn>
                  </v-col>
                </v-row>              </v-form>
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

// Lista de países del mundo
const countriesList = [
  { nombre: 'Afganistán' },
  { nombre: 'Albania' },
  { nombre: 'Alemania' },
  { nombre: 'Andorra' },
  { nombre: 'Angola' },
  { nombre: 'Antigua y Barbuda' },
  { nombre: 'Arabia Saudí' },
  { nombre: 'Argelia' },
  { nombre: 'Argentina' },
  { nombre: 'Armenia' },
  { nombre: 'Australia' },
  { nombre: 'Austria' },
  { nombre: 'Azerbaiyán' },
  { nombre: 'Bahamas' },
  { nombre: 'Bahrein' },
  { nombre: 'Bangladesh' },
  { nombre: 'Barbados' },
  { nombre: 'Bélgica' },
  { nombre: 'Belice' },
  { nombre: 'Benin' },
  { nombre: 'Bielorrusia' },
  { nombre: 'Bolivia' },
  { nombre: 'Bosnia y Herzegovina' },
  { nombre: 'Botsuana' },
  { nombre: 'Brasil' },
  { nombre: 'Brunéi' },
  { nombre: 'Bulgaria' },
  { nombre: 'Burkina Faso' },
  { nombre: 'Burundi' },
  { nombre: 'Bután' },
  { nombre: 'Cabo Verde' },
  { nombre: 'Camboya' },
  { nombre: 'Camerún' },
  { nombre: 'Canadá' },
  { nombre: 'Catar' },
  { nombre: 'Chad' },
  { nombre: 'Chile' },
  { nombre: 'China' },
  { nombre: 'Chipre' },
  { nombre: 'Colombia' },
  { nombre: 'Comoras' },
  { nombre: 'Congo' },
  { nombre: 'Corea del Norte' },
  { nombre: 'Corea del Sur' },
  { nombre: 'Costa de Marfil' },
  { nombre: 'Costa Rica' },
  { nombre: 'Croacia' },
  { nombre: 'Cuba' },
  { nombre: 'Dinamarca' },
  { nombre: 'Dominica' },
  { nombre: 'Ecuador' },
  { nombre: 'Egipto' },
  { nombre: 'El Salvador' },
  { nombre: 'Emiratos Árabes Unidos' },
  { nombre: 'Eritrea' },
  { nombre: 'Eslovaquia' },
  { nombre: 'Eslovenia' },
  { nombre: 'España' },
  { nombre: 'Estados Unidos' },
  { nombre: 'Estonia' },
  { nombre: 'Etiopía' },
  { nombre: 'Filipinas' },
  { nombre: 'Finlandia' },
  { nombre: 'Fiyi' },
  { nombre: 'Francia' },
  { nombre: 'Gabón' },
  { nombre: 'Gambia' },
  { nombre: 'Georgia' },
  { nombre: 'Ghana' },
  { nombre: 'Granada' },
  { nombre: 'Grecia' },
  { nombre: 'Guatemala' },
  { nombre: 'Guinea' },
  { nombre: 'Guinea Ecuatorial' },
  { nombre: 'Guinea-Bisáu' },
  { nombre: 'Guyana' },
  { nombre: 'Haití' },
  { nombre: 'Honduras' },
  { nombre: 'Hungría' },
  { nombre: 'India' },
  { nombre: 'Indonesia' },
  { nombre: 'Irak' },
  { nombre: 'Irán' },
  { nombre: 'Irlanda' },
  { nombre: 'Islandia' },
  { nombre: 'Islas Marshall' },
  { nombre: 'Islas Salomón' },
  { nombre: 'Israel' },
  { nombre: 'Italia' },
  { nombre: 'Jamaica' },
  { nombre: 'Japón' },
  { nombre: 'Jordania' },
  { nombre: 'Kazajistán' },
  { nombre: 'Kenia' },
  { nombre: 'Kirguistán' },
  { nombre: 'Kiribati' },
  { nombre: 'Kuwait' },
  { nombre: 'Laos' },
  { nombre: 'Lesoto' },
  { nombre: 'Letonia' },
  { nombre: 'Líbano' },
  { nombre: 'Liberia' },
  { nombre: 'Libia' },
  { nombre: 'Liechtenstein' },
  { nombre: 'Lituania' },
  { nombre: 'Luxemburgo' },
  { nombre: 'Madagascar' },
  { nombre: 'Malasia' },
  { nombre: 'Malaui' },
  { nombre: 'Maldivas' },
  { nombre: 'Malí' },
  { nombre: 'Malta' },
  { nombre: 'Marruecos' },
  { nombre: 'Mauricio' },
  { nombre: 'Mauritania' },
  { nombre: 'México' },
  { nombre: 'Micronesia' },
  { nombre: 'Moldavia' },
  { nombre: 'Mónaco' },
  { nombre: 'Mongolia' },
  { nombre: 'Montenegro' },
  { nombre: 'Mozambique' },
  { nombre: 'Myanmar' },
  { nombre: 'Namibia' },
  { nombre: 'Nauru' },
  { nombre: 'Nepal' },
  { nombre: 'Nicaragua' },
  { nombre: 'Níger' },
  { nombre: 'Nigeria' },
  { nombre: 'Noruega' },
  { nombre: 'Nueva Zelanda' },
  { nombre: 'Omán' },
  { nombre: 'Países Bajos' },
  { nombre: 'Pakistán' },
  { nombre: 'Palaos' },
  { nombre: 'Panamá' },
  { nombre: 'Papúa Nueva Guinea' },
  { nombre: 'Paraguay' },
  { nombre: 'Perú' },
  { nombre: 'Polonia' },
  { nombre: 'Portugal' },
  { nombre: 'Reino Unido' },
  { nombre: 'República Centroafricana' },
  { nombre: 'República Checa' },
  { nombre: 'República del Congo' },
  { nombre: 'República Democrática del Congo' },
  { nombre: 'República Dominicana' },
  { nombre: 'Ruanda' },
  { nombre: 'Rumania' },
  { nombre: 'Rusia' },
  { nombre: 'Samoa' },
  { nombre: 'San Cristóbal y Nieves' },
  { nombre: 'San Marino' },
  { nombre: 'San Vicente y las Granadinas' },
  { nombre: 'Santa Lucía' },
  { nombre: 'Santo Tomé y Príncipe' },
  { nombre: 'Senegal' },
  { nombre: 'Serbia' },
  { nombre: 'Seychelles' },
  { nombre: 'Sierra Leona' },
  { nombre: 'Singapur' },
  { nombre: 'Siria' },
  { nombre: 'Somalia' },
  { nombre: 'Sri Lanka' },
  { nombre: 'Suazilandia' },
  { nombre: 'Sudáfrica' },
  { nombre: 'Sudán' },
  { nombre: 'Sudán del Sur' },
  { nombre: 'Suecia' },
  { nombre: 'Suiza' },
  { nombre: 'Surinam' },
  { nombre: 'Tailandia' },
  { nombre: 'Tanzania' },
  { nombre: 'Tayikistán' },
  { nombre: 'Timor Oriental' },
  { nombre: 'Togo' },
  { nombre: 'Tonga' },
  { nombre: 'Trinidad y Tobago' },
  { nombre: 'Túnez' },
  { nombre: 'Turkmenistán' },
  { nombre: 'Turquía' },
  { nombre: 'Tuvalu' },
  { nombre: 'Ucrania' },
  { nombre: 'Uganda' },
  { nombre: 'Uruguay' },
  { nombre: 'Uzbekistán' },
  { nombre: 'Vanuatu' },
  { nombre: 'Vaticano' },
  { nombre: 'Venezuela' },
  { nombre: 'Vietnam' },
  { nombre: 'Yemen' },
  { nombre: 'Yibuti' },
  { nombre: 'Zambia' },
  { nombre: 'Zimbabue' }
]

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
  apellido: '',
  pais: ''
})

// Errores del formulario
const formErrors = computed(() => form.errors || {})

const submitForm = () => {
  console.log('Enviando formulario de autor:', form.data())
  
  form.post(route('authors.store'), {
    onSuccess: () => {
      console.log('Autor creado exitosamente')
      showNotification('Autor creado exitosamente', 'success')
    },
    onError: (errors) => {
      console.error('Errores de validación:', errors)
      showNotification('Error al crear el autor. Revisa los datos.', 'error')
    }
  })
}
</script>
