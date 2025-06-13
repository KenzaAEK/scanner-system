<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_presence';
    
    protected $fillable = [
        'code_apoge',
        'id_seance',
        'est_present',
        'est_retard',
        'commentaire',
        'heure_pointage',
        'methode_pointage',
    ];

    protected $casts = [
        'est_present' => 'boolean',
        'est_retard' => 'boolean',
        'heure_pointage' => 'datetime',
    ];

    // Relations
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'code_apoge', 'code_apoge');
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class, 'id_seance', 'id_seance');
    }

    // Accessors
    public function getStatutAttribute()
    {
        if ($this->est_present) {
            return $this->est_retard ? 'Présent (retard)' : 'Présent';
        }
        return 'Absent';
    }

    // Scopes
    public function scopePresents($query)
    {
        return $query->where('est_present', true);
    }

    public function scopeAbsents($query)
    {
        return $query->where('est_present', false);
    }

    public function scopeEnRetard($query)
    {
        return $query->where('est_retard', true);
    }
}