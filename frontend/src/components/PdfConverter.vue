<template>
  <div class="card">
    <div class="card-body">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Convertisseur d'images vers PDF</h3>
      
      <div 
        @drop="handleDrop"
        @dragover.prevent
        @dragenter.prevent
        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-primary-400 transition-colors"
        :class="{ 'border-primary-400 bg-primary-50': isDragOver }"
        @dragenter="isDragOver = true"
        @dragleave="isDragOver = false"
      >
        <CloudArrowUpIcon class="w-12 h-12 text-gray-400 mx-auto mb-4" />
        <p class="text-gray-600 mb-2">Glissez vos images ici ou</p>
        <input 
          ref="fileInput" 
          type="file" 
          multiple 
          accept="image/*" 
          @change="handleFileSelect" 
          class="hidden"
        >
        <button 
          @click="$refs.fileInput.click()" 
          class="btn-primary"
        >
          Sélectionner des fichiers
        </button>
      </div>

      <div v-if="selectedFiles.length > 0" class="mt-6">
        <h4 class="font-medium text-gray-900 mb-3">Fichiers sélectionnés ({{ selectedFiles.length }})</h4>
        <div class="space-y-2 max-h-40 overflow-y-auto">
          <div 
            v-for="(file, index) in selectedFiles" 
            :key="index"
            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg"
          >
            <div class="flex items-center space-x-3">
              <PhotoIcon class="w-5 h-5 text-gray-400" />
              <span class="text-sm text-gray-700">{{ file.name }}</span>
              <span class="text-xs text-gray-500">({{ formatFileSize(file.size) }})</span>
            </div>
            <button 
              @click="removeFile(index)"
              class="text-red-500 hover:text-red-700 p-1"
            >
              <XMarkIcon class="w-4 h-4" />
            </button>
          </div>
        </div>

        <div class="flex justify-between items-center mt-6">
          <div class="flex items-center space-x-4">
            <label class="flex items-center space-x-2">
              <input 
                v-model="includeMetadata" 
                type="checkbox" 
                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
              >
              <span class="text-sm text-gray-700">Inclure les métadonnées</span>
            </label>
          </div>
          <button 
            @click="convertToPdf" 
            :disabled="isConverting"
            class="btn-primary"
          >
            <ArrowPathIcon v-if="isConverting" class="w-4 h-4 animate-spin mr-2" />
            {{ isConverting ? 'Conversion...' : 'Convertir en PDF' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { CloudArrowUpIcon, PhotoIcon, XMarkIcon, ArrowPathIcon } from '@heroicons/vue/24/outline'
const scanId = ref<number | null>(null)
const pdfStatus = ref<'pending' | 'ready' | 'failed' | null>(null)
const pollInterval = ref<number | null>(null)

const selectedFiles = ref<File[]>([])
const isDragOver = ref(false)
const includeMetadata = ref(false)
const isConverting = ref(false)
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
  const imageFiles = files.filter(file => file.type.startsWith('image/'))
  selectedFiles.value.push(...imageFiles)
}

const removeFile = (index: number) => {
  selectedFiles.value.splice(index, 1)
}

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}
const convertToPdf = async () => {
  if (selectedFiles.value.length === 0) return
  isConverting.value = true

  try {
    const formData = new FormData()
    formData.append('image', selectedFiles.value[0]) // tu peux gérer plusieurs plus tard
    formData.append('quality', 'Rapide')
    formData.append('add_background', 'false')

    const response = await fetch('http://127.0.0.1:8000/api/pdf-scan', {
      method: 'POST',
      body: formData
    })

    if (!response.ok) throw new Error('Erreur de scan OCR')

    const data = await response.json()
    scanId.value = data.scan_id
    pdfStatus.value = 'pending'

    pollPdfStatus()
  } catch (err) {
    console.error(err)
    isConverting.value = false
  }
}

const pollPdfStatus = () => {
  if (!scanId.value) return

  pollInterval.value = window.setInterval(async () => {
    const res = await fetch(`http://127.0.0.1:8000/api/pdf-scan/${scanId.value}`)
    const data = await res.json()

    if (data.status === 'ready') {
      pdfStatus.value = 'ready'
      clearInterval(pollInterval.value!)
      isConverting.value = false
      downloadPdf(scanId.value!)
    } else if (data.status === 'failed') {
      pdfStatus.value = 'failed'
      clearInterval(pollInterval.value!)
      isConverting.value = false
      alert('La conversion a échoué.')
    }
  }, 2000)
}
const downloadPdf = (id: number) => {
  const url = `http://127.0.0.1:8000/api/pdf-scan/${id}/download`
  const a = document.createElement('a')
  a.href = url
  a.download = `converted.pdf`
  a.click()
}

</script>