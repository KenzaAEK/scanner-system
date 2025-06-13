<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PdfScannerController;
use App\Http\Controllers\Api\ExcelGeneratorController;
use App\Http\Controllers\Api\AbsenceListController;
use App\Http\Controllers\Api\BinomesController;
use App\Http\Controllers\Api\GroupMakerController;
use App\Http\Controllers\DownloadController;

// Supprimez le préfixe 'api' inutile
Route::post('/pdf-scan', [PdfScannerController::class, 'scan']);
Route::post('/excel-generate', [ExcelGeneratorController::class, 'generate']);
Route::get('/absence-list', [AbsenceListController::class, 'generate']);
Route::get('/binomes-list', [BinomesController::class, 'generate']);
Route::post('/group-maker', [GroupMakerController::class, 'generate']);
Route::get('/download', [DownloadController::class, 'download']);