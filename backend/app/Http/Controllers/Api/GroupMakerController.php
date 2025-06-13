<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Http\Controllers\Controller;

class GroupMakerController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'students' => 'required|array|min:2',
            'group_size' => 'required|integer|min:2|max:8',
        ]);

        $tempInput = tempnam(sys_get_temp_dir(), 'students_') . '.txt';
        file_put_contents($tempInput, implode("\n", $request->students));

        $excelOutput = storage_path('app/generated_files/'.time().'_groupes.xlsx');
        $pdfOutput = storage_path('app/generated_files/'.time().'_groupes.pdf');

        $process = new Process([
            'python',
            base_path('scripts/group_maker.py'),
            $tempInput,
            $request->group_size,
            $excelOutput,
            $pdfOutput,
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new \Exception("Erreur de création de groupes: ".$process->getErrorOutput());
        }

        return response()->json([
            'excel' => url('download?path='.urlencode($excelOutput)),
            'pdf' => url('download?path='.urlencode($pdfOutput)),
        ]);
    }
}