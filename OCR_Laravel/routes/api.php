<?php

use App\Http\Controllers\AbsenceListController;
use App\Http\Controllers\BinomesController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ExcelGeneratorController;
use App\Http\Controllers\GroupMakerController;
use App\Http\Controllers\PdfScannerController;
use Illuminate\Support\Facades\Route;

Route::get('/helloo', function () {
    return response()->json('hellooo');
});

// Supprimez le préfixe 'api' inutile
// img -> pdf
Route::post('/pdf-scan', [PdfScannerController::class, 'scan']);
Route::get('/pdf-scan/{id}', [PdfScannerController::class, 'getStatus']);
Route::get('/pdf-scan/{id}/download', [PdfScannerController::class, 'download']);

// img -> excel
Route::post('/excel-generate', [ExcelGeneratorController::class, 'generate']); // good
Route::get('/absence-list', [AbsenceListController::class, 'generate']); // good

// no use
Route::get('/binomes-list', [BinomesController::class, 'generate']);

// groupe maker (binomes ...)
Route::post('/group-maker', [GroupMakerController::class, 'generate']);
Route::get('/download', [DownloadController::class, 'download'])->name("download");