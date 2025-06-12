<template>
  <div style="padding: 20px; background: lightblue;">
    <h1>✅ Vue básico funciona!</h1>
    <p>Esta página no usa Vuetify</p>
    <p>Contador: {{ count }}</p>
    <button @click="count++" style="padding: 10px; margin: 10px;">Incrementar</button>
  </div>
</template>

<script setup>
import { ref } from 'vue'

console.log('📄 BasicTest.vue cargando...');

const count = ref(0)

console.log('✅ BasicTest.vue cargado correctamente');
</script>
