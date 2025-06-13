<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function download(Request $request)
    {
        $request->validate(['path' => 'required|string']);
        $path = urldecode($request->path);
        
        if (!file_exists($path)) {
            abort(404);
        }
        
        return response()->download($path)->deleteFileAfterSend();
    }
}