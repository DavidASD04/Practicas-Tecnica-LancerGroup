<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-16">
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">
           Sistema de Biblioteca
        </h1>
        <p class="text-xl text-gray-600 mb-8">
          Administra autores y libros de manera eficiente
        </p>
      </div>

      <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition-shadow">
          <div class="text-center">
            <div class="text-6xl mb-4"> </div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Autores</h2>
            <p class="text-gray-600 mb-6">
              Gestiona la información de los autores de tu biblioteca
            </p>
            <Link
              :href="route('authors.index')"
              class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors"
            >
              Ver Autores
            </Link>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition-shadow">
          <div class="text-center">
            <div class="text-6xl mb-4">📕</div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Libros</h2>
            <p class="text-gray-600 mb-6">
              Administra el catálogo de libros disponibles
            </p>
            <Link
              :href="route('books.index')"
              class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors"
            >
              Ver Libros
            </Link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
