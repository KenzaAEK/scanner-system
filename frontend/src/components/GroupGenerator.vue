<template>
  <div class="card">
    <div class="card-body">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Générateur des groupes</h3>

      <div class="space-y-6">
        <!-- File Import Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
          <h4 class="font-medium text-blue-900 mb-3">📁 Importer la liste des élèves</h4>
          <div class="flex items-center space-x-4">
            <input ref="fileInput" type="file" accept=".csv,.xlsx,.xls" @change="handleFileImport" class="hidden">
            <button @click="$refs.fileInput?.click()" class="btn-primary flex items-center">
              <DocumentArrowUpIcon class="w-4 h-4 mr-2" />
              Choisir un fichier (.csv, .xlsx)
            </button>
            <span v-if="importedFile" class="text-sm text-gray-600">
              {{ importedFile.name }} ({{ importedStudents.length }} élèves)
            </span>
          </div>
          <p class="text-xs text-blue-700 mt-2">
            Le fichier doit contenir les colonnes : Nom, Prénom (et optionnellement : Numéro étudiant, Classe)
          </p>
        </div>

        <!-- Students Preview -->
        <div v-if="importedStudents.length > 0" class="bg-white border border-gray-200 rounded-lg">
          <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-medium text-gray-900">Aperçu des élèves importés ({{ importedStudents.length }})</h4>
          </div>
          <div class="max-h-40 overflow-y-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prénom</th>
                  <th v-if="algorithm === 'balanced'"
                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Niveau</th>
                  <th v-if="algorithm === 'mixed'"
                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Genre</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(student, index) in importedStudents.slice(0, 5)" :key="index">
                  <td class="px-4 py-2 text-sm text-gray-900">{{ student.lastName }}</td>
                  <td class="px-4 py-2 text-sm text-gray-900">{{ student.firstName }}</td>
                  <td v-if="algorithm === 'balanced'" class="px-4 py-2 text-sm text-gray-500">
                    <select v-model="student.level" class="border border-gray-300 rounded px-2 py-1 text-xs">
                      <option value="low">Faible</option>
                      <option value="medium">Moyen</option>
                      <option value="high">Élevé</option>
                    </select>
                  </td>
                  <td v-if="algorithm === 'mixed'" class="px-4 py-2 text-sm text-gray-500">
                    <select v-model="student.gender" class="border border-gray-300 rounded px-2 py-1 text-xs">
                      <option value="">Autre</option>
                      <option value="M">M</option>
                      <option value="F">F</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-if="importedStudents.length > 5" class="px-4 py-2 bg-gray-50 text-sm text-gray-500">
            ... et {{ importedStudents.length - 5 }} autres élèves
          </div>
        </div>

        <!-- Configuration -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Type de groupes</label>

            <input v-model.number="customGroupSize" type="number" min="2" max="6"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
          </div>
        </div>

        <!-- Manual Student Input (fallback) -->
        <div v-if="importedStudents.length === 0">
          <div class="flex justify-between items-center mb-3">
            <h4 class="font-medium text-gray-900">Saisie manuelle des élèves</h4>
            <div class="flex space-x-2">

              <!-- Bouton Ajouter -->
              <button @click="addStudent"
                class="text-primary-600 hover:text-primary-700 text-sm font-medium flex items-center">
                <PlusIcon class="w-4 h-4 mr-1" />
                Ajouter
              </button>

              <!-- Bouton Effacer tout -->
              <button @click="clearAll" class="text-red-600 hover:text-red-700 text-sm font-medium">
                Effacer tout
              </button>

            </div>
          </div>


          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto">
            <div v-for="(student, index) in manualStudents" :key="index"
              class="flex items-center space-x-2 p-2 bg-gray-50 rounded-lg">
              <input v-model="student.name" placeholder="Nom de l'élève"
                class="flex-1 border border-gray-300 rounded px-2 py-1 text-sm">
              <select v-if="algorithm === 'balanced'" v-model="student.level"
                class="border border-gray-300 rounded px-2 py-1 text-sm">
                <option value="low">Faible</option>
                <option value="medium">Moyen</option>
                <option value="high">Élevé</option>
              </select>
              <select v-if="algorithm === 'mixed'" v-model="student.gender"
                class="border border-gray-300 rounded px-2 py-1 text-sm">
                <option value="">Autre</option>
                <option value="M">M</option>
                <option value="F">F</option>
              </select>
              <button @click="removeStudent(index)" class="text-red-500 hover:text-red-700 p-1">
                <XMarkIcon class="w-4 h-4" />
              </button>
            </div>
          </div>

          <div class="mt-3 flex items-center justify-between">
            <button @click="addSampleStudents" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
              Ajouter des exemples
            </button>
            <span class="text-sm text-gray-500">{{ manualStudents.length }} élève(s)</span>
          </div>
        </div>

        <!-- Advanced Options -->
        <div class="bg-gray-50 p-4 rounded-lg">
          <h4 class="font-medium text-gray-900 mb-3">Options avancées</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="flex items-center space-x-2">
              <input v-model="avoidPreviousGroups" type="checkbox"
                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
              <span class="text-sm text-gray-700">Éviter les anciens groupes</span>
            </label>

            <label class="flex items-center space-x-2">
              <input v-model="ensureCompleteness" type="checkbox"
                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
              <span class="text-sm text-gray-700">Assurer la complétude</span>
            </label>

            <div class="flex items-center space-x-2">
              <label class="text-sm text-gray-700">Nombre de formations:</label>
              <input v-model.number="generationCount" type="number" min="1" max="5"
                class="w-16 border border-gray-300 rounded px-2 py-1 text-sm">
            </div>
          </div>
        </div>

        <!-- Generate Button -->
        <div class="flex justify-center">
          <button @click="generateGroups" :disabled="!canGenerate || isGenerating"
            class="btn-primary px-8 py-3 text-lg">
            <ArrowPathIcon v-if="isGenerating" class="w-5 h-5 animate-spin mr-2" />
            <UserGroupIcon v-else class="w-5 h-5 mr-2" />
            {{ isGenerating ? 'Génération...' : 'Générer les groupes' }}
          </button>
        </div>

        <!-- Results -->
        <div  class="mt-8">
          <div class="flex justify-between items-center mb-4">
            <h4 class="font-medium text-gray-900">Groupes générés</h4>
            <div class="flex space-x-2">
              <button @click="regenerateGroups" class="btn-secondary text-sm">
                <ArrowPathIcon class="w-4 h-4 mr-1" />
                Regénérer
              </button>
              <!-- Export Excel -->
              <button  @click="exportExcel"
                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center text-sm">
                <DocumentArrowDownIcon class="w-4 h-4 mr-1" />
                Télécharger Excel
              </button>

              <!-- Export PDF -->
              <button  @click="exportPdf"
                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center text-sm">
                <DocumentIcon class="w-4 h-4 mr-1" />
                Télécharger PDF
              </button>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-for="(group, index) in generatedGroups" :key="index"
              class="bg-white border-2 border-primary-200 rounded-lg p-4 hover:border-primary-400 transition-colors">
              <h5 class="font-medium text-primary-700 mb-2">Groupe {{ index + 1 }}</h5>
              <ul class="space-y-1">
                <li v-for="student in group" :key="student" class="text-sm text-gray-700 flex items-center">
                  <UserIcon class="w-3 h-3 mr-2 text-gray-400" />
                  {{ student }}
                </li>
              </ul>
            </div>
          </div>

          <div v-if="remainingStudents.length > 0" class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <h5 class="font-medium text-yellow-800 mb-2">Élèves restants</h5>
            <p class="text-sm text-yellow-700">
              {{ remainingStudents.join(', ') }}
            </p>
            <p class="text-xs text-yellow-600 mt-1">
              Ces élèves peuvent être ajoutés aux groupes existants ou former un groupe supplémentaire.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import {
  PlusIcon,
  XMarkIcon,
  DocumentArrowUpIcon,
  DocumentArrowDownIcon,
  ArrowPathIcon,
  UserGroupIcon,
  UserIcon,
  DocumentIcon
} from '@heroicons/vue/24/outline'
import { useFileImport, type Student } from '../composables/useFileImport'
import { usePdfGenerator } from '../composables/usePdfGenerator'
import { useExcelGenerator } from '../composables/useExcelGenerator'
import { useMainStore } from '../stores/main'

