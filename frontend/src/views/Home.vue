<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-primary-600 to-secondary-600 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
          <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
              <DocumentMagnifyingGlassIcon class="w-10 h-10 text-white" />
            </div>
          </div>
          <h1 class="text-4xl md:text-6xl font-bold mb-6">
            ScannerSystem
          </h1>
          <p class="text-xl md:text-2xl mb-8 text-white/90 max-w-3xl mx-auto">
            Votre assistant numérique pour simplifier la gestion pédagogique
          </p>
          <p class="text-lg text-white/80 max-w-2xl mx-auto">
            Convertissez, extrayez, organisez et générez vos documents en quelques clics. 
            Conçu spécialement pour les enseignants.
          </p>
        </div>
      </div>
    </div>

    <!-- Features Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Fonctionnalités principales</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Quatre outils puissants pour automatiser vos tâches administratives et pédagogiques
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- PDF Converter -->
        <router-link 
          to="/pdf-converter"
          class="feature-card group"
        >
          <div class="card-body">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center mr-4">
                <DocumentIcon class="w-6 h-6 text-white" />
              </div>
              <h3 class="text-xl font-semibold text-gray-900">Convertisseur PDF</h3>
            </div>
            <p class="text-gray-600 mb-4">
              Transformez vos images en documents PDF de qualité professionnelle. 
              Glissez-déposez vos fichiers et obtenez un PDF optimisé en quelques secondes.
            </p>
            <div class="flex items-center text-primary-600 font-medium group-hover:text-primary-700">
              <span>Commencer la conversion</span>
              <ArrowRightIcon class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
            </div>
          </div>
        </router-link>

        <!-- Table Extractor -->
        <router-link 
          to="/table-extractor"
          class="feature-card group"
        >
          <div class="card-body">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-500 rounded-xl flex items-center justify-center mr-4">
                <TableCellsIcon class="w-6 h-6 text-white" />
              </div>
              <h3 class="text-xl font-semibold text-gray-900">Extraction Excel</h3>
            </div>
            <p class="text-gray-600 mb-4">
              Extrayez automatiquement les tableaux de vos images et documents grâce à l'OCR intelligent. 
              Obtenez vos données directement dans Excel.
            </p>
            <div class="flex items-center text-secondary-600 font-medium group-hover:text-secondary-700">
              <span>Extraire des tableaux</span>
              <ArrowRightIcon class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
            </div>
          </div>
        </router-link>

        <!-- Absence Generator -->
        <router-link 
          to="/absence-generator"
          class="feature-card group"
        >
          <div class="card-body">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl flex items-center justify-center mr-4">
                <ClipboardDocumentListIcon class="w-6 h-6 text-white" />
              </div>
              <h3 class="text-xl font-semibold text-gray-900">Listes d'absences</h3>
            </div>
            <p class="text-gray-600 mb-4">
              Créez des listes d'absences personnalisées pour vos classes. 
              Choisissez vos options et générez des documents prêts à imprimer.
            </p>
            <div class="flex items-center text-accent-600 font-medium group-hover:text-accent-700">
              <span>Créer une liste</span>
              <ArrowRightIcon class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
            </div>
          </div>
        </router-link>

        <!-- Group Generator -->
        <router-link 
          to="/group-generator"
          class="feature-card group"
        >
          <div class="card-body">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center mr-4">
                <UserGroupIcon class="w-6 h-6 text-white" />
              </div>
              <h3 class="text-xl font-semibold text-gray-900">Générateur de groupes</h3>
            </div>
            <p class="text-gray-600 mb-4">
              Formez automatiquement des binômes et trinômes équilibrés. 
              Algorithmes intelligents pour optimiser la collaboration entre élèves.
            </p>
            <div class="flex items-center text-primary-600 font-medium group-hover:text-primary-700">
              <span>Former des groupes</span>
              <ArrowRightIcon class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
            </div>
          </div>
        </router-link>
      </div>
    </div>

    <!-- Statistics Section -->
    <div class="bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Pourquoi choisir ScannerSystem ?</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <ClockIcon class="w-8 h-8 text-primary-600" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Gain de temps</h3>
            <p class="text-gray-600">
              Automatisez vos tâches répétitives et concentrez-vous sur l'enseignement
            </p>
          </div>
          
          <div class="text-center">
            <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <CpuChipIcon class="w-8 h-8 text-secondary-600" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Intelligence artificielle</h3>
            <p class="text-gray-600">
              Technologies OCR avancées pour une extraction précise des données
            </p>
          </div>
          
          <div class="text-center">
            <div class="w-16 h-16 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <ShieldCheckIcon class="w-8 h-8 text-accent-600" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Sécurité</h3>
            <p class="text-gray-600">
              Vos données restent confidentielles et sécurisées en permanence
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-primary-600 to-secondary-600">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">
          Prêt à simplifier votre quotidien ?
        </h2>
        <p class="text-xl text-white/90 mb-8">
          Découvrez dès maintenant comment ScannerSystem peut transformer votre approche pédagogique
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <router-link 
            to="/pdf-converter" 
            class="bg-white text-primary-600 hover:bg-gray-50 font-semibold py-3 px-8 rounded-lg transition-colors"
          >
            Commencer gratuitement
          </router-link>
          <router-link 
            to="/table-extractor" 
            class="border-2 border-white text-white hover:bg-white hover:text-primary-600 font-semibold py-3 px-8 rounded-lg transition-colors"
          >
            Voir la démo
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { 
  DocumentMagnifyingGlassIcon,
  DocumentIcon,
  TableCellsIcon,
  ClipboardDocumentListIcon,
  UserGroupIcon,
  ArrowRightIcon,
  ClockIcon,
  CpuChipIcon,
  ShieldCheckIcon
} from '@heroicons/vue/24/outline'
</script>