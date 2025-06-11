<template>
  <AppLayout title="Editar Autor">
    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-semibold text-gray-800">✏️ Editar Autor</h2>
              <Link
                :href="route('authors.index')"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors"
              >
                ← Volver
              </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
              <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">
                  Nombre *
                </label>
                <input
                  id="nombre"
                  v-model="form.nombre"
                  type="text"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  :class="{ 'border-red-500': form.errors.nombre }"
                  required
                />
                <div v-if="form.errors.nombre" class="mt-2 text-sm text-red-600">
                  {{ form.errors.nombre }}
                </div>
              </div>

              <div>
                <label for="apellido" class="block text-sm font-medium text-gray-700">
                  Apellido *
                </label>
                <input
                  id="apellido"
                  v-model="form.apellido"
                  type="text"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  :class="{ 'border-red-500': form.errors.apellido }"
                  required
                />
                <div v-if="form.errors.apellido" class="mt-2 text-sm text-red-600">
                  {{ form.errors.apellido }}
                </div>
              </div>

              <div>
                <label for="pais" class="block text-sm font-medium text-gray-700">
                  País *
                </label>
                <input
                  id="pais"
                  v-model="form.pais"
                  type="text"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  :class="{ 'border-red-500': form.errors.pais }"
                  required
                />
                <div v-if="form.errors.pais" class="mt-2 text-sm text-red-600">
                  {{ form.errors.pais }}
                </div>
              </div>

              <div class="flex justify-end space-x-3">
                <Link
                  :href="route('authors.index')"
                  class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors"
                >
                  Cancelar
                </Link>
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50"
                >
                  💾 Actualizar Autor
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
  author: Object
})

const form = useForm({
  nombre: props.author.nombre,
  apellido: props.author.apellido,
  pais: props.author.pais
})

const submit = () => {
  form.put(route('authors.update', props.author.id))
}
</script>
