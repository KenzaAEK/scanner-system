import * as XLSX from 'xlsx'

export interface Student {
  lastName: string
  firstName: string
  studentId?: string
  class?: string
  [key: string]: any
}

export interface AbsenceListOptions {
  className: string
  subject: string
  teacherName: string
  period: string
  includePhoto: boolean
  includeNotes: boolean
  includeDate: boolean
  sessionCount: number
}

export interface GroupData {
  groups: string[][]
  remaining: string[]
  config: {
    type: string
    size: number
    algorithm: string
  }
}

export const useExcelGenerator = () => {
  const generateAbsenceListExcel = (students: Student[], options: AbsenceListOptions) => {
    const workbook = XLSX.utils.book_new()
    
    // Prepare headers
    const headers = ['N°', 'Nom', 'Prénom']
    
    if (options.includePhoto) {
      headers.push('Photo')
    }
    
    if (options.includeDate) {
      for (let i = 1; i <= options.sessionCount; i++) {
        headers.push(`Séance ${i}`)
      }
    } else {
      headers.push('Absent')
    }
    
    if (options.includeNotes) {
      headers.push('Observations')
    }
    
    // Prepare data
    const data = [
      [`Classe: ${options.className}`],
      [`Matière: ${options.subject}`],
      [`Professeur: ${options.teacherName}`],
      [`Période: ${options.period}`],
      [], // Empty row
      headers,
      ...students.map((student, index) => {
        const row = [
          index + 1,
          student.lastName,
          student.firstName
        ]
        
        if (options.includePhoto) {
          row.push('')
        }
        
        if (options.includeDate) {
          for (let i = 0; i < options.sessionCount; i++) {
            row.push('')
          }
        } else {
          row.push('')
        }
        
        if (options.includeNotes) {
          row.push('')
        }
        
        return row
      })
    ]
    
    const worksheet = XLSX.utils.aoa_to_sheet(data)
    
    // Set column widths
    const colWidths = [
      { wch: 5 },  // N°
      { wch: 15 }, // Nom
      { wch: 15 }, // Prénom
    ]
    
    if (options.includePhoto) {
      colWidths.push({ wch: 10 })
    }
    
    if (options.includeDate) {
      for (let i = 0; i < options.sessionCount; i++) {
        colWidths.push({ wch: 10 })
      }
    } else {
      colWidths.push({ wch: 10 })
    }
    
    if (options.includeNotes) {
      colWidths.push({ wch: 20 })
    }
    
    worksheet['!cols'] = colWidths
    
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Liste d\'absences')
    XLSX.writeFile(workbook, `liste-absences-${options.className.replace(/\s+/g, '-')}.xlsx`)
  }
  
  const generateGroupsExcel = (groupData: GroupData) => {
    const workbook = XLSX.utils.book_new()
    
    // Prepare data
    const data = [
      [`Type de groupes: ${groupData.config.type}`],
      [`Taille: ${groupData.config.size} élèves par groupe`],
      [`Algorithme: ${groupData.config.algorithm}`],
      [], // Empty row
    ]
    
    // Add groups
    groupData.groups.forEach((group, index) => {
      data.push([`Groupe ${index + 1}`])
      group.forEach((student, studentIndex) => {
        data.push([`${studentIndex + 1}. ${student}`])
      })
      data.push([]) // Empty row between groups
    })
    
    // Add remaining students
    if (groupData.remaining.length > 0) {
      data.push(['Élèves restants'])
      groupData.remaining.forEach((student, index) => {
        data.push([`${index + 1}. ${student}`])
      })
    }
    
    const worksheet = XLSX.utils.aoa_to_sheet(data)
    worksheet['!cols'] = [{ wch: 30 }]
    
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Groupes')
    XLSX.writeFile(workbook, 'groupes-generes.xlsx')
  }
  
  return {
    generateAbsenceListExcel,
    generateGroupsExcel
  }
}