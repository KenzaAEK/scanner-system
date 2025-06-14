<?php

namespace App\Jobs;

use App\Models\PdfScan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ScanImageToPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    public string $imagePath;
    public string $quality;
    public bool $addBackground;
    public int $scanId;

    /** Pas de limite d’exécution côté worker */
    public $timeout = 0;

    public function __construct(string $imagePath, string $quality, bool $addBackground, int $scanId)
    {
        $this->imagePath = $imagePath;
        $this->quality = $quality;
        $this->addBackground = $addBackground;
        $this->scanId = $scanId;
    }

    public function handle(): void
    {
        $scan = PdfScan::find($this->scanId);
        if (!$scan) {
            Log::warning("PDF scan #{$this->scanId} introuvable.");
            return;
        }

        $scan->update(['status' => 'processing']);

        $outputPath = storage_path('app/public/generated_files/' . uniqid() . '.pdf');

        $process = new Process([
            'python',
            base_path('scripts/pdf_creator.py'),
            $this->imagePath,
            $outputPath,
            '--quality', $this->quality,
            '--add_background', $this->addBackground ? 'true' : 'false',
        ]);
        $process->setTimeout(5 * 60);
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error("OCR Python error: " . $process->getErrorOutput());
            $scan->update(['status' => 'failed']);
            throw new ProcessFailedException($process);
        }

        // Enregistrer le résultat
        $scan->update([
            'status' => 'done',
            'output_path' => str_replace(storage_path('app/'), '', $outputPath),
        ]);

        // Nettoyer l’image temporaire
        Storage::delete(str_replace(storage_path('app/'), '', $this->imagePath));
    }
}
