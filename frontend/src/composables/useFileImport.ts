import Papa from 'papaparse'
import * as XLSX from 'xlsx'

export interface Student {
  lastName: string
  firstName: string
  studentId?: string
  class?: string
  [key: string]: any
}

export const useFileImport = () => {
  const parseCSV = (file: File): Promise<Student[]> => {
    return new Promise((resolve, reject) => {
      Papa.parse(file, {
        header: true,
        skipEmptyLines: true,
        encoding: 'UTF-8',
        complete: (results) => {
          try {
            const students = results.data.map((row: any) => {
              // Try to map common column names
              const student: Student = {
                lastName: row['Nom'] || row['Last Name'] || row['nom'] || row['lastname'] || '',
                firstName: row['Prénom'] || row['First Name'] || row['prenom'] || row['firstname'] || '',
                studentId: row['Numéro étudiant'] || row['Student ID'] || row['numero'] || row['id'] || '',
                class: row['Classe'] || row['Class'] || row['classe'] || ''
              }
              
              // Add any additional fields
              Object.keys(row).forEach(key => {
                if (!['Nom', 'Prénom', 'nom', 'prenom', 'Last Name', 'First Name', 'lastname', 'firstname', 'Numéro étudiant', 'Student ID', 'numero', 'id', 'Classe', 'Class', 'classe'].includes(key)) {
                  student[key] = row[key]
                }
              })
              
              return student
            }).filter((student: Student) => student.lastName || student.firstName)
            
            resolve(students)
          } catch (error) {
            reject(error)
          }
        },
        error: (error) => {
          reject(error)
        }
      })
    })
  }
  
  const parseExcel = (file: File): Promise<Student[]> => {
    return new Promise((resolve, reject) => {
      const reader = new FileReader()
      
      reader.onload = (e) => {
        try {
          const data = new Uint8Array(e.target?.result as ArrayBuffer)
          const workbook = XLSX.read(data, { type: 'array' })
          const sheetName = workbook.SheetNames[0]
          const worksheet = workbook.Sheets[sheetName]
          const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 })
          
          if (jsonData.length < 2) {
            reject(new Error('Le fichier doit contenir au moins une ligne d\'en-têtes et une ligne de données'))
            return
          }
          
          const headers = jsonData[0] as string[]
          const rows = jsonData.slice(1) as any[][]
          
          const students = rows.map((row) => {
            const student: Student = {
              lastName: '',
              firstName: '',
              studentId: '',
              class: ''
            }
            
            headers.forEach((header, index) => {
              const value = row[index] || ''
              const normalizedHeader = header.toLowerCase().trim()
              
              if (normalizedHeader.includes('nom') && !normalizedHeader.includes('prénom') && !normalizedHeader.includes('prenom')) {
                student.lastName = value
              } else if (normalizedHeader.includes('prénom') || normalizedHeader.includes('prenom')) {
                student.firstName = value
              } else if (normalizedHeader.includes('numéro') || normalizedHeader.includes('numero') || normalizedHeader.includes('id')) {
                student.studentId = value
              } else if (normalizedHeader.includes('classe') || normalizedHeader.includes('class')) {
                student.class = value
              } else {
                student[header] = value
              }
            })
            
            return student
          }).filter((student: Student) => student.lastName || student.firstName)
          
          resolve(students)
        } catch (error) {
          reject(error)
        }
      }
      
      reader.onerror = () => {
        reject(new Error('Erreur lors de la lecture du fichier'))
      }
      
      reader.readAsArrayBuffer(file)
    })
  }
  
  const importStudents = async (file: File): Promise<Student[]> => {
    const fileExtension = file.name.split('.').pop()?.toLowerCase()
    
    if (fileExtension === 'csv') {
      return parseCSV(file)
    } else if (fileExtension === 'xlsx' || fileExtension === 'xls') {
      return parseExcel(file)
    } else {
      throw new Error('Format de fichier non supporté. Utilisez .csv, .xlsx ou .xls')
    }
  }
  
  return {
    importStudents,
    parseCSV,
    parseExcel
  }
}