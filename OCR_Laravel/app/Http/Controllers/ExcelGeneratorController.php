<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Http\Controllers\Controller;

class ExcelGeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:20480',
            'conversion_type' => 'required|in:Liste d\'absence,Autres listes',
        ]);

        $image = $request->file('image');
        $imagePath = $image->store('temp_uploads');
        $fullImagePath = storage_path('app/private/'.$imagePath);

        $outputPath = storage_path('app/public/generated_files/'.time().'.xlsx');

        $script = $request->conversion_type === 'Liste d\'absence' 
            ? 'image_to_excel_converter_fast.py'
            : 'image_to_excel_converter_local.py';

        $process = new Process([
            'python',
            base_path('scripts/'.$script),
            $fullImagePath,
            $outputPath
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new \Exception("Erreur de conversion: ".$process->getErrorOutput());
        }

        return response()->download($outputPath)->deleteFileAfterSend();
    }
}