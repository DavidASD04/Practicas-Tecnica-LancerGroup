import { defineStore } from "pinia"
import { reactive } from "vue"

export const useNotificationStore = defineStore("notification", () => {
  const snackbar = reactive({
    show: false,
    text: "",
    color: "success",
    timeout: 4000,
  })

  const showSuccess = (message) => {
    snackbar.text = message
    snackbar.color = "success"
    snackbar.show = true
  }

  const showError = (message) => {
    snackbar.text = message
    snackbar.color = "error"
    snackbar.show = true
  }

  const showInfo = (message) => {
    snackbar.text = message
    snackbar.color = "info"
    snackbar.show = true
  }

  return {
    snackbar,
    showSuccess,
    showError,
    showInfo,
  }
})
