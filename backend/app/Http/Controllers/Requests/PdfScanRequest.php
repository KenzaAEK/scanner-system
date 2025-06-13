<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PdfScanRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:20480',
            'quality' => 'sometimes|in:Rapide,Standard,Précis,Ultra',
            'add_background' => 'sometimes|boolean',
            'enhance_contrast' => 'sometimes|boolean',
            'auto_rotate' => 'sometimes|boolean',
            'compress_pdf' => 'sometimes|boolean',
        ];
    }
}