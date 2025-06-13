<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;

    protected $table = 'niveaux';
    protected $primaryKey = 'id_niveau';
    
    protected $fillable = [
        'nom_niveau',
        'annee_scolaire',
    ];

    // Relations
    public function classes()
    {
        return $this->hasMany(Classe::class, 'id_niveau', 'id_niveau');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'niveau_module', 'id_niveau', 'id_module')
                    ->withPivot('coefficient', 'semestre')
                    ->withTimestamps();
    }

    public function etudiants()
    {
        return $this->hasManyThrough(Etudiant::class, Classe::class, 'id_niveau', 'id_classe', 'id_niveau', 'id_classe');
    }
}