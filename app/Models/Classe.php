<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
{
    use HasFactory;

    protected $table = 'classe';
    protected $primaryKey = 'id_classe';
    
    protected $fillable = [
        'nom_classe'
    ];

    /**
     * Relation avec les étudiants
     * Une classe peut avoir plusieurs étudiants
     */
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'id_classe');
    }

    /**
     * Relation avec les présences
     * Une classe peut avoir plusieurs enregistrements de présence
     */
    public function presences()
    {
        return $this->hasMany(Presence::class, 'id_classe');
    }

    /**
     * Scope pour rechercher par nom de classe
     */
    public function scopeByName($query, $name)
    {
        return $query->where('nom_classe', 'like', '%' . $name . '%');
    }

    /**
     * Accessor pour formater le nom de la classe
     */
    public function getNomClasseFormattedAttribute()
    {
        return strtoupper($this->nom_classe);
    }

    /**
     * Méthode pour obtenir le nombre d'étudiants dans la classe
     */
    public function getNombreEtudiantsAttribute()
    {
        return $this->etudiants()->count();
    }
}