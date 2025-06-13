<template>
  <div class="card">
    <div class="card-body">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Extraction de tableaux vers Excel</h3>
      
      <div class="space-y-6">
        <!-- Upload Section -->
        <div 
          @drop="handleDrop"
          @dragover.prevent
          @dragenter.prevent
          class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-secondary-400 transition-colors"
          :class="{ 'border-secondary-400 bg-secondary-50': isDragOver }"
          @dragenter="isDragOver = true"
          @dragleave="isDragOver = false"
        >
          <TableCellsIcon class="w-12 h-12 text-gray-400 mx-auto mb-4" />
          <p class="text-gray-600 mb-2">Déposez vos images contenant des tableaux</p>
          <input 
            ref="fileInput" 
            type="file" 
            multiple 
            accept="image/*,.pdf" 
            @change="handleFileSelect" 
            class="hidden"
          >
          <button 
            @click="$refs.fileInput.click()" 
            class="bg-secondary-600 hover:bg-secondary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors"
          >
            Sélectionner des fichiers
          </button>
        </div>

        <!-- File List -->
        <div v-if="selectedFiles.length > 0">
          <h4 class="font-medium text-gray-900 mb-3">Documents à traiter</h4>
          <div class="space-y-2">
            <div 
              v-for="(file, index) in selectedFiles" 
              :key="index"
              class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"
            >
              <div class="flex items-center space-x-3">
                <DocumentIcon class="w-5 h-5 text-gray-400" />
                <span class="text-sm text-gray-700">{{ file.name }}</span>
              </div>
              <button 
                @click="removeFile(index)"
                class="text-red-500 hover:text-red-700 p-1"
              >
                <XMarkIcon class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>

        <!-- OCR Options -->
        <div v-if="selectedFiles.length > 0" class="bg-gray-50 p-4 rounded-lg">
          <h4 class="font-medium text-gray-900 mb-3">Options d'extraction</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="flex items-center space-x-2">
              <input 
                v-model="preserveFormatting" 
                type="checkbox" 
                class="rounded border-gray-300 text-secondary-600 focus:ring-secondary-500"
              >
              <span class="text-sm text-gray-700">Préserver le formatage</span>
            </label>
            
            <label class="flex items-center space-x-2">
              <input 
                v-model="detectHeaders" 
                type="checkbox" 
                class="rounded border-gray-300 text-secondary-600 focus:ring-secondary-500"
              >
              <span class="text-sm text-gray-700">Détecter les en-têtes</span>
            </label>
            
            <label class="flex items-center space-x-2">
              <input 
                v-model="mergeMultipleTables" 
                type="checkbox" 
                class="rounded border-gray-300 text-secondary-600 focus:ring-secondary-500"
              >
              <span class="text-sm text-gray-700">Fusionner les tableaux</span>
            </label>
            
            <div class="flex items-center space-x-2">
              <label class="text-sm text-gray-700">Langue:</label>
              <select 
                v-model="ocrLanguage" 
                class="border border-gray-300 rounded px-2 py-1 text-sm"
              >
                <option value="fr">Français</option>
                <option value="en">Anglais</option>
                <option value="es">Espagnol</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Process Button -->
        <div v-if="selectedFiles.length > 0" class="flex justify-end">
          <button 
            @click="extractTables" 
            :disabled="isProcessing"
            class="bg-secondary-600 hover:bg-secondary-700 text-white font-medium py-2 px-6 rounded-lg transition-colors flex items-center"
          >
            <ArrowPathIcon v-if="isProcessing" class="w-4 h-4 animate-spin mr-2" />
            {{ isProcessing ? 'Extraction en cours...' : 'Extraire les tableaux' }}
          </button>
        </div>

        <!-- Results Preview -->
        <div v-if="extractedData.length > 0" class="mt-6">
          <h4 class="font-medium text-gray-900 mb-3">Aperçu des données extraites</h4>
          <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th v-for="(header, index) in extractedData[0]" :key="index" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      {{ header }}
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(row, index) in extractedData.slice(1, 6)" :key="index">
                    <td v-for="(cell, cellIndex) in row" :key="cellIndex" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ cell }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="bg-gray-50 px-6 py-3 text-sm text-gray-500">
              Affichage des 5 premières lignes sur {{ extractedData.length - 1 }} lignes de données
            </div>
          </div>
          
          <div class="mt-4 flex justify-end">
            <button 
              @click="downloadExcel"
              class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center"
            >
              <ArrowDownTrayIcon class="w-4 h-4 mr-2" />
              Télécharger Excel
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { TableCellsIcon, DocumentIcon, XMarkIcon, ArrowPathIcon, ArrowDownTrayIcon } from '@heroicons/vue/24/outline'

const selectedFiles = ref<File[]>([])
const isDragOver = ref(false)
const isProcessing = ref(false)
const preserveFormatting = ref(true)
const detectHeaders = ref(true)
const mergeMultipleTables = ref(false)
const ocrLanguage = ref('fr')
const extractedData = ref<string[][]>([])
const fileInput = ref<HTMLInputElement>()

const handleDrop = (e: DragEvent) => {
  isDragOver.value = false
  const files = Array.from(e.dataTransfer?.files || [])
  addFiles(files)
}

const handleFileSelect = (e: Event) => {
  const files = Array.from((e.target as HTMLInputElement).files || [])
  addFiles(files)
}

const addFiles = (files: File[]) => {
  const validFiles = files.filter(file => 
    file.type.startsWith('image/') || file.type === 'application/pdf'
  )
  selectedFiles.value.push(...validFiles)
}

const removeFile = (index: number) => {
  selectedFiles.value.splice(index, 1)
}

const extractTables = async () => {
  isProcessing.value = true
  
  // Simulation de l'extraction OCR
  setTimeout(() => {
    // Données simulées pour la démonstration
    extractedData.value = [
      ['Nom', 'Prénom', 'Classe', 'Note', 'Observations'],
      ['Dupont', 'Marie', '5A', '16', 'Très bien'],
      ['Martin', 'Pierre', '5A', '14', 'Bien'],
      ['Dubois', 'Sophie', '5B', '18', 'Excellent'],
      ['Leroy', 'Thomas', '5B', '12', 'Assez bien'],
      ['Bernard', 'Julie', '5A', '15', 'Bien'],
    ]
    isProcessing.value = false
  }, 3000)
}

const downloadExcel = () => {
  // Ici, on générerait et téléchargerait le fichier Excel
  console.log('Téléchargement du fichier Excel', extractedData.value)
}
</script>