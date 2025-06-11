<template>
  <AppLayout title="Detalles del Autor">
    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-2xl font-semibold text-gray-800">
                👤 {{ author.nombre_completo }}
              </h2>
              <div class="space-x-2">
                <Link
                  :href="route('authors.edit', author.id)"
                  class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors"
                >
                  ✏️ Editar
                </Link>
                <Link
                  :href="route('authors.index')"
                  class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors"
                >
                  ← Volver
                </Link>
              </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mb-8">
              <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-700 mb-2">Información Personal</h3>
                <div class="space-y-2">
                  <p><strong>Nombre:</strong> {{ author.nombre }}</p>
                  <p><strong>Apellido:</strong> {{ author.apellido }}</p>
                  <p><strong>País:</strong> {{ author.pais }}</p>
                </div>
              </div>

              <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-700 mb-2">Estadísticas</h3>
                <div class="space-y-2">
                  <p><strong>Fecha de registro:</strong> {{ formatDate(author.fecha_registro) }}</p>
                  <p><strong>Cantidad de libros:</strong> {{ author.cantidad_libros }}</p>
                </div>
              </div>
            </div>

            <div v-if="author.books.length > 0">
              <h3 class="text-xl font-semibold text-gray-800 mb-4">📚 Libros del Autor</h3>
              <div class="grid gap-4">
                <div
                  v-for="book in author.books"
                  :key="book.id"
                  class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500"
                >
                  <h4 class="font-semibold text-gray-800">{{ book.nombre }}</h4>
                  <p class="text-gray-600">Edición: {{ book.edicion }}</p>
                  <p class="text-gray-600">Publicado: {{ formatDate(book.fecha_publicacion) }}</p>
                </div>
              </div>
            </div>
            <div v-else class="text-center py-8">
              <p class="text-gray-500">Este autor aún no tiene libros registrados.</p>
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
  author: Object
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('es-ES')
}
</script>
