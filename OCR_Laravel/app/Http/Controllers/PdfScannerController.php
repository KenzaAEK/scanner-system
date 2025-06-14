<?php

namespace App\Http\Controllers;

use App\Jobs\ScanImageToPdf;
use App\Models\PdfScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfScannerController extends Controller
{
    /**
     * Lance l’OCR en tâche de fond.
     */
    public function scan(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:20480',
            'quality' => 'sometimes|in:Rapide,Standard,Précis',
            'add_background' => 'sometimes|string',
        ]);

        // 1 – stockage de l’image
        $image = $request->file('image');
        $stored = $image->store('/temp_uploads');
        $fullPath = storage_path('app/private/' . $stored);

        // 2 – entrée BDD
        $scan = PdfScan::create([
            'original_filename' => $image->getClientOriginalName(),
            'status' => 'pending',
        ]);

        // 3 – dispatch du job
        ScanImageToPdf::dispatch(
            $fullPath,
            $request->input('quality', 'Standard'),
            $request->boolean('add_background', true),
            $scan->id
        );

        return response()->json([
            'message' => 'OCR lancé avec succès.',
            'scan_id' => $scan->id,
        ], 202);
    }

    /**
     * Retourne le statut d’un traitement.
     */
    public function getStatus(int $id)
    {
        $scan = PdfScan::findOrFail($id);

        return response()->json([
            'status' => $scan->status,
            'can_download' => $scan->status === 'done',
            'filename' => $scan->original_filename,
        ]);
    }

    /**
     * Téléchargement du PDF généré.
     */
    public function download(int $id)
    {
        $scan = PdfScan::findOrFail($id);

        if ($scan->status !== 'done') {
            return response()->json(['error' => 'PDF non prêt'], 423);
        }

        $fullPath = storage_path('app/' . $scan->output_path);
        if (!file_exists($fullPath)) {
            return response()->json(['error' => 'Fichier introuvable'], 404);
        }

        $downloadName = pathinfo($scan->original_filename, PATHINFO_FILENAME) . '.pdf';
        return response()->download($fullPath, $downloadName);
    }
}
