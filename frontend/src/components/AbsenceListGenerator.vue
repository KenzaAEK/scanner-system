<template>
  <div class="card">
    <div class="card-body">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Générateur de listes d'absences</h3>
      
      <div class="space-y-6">
        <!-- File Import Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
          <h4 class="font-medium text-blue-900 mb-3">📁 Importer la liste des élèves</h4>
          <div class="flex items-center space-x-4">
            <input 
              ref="fileInput"
              type="file" 
              accept=".csv,.xlsx,.xls" 
              @change="handleFileImport"
              class="hidden"
            >
            <button 
              @click="$refs.fileInput?.click()" 
              class="btn-primary flex items-center"
            >
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
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N° Étudiant</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Classe</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(student, index) in importedStudents.slice(0, 5)" :key="index">
                  <td class="px-4 py-2 text-sm text-gray-900">{{ student.lastName }}</td>
                  <td class="px-4 py-2 text-sm text-gray-900">{{ student.firstName }}</td>
                  <td class="px-4 py-2 text-sm text-gray-500">{{ student.studentId || '-' }}</td>
                  <td class="px-4 py-2 text-sm text-gray-500">{{ student.class || '-' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-if="importedStudents.length > 5" class="px-4 py-2 bg-gray-50 text-sm text-gray-500">
            ... et {{ importedStudents.length - 5 }} autres élèves
          </div>
        </div>

        <!-- Class Configuration -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la classe</label>
            <input 
              v-model="className" 
              type="text" 
              placeholder="Ex: 5ème A"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            >
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Matière</label>
            <input 
              v-model="subject" 
              type="text" 
              placeholder="Ex: Mathématiques"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Professeur</label>
            <input 
              v-model="teacherName" 
              type="text" 
              placeholder="Nom du professeur"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Période</label>
            <select 
              v-model="period" 
              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-accent-500 focus:border-transparent"
            >
              <option value="semaine">Semaine</option>
              <option value="mois">Mois</option>
              <option value="trimestre">Trimestre</option>
              <option value="annee">Année scolaire</option>
            </select>
          </div>
        </div>

        <!-- Manual Student Entry (fallback) -->
        <div v-if="importedStudents.length === 0">
          <div class="flex justify-between items-center mb-3">
            <h4 class="font-medium text-gray-900">Saisie manuelle des élèves</h4>
            <button 
              @click="addStudent" 
              class="text-accent-600 hover:text-accent-700 text-sm font-medium flex items-center"
            >
              <PlusIcon class="w-4 h-4 mr-1" />
              Ajouter un élève
            </button>
          </div>
          
          <div class="space-y-2 max-h-60 overflow-y-auto">
            <div 
              v-for="(student, index) in manualStudents" 
              :key="index"
              class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg"
            >
              <input 
                v-model="student.lastName" 
                placeholder="Nom" 
                class="flex-1 border border-gray-300 rounded px-2 py-1 text-sm"
              >
              <input 
                v-model="student.firstName" 
                placeholder="Prénom" 
                class="flex-1 border border-gray-300 rounded px-2 py-1 text-sm"
              >
              <button 
                @click="removeStudent(index)"
                class="text-red-500 hover:text-red-700 p-1"
              >
                <XMarkIcon class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>

        <!-- Template Options -->
        <div class="bg-gray-50 p-4 rounded-lg">
          <h4 class="font-medium text-gray-900 mb-3">Options du modèle</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="flex items-center space-x-2">
              <input 
                v-model="includePhoto" 
                type="checkbox" 
                class="rounded border-gray-300 text-accent-600 focus:ring-accent-500"
              >
              <span class="text-sm text-gray-700">Inclure une colonne photo</span>
            </label>
            
            <label class="flex items-center space-x-2">
              <input 
                v-model="includeNotes" 
                type="checkbox" 
                class="rounded border-gray-300 text-accent-600 focus:ring-accent-500"
              >
              <span class="text-sm text-gray-700">Colonne observations</span>
            </label>
            
            <label class="flex items-center space-x-2">
              <input 
                v-model="includeDate" 
                type="checkbox" 
                class="rounded border-gray-300 text-accent-600 focus:ring-accent-500"
              >
              <span class="text-sm text-gray-700">Colonnes de dates</span>
            </label>
            
            <div class="flex items-center space-x-2">
              <label class="text-sm text-gray-700">Nombre de séances:</label>
              <input 
                v-model.number="sessionCount" 
                type="number" 
                min="1" 
                max="20" 
                class="w-16 border border-gray-300 rounded px-2 py-1 text-sm"
              >
            </div>
          </div>
        </div>

        <!-- Generate Buttons -->
        <div class="flex justify-end space-x-3">
          <button 
            @click="previewList" 
            :disabled="!canGenerate"
            class="btn-secondary"
          >
            <EyeIcon class="w-4 h-4 mr-2" />
            Aperçu
          </button>
          <button 
            @click="generateExcel" 
            :disabled="!canGenerate || isGenerating"
            class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center"
          >
            <ArrowPathIcon v-if="isGenerating === 'excel'" class="w-4 h-4 animate-spin mr-2" />
            <DocumentArrowDownIcon v-else class="w-4 h-4 mr-2" />
            {{ isGenerating === 'excel' ? 'Génération...' : 'Générer Excel' }}
          </button>
          <button 
            @click="generatePdf" 
            :disabled="!canGenerate || isGenerating"
            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center"
          >
            <ArrowPathIcon v-if="isGenerating === 'pdf'" class="w-4 h-4 animate-spin mr-2" />
            <DocumentIcon v-else class="w-4 h-4 mr-2" />
            {{ isGenerating === 'pdf' ? 'Génération...' : 'Générer PDF' }}
          </button>
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
  EyeIcon, 
  DocumentArrowDownIcon, 
  ArrowPathIcon,
  DocumentIcon
} from '@heroicons/vue/24/outline'
import { useFileImport, type Student } from '../composables/useFileImport'
import { usePdfGenerator } from '../composables/usePdfGenerator'
import { useExcelGenerator } from '../composables/useExcelGenerator'
import { useMainStore } from '../stores/main'

const mainStore = useMainStore()
const { importStudents } = useFileImport()
const { generateAbsenceListPdf } = usePdfGenerator()
const { generateAbsenceListExcel } = useExcelGenerator()

const className = ref('')
const subject = ref('')
const teacherName = ref('')
const period = ref('semaine')
const manualStudents = ref<Student[]>([
  { lastName: '', firstName: '' }
])
const importedStudents = ref<Student[]>([])
const importedFile = ref<File | null>(null)
const includePhoto = ref(false)
const includeNotes = ref(true)
const includeDate = ref(true)
const sessionCount = ref(5)
const isGenerating = ref<string | null>(null)
const fileInput = ref<HTMLInputElement>()

const canGenerate = computed(() => {
  const hasStudents = importedStudents.value.length > 0 || 
                     manualStudents.value.some(s => s.lastName.trim() !== '' || s.firstName.trim() !== '')
  return className.value.trim() !== '' && hasStudents
})

const currentStudents = computed(() => {
  return importedStudents.value.length > 0 ? importedStudents.value : manualStudents.value.filter(s => s.lastName.trim() || s.firstName.trim())
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
  manualStudents.value.push({ lastName: '', firstName: '' })
}

const removeStudent = (index: number) => {
  if (manualStudents.value.length > 1) {
    manualStudents.value.splice(index, 1)
  }
}

const previewList = () => {
  console.log('Aperçu de la liste d\'absences', {
    className: className.value,
    subject: subject.value,
    teacher: teacherName.value,
    students: currentStudents.value,
    options: {
      includePhoto: includePhoto.value,
      includeNotes: includeNotes.value,
      includeDate: includeDate.value,
      sessionCount: sessionCount.value
    }
  })
}

const generatePdf = async () => {
  isGenerating.value = 'pdf'
  
  try {
    const options = {
      className: className.value,
      subject: subject.value,
      teacherName: teacherName.value,
      period: period.value,
      includePhoto: includePhoto.value,
      includeNotes: includeNotes.value,
      includeDate: includeDate.value,
      sessionCount: sessionCount.value
    }
    
    generateAbsenceListPdf(currentStudents.value, options)
    mainStore.addNotification('success', 'Liste d\'absences PDF générée avec succès')
  } catch (error) {
    console.error('Erreur génération PDF:', error)
    mainStore.addNotification('error', 'Erreur lors de la génération du PDF')
  } finally {
    isGenerating.value = null
  }
}

const generateExcel = async () => {
  isGenerating.value = 'excel'
  
  try {
    const options = {
      className: className.value,
      subject: subject.value,
      teacherName: teacherName.value,
      period: period.value,
      includePhoto: includePhoto.value,
      includeNotes: includeNotes.value,
      includeDate: includeDate.value,
      sessionCount: sessionCount.value
    }
    
    generateAbsenceListExcel(currentStudents.value, options)
    mainStore.addNotification('success', 'Liste d\'absences Excel générée avec succès')
  } catch (error) {
    console.error('Erreur génération Excel:', error)
    mainStore.addNotification('error', 'Erreur lors de la génération du fichier Excel')
  } finally {
    isGenerating.value = null
  }
}
</script>