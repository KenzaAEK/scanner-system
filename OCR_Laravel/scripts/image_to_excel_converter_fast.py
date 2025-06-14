from openpyxl import Workbook
from openpyxl.drawing.image import Image as XLImage
import os

def insert_image_into_excel(image_path, output_excel_path):
    wb = Workbook()
    ws = wb.active
    ws.title = "Image Scannée"

    # Charger l'image (doit être PNG ou JPEG)
    img = XLImage(image_path)

    # Ajuster la taille de l'image si nécessaire (facultatif)
    img.width = img.width * 0.5
    img.height = img.height * 0.5

    # Insérer dans la cellule A1
    ws.add_image(img, 'A1')

    # Sauvegarder
    wb.save(output_excel_path)
    print(f"[OCR INFO] Image insérée dans {output_excel_path}")

if __name__ == "__main__":
    import argparse
    parser = argparse.ArgumentParser(description='Convertir image vers Excel (rapide)')
    parser.add_argument('image_path', help='Chemin de l\'image')
    parser.add_argument('output_path', help='Chemin de sortie Excel')
    
    args = parser.parse_args()
    
    insert_image_into_excel(args.image_path, args.output_path)
    print(args.output_path)
