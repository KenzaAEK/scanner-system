<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Http\Controllers\Controller;

class AbsenceListController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'filiere' => 'sometimes|in:GINF1,GINF2,GINF3',
            'num_seances' => 'sometimes|integer|min:1|max:20',
            'format' => 'sometimes|in:excel,pdf',
        ]);

        $process = new Process([
            'python',
            base_path('scripts/generate_absence_list.py'),
            $request->input('filiere', 'GINF2'),
            $request->input('num_seances', 6),
            $request->input('format', 'excel'),
        ]);

        $process->run();
        $outputPath = trim($process->getOutput());

        if (!$process->isSuccessful() || !file_exists($outputPath)) {
            throw new \Exception("Erreur de génération: ".$process->getErrorOutput());
        }

        return response()->download($outputPath)->deleteFileAfterSend();
    }
}