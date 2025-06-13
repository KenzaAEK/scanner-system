<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PdfScannerController extends Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:20480',
            'quality' => 'sometimes|in:Rapide,Standard,Précis',
            'add_background' => 'sometimes|boolean',
        ]);

        $image = $request->file('image');
        $imagePath = $image->store('temp_uploads');
        $fullImagePath = storage_path('app/'.$imagePath);

        $outputPath = storage_path('app/generated_files/'.time().'.pdf');

        $process = new Process([
            'python',
            base_path('scripts/pdf_creator.py'),
            $fullImagePath,
            $outputPath,
            $request->input('quality', 'Standard'),
            $request->input('add_background', true) ? 'true' : 'false'
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->download($outputPath)->deleteFileAfterSend();
    }
}