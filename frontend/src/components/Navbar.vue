<template>
  <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <router-link to="/" class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-br from-primary-600 to-secondary-600 rounded-lg flex items-center justify-center">
              <DocumentMagnifyingGlassIcon class="w-5 h-5 text-white" />
            </div>
            <span class="text-xl font-bold text-gray-900">ScannerSystem</span>
          </router-link>
        </div>
        
        <div class="hidden md:flex items-center space-x-8">
          <router-link 
            to="/" 
            class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
            :class="{ 'text-primary-600 bg-primary-50': $route.name === 'home' }"
          >
            Accueil
          </router-link>
          <router-link 
            to="/pdf-converter" 
            class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
            :class="{ 'text-primary-600 bg-primary-50': $route.name === 'pdf' }"
          >
            PDF
          </router-link>
          <router-link 
            to="/table-extractor" 
            class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
            :class="{ 'text-primary-600 bg-primary-50': $route.name === 'excel' }"
          >
            Excel
          </router-link>
          <router-link 
            to="/absence-generator" 
            class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
            :class="{ 'text-primary-600 bg-primary-50': $route.name === 'absence' }"
          >
            Absences
          </router-link>
          <router-link 
            to="/group-generator" 
            class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
            :class="{ 'text-primary-600 bg-primary-50': $route.name === 'group' }"
          >
            Groupes
          </router-link>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center">
          <button 
            @click="toggleMobileMenu"
            class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900 p-2"
          >
            <Bars3Icon v-if="!isMobileMenuOpen" class="w-6 h-6" />
            <XMarkIcon v-else class="w-6 h-6" />
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div v-if="isMobileMenuOpen" class="md:hidden border-t border-gray-200 bg-white">
      <div class="px-2 pt-2 pb-3 space-y-1">
        <router-link 
          to="/" 
          @click="closeMobileMenu"
          class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50"
          :class="{ 'text-primary-600 bg-primary-50': $route.name === 'home' }"
        >
          Accueil
        </router-link>
        <router-link 
          to="/pdf-converter" 
          @click="closeMobileMenu"
          class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50"
          :class="{ 'text-primary-600 bg-primary-50': $route.name === 'pdf' }"
        >
          Convertisseur PDF
        </router-link>
        <router-link 
          to="/table-extractor" 
          @click="closeMobileMenu"
          class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50"
          :class="{ 'text-primary-600 bg-primary-50': $route.name === 'excel' }"
        >
          Extraction Excel
        </router-link>
        <router-link 
          to="/absence-generator" 
          @click="closeMobileMenu"
          class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50"
          :class="{ 'text-primary-600 bg-primary-50': $route.name === 'absence' }"
        >
          Listes d'absences
        </router-link>
        <router-link 
          to="/group-generator" 
          @click="closeMobileMenu"
          class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50"
          :class="{ 'text-primary-600 bg-primary-50': $route.name === 'group' }"
        >
          Générateur de groupes
        </router-link>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { DocumentMagnifyingGlassIcon, Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

const isMobileMenuOpen = ref(false)

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}
</script>