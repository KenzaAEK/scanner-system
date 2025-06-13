<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcelGenerateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:20480',
            'conversion_type' => 'required|in:Liste d\'absence,Autres listes',
            'detection_mode' => 'sometimes|in:Automatique,Tableau structuré,Données libres',
            'add_styling' => 'sometimes|boolean',
            // Ajouter d'autres règles selon les besoins
        ];
    }
}
