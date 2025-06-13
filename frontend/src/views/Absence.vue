<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl flex items-center justify-center">
            <ClipboardDocumentListIcon class="w-6 h-6 text-white" />
          </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Générateur de listes d'absences</h1>
        <p class="text-lg text-gray-600">
          Créez des listes d'absences personnalisées pour vos classes en quelques clics
        </p>
      </div>

      <!-- Main Content -->
      <AbsenceListGenerator />

      <!-- Templates Preview -->
      <div class="mt-12 bg-white rounded-xl shadow-soft border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">🎨 Modèles disponibles</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="font-medium text-gray-900 mb-2">Modèle standard</h4>
            <div class="text-xs text-gray-600 bg-gray-50 p-3 rounded font-mono">
              <div class="mb-2 font-semibold">Classe: 5ème A - Mathématiques</div>
              <div class="border-b border-gray-300 pb-1 mb-2">
                <span class="inline-block w-20">Nom</span>
                <span class="inline-block w-16">Prénom</span>
                <span class="inline-block w-12">L1</span>
                <span class="inline-block w-12">M1</span>
                <span class="inline-block w-12">M2</span>
              </div>
              <div>Dupont &nbsp;&nbsp;&nbsp; Marie &nbsp;&nbsp;&nbsp;&nbsp; ☐ &nbsp;&nbsp; ☐ &nbsp;&nbsp; ☐</div>
              <div>Martin &nbsp;&nbsp;&nbsp; Pierre &nbsp;&nbsp;&nbsp; ☐ &nbsp;&nbsp; ☐ &nbsp;&nbsp; ☐</div>
            </div>
          </div>
          
          <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="font-medium text-gray-900 mb-2">Modèle avec photos</h4>
            <div class="text-xs text-gray-600 bg-gray-50 p-3 rounded font-mono">
              <div class="mb-2 font-semibold">Classe: 5ème A - Mathématiques</div>
              <div class="border-b border-gray-300 pb-1 mb-2">
                <span class="inline-block w-12">Photo</span>
                <span class="inline-block w-20">Nom</span>
                <span class="inline-block w-12">Abs.</span>
              </div>
              <div class="flex items-center">
                <div class="w-8 h-8 bg-gray-300 rounded mr-2 text-xs flex items-center justify-center">📷</div>
                <span>Dupont Marie &nbsp;&nbsp; ☐</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Tips -->
      <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4">💡 Conseils pratiques</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
          <div>
            <h4 class="font-medium mb-2">Optimisation</h4>
            <ul class="space-y-1 list-disc list-inside">
              <li>Imprimez en format A4 pour une lisibilité optimale</li>
              <li>Utilisez les colonnes de dates pour un suivi hebdomadaire</li>
              <li>Activez les observations pour noter les retards</li>
            </ul>
          </div>
          <div>
            <h4 class="font-medium mb-2">Personnalisation</h4>
            <ul class="space-y-1 list-disc list-inside">
              <li>Adaptez le nombre de séances selon vos besoins</li>
              <li>Ajoutez votre nom pour identifier vos listes</li>
              <li>Sauvegardez vos classes pour les réutiliser</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ClipboardDocumentListIcon } from '@heroicons/vue/24/outline'
import AbsenceListGenerator from '../components/AbsenceListGenerator.vue'
</script>