interface ManualStudent {
  name: string
  level?: 'low' | 'medium' | 'high'
  gender?: 'M' | 'F' | ''
}

const mainStore = useMainStore()
const { importStudents } = useFileImport()
const { generateGroupsPdf } = usePdfGenerator()
const { generateGroupsExcel } = useExcelGenerator()

const groupType = ref('binomes')
const customGroupSize = ref(4)
const algorithm = ref('random')
const manualStudents = ref<ManualStudent[]>([
  { name: '' }
])
const importedStudents = ref<Student[]>([])
const importedFile = ref<File | null>(null)
const avoidPreviousGroups = ref(false)
const ensureCompleteness = ref(true)
const generationCount = ref(1)
const isGenerating = ref(false)
const isExporting = ref<string | null>(null)
const generatedGroups = ref<string[][]>([])
const remainingStudents = ref<string[]>([])
const fileInput = ref<HTMLInputElement>()

const canGenerate = computed(() => {
  if (importedStudents.value.length > 0) {
    return importedStudents.value.length >= 2
  }
  const validStudents = manualStudents.value.filter(s => s.name.trim() !== '')
  return validStudents.length >= 2
})

const getGroupSize = computed(() => {
  return customGroupSize.value
})

const currentStudents = computed(() => {
  if (importedStudents.value.length > 0) {
    return importedStudents.value.map(s => `${s.firstName} ${s.lastName}`.trim())
  }
  return manualStudents.value.filter(s => s.name.trim() !== '').map(s => s.name.trim())
})

