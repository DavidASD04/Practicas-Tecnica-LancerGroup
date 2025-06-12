<template>
  <v-dialog v-model="isOpen" :max-width="maxWidth" persistent>
    <v-card>
      <v-card-title class="d-flex align-center justify-space-between">
        <span>{{ title }}</span>
        <v-btn icon="mdi-close" variant="text" @click="closeModal"></v-btn>
      </v-card-title>
      
      <v-card-text>
        <slot></slot>
      </v-card-text>
      
      <v-card-actions v-if="showActions">
        <v-spacer></v-spacer>
        <slot name="actions">
          <v-btn color="primary" @click="closeModal">Cerrar</v-btn>
        </slot>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: 'Modal'
  },
  maxWidth: {
    type: [String, Number],
    default: '600px'
  },
  showActions: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['update:modelValue', 'close'])

const isOpen = ref(props.modelValue)

watch(() => props.modelValue, (newValue) => {
  isOpen.value = newValue
})

watch(isOpen, (newValue) => {
  emit('update:modelValue', newValue)
})

const closeModal = () => {
  isOpen.value = false
  emit('close')
}
</script>
