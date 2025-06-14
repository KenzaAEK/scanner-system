<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_filename',
        'output_path',
        'status',
    ];
}