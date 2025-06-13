<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
            <DocumentIcon class="w-6 h-6 text-white" />
          </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Convertisseur d'images vers PDF</h1>
        <p class="text-lg text-gray-600">
          Transformez vos images en documents PDF de qualité professionnelle
        </p>
      </div>

      <!-- Main Content -->
      <PdfConverter />

      <!-- Help Section -->
      <div class="mt-12 bg-white rounded-xl shadow-soft border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">💡 Conseils d'utilisation</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-600">
          <div>
            <h4 class="font-medium text-gray-900 mb-2">Formats supportés</h4>
            <ul class="space-y-1 list-disc list-inside">
              <li>JPEG, JPG (recommandé)</li>
              <li>PNG avec transparence</li>
              <li>WEBP moderne</li>
              <li>TIFF haute qualité</li>
            </ul>
          </div>
          <div>
            <h4 class="font-medium text-gray-900 mb-2">Bonnes pratiques</h4>
            <ul class="space-y-1 list-disc list-inside">
              <li>Images nettes et bien éclairées</li>
              <li>Résolution d'au moins 300 DPI</li>
              <li>Éviter les images floues</li>
              <li>Taille max : 10 MB par image</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { DocumentIcon } from '@heroicons/vue/24/outline'
import PdfConverter from '../components/PdfConverter.vue'
</script>