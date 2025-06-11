<template>
  <AppLayout title="Editar Libro">
    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-semibold text-gray-800">✏️ Editar Libro</h2>
              <Link
                :href="route('books.index')"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors"
              >
                ← Volver
              </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
              <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">
                  Nombre del Libro *
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
                <label for="fecha_publicacion" class="block text-sm font-medium text-gray-700">
                  Fecha de Publicación *
                </label>
                <input
                  id="fecha_publicacion"
                  v-model="form.fecha_publicacion"
                  type="date"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  :class="{ 'border-red-500': form.errors.fecha_publicacion }"
                  required
                />
                <div v-if="form.errors.fecha_publicacion" class="mt-2 text-sm text-red-600">
                  {{ form.errors.fecha_publicacion }}
                </div>
              </div>

              <div>
                <label for="edicion" class="block text-sm font-medium text-gray-700">
                  Edición *
                </label>
                <input
                  id="edicion"
                  v-model="form.edicion"
                  type="text"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  :class="{ 'border-red-500': form.errors.edicion }"
                  required
                />
                <div v-if="form.errors.edicion" class="mt-2 text-sm text-red-600">
                  {{ form.errors.edicion }}
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Autores * (Selecciona al menos uno)
                </label>
                <div class="space-y-2 max-h-48 overflow-y-auto border rounded-md p-3">
                  <label
                    v-for="author in authors"
                    :key="author.id"
                    class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-2 rounded"
                  >
                    <input
                      v-model="form.authors"
                      :value="author.id"
                      type="checkbox"
                      class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <span class="text-sm">{{ author.nombre }} {{ author.apellido }}</span>
                  </label>
                </div>
                <div v-if="form.errors.authors" class="mt-2 text-sm text-red-600">
                  {{ form.errors.authors }}
                </div>
              </div>

              <div class="flex justify-end space-x-3">
                <Link
                  :href="route('books.index')"
                  class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors"
                >
                  Cancelar
                </Link>
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50"
                >
                  💾 Actualizar Libro
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
import { ref, onMounted } from 'vue';

const props = defineProps({
  book: Object,
  authors: Array
})

const form = useForm({
  nombre: props.book.nombre,
  fecha_publicacion: props.book.fecha_publicacion,
  edicion: props.book.edicion,
  authors: props.book.authors.map(author => author.id)
})

const submit = () => {
  form.put(route('books.update', props.book.id))
}
</script>
