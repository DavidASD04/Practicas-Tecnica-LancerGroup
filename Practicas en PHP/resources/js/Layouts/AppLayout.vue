<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <Link :href="route('welcome')" class="flex items-center space-x-2">
              <span class="text-2xl"></span>
              <span class="font-bold text-xl text-gray-800">Biblioteca</span>
            </Link>
          </div>
          
          <div class="flex items-center space-x-4">
            <Link
              :href="route('authors.index')"
              class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium"
              :class="{ 'bg-gray-100 text-gray-900': $page.component.startsWith('Authors') }"
            >
                Autores
            </Link>
            <Link
              :href="route('books.index')"
              class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium"
              :class="{ 'bg-gray-100 text-gray-900': $page.component.startsWith('Books') }"
            >
               Libros
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <main>
      <slot />
    </main>

    <!-- Flash Messages -->
    <div
      v-if="$page.props.flash.success"
      class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
    >
      ✅ {{ $page.props.flash.success }}
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  title: String
})
</script>
