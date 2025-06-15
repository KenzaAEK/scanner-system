#!/usr/bin/env python
# -*- coding: utf-8 -*-
from pathlib import Path
from datetime import datetime

import pandas as pd
from fpdf import FPDF


# ──────────────────────────────── CONSTANTES DOSSIERS
# Racine du projet = dossier script/.. (= dossier Laravel)
ROOT = Path(__file__).resolve().parent.parent
PUBLIC_DIR    = ROOT / "storage" / "app" / "public"
INPUTS_DIR    = PUBLIC_DIR / "inputs"
GENERATED_DIR = PUBLIC_DIR / "generated_files"

INPUTS_DIR.mkdir(parents=True, exist_ok=True)
GENERATED_DIR.mkdir(parents=True, exist_ok=True)


# ──────────────────────────────── EXCEL
def generate_excel_absence(filiere: str, n: int, basename: str) -> str:
    """
    Crée un Excel d'absence avec colonnes Code Apogée | Nom | Prénom | Séance 1..n
    """
    src_xlsx = INPUTS_DIR / "Liste_absences.xlsx"   # ← fichier source
    if not src_xlsx.exists():
        raise FileNotFoundError(f"Fichier introuvable : {src_xlsx}")

    # Ne prendre QUE les trois colonnes utiles
    df_src = pd.read_excel(src_xlsx, engine="openpyxl")
    df_src = df_src.rename(columns=lambda c: c.strip())  # nettoyage
    required = ["Code Apogée", "Nom", "Prénom"]
    missing  = [c for c in required if c not in df_src.columns]
    if missing:
        raise ValueError(f"Colonnes manquantes dans {src_xlsx} : {missing}")

    df = df_src[required].copy()

    # Ajout colonnes Séance
    for i in range(1, n + 1):
        df[f"Séance {i}"] = ""

    # Sauvegarde
    out_xlsx = GENERATED_DIR / f"{basename}.xlsx"
    with pd.ExcelWriter(out_xlsx, engine="xlsxwriter") as writer:
        df.to_excel(writer, index=False, sheet_name=f"Absences {filiere}")

        wb = writer.book
        ws = writer.sheets[f"Absences {filiere}"]

        header_fmt = wb.add_format({
            "bold": True,
            "valign": "top",
            "fg_color": "#4472C4",
            "font_color": "white",
            "border": 1,
        })
        for c, name in enumerate(df.columns):
            ws.write(0, c, name, header_fmt)
            ws.set_column(c, c, 18)

    return str(out_xlsx.resolve())


# ──────────────────────────────── PDF
def generate_pdf_absence(filiere: str, n: int, basename: str) -> str:
    """
    Produit un PDF à partir du fichier Excel généré juste avant.
    """
    excel_path = Path(generate_excel_absence(filiere, n, basename))
    df         = pd.read_excel(excel_path, engine="openpyxl")

    out_pdf = GENERATED_DIR / f"{basename}.pdf"
    pdf     = FPDF(orientation="L")
    pdf.add_page()
    pdf.set_font("Arial", size=12)

    pdf.cell(0, 10,
             f"Liste d'absence - {filiere} - {n} séances",
             ln=1, align="C")
    pdf.ln(6)

    col_w = 280 / len(df.columns)  # largeur dynamique

    # En-têtes
    pdf.set_font("Arial", "B", 10)
    for col in df.columns:
        pdf.cell(col_w, 8, str(col), 1, 0, "C")
    pdf.ln()

    # Lignes
    pdf.set_font("Arial", size=9)
    for _, row in df.iterrows():
        for val in row:
            txt = "" if pd.isna(val) else str(val)
            pdf.cell(col_w, 8, txt, 1, 0, "C")
        pdf.ln()

    pdf.output(str(out_pdf))
    return str(out_pdf.resolve())


# ──────────────────────────────── ORCHESTRATEUR
def generate_absence_list(
    filiere: str = "GINF2",
    num_seances: int = 6,
    output_format: str = "excel"
) -> str:
    """
    Retourne le chemin absolu du fichier généré (Excel ou PDF).
    """
    ts   = datetime.now().strftime("%Y%m%d_%H%M%S")
    base = f"Liste_Absence_{filiere}_{num_seances}s_{ts}"

    if output_format == "pdf":
        return generate_pdf_absence(filiere, num_seances, base)
    return generate_excel_absence(filiere, num_seances, base)


# ──────────────────────────────── CLI
if __name__ == "__main__":
    import argparse

    p = argparse.ArgumentParser("Générateur de listes d'absence")
    p.add_argument("--filiere", default="GINF2")
    p.add_argument("--num_seances", type=int, default=6)
    p.add_argument("--format", default="excel")
    args = p.parse_args()

    print(generate_absence_list(
        filiere=args.filiere,
        num_seances=args.num_seances,
        output_format=args.format
        ))
