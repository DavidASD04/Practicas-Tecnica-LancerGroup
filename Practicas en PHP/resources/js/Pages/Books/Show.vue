<template>
  <AppLayout title="Detalles del Libro">
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-semibold text-gray-800">
                📖 {{ book.nombre }}
              </h2>
              <div class="space-x-2">
                <Link
                  :href="route('books.edit', book.id)"
                  class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors"
                >
                  ✏️ Editar
                </Link>
                <Link
                  :href="route('books.index')"
                  class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors"
                >
                  ← Volver
                </Link>
              </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg mb-8">
              <h3 class="font-semibold text-gray-700 mb-4">Información del Libro</h3>
              <div class="grid md:grid-cols-2 gap-4">
                <div>
                  <p><strong>Nombre:</strong> {{ book.nombre }}</p>
                  <p><strong>Edición:</strong> {{ book.edicion }}</p>
                </div>
                <div>
                  <p><strong>Fecha de publicación:</strong> {{ formatDate(book.fecha_publicacion) }}</p>
                </div>
              </div>
            </div>

            <div v-if="book.authors.length > 0">
              <h3 class="text-xl font-semibold text-gray-800 mb-4">  Autores</h3>
              <div class="grid gap-4">
                <div
                  v-for="author in book.authors"
                  :key="author.id"
                  class="bg-gray-50 p-4 rounded-lg border-l-4 border-green-500 flex justify-between items-center"
                >
                  <div>
                    <h4 class="font-semibold text-gray-800">
                      {{ author.nombre }} {{ author.apellido }}
                      <span v-if="author.deleted_at" class="text-red-500 text-sm">(Eliminado)</span>
                    </h4>
                    <p class="text-gray-600">{{ author.pais }}</p>
                  </div>
                  <Link
                    v-if="!author.deleted_at"
                    :href="route('authors.show', author.id)"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    Ver Autor →
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  book: Object
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES')
}
</script>
