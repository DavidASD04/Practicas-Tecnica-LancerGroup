<template>
  <Layout>
    <div>
      <v-row class="mb-4">
        <v-col>
          <v-card>
            <v-card-title>
              🧪 Página de Prueba de Formularios
            </v-card-title>
            <v-card-text>
              <p>Esta página está diseñada para probar que los formularios funcionen correctamente.</p>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <!-- Formulario de prueba simple -->
      <v-row>
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title>Prueba de Formulario Simple</v-card-title>
            <v-card-text>
              <form @submit.prevent="testSubmit">
                <v-text-field
                  v-model="testForm.name"
                  label="Nombre de prueba"
                  variant="outlined"
                  required
                ></v-text-field>
                
                <v-text-field
                  v-model="testForm.email"
                  label="Email de prueba"
                  variant="outlined"
                  type="email"
                ></v-text-field>

                <v-btn
                  type="submit"
                  color="primary"
                  :loading="submitting"
                  block
                >
                  Enviar Prueba
                </v-btn>
              </form>
            </v-card-text>
          </v-card>
        </v-col>

        <!-- Información de estado -->
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title>Estado de Pruebas</v-card-title>
            <v-card-text>
              <v-list>
                <v-list-item>
                  <v-list-item-title>Inertia Funcionando</v-list-item-title>
                  <v-list-item-subtitle>✅ Esta página se cargó correctamente</v-list-item-subtitle>
                </v-list-item>
                
                <v-list-item>
                  <v-list-item-title>Vuetify Funcionando</v-list-item-title>
                  <v-list-item-subtitle>✅ Los componentes se renderizan</v-list-item-subtitle>
                </v-list-item>
                
                <v-list-item>
                  <v-list-item-title>CSRF Token</v-list-item-title>
                  <v-list-item-subtitle>{{ csrfToken ? '✅ Disponible' : '❌ No disponible' }}</v-list-item-subtitle>
                </v-list-item>
                
                <v-list-item>
                  <v-list-item-title>showNotification</v-list-item-title>
                  <v-list-item-subtitle>{{ hasNotification ? '✅ Disponible' : '❌ No disponible' }}</v-list-item-subtitle>
                </v-list-item>
              </v-list>

              <v-btn
                color="info"
                @click="testNotification"
                class="mt-4"
                block
              >
                Probar Notificación
              </v-btn>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <!-- Estado de la aplicación -->
      <v-row class="mt-4">
        <v-col>
          <v-card>
            <v-card-title>Información de Debug</v-card-title>
            <v-card-text>
              <pre>{{ debugInfo }}</pre>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </Layout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'

const testForm = ref({
  name: '',
  email: ''
})

const submitting = ref(false)

const page = usePage()

const csrfToken = computed(() => {
  return page.props.value?.csrf_token || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || null
})

const hasNotification = computed(() => {
  return typeof window.showNotification === 'function'
})

const debugInfo = computed(() => {
  return {
    page_props: Object.keys(page.props.value || {}),
    csrf_token: csrfToken.value ? 'Present' : 'Missing',
    window_functions: {
      showNotification: typeof window.showNotification,
      route: typeof window.route
    },
    form_data: testForm.value,
    user_agent: navigator.userAgent
  }
})

const testSubmit = () => {
  submitting.value = true
  
  // Simular envío
  setTimeout(() => {
    submitting.value = false
    if (window.showNotification) {
      window.showNotification('Formulario de prueba enviado exitosamente', 'success')
    } else {
      alert('Formulario enviado (showNotification no disponible)')
    }
  }, 1000)
}

const testNotification = () => {
  if (window.showNotification) {
    window.showNotification('Esta es una notificación de prueba', 'info')
  } else {
    alert('showNotification no está disponible')
  }
}

onMounted(() => {
  console.log('TestForm mounted')
  console.log('CSRF Token:', csrfToken.value)
  console.log('showNotification available:', hasNotification.value)
})
</script>
