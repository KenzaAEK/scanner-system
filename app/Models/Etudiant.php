<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiants';
    protected $primaryKey = 'code_apoge';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'code_apoge',
        'nom',
        'prenom',
        'id_classe',
        'email',
        'date_naissance',
        'statut',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    // Relations
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'id_classe', 'id_classe');
    }

    public function niveau()
    {
        return $this->hasOneThrough(Niveau::class, Classe::class, 'id_classe', 'id_niveau', 'id_classe', 'id_niveau');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class, 'code_apoge', 'code_apoge');
    }

    // Accessors
    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('statut', 'Actif');
    }

    public function scopeDeClasse($query, $classeId)
    {
        return $query->where('id_classe', $classeId);
    }
}