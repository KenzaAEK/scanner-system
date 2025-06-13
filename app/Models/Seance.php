<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_seance';
    
    protected $fillable = [
        'id_module',
        'id_classe',
        'date_seance',
        'heure_debut',
        'heure_fin',
        'salle',
        'enseignant',
        'type_seance',
        'statut',
    ];

    protected $casts = [
        'date_seance' => 'date',
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i',
    ];

    // Relations
    public function module()
    {
        return $this->belongsTo(Module::class, 'id_module', 'id_module');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'id_classe', 'id_classe');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class, 'id_seance', 'id_seance');
    }

    // Accessors
    public function getDureeAttribute()
    {
        return $this->heure_debut->diffInMinutes($this->heure_fin);
    }

    // Scopes
    public function scopeAujourdhui($query)
    {
        return $query->whereDate('date_seance', today());
    }

    public function scopeProgrammees($query)
    {
        return $query->where('statut', 'Programmée');
    }

    public function scopeTerminees($query)
    {
        return $query->where('statut', 'Terminée');
    }
}