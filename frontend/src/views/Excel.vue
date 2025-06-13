<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-500 rounded-xl flex items-center justify-center">
            <TableCellsIcon class="w-6 h-6 text-white" />
          </div>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Extraction intelligente de tableaux</h1>
        <p class="text-lg text-gray-600">
          Convertissez automatiquement vos tableaux images en fichiers Excel exploitables
        </p>
      </div>

      <!-- Main Content -->
      <TableExtractor />

      <!-- Features Section -->
      <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-soft border border-gray-100 p-6">
          <div class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center mb-4">
            <EyeIcon class="w-5 h-5 text-secondary-600" />
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">OCR Intelligent</h3>
          <p class="text-sm text-gray-600">
            Reconnaissance optique de caractères avancée pour une extraction précise des données
          </p>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-100 p-6">
          <div class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center mb-4">
            <TableCellsIcon class="w-5 h-5 text-secondary-600" />
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Détection automatique</h3>
          <p class="text-sm text-gray-600">
            Identification automatique des structures de tableaux et des données organisées
          </p>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-100 p-6">
          <div class="w-10 h-10 bg-secondary-100 rounded-lg flex items-center justify-center mb-4">
            <DocumentArrowDownIcon class="w-5 h-5 text-secondary-600" />
          </div>
          <h3 class="font-semibold text-gray-900 mb-2">Export Excel</h3>
          <p class="text-sm text-gray-600">
            Génération directe de fichiers Excel avec formatage et structure préservés
          </p>
        </div>
      </div>

      <!-- Use Cases -->
      <div class="mt-12 bg-white rounded-xl shadow-soft border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">📋 Cases d'usage typiques</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm text-gray-600">
          <div>
            <h4 class="font-medium text-gray-900 mb-3">Documents pédagogiques</h4>
            <ul class="space-y-2 list-disc list-inside">
              <li>Listes de notes scannées</li>
              <li>Tableaux de résultats d'évaluations</li>
              <li>Planning de cours et horaires</li>
              <li>Listes d'élèves avec informations</li>
            </ul>
          </div>
          <div>
            <h4 class="font-medium text-gray-900 mb-3">Documents administratifs</h4>
            <ul class="space-y-2 list-disc list-inside">
              <li>Tableaux budgétaires</li>
              <li>Inventaires et catalogues</li>
              <li>Rapports avec données chiffrées</li>
              <li>Formulaires structurés</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { TableCellsIcon, EyeIcon, DocumentArrowDownIcon } from '@heroicons/vue/24/outline'
import TableExtractor from '../components/TableExtractor.vue'
</script>