const handleFileImport = async (event: Event) => {
  const file = (event.target as HTMLInputElement).files?.[0]
  if (!file) return

  try {
    mainStore.setLoading(true)
    const students = await importStudents(file)
    importedStudents.value = students
    importedFile.value = file
    mainStore.addNotification('success', `${students.length} élèves importés avec succès`)
  } catch (error) {
    console.error('Erreur lors de l\'import:', error)
    mainStore.addNotification('error', 'Erreur lors de l\'import du fichier')
  } finally {
    mainStore.setLoading(false)
  }
}

const addStudent = () => {
  manualStudents.value.push({ name: '' })
}

const removeStudent = (index: number) => {
  if (manualStudents.value.length > 1) {
    manualStudents.value.splice(index, 1)
  }
}

const clearAll = () => {
  manualStudents.value = [{ name: '' }]
  generatedGroups.value = []
  remainingStudents.value = []
}

const addSampleStudents = () => {
  const sampleNames = [
    'Alice Martin', 'Bob Dubois', 'Clara Leroy', 'David Bernard',
    'Emma Rousseau', 'Felix Moreau', 'Grace Petit', 'Hugo Laurent',
    'Iris Girard', 'Jules Roux', 'Karine Michel', 'Louis Fournier'
  ]

  manualStudents.value = sampleNames.map(name => ({
    name,
    level: ['low', 'medium', 'high'][Math.floor(Math.random() * 3)] as 'low' | 'medium' | 'high',
    gender: ['M', 'F', ''][Math.floor(Math.random() * 3)] as 'M' | 'F' | ''
  }))
}
const generatedExcelUrl = ref<string | null>(null)
const generatedPdfUrl = ref<string | null>(null)


// const generateGroups = async () => {
//   isGenerating.value = true

//   setTimeout(() => {
//     const students = currentStudents.value
//     const shuffled = [...students].sort(() => Math.random() - 0.5)
//     const groups: string[][] = []
//     const groupSize = getGroupSize.value

//     for (let i = 0; i < shuffled.length; i += groupSize) {
//       const group = shuffled.slice(i, i + groupSize)
//       if (group.length >= 2) {
//         groups.push(group)
//       } else {
//         remainingStudents.value = group
//       }
//     }

//     generatedGroups.value = groups
//     isGenerating.value = false
//     mainStore.addNotification('success', `${groups.length} groupes générés avec succès`)
//   }, 1500)
// }

const regenerateGroups = () => {
  generateGroups()
}

// const exportExcel = async () => {
//   isExporting.value = 'excel'

//   try {
//     const groupData = {
//       groups: generatedGroups.value,
//       remaining: remainingStudents.value,
//       config: {
//         type: groupType.value,
//         size: getGroupSize.value,
//         algorithm: algorithm.value
//       }
//     }

//     generateGroupsExcel(groupData)
//     mainStore.addNotification('success', 'Groupes exportés en Excel avec succès')
//   } catch (error) {
//     console.error('Erreur export Excel:', error)
//     mainStore.addNotification('error', 'Erreur lors de l\'export Excel')
//   } finally {
//     isExporting.value = null
//   }
// }

// const exportPdf = async () => {
//   isExporting.value = 'pdf'

//   try {
//     const groupData = {
//       groups: generatedGroups.value,
//       remaining: remainingStudents.value,
//       config: {
//         type: groupType.value,
//         size: getGroupSize.value,
//         algorithm: algorithm.value
//       }
//     }

//     generateGroupsPdf(groupData)
//     mainStore.addNotification('success', 'Groupes exportés en PDF avec succès')
//   } catch (error) {
//     console.error('Erreur export PDF:', error)
//     mainStore.addNotification('error', 'Erreur lors de l\'export PDF')
//   } finally {
//     isExporting.value = null
//   }
// }

const callGroupMakerApi = async () => {
  try {
    const response = await fetch('http://ocr_laravel2.test/api/group-maker', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        students: currentStudents.value,
        group_size: getGroupSize.value
      })
    })

    if (!response.ok) throw new Error('Erreur API group-maker')
    
    const data = await response.json()
    generatedExcelUrl.value = data.excel
    generatedPdfUrl.value = data.pdf

    mainStore.addNotification('success', 'Groupes générés avec succès')
  } catch (error) {
    console.error(error)
    mainStore.addNotification('error', 'Erreur API')
  }
}
const exportExcel = () => {
  if (generatedExcelUrl.value) {
    window.open(generatedExcelUrl.value, '_blank')
  } else {
    mainStore.addNotification('error', 'Aucun fichier Excel généré')
  }
}

const exportPdf = () => {
  if (generatedPdfUrl.value) {
    window.open(generatedPdfUrl.value, '_blank')
  } else {
    mainStore.addNotification('error', 'Aucun fichier PDF généré')
  }
}


const generateGroups = async () => {
  isGenerating.value = true
  try {
    await callGroupMakerApi()
  } finally {
    isGenerating.value = false
  }
}

</script>