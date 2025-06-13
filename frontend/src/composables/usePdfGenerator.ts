import jsPDF from 'jspdf'
import autoTable from 'jspdf-autotable'

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

export const usePdfGenerator = () => {
  const generateAbsenceListPdf = (students: Student[], options: AbsenceListOptions) => {
    const doc = new jsPDF()
    
    // Header
    doc.setFontSize(16)
    doc.text('Liste d\'absences', 20, 20)
    
    doc.setFontSize(12)
    doc.text(`Classe: ${options.className}`, 20, 35)
    doc.text(`Matière: ${options.subject}`, 20, 45)
    doc.text(`Professeur: ${options.teacherName}`, 20, 55)
    doc.text(`Période: ${options.period}`, 20, 65)
    
    // Prepare table data
    const headers = ['N°', 'Nom', 'Prénom']
    
    if (options.includePhoto) {
      headers.push('Photo')
    }
    
    if (options.includeDate) {
      for (let i = 1; i <= options.sessionCount; i++) {
        headers.push(`S${i}`)
      }
    } else {
      headers.push('Absent')
    }
    
    if (options.includeNotes) {
      headers.push('Observations')
    }
    
    const tableData = students.map((student, index) => {
      const row = [
        (index + 1).toString(),
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
    
    // Generate table
    autoTable(doc, {
      head: [headers],
      body: tableData,
      startY: 80,
      styles: {
        fontSize: 10,
        cellPadding: 3
      },
      headStyles: {
        fillColor: [59, 130, 246],
        textColor: 255
      },
      columnStyles: options.includePhoto ? {
        3: { cellWidth: 20 }
      } : {}
    })
    
    // Save the PDF
    doc.save(`liste-absences-${options.className.replace(/\s+/g, '-')}.pdf`)
  }
  
  const generateGroupsPdf = (groupData: GroupData) => {
    const doc = new jsPDF()
    
    // Header
    doc.setFontSize(16)
    doc.text('Groupes générés', 20, 20)
    
    doc.setFontSize(12)
    doc.text(`Type: ${groupData.config.type}`, 20, 35)
    doc.text(`Taille: ${groupData.config.size} élèves par groupe`, 20, 45)
    doc.text(`Algorithme: ${groupData.config.algorithm}`, 20, 55)
    
    let yPosition = 70
    
    // Generate groups
    groupData.groups.forEach((group, index) => {
      if (yPosition > 250) {
        doc.addPage()
        yPosition = 20
      }
      
      doc.setFontSize(14)
      doc.text(`Groupe ${index + 1}`, 20, yPosition)
      yPosition += 10
      
      doc.setFontSize(10)
      group.forEach((student, studentIndex) => {
        doc.text(`${studentIndex + 1}. ${student}`, 25, yPosition)
        yPosition += 7
      })
      
      yPosition += 10
    })
    
    // Remaining students
    if (groupData.remaining.length > 0) {
      if (yPosition > 230) {
        doc.addPage()
        yPosition = 20
      }
      
      doc.setFontSize(14)
      doc.text('Élèves restants', 20, yPosition)
      yPosition += 10
      
      doc.setFontSize(10)
      groupData.remaining.forEach((student, index) => {
        doc.text(`${index + 1}. ${student}`, 25, yPosition)
        yPosition += 7
      })
    }
    
    doc.save('groupes-generes.pdf')
  }
  
  return {
    generateAbsenceListPdf,
    generateGroupsPdf
  }
}