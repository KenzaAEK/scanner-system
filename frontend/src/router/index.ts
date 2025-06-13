import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Pdf from '../views/Pdf.vue'
import Excel from '../views/Excel.vue'
import Absence from '../views/Absence.vue'
import Group from '../views/Group.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/pdf-converter',
      name: 'pdf',
      component: Pdf
    },
    {
      path: '/table-extractor',
      name: 'excel',
      component: Excel
    },
    {
      path: '/absence-generator',
      name: 'absence',
      component: Absence
    },
    {
      path: '/group-generator',
      name: 'group',
      component: Group
    }
  ]
})

export default router