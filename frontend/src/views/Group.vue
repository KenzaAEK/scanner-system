<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
            <UserGroupIcon class="w-6 h-6 text-white" />
          </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Générateur de binômes et trinômes</h1>
        <p class="text-lg text-gray-600">
          Formez automatiquement des groupes équilibrés grâce à nos algorithmes intelligents
        </p>
      </div>

      <!-- Main Content -->
      <GroupGenerator />

      <!-- Algorithm Explanation -->
      <div class="mt-12 bg-white rounded-xl shadow-soft border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">🧠 Algorithmes de formation</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="border border-gray-200 rounded-lg p-4">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
              <span class="text-lg">🎲</span>
            </div>
            <h4 class="font-medium text-gray-900 mb-2">Aléatoire</h4>
            <p class="text-sm text-gray-600">
              Formation complètement aléatoire des groupes. Idéal pour créer de nouvelles interactions et casser les habitudes.
            </p>
          </div>
          
          <div class="border border-gray-200 rounded-lg p-4">
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center mb-3">
              <span class="text-lg">⚖️</span>
            </div>
            <h4 class="font-medium text-gray-900 mb-2">Équilibré par niveau</h4>
            <p class="text-sm text-gray-600">
              Mélange les niveaux pour créer des groupes hétérogènes favorisant l'entraide et la collaboration.
            </p>
          </div>
          
          <div class="border border-gray-200 rounded-lg p-4">
            <div class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center mb-3">
              <span class="text-lg">🤝</span>
            </div>
            <h4 class="font-medium text-gray-900 mb-2">Mixte hétérogène</h4>
            <p class="text-sm text-gray-600">
              Prend en compte le genre pour créer des groupes mixtes et favoriser la diversité des points de vue.
            </p>
          </div>
        </div>
      </div>

      <!-- Benefits Section -->
      <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
          <h3 class="text-lg font-semibold text-green-900 mb-4">✅ Avantages pédagogiques</h3>
          <ul class="space-y-2 text-sm text-green-800">
            <li class="flex items-start">
              <span class="text-green-600 mr-2">•</span>
              <span>Favorise l'entraide entre élèves de niveaux différents</span>
            </li>
            <li class="flex items-start">
              <span class="text-green-600 mr-2">•</span>
              <span>Développe les compétences sociales et collaboratives</span>
            </li>
            <li class="flex items-start">
              <span class="text-green-600 mr-2">•</span>
              <span>Évite la formation de cliques habituelles</span>
            </li>
            <li class="flex items-start">
              <span class="text-green-600 mr-2">•</span>
              <span>Optimise l'apprentissage par les pairs</span>
            </li>
          </ul>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
          <h3 class="text-lg font-semibold text-blue-900 mb-4">⚙️ Fonctionnalités avancées</h3>
          <ul class="space-y-2 text-sm text-blue-800">
            <li class="flex items-start">
              <span class="text-blue-600 mr-2">•</span>
              <span>Évite automatiquement les regroupements précédents</span>
            </li>
            <li class="flex items-start">
              <span class="text-blue-600 mr-2">•</span>
              <span>Gestion intelligente des élèves restants</span>
            </li>
            <li class="flex items-start">
              <span class="text-blue-600 mr-2">•</span>
              <span>Export des groupes en différents formats</span>
            </li>
            <li class="flex items-start">
              <span class="text-blue-600 mr-2">•</span>
              <span>Historique des formations précédentes</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { UserGroupIcon } from '@heroicons/vue/24/outline'
import GroupGenerator from '../components/GroupGenerator.vue'
</script>