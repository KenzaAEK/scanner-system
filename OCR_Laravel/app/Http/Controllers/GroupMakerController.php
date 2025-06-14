<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class GroupMakerController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'students' => 'required|array|min:2',
            'group_size' => 'required|integer|min:2|max:8',
        ]);

        /** 1️⃣ Fichier temporaire contenant les noms */
        $tmpInput = tempnam(sys_get_temp_dir(), 'students_') . '.txt';
        file_put_contents($tmpInput, implode("\n", $request->students));

        /** 2️⃣ Chemins de sortie */
        $timestamp = now()->format('Ymd_His');
        $excelOutput = storage_path("app/public/generated_files/{$timestamp}_groupes.xlsx");
        $pdfOutput = storage_path("app/public/generated_files/{$timestamp}_groupes.pdf");

        /** 3️⃣ Exécution du script Python */
        $process = new Process([
            'python',
            base_path('scripts/group_maker.py'),
            $tmpInput,
            $request->group_size,
            $excelOutput,
            $pdfOutput,
        ]);
        $process->setTimeout(0);       // aucune limite
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error('[GroupMaker] STDERR: ' . $process->getErrorOutput());
            throw new \RuntimeException('Erreur de création de groupes.');
        }

        /** 4️⃣ URL de téléchargement (à sécuriser selon votre logique) */
        return response()->json([
            'excel' => route('download', ['path' => base64_encode($excelOutput)]),
            'pdf' => route('download', ['path' => base64_encode($pdfOutput)]),
        ]);
    }
}
