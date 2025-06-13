<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_classe';
    
    protected $fillable = [
        'nom_classe',
        'id_niveau',
        'effectif_max',
    ];

    protected $casts = [
        'effectif_max' => 'integer',
    ];

    // Relations
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'id_niveau', 'id_niveau');
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'id_classe', 'id_classe');
    }

    public function seances()
    {
        return $this->hasMany(Seance::class, 'id_classe', 'id_classe');
    }

    // Accessor pour le nom complet
    public function getNomCompletAttribute()
    {
        return $this->niveau->nom_niveau . ' - ' . $this->nom_classe;
    }
}