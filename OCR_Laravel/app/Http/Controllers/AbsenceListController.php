<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Pail\ValueObjects\Origin\Console;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

class AbsenceListController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'filiere' => 'sometimes|in:GINF1,GINF2,GINF3',
            'num_seances' => 'sometimes|integer|min:1|max:20',
            'format' => 'sometimes|string|in:excel,pdf',
        ]);

        $process = new Process([
            'python',
            base_path('scripts/generate_absence_list.py'),
            "--filiere", $request->input('filiere', 'GINF2'),
            "--num_seances", $request->input('num_seances', 4),
            "--format", $request->input('format', 'excel')
        ]);

        $process->setTimeout(2 * 60);
        $process->run();                                      // blocking run is fine
        $outputPath = trim($process->getOutput());

        if (!$process->isSuccessful() || !is_file($outputPath)) {
            Log::error('[AbsenceList] STDERR: ' . $process->getErrorOutput());
            abort(500, 'Erreur lors de la génération du fichier absence.');
        }

        return response()->download($outputPath)->deleteFileAfterSend();
    }
}
