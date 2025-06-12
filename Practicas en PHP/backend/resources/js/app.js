import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi'

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    },
  },
  theme: {
    defaultTheme: 'light',
    themes: {
      light: {
        colors: {
          primary: '#1976D2',
          secondary: '#424242',
          accent: '#82B1FF',
          error: '#FF5252',
          info: '#2196F3',
          success: '#4CAF50',
          warning: '#FFC107',
        },
      },
    },
  },
})

const appName = import.meta.env.VITE_APP_NAME || 'Sistema de Biblioteca'

console.log('🚀 Iniciando aplicación Vue + Inertia.js...');

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => {
    console.log('📄 Resolviendo página:', name);
    return resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
  },
  setup({ el, App, props, plugin }) {
    console.log('⚙️ Configurando aplicación Vue...');
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(vuetify)
      .mount(el)
  },
  progress: {
    color: '#1976D2',
    showSpinner: true,
  },
})
