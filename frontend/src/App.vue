<template>
  <div id="app">
    <Navbar />
    <main>
      <router-view />
    </main>
    
    <!-- Notifications -->
    <div class="fixed top-4 right-4 z-50 space-y-2">
      <div 
        v-for="notification in notifications" 
        :key="notification.id"
        class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg p-4 transition-all duration-300 transform translate-x-0"
        :class="{
          'border-green-200 bg-green-50': notification.type === 'success',
          'border-red-200 bg-red-50': notification.type === 'error',
          'border-blue-200 bg-blue-50': notification.type === 'info'
        }"
      >
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <CheckCircleIcon 
              v-if="notification.type === 'success'" 
              class="w-5 h-5 text-green-600 mr-2" 
            />
            <ExclamationTriangleIcon 
              v-if="notification.type === 'error'" 
              class="w-5 h-5 text-red-600 mr-2" 
            />
            <InformationCircleIcon 
              v-if="notification.type === 'info'" 
              class="w-5 h-5 text-blue-600 mr-2" 
            />
            <span 
              class="text-sm font-medium"
              :class="{
                'text-green-800': notification.type === 'success',
                'text-red-800': notification.type === 'error',
                'text-blue-800': notification.type === 'info'
              }"
            >
              {{ notification.message }}
            </span>
          </div>
          <button 
            @click="removeNotification(notification.id)"
            class="ml-2 text-gray-400 hover:text-gray-600"
          >
            <XMarkIcon class="w-4 h-4" />
          </button>
        </div>
      </div>
    </div>

    <!-- Loading Overlay -->
    <div 
      v-if="isLoading" 
      class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center"
    >
      <div class="bg-white rounded-lg p-6 shadow-xl">
        <div class="flex items-center space-x-3">
          <ArrowPathIcon class="w-6 h-6 text-primary-600 animate-spin" />
          <span class="text-gray-900 font-medium">Traitement en cours...</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia'
import { useMainStore } from './stores/main'
import Navbar from './components/Navbar.vue'
import { 
  CheckCircleIcon, 
  ExclamationTriangleIcon, 
  InformationCircleIcon, 
  XMarkIcon,
  ArrowPathIcon
} from '@heroicons/vue/24/outline'

const mainStore = useMainStore()
const { isLoading, notifications } = storeToRefs(mainStore)
const { removeNotification } = mainStore
</script>