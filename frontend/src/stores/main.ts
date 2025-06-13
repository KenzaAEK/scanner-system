import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useMainStore = defineStore('main', () => {
  const isLoading = ref(false)
  const notifications = ref<Array<{ id: string; type: 'success' | 'error' | 'info'; message: string }>>([])

  const setLoading = (loading: boolean) => {
    isLoading.value = loading
  }

  const addNotification = (type: 'success' | 'error' | 'info', message: string) => {
    const id = Date.now().toString()
    notifications.value.push({ id, type, message })
    
    setTimeout(() => {
      removeNotification(id)
    }, 5000)
  }

  const removeNotification = (id: string) => {
    const index = notifications.value.findIndex(n => n.id === id)
    if (index > -1) {
      notifications.value.splice(index, 1)
    }
  }

  return {
    isLoading,
    notifications,
    setLoading,
    addNotification,
    removeNotification
  }